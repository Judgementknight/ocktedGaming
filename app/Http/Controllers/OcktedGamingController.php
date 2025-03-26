<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\OcktedStudentModel;
use App\Models\OcktedScoreModel;
use App\Models\OcktedGameModel;
use App\Models\OcktedTeacherModel;
use App\Models\OcktedGameroomModel;
use Illuminate\Support\Facades\DB;

class OcktedGamingController extends Controller
{
    function assignRank($totalScore, $userId)
    {
        Log::info("ITs hitting rank");
        $bronze = 200;
        $silver = 500;
        Log::info("assign rank score",['sad' => $totalScore]);
        Log::info("assign rank user",['sad' => $userId]);

        $student = OcktedStudentModel::where('ocktedgaming_id', $userId)->first();
        Log::info("ID",['data'=>$student]);
        if($totalScore > $silver){
            $student->update([
                'rank' => 'Gold',
            ]);
        }elseif($totalScore > $bronze){
            $student->update([
                'rank' => 'Silver',
            ]);
        }elseif($totalScore < $bronze){
            $student->update([
                'rank' => 'Bronze',
            ]);
        }
        return ['student' => $student];
    }

    public function displayWelcomePage(Request $request)
    {
        try{
            Log::info("TRIGGER", ['URL' => $request->fullUrl(), 'Method' => $request->method()]);
            Log::info( "TRIGGER");
            $response = Http::get('http://127.0.0.1:8005/user-data');  //this will the prayagedu User Get Request
            if($response->successful())
            {
                // Decrypting User Data from Prayag Edu
                $encrypted_data = $response->json('data');
                $secretKey = env('ENCRYPTION_KEY');
                $decrypted_data = $this->decryptData($encrypted_data, $secretKey);
                $data = json_decode($decrypted_data, true);
                // Log::info("Data", ['User Data Json' => $data]);

                // Extract common data
                $studentId     = $data['student_id'] ?? null;
                $teacherId     = $data['teacher_id'] ?? null;
                $code        = $data['school_code'] ?? null;
                $username    = $data['username'] ?? null;
                $picture     = $data['profile_picture'] ?? null;
                $token       = $data['game_token'] ?? null;

                $Data = [
                    'student_id' => $studentId,
                    'teacher_id' => $teacherId,
                    'school_code' => $code,
                    'username' => $username,
                    'profile_picture' => $picture,
                    'game_token' => $token,
                ];

                Log::info("Data", ['data' => $Data]);

                if (array_key_exists('student_id', $data)) {
                    info('STUDENT DETECTED');
                    $studentExists = OcktedStudentModel::where('student_id', $studentId)->first();
                    Log::info("Student Data", ['data:' => $studentExists]);

                    if (!$studentExists) {
                        session()->put('Student JSON Data', $Data);
                        return view('Main-Pages.start-page-student');
                    } else {
                        // If the student's profile setup is incomplete, show the start page
                        if (empty($studentExists->ocktedgaming_student_username)) {
                            return view('Main-Pages.start-page-student');
                        } else {
                            // Profile setup complete; redirect to ockted homepage
                            session()->put('Student Data', $studentExists);
                            return redirect()->route('ockted');
                        }
                    }
                }
                elseif(array_key_exists('teacher_id', $data)){
                    info('Teacher Detected');
                    $teacherExists = OcktedTeacherModel::where('teacher_id', $teacherId)->first();
                    Log::info("Teacher Data Exists?",['data' => $teacherExists]);
                    if(!$teacherExists){

                        session()->put('Teacher JSON Data', $Data);
                        return view('Main-Pages.start-page-teacher');
                    }else {
                        //Check if profile setup is complete
                        if (empty($teacherExists->ocktedgaming_teacher_username)) {
                            //Show start page to complete setup
                            return view('Main-Pages.start-page-teacher');
                        } else {
                            //Redirect to ockted homepage
                            session()->put('Teacher Data', $teacherExists);
                            return redirect()->route('ockted');
                        }
                    }
                }
            }else {
                return response()->json(['message' => 'User API ERROR']);
            }
        }catch(Exception $e){
            Log::error("Error", ['Error' => $e->getMessage()]);
            return response()->json([
                'erorr' => $e->getMessage()
            ]);
        }
    }

    public function createOcktedStudent(Request $request)
    {
        try{
            $sessionUser = session()->get('Student JSON Data');
            Log::info("SESSION DATA BOIII", ['data:' => $sessionUser]);

            $studentId = $sessionUser['student_id'];
            $code      = $sessionUser['school_code'];
            $username  = $sessionUser['username'];
            $picture   = $sessionUser['profile_picture'];

            $gameToken = $this->createToken();
            $ocktedGamingId = $this->generateOcktedGamingIdForStudent();

            //Retrieve the ockted_username from the request
            $ocktedUsername = $request->input('ockted_username');

            //Initialize a variable for the file path
            $filePath = null;
            $fileUrl = null;

            //Check if the file is uploaded and is valid
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                //Store the image in the "profile_pictures" directory on the public disk
                $filePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $fileUrl = \Illuminate\Support\Facades\Storage::url($filePath);
            }

            $student = OcktedStudentModel::create([
                        'student_id'      => $studentId,
                        'ocktedgaming_id' => $ocktedGamingId,
                        'student_name'    => $username,
                        'ocktedgaming_student_username' => $ocktedUsername,
                        'school_code'     => $code,
                        'game_token'      => $gameToken,
                        'profile_picture' => $fileUrl ? $fileUrl : $user->profile_picture,
                    ]);

            session()->put('Student Data', $student);
            Log::info("Session Data", ['data:' => session('Student Data')]);

            return redirect()->route('ockted');

        }catch(Exception $e){

            Log::error("Error", ['data' => $e->getMessage()]);

        }

    }

    public function createOcktedTeacher(Request $request)
    {
        try{
            $sessionUser = session()->get('Teacher JSON Data');
            Log::info("SESSION DATA BOIII", ['data:' => $sessionUser]);

            $teacherId = $sessionUser['teacher_id'];
            $code      = $sessionUser['school_code'];
            $username  = $sessionUser['username'];
            $picture   = $sessionUser['profile_picture'];

            $gameToken = $this->createToken();
            $ocktedGamingId = $this->generateOcktedGamingIdForTeacher();

            //Retrieve the ockted_username from the request
            $ocktedUsername = $request->input('ockted_username');

            //Initialize a variable for the file path
            $filePath = null;
            $fileUrl = null;

            //Check if the file is uploaded and is valid
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                //Store the image in the "profile_pictures" directory on the public disk
                $filePath = $request->file('profile_picture')->store('profile_pictures', 'public');
                $fileUrl = \Illuminate\Support\Facades\Storage::url($filePath);
            }

            $teacher = OcktedTeacherModel::create([
                        'teacher_id'      => $teacherId,
                        'ocktedgaming_id' => $ocktedGamingId,
                        'teacher_name'    => $username,
                        'ocktedgaming_teacher_username' => $ocktedUsername,
                        'school_code'     => $code,
                        'game_token'      => $gameToken,
                        'profile_picture' => $fileUrl ? $fileUrl : $user->profile_picture,
                    ]);

            Log::info("Teacher Created!!", ['data:' => $teacher]);
            session()->put('Teacher Data', $teacher);
            Log::info("Session Data", ['data:' => session('Student Data')]);

            return redirect()->route('ockted');

        }catch(Exception $e){

            Log::error("Error", ['data' => $e->getMessage()]);

        }

    }

    public function Initialize()
    {
        try{
            Log::info( "TRIGGER");
            $response = Http::get('http://127.0.0.1:8005/user-data');  //this will the prayagedu User Get Request
            if($response->successful())
            {
                //Decrypting User Data from Prayag Edu
                $encrypted_data = $response->json('data');
                $secretKey = env('ENCRYPTION_KEY');
                $decrypted_data = $this->decryptData($encrypted_data, $secretKey);
                $data = json_decode($decrypted_data, true);
                Log::info("Data", ['User Data Json' => $data]);

                $session_key = $data['session_key'] ?? null;
                $user_id = $session_key['user_id'] ?? null;
                $code = $data['school_code'] ?? null;
                $game_token = $data['game_token'] ?? null;
                $username = $data['username'] ?? null;
                $picture = $data['profile_picture'] ?? null;


                if(!$game_token){                   //creating Game Token For New Users
                    $token = Str::random(60);
                    $hashToken = Hash::make($token);
                    return response()->json([
                        'message' => 'Token Generated',
                        'token' => $token,
                        'hash token' => $hashToken
                    ]);
                }

                if($game_token && $user_id && $code && $username && $picture){
                    $userData = [
                        'user_id' => $user_id,
                        'game_token' => $game_token,
                        'school_code' => $code,
                        'username' => $username,
                        'profile_picture' => $picture,
                    ];

                    $userExists = OcktedStudentModel::where('game_token',$game_token)->where('user_id', $user_id)->first();
                    Log::info("USer Exists",['Data:' => $userExists]);

                    if(!$userExists){           //storing user data in DB if the user is new
                        $user = OcktedStudentModel::create([
                            'user_id' => $user_id,
                            'username' => $username,
                            'school_code' => $code,
                            'game_token' => $game_token,
                            'profile_picture' => $picture,
                        ]);

                        session()->put('User Data', $user);
                        Log::info("SESSION DATA", ['User Data' => session()->get('User Data')]);
                        Log::info("User Data Created", ["data:" => $user]);

                        //Fetching Game Data to Render
                        $gameData = $this->initiateGame();

                        $combinedData = ['User Data' => $userExists,'Game Data' => $gameData];

                        return view('Main-Pages.homepage', compact('combinedData'));
                    }

                    session()->put('User Data', $userExists);   //put user data in session
                    $user = session()->get('User Data');
                    Log::info("User Data", ["sessiondata" => $user]);
                    if(!$user){             //checking if user is in session
                        return response()->json(["message" => 'User Doesnt Exists'], 401);
                    }

                    $score = OcktedStudentModel::with('scores')->where('user_id', $user['user_id'])->first();   //
                    $total = $score->scores->sum('score');     //Fetching Total Scores of User
                    $recent = $score->scores()->latest()->take(3)->get();           //recent Games Played
                    $userId = $user['user_id'];

                    // $update = OcktedStudentModel::where('user_id',$user_id)->update(['user_status' => 'Active']);
                    // Log::info("Updated", ['data' => $update]);

                    $user = $this->assignRank($total, $userId);         //assign rank
                    Log::info("RANK", ['rnak' => $user]);

                    $gameData = $this->initiateGame();          //fetching game data to render

                    $encrypted_token = $this->encryptToken($game_token);        //encrypting game_token which is gonna pass as an URL params
                    Log::info("Encrypt Token", ['token' => $encrypted_token]);


                    //data to be send to the view page
                    $combinedData = ['User Data' => $userExists,'Game Data' => $gameData, 'Score Data' => $recent , 'Total Score' => $total, 'gameToken' => $encrypted_token];
                        // return response()->json([
                        //     'data' => $combinedData,
                        // ]);

                    return view('Main-Pages.homepage', compact('combinedData'));
                } else {
                    return response()->json([
                        'message' => 'Validation Failed'
                    ]);
                }

            }else{
                return response()->json([
                    'message'=> 'User API ERROR',
                ]);
            }
        }catch(Exception $e){
            Log::error("Error", ['Error' => $e->getMessage()]);
            return response()->json([
                'erorr' => $e->getMessage()
            ]);
        }
    }

    public function ocktedHomepage()
    {
        info('ITS HITING OCKTEDHOMEPAGE');
        if(session()->has('Student Data')){
            $student = session()->get('Student Data');
            $studentId = $student->ocktedgaming_id;
            Log::info("User Data", ["OCKTED HOMEPAGE" => $student]);

            $score = OcktedStudentModel::with('scores')->where('ocktedgaming_id', $studentId)->first();
            $totalScore = $score->scores()->sum('score');
            Log::info('Score', ['data:' => $totalScore]);

            // $recentGame = OcktedStudentModel::with('scores.game')->where('user_id', $user->user_id)->first();
            // $recent = $recentGame->scores()->latest()->take(3)->get();

            $recent = DB::table('ockted_score')
                      ->join('ockted_students', 'ockted_score.ocktedgaming_id', '=', 'ockted_students.ocktedgaming_id')
                      ->join('ockted_games', 'ockted_score.game_code', '=', 'ockted_games.game_code')
                      ->select('ockted_games.game_title','ockted_score.score')
                      ->where('ockted_students.ocktedgaming_id', $studentId)
                      ->orderBy('ockted_score.created_at', 'desc')
                      ->limit(3)
                      ->get();


            //getting active games
            $status = "Active";
            $gameData = OcktedGameModel::where('game_status', $status)->get();
            Log::info("Active Game", ['data:' => $gameData]);

            //getting total games
            $totalGames = $gameData->count();
            Log::info("Total Game Count", ['data' => $totalGames]);

            $userId = $student->ocktedgaming_id;
            $game_token = $student->game_token;

            $student = $this->assignRank($totalScore, $userId);         //assign rank
            Log::info("RANK", ['rank' => $student]);

            $encrypted_token = $this->encryptToken($game_token);        //encrypting game_token which is gonna pass as an URL params
            Log::info("Encrypt Token", ['token' => $encrypted_token]);

            $combinedData = ['Student Data' => $student, 'Game Data' => $gameData, 'Total Games' => $totalGames, 'Total Score' => $totalScore, 'Recent Games Played' => $recent, 'gameToken' => $encrypted_token];
            Log::info("combined Data", ['data' => $combinedData]);
            // return response()->json([
            //     'data' => $combinedData,
            // ]);

            return view('Main-Pages.homepage', compact('combinedData'));
        }

        elseif (session()->has('Teacher Data')) {
            $teacher = session()->get('Teacher Data');
            Log::info("Teacher Data", ['data' => $teacher]);

            //getting active games
            $status = "Active";
            $gameData = OcktedGameModel::where('game_status', $status)->get();
            Log::info("Active Game", ['data:' => $gameData]);

            //getting total games
            $totalGames = $gameData->count();
            Log::info("Total Game Count", ['data' => $totalGames]);

            $userId = $teacher->ocktedgaming_id;
            $game_token = $teacher->game_token;

            $score = OcktedTeacherModel::with('scores')->where('ocktedgaming_id', $userId)->first();
            $totalScore = $score->scores()->sum('score');

            $teacherId = $teacher->teacher_id;
            $gameroom = OcktedGameroomModel::where('teacher_id', $teacherId)->get();

            $encrypted_token = $this->encryptToken($game_token);        //encrypting game_token which is gonna pass as an URL params
            Log::info("Encrypt Token", ['token' => $encrypted_token]);

            $combinedData = ['Teacher Data' => $teacher, 'Game Data' => $gameData, 'Total Games' => $totalGames, 'Total Score' => $totalScore, 'gameToken' => $encrypted_token, 'Game Room' => $gameroom];
            Log::info("combined Data", ['data' => $combinedData]);

            // return response()->json([
            //     'data' => $combinedData,
            // ]);

            return view('TeacherDashboard.teacher-dashboard', compact('combinedData'));

        }

        else{
            info('No Session Available');
        }

    }


    //encrypting game token
    function encryptToken($game_token){
        $secretKey = base64_decode(env('ENCRYPTION_KEY'));
        if(strlen($secretKey) != 24){
            return response()->json([
                'message' => 'Length is not 24',
            ]);
        }
        $encrypt_token = openssl_encrypt($game_token, 'AES-192-ECB', $secretKey, OPENSSL_RAW_DATA);
        $encrypted_token = base64_encode($encrypt_token);
        return $encrypted_token;

    }

    function decryptToken($encrypt_token, $secretKey){
        Log::info("enc TOKEN",['enc'=> $encrypt_token]);
        $keyArray = base64_decode($secretKey);
        Log::info("token", ['length'=>$keyArray]);
        if (strlen($keyArray) !== 24) {
            throw new \Exception("The key must be 192 bits (24 bytes).");
        }
        $encrypted_token = base64_decode($encrypt_token);
        $decrypted_token = openssl_decrypt($encrypted_token, 'AES-192-ECB', $keyArray, OPENSSL_RAW_DATA);
        return $decrypted_token;
    }

    //Decrypting Data of User Data
    function decryptData($encrypted_data, $secretKey)  //base64_decode
    {
        $keyArray = base64_decode($secretKey);

        // Ensure that the key length is 24 bytes (192 bits)
        if (strlen($keyArray) !== 24) {
            throw new \Exception("The key must be 192 bits (24 bytes).");
        }

        // Decode the base64-encoded encrypted text
        $encryptedData = base64_decode($encrypted_data);
        $decryptedData = openssl_decrypt($encryptedData, 'AES-192-ECB', $keyArray, OPENSSL_RAW_DATA);  //openssl_decrypt() doesn’t need an empty IV (''). ECB mode doesn't use an IV, so you can remove it:

        return $decryptedData;
    }

    //Fetch Game Data From Games
    function initiateGame()
    {
        $server1Data = [];
        $server2Data = [];

        //always return null to ignore api fails
        try {
            $response1 = Http::timeout(2)->get('http://127.0.0.1:8005/game-data');
                $server1Data = $response1->successful() ? $response1->json()['Game Data'] ?? [] : [];
        }catch (\Exception $e) {
            Log::info("Server 1 API failed", ['error' => $e->getMessage()]);
        }

        try {
            $response2 = Http::timeout(2)->get('http://localhost:8003/api/games');
            $server2Data = $response2->successful() ? $response2->json() ?? [] : [];
        }catch (\Exception $e) {
            Log::info("Server 2 API failed", ['error' => $e->getMessage()]);
        }

        return [
            'Server 1' => $server1Data,
            'Server 2' => $server2Data,
            'Total Games' => count($server1Data) + count($server2Data),
        ];

    }

    function createToken(){
        $token = Str::random(60);
        $hashToken = Hash::make($token);
        return $token;
    }

    function generateOcktedGamingIdForStudent()
    {
        $ocktedGamingId = 'OGS' . rand(10000, 99999);
        $OctedIdExists = OcktedStudentModel::where('ocktedgaming_id', $ocktedGamingId)->first();
        if(!$OctedIdExists){
            return $ocktedGamingId;
        }else{
            return $this->generateOcktedGamingIdForStudent();
        }
    }

    function generateOcktedGamingIdForTeacher()
    {
        $ocktedGamingId = 'OGT' . rand(10000, 99999);
        $OctedIdExists = OcktedTeacherModel::where('ocktedgaming_id', $ocktedGamingId)->first();
        if(!$OctedIdExists){
            return $ocktedGamingId;
        }else{
            return $this->generateOcktedGamingIdForTeacher();
        }
    }

    //Accepting Score From Games
    public function acceptScore(Request $request)
    {
        try{

            //where i already have the game title game description and other game data and game banner
            //data coming from Games
            $field = $request->validate([
                'score' => 'required',
                'game_token' => 'required',
                'game_code' => 'required',
            ]);

            Log::info("Data", ['user:' => $field]);
            $encrypt_token = $field['game_token'];
            $secretKey = env('ENCRYPTION_KEY');
            Log::info("key",['data'=>$secretKey]);
            $decrypted_token = $this->decryptToken($encrypt_token, $secretKey);         //decrypt token decryptToken()
            Log::info("Decrypt",['data'=>$decrypted_token]);

            $userIDExists = OcktedStudentModel::where('game_token', $decrypted_token)->first();
            Log::info("User Exists",["return true if exists:" => $userIDExists->user_id]);

            if($userIDExists){
                $score = OcktedScoreModel::create([
                    'user_id' => $userIDExists->user_id,
                    'game_code' => $field['game_code'],
                    'score' => $field['score'],
                ]);
                Log::info("Score Created",["data"=> $score]);
            }else{
                Log::info("Invalid User Id",['message' => $field['user_id']]);
                return response()->json([
                    'message' => "This User ID {$field['user_id']} is not valid",
                ]);
            }

        }catch(Exception $e){
            Log::error("Cant Fetch Score",["Error" => $e->getMessage()]);
            return response()->json(['message' => 'Error Fetching Score', 'error' => $e->getMessage()], 200);
        }
    }




    public function leaderboard(){
        try{
            $user = session()->get('User Data');
            $userId = $user['user_id'];
            $totalScore = OcktedScoreModel::where('user_id', $userId)->sum('score');
            $userData = ['user' => $user, 'totalScore' => $totalScore];
            Log::info("User ID",['data:' => $userData]);


            $score = OcktedStudentModel::select('ockted_users.user_id','ockted_users.username','ockted_users.profile_picture', OcktedScoreModel::raw('SUM(ockted_score.score) as total_score'))
            ->join('ockted_score','ockted_users.user_id', '=', 'ockted_score.user_id')
            ->groupBy('ockted_users.user_id', 'ockted_users.profile_picture', 'ockted_users.username')
            ->orderBy('total_score', 'desc')
            ->take(10)
            ->get();

            $data = ['User Data' => $userData, 'leaderboard' => $score];
            // return response()->json([
            //     'User Data' => $data,
            // ]);
            return view('Main-Pages.leaderboard', compact('data'));
        }catch(Exception $e){
            Log::error("Error", ['error'=> $e->getMessage()]);
        }

    }

    public function history()           //not done
    {
        $user = session()->get('User Data');
        Log::info("User in Session",['user'=>$user]);

        // $history = OcktedStudentModel::where('user_id',$user)->select('ockted_users.')

        return view('Main-Pages.history');
    }

    public function isTokenValid(Request $request){             //checking if token is valid and if valid then send back user data as respsonse
        try{

            $token = $request->input('token');
            Log::info("Token", ['data' => $token]);

            $secretKey = env('ENCRYPTION_KEY');
            $decrypted_token = $this->decryptData($token, $secretKey);
            Log::info("Decrypt",['token'=>$decrypted_token]);

            $user = OcktedStudentModel::where('game_token', $decrypted_token)->first();
            Log::info("Request User Data",['data'=>$user]);

            $userToken = $user->game_token;
            Log::info("Request User TOKEN",['data'=>$userToken]);

            if($decrypted_token === $user['game_token']){
                Log::info("IT IS VALID");
                return response()->json([
                    'user' => $user,
                ]);
            }else{
                Log::info("IT IS NOT VALID");
            }
        }catch(Exception $e){
            Log::error("Token Not received", ['token' => $e->getMessage()]);
        }
    }
}


// 2. CHECK GAME TOKEN isValidToken(token) IF ITS PRESENT OR NOT IN URL PARAMS IF NOT RETURN A WARNING PAGE
// 3. IF TOKEN VALID THEN REQUEST FOR USER DATA getGameTokenDetails(token)
// 4.


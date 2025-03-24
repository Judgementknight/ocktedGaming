<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\OcktedUserModel;
use App\Models\OcktedScoreModel;
use App\Models\OcktedGameModel;
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
        $user = OcktedUserModel::where('user_id', $userId)->first();
        Log::info("ID",['data'=>$user]);
        if($totalScore > $silver){
            $user->update([
                'rank' => 'Gold',
            ]);
        }elseif($totalScore > $bronze){
            $user->update([
                'rank' => 'Silver',
            ]);
        }elseif($totalScore < $bronze){
            $user->update([
                'rank' => 'Bronze',
            ]);
        }
        return ['user' => $user];
    }

    public function displayWelcomePage()
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
                $username = $data['username'] ?? null;
                $picture = $data['profile_picture'] ?? null;


                $teacher_game_token = $data['teacher_game_token'] ?? null;
                $game_token = $data['game_token'] ?? null;

                //how to send this as a post
                if(!$game_token){                   //creating Game Token For New Users
                    $game_token = $this->createToken();

                    // send token to prayagEdu
                    $response = Http::post('create token for student', [
                        'game_token' => $game_token
                    ]);
                }elseif(!$teacher_game_token){
                    $teacher_game_token = $this->createToken();

                    $response = Http::post('create token for teacher',[
                        'teacher_game_token' => $teacher_game_token
                    ]);

                    return response()->json([
                        'token' => $token,
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

                    $userExists = OcktedUserModel::where('game_token',$game_token)->where('user_id', $user_id)->first();
                    Log::info("USer Exists",['Data:' => $userExists]);

                    if(!$userExists){           //storing user data in DB if the user is new
                        $user = OcktedUserModel::create([
                            'user_id' => $user_id,
                            'username' => $username,
                            'school_code' => $code,
                            'game_token' => $game_token,
                            'profile_picture' => $picture,
                        ]);

                        session()->put('User Data', $user);
                        $session = session()->get('User Data');
                        Log::info("SESSION DATA", ['User Data' => $session]);
                        Log::info("User Data Created", ["data:" => $user]);


                        return view('Main-Pages.start-page');
                    }

                    session()->put('User Data', $userExists);   //put user data in session
                    return redirect()->route('ockted');
                    // info('ITS HITING OCKTEDHOMEPAGE');
                    // $user = session()->get('User Data');
                    // Log::info("User Data", ["(OCKTED HOMEPAGE)" => $user]);

                    // //convert the image to link
                    // $score = OcktedUserModel::with('scores')->where('user_id', $user->user_id)->first();
                    // $totalScore = $score->scores()->sum('score');
                    // Log::info('Score', ['data:' => $totalScore]);

                    // $recentGame = OcktedUserModel::with('scores')->where('user_id', $user->user_id)->first();
                    // $recent = $recentGame->scores()->latest()->take(3)->get();

                    // $gameData = OcktedGameModel::all();
                    // Log::info("Game", ['data:' => $gameData]);
                    // $totalGames = $gameData->count();
                    // Log::info("Total Game Count", ['data' => $totalGames]);

                    // $userId = $user['user_id'];
                    // $game_token = $user['game_token'];

                    // $user = $this->assignRank($totalScore, $userId);         //assign rank
                    // Log::info("RANK", ['rank' => $user]);

                    // $encrypted_token = $this->encryptToken($game_token);        //encrypting game_token which is gonna pass as an URL params
                    // Log::info("Encrypt Token", ['token' => $encrypted_token]);


                    // // //data to be send to the view page
                    // // $combinedData = ['User Data' => $userExists,'Game Data' => $gameData, 'Score Data' => $recent , 'Total Score' => $totalScore, 'gameToken' => $encrypted_token];

                    // $combinedData = ['User Data' => $user, 'Game Data' => $gameData, 'Total Games' => $totalGames, 'Total Score' => $totalScore, 'Recent Games Played' => $recent, 'gameToken' => $encrypted_token];
                    // Log::info("combined Data", ['data' => $combinedData]);
                    // return response()->json([
                    //     'data' => $combinedData,
                    // ]);
                }elseif($teacher_game_token && $code && $user_id && $username && $picture){
                    $teacherData = [
                        'username' => $username,
                        'teacher_game_token' => $teacher_game_token,
                        'school_code' => $code,
                        'user_id' => $user_id,
                        'profile_picture' => $picture,
                    ];

                    $teacherExists = OcktedTeacherModel::where('teacher_game_token', $teacher_game_token)->first();

                    if(!$teacherExists){
                        $teacher = OcktedTeacherModel::create($teacherData);
                        session()->put('Teacher Data', $teacherData);

                        return view('Main-Pages.start-page');
                    }

                    session()->put('Teacher Data', $teacherData);
                    return redirect()->route('ockted');

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

    public function createOcktedUserName(Request $request)
    {
        try{
            $sessionUser = session()->get('User Data');
            Log::info("SESSION DATA BOIII", ['data:' => $sessionUser]);

            $userId = $sessionUser->user_id;

            Log::info("Processing createOcktedUser", ['user_id' => $userId]);

            // Retrieve the ockted_username from the request
            $ocktedUsername = $request->input('ockted_username');

            // Initialize a variable for the file path
            $filePath = null;
            $fileUrl = null;

            // Check if the file is uploaded and is valid
            if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
                // Store the image in the "profile_pictures" directory on the public disk
                $filePath = $request->file('profile_picture')->store('profile_pictures', 'public');

                $fileUrl = \Illuminate\Support\Facades\Storage::url($filePath);
            }

            $user = OcktedUserModel::where('user_id', $userId)->first();
            Log::info("User found", ['data' => $user]);

            // Update the user with the new username and image path (if uploaded)
            $user->update([
                'ockted_username' => $ocktedUsername,
                'profile_picture' => $fileUrl ? $fileUrl : $user->profile_picture,
            ]);

            Log::info("User Updated", ['data' => $user]);

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

                    $userExists = OcktedUserModel::where('game_token',$game_token)->where('user_id', $user_id)->first();
                    Log::info("USer Exists",['Data:' => $userExists]);

                    if(!$userExists){           //storing user data in DB if the user is new
                        $user = OcktedUserModel::create([
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

                    $score = OcktedUserModel::with('scores')->where('user_id', $user['user_id'])->first();   //
                    $total = $score->scores->sum('score');     //Fetching Total Scores of User
                    $recent = $score->scores()->latest()->take(3)->get();           //recent Games Played
                    $userId = $user['user_id'];

                    // $update = OcktedUserModel::where('user_id',$user_id)->update(['user_status' => 'Active']);
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
        $user = session()->get('User Data');
        Log::info("User Data", ["(OCKTED HOMEPAGE)" => $user]);

        //convert the image to link
        $score = OcktedUserModel::with('scores')->where('user_id', $user->user_id)->first();
        $totalScore = $score->scores()->sum('score');
        Log::info('Score', ['data:' => $totalScore]);

        // $recentGame = OcktedUserModel::with('scores.game')->where('user_id', $user->user_id)->first();
        // $recent = $recentGame->scores()->latest()->take(3)->get();

        $recent = DB::table('ockted_score')
                  ->join('ockted_users', 'ockted_score.user_id', '=', 'ockted_users.user_id')
                  ->join('ockted_games', 'ockted_score.game_code', '=', 'ockted_games.game_code')
                  ->select('ockted_games.game_title','ockted_score.score')
                  ->where('ockted_users.user_id', $user->user_id)
                  ->orderBy('ockted_score.created_at', 'desc')
                  ->limit(3)
                  ->get();


        $status = "Active";
        $gameData = OcktedGameModel::where('game_status', $status)->get();
        Log::info("Active Game", ['data:' => $gameData]);
        $totalGames = $gameData->count();
        Log::info("Total Game Count", ['data' => $totalGames]);

        $userId = $user['user_id'];
        $game_token = $user['game_token'];

        $user = $this->assignRank($totalScore, $userId);         //assign rank
        Log::info("RANK", ['rank' => $user]);

        $encrypted_token = $this->encryptToken($game_token);        //encrypting game_token which is gonna pass as an URL params
        Log::info("Encrypt Token", ['token' => $encrypted_token]);

        $last = session()->get('last_visited_page');
        Log::info("last page",['page' => $last]);

        // //data to be send to the view page
        // $combinedData = ['User Data' => $userExists,'Game Data' => $gameData, 'Score Data' => $recent , 'Total Score' => $totalScore, 'gameToken' => $encrypted_token];

        $combinedData = ['User Data' => $user, 'Game Data' => $gameData, 'Total Games' => $totalGames, 'Total Score' => $totalScore, 'Recent Games Played' => $recent, 'gameToken' => $encrypted_token];
        Log::info("combined Data", ['data' => $combinedData]);
        // return response()->json([
        //     'data' => $combinedData,
        // ]);

        return view('Main-Pages.homepage', compact('combinedData'));


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

            $userIDExists = OcktedUserModel::where('game_token', $decrypted_token)->first();
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


            $score = OcktedUserModel::select('ockted_users.user_id','ockted_users.username','ockted_users.profile_picture', OcktedScoreModel::raw('SUM(ockted_score.score) as total_score'))
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

        // $history = OcktedUserModel::where('user_id',$user)->select('ockted_users.')

        return view('Main-Pages.history');
    }

    public function isTokenValid(Request $request){             //checking if token is valid and if valid then send back user data as respsonse
        try{

            $token = $request->input('token');
            Log::info("Token", ['data' => $token]);

            $secretKey = env('ENCRYPTION_KEY');
            $decrypted_token = $this->decryptData($token, $secretKey);
            Log::info("Decrypt",['token'=>$decrypted_token]);

            $user = OcktedUserModel::where('game_token', $decrypted_token)->first();
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


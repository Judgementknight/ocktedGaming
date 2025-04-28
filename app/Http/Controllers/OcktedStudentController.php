<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ClassroomModel;
use App\Models\GameTypeModel\MCQQuestionModel;
use App\Models\GameroomModel;
use App\Models\Assignment\CustomGameAssignmentModel;
use App\Models\Assignment\CustomAssignmentCompleteModel;
use App\Models\Assignment\GameAssignmentCompleteModel;
use App\Models\Assignment\GameAssignmentModel;
use App\Models\OcktedGameModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OcktedGamingController;
use App\Models\OcktedStudentModel;
use App\Models\OcktedScoreModel;
use App\Models\GameTypeModel\PictureQuestionModel;
use App\Models\GameTypeModel\MathQuestionModel;

use Carbon\Carbon;

class OcktedStudentController extends Controller
{
    public function viewClassroomAssignment($classroomCode)
    {
        session()->put('Class Room Code', $classroomCode);
        $student = session()->get('Student Data');
        Log::info('Student',['data'=>$student]);


        $studentId = $student->student_id;
        Log::info("Student Id",['id'=> $studentId]);

        info('hitting viewClassroomAssignment methods');

        $classroom = ClassroomModel::with('teacher','assignments', 'gamerooms')->where('classroom_code', $classroomCode)->get();

        // $customAssignmentPending = DB::table('custom_game_assignments')
        // ->whereNotExists(function ($query) use ($studentId) {
        // $query->select(DB::raw(1))
        //       ->from('custom_assignment_complete')
        //       ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
        //       ->where('custom_game_assignments.gameroom_code = gamerooms.gameroom_code')
        //       ->where('gamerooms.classroom_code', $classroomCode)
        //       ->where('custom_assignment_complete.student_id', $studentId);
        // })
        // ->orWhereExists(function ($query) use ($studentId) {
        //     $query->select(DB::raw(1))
        //         ->from('custom_assignment_complete')
        //         ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
        //         ->where('custom_assignment_complete.student_id', $studentId)
        //         ->where('custom_assignment_complete.assignment_status', 'pending');
        // })
        // ->get();

        $customAssignmentPending = DB::table('custom_game_assignments')
        ->join('gamerooms', 'custom_game_assignments.gameroom_code', '=', 'gamerooms.gameroom_code')
        ->where('gamerooms.classroom_code', $classroomCode)
        ->where(function ($query) use ($studentId) {
            $query->whereNotExists(function ($subQuery) use ($studentId) {
                $subQuery->select(DB::raw(1))
                    ->from('custom_assignment_complete')
                    ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
                    ->where('custom_assignment_complete.student_id', $studentId);
            })
            ->orWhereExists(function ($subQuery) use ($studentId) {
                $subQuery->select(DB::raw(1))
                    ->from('custom_assignment_complete')
                    ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
                    ->where('custom_assignment_complete.student_id', $studentId)
                    ->where('custom_assignment_complete.assignment_status', 'pending');
            });
        })
        ->select('custom_game_assignments.*', 'gamerooms.*') // Including all columns from both tables
        ->orderBy('custom_game_assignments.created_at', 'desc') // Or use 'updated_at', based on your table structure
        ->take(3) // Limit to the latest 3
        ->get();

        $customAssignmentComplete = CustomAssignmentCompleteModel::with('assignment')
        ->where('student_id', $studentId)
        ->where('assignment_status', 'completed')
        ->orderBy('created_at', 'desc') // Order by created_at or any other timestamp field
        ->take(3) // Limit to the latest 3 records
        ->get();

        $customAssignmentOverdue = CustomAssignmentCompleteModel::with('assignment')
        ->where('student_id', $studentId)
        ->where('assignment_status', 'overdue')
        ->orderBy('created_at', 'desc') // Order by created_at or any other timestamp field
        ->take(3) // Limit to the latest 3 records
        ->get();        // $customAssignmentComplete = CustomAssignmentCompleteModel::where('student_id', $studentId)->get();

        $gameAssignmentPending = DB::table('game_assignments')
        ->whereNotExists(function ($query) use ($studentId) {
        $query->select(DB::raw(1))
              ->from('game_assignment_complete')
              ->whereRaw('game_assignment_complete.game_assignment_code = game_assignments.game_assignment_code')
              ->where('game_assignment_complete.student_id', $studentId);
        })
        ->orWhereExists(function ($query) use ($studentId) {
            $query->select(DB::raw(1))
                ->from('game_assignment_complete')
                ->whereRaw('game_assignment_complete.game_assignment_code = game_assignments.game_assignment_code')
                ->where('game_assignment_complete.student_id', $studentId)
                ->where('game_assignment_complete.assignment_status', 'pending');
        })
        ->get();


        // $pendingAssignment = AssignmentCompleteModel::with('assignment')->where('student_id', $studentId)->where('assignment_status','pending')->get();
        $gameAssignmentComplete = GameAssignmentCompleteModel::with('assignment')->where('student_id', $studentId)->where('assignment_status','completed')->get();
        $gameAssignmentOverdue = GameAssignmentCompleteModel::with('assignment')->where('student_id', $studentId)->where('assignment_status','overdue')->get();


        //HAVE TO MERGE
        //1.PENDING CUSTOM AND GAME
        $score = OcktedStudentModel::with('scores')->where('student_id', $studentId)->first();
        $totalScore = $score->scores->sum('score');

        $combinedData = ['classroom' => $classroom, 'Student Data' => $student, 'totalScore' => $totalScore];
        //     // 'student Assignment' => $studentAssignment,

        $pendingA = collect($customAssignmentPending ?? []);
        $pendingB = collect($gameAssignmentPending ?? []);

        $completeA = collect($customAssignmentComplete ?? []);
        $completeB = collect($gameAssignmentComplete ?? []);

        $overdueA = collect($customAssignmentOverdue ?? []);
        $overdueB = collect($gameAssignmentOverdue ?? []);

        // $pendingAll = $pendingA->merge($pendingB)->map(function($a) use ($combinedData) {
        //     return (object) [
        //         'assignment_title' => $a->assignment_title ?? $a->assignment_title,
        //         'due_date' => $a->due_date ?? $a->due_date,
        //         'assignment_code' => $a->custom_game_assignment_code ?? $a->game_assignment_code,
        //         'code' => $a->gameroom_code ?? $a->game_code,
        //     ];
        // });

        $completeAll = $completeA->merge($completeB)->map(function($a) use ($combinedData) {
            return (object) [
                'assignment_title' => $a->assignment->assignment_title ?? null,
                'due_date' => $a->assignment->due_date ?? null,
                'assignment_code' => $a->custom_game_assignment_code ?? $a->game_assignment_code,
            ];
        });

        $overdueAll = $overdueA->merge($overdueB)->map(function($a) use ($combinedData) {
            return (object) [
                'assignment_title' => $a->assignment->assignment_title ?? null,
                'due_date' => $a->assignment->due_date ?? null,
                'assignment_code' => $a->custom_game_assignment_code ?? $a->game_assignment_code,
            ];
        });

        // return response()->json([
        //     'data' => $combinedData,
        //     //'pending' => $pendingAll,
        //     'complete assi' => $customAssignmentComplete,
        //     'overdue' => $customAssignmentOverdue,
        //     'complete' => $completeAll,
        //     'pending' => $customAssignmentPending
        // ]);

        return view('Student.student-assignment', [
            'combinedData' => $combinedData,
            'pending' => $customAssignmentPending,
            'overdue' => $customAssignmentOverdue,
            'completed' => $customAssignmentComplete,
        ]);

    }

    public function viewAssignmentComplete($classroomCode)
    {
        $student = session()->get('Student Data');
        $studentId = $student->student_id;

        $score = OcktedStudentModel::with('scores')->where('student_id', $studentId)->first();
        $totalScore = $score->scores->sum('score');

        $classroom = ClassroomModel::with('teacher','assignments', 'gamerooms')->where('classroom_code', $classroomCode)->get();
        $combinedData = ['classroom' => $classroom, 'Student Data' => $student, 'totalScore' => $totalScore];

        $customAssignmentComplete = CustomAssignmentCompleteModel::withCount('assignment') // Counting related assignments
        ->where('student_id', $studentId)
        ->where('assignment_status', 'completed')
        ->orderBy('created_at', 'desc') // Order by created_at or any other timestamp field
        ->get();

        $customAssignmentCompleteCount = CustomAssignmentCompleteModel::withCount('assignment') // Counting related assignments
        ->where('student_id', $studentId)
        ->where('assignment_status', 'completed')
        ->orderBy('created_at', 'desc') // Order by created_at or any other timestamp field
        ->count();

        // return response()->json([
        //     'data' => $customAssignmentComplete,
        // ]);

        return view('Student.completed-assignment',[
            'completed' => $customAssignmentComplete,
            'combinedData' => $combinedData,
            'count' => $customAssignmentCompleteCount
        ]);
    }

    public function viewAssignmentPending($classroomCode)
    {
        $student = session()->get('Student Data');
        $studentId = $student->student_id;

        $score = OcktedStudentModel::with('scores')->where('student_id', $studentId)->first();
        $totalScore = $score->scores->sum('score');

        $classroom = ClassroomModel::with('teacher','assignments', 'gamerooms')->where('classroom_code', $classroomCode)->get();
        $combinedData = ['classroom' => $classroom, 'Student Data' => $student, 'totalScore' => $totalScore];

        $customAssignmentPending = DB::table('custom_game_assignments')
        ->join('gamerooms', 'custom_game_assignments.gameroom_code', '=', 'gamerooms.gameroom_code')
        ->where('gamerooms.classroom_code', $classroomCode)
        ->where(function ($query) use ($studentId) {
            $query->whereNotExists(function ($subQuery) use ($studentId) {
                $subQuery->select(DB::raw(1))
                    ->from('custom_assignment_complete')
                    ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
                    ->where('custom_assignment_complete.student_id', $studentId);
            })
            ->orWhereExists(function ($subQuery) use ($studentId) {
                $subQuery->select(DB::raw(1))
                    ->from('custom_assignment_complete')
                    ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
                    ->where('custom_assignment_complete.student_id', $studentId)
                    ->where('custom_assignment_complete.assignment_status', 'pending');
            });
        })
        ->select('custom_game_assignments.*', 'gamerooms.*') //Including all columns from both tables
        ->get();

        $customAssignmentPendingCount = DB::table('custom_game_assignments')
        ->join('gamerooms', 'custom_game_assignments.gameroom_code', '=', 'gamerooms.gameroom_code')
        ->leftJoin('custom_assignment_complete', function($join) use ($studentId) {
            $join->on('custom_game_assignments.custom_game_assignment_code', '=', 'custom_assignment_complete.custom_game_assignment_code')
                 ->where('custom_assignment_complete.student_id', '=', $studentId);
        })
        ->where('gamerooms.classroom_code', $classroomCode)
        ->where(function ($query) use ($studentId) {
            $query->whereNotExists(function ($subQuery) use ($studentId) {
                $subQuery->select(DB::raw(1))
                    ->from('custom_assignment_complete')
                    ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
                    ->where('custom_assignment_complete.student_id', $studentId);
            })
            ->orWhereExists(function ($subQuery) use ($studentId) {
                $subQuery->select(DB::raw(1))
                    ->from('custom_assignment_complete')
                    ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
                    ->where('custom_assignment_complete.student_id', $studentId)
                    ->where('custom_assignment_complete.assignment_status', 'pending');
            });
        })
        ->count();


        // return response()->json([
        //     'count' => $customAssignmentPendingCount,
        //     'data' => $customAssignmentPending
        // ]);

        return view('Student.pending-assignment',[
            'pending' => $customAssignmentPending,
            'combinedData' => $combinedData,
            'count' => $customAssignmentPendingCount,
        ]);

    }

    public function viewAssignmentOverdue($classroomCode)
    {
        $student = session()->get('Student Data');
        $studentId = $student->student_id;

        $score = OcktedStudentModel::with('scores')->where('student_id', $studentId)->first();
        $totalScore = $score->scores->sum('score');

        $classroom = ClassroomModel::with('teacher','assignments', 'gamerooms')->where('classroom_code', $classroomCode)->get();
        $combinedData = ['classroom' => $classroom, 'Student Data' => $student, 'totalScore' => $totalScore];

        $customAssignmentOverdueCount = CustomAssignmentCompleteModel::with('assignment')
        ->where('student_id', $studentId)
        ->where('assignment_status', 'overdue')
        ->orderBy('created_at', 'desc') // Order by created_at or any other timestamp field
        ->count();

        $customAssignmentOverdue = CustomAssignmentCompleteModel::with('assignment')
        ->where('student_id', $studentId)
        ->where('assignment_status', 'overdue')
        ->orderBy('created_at', 'desc') // Order by created_at or any other timestamp field
        ->get();

        // return response()->json([
        //     'data' => $customAssignmentOverdue,
        // ]);

        return view('Student.overdue-assignment',[
            'overdue' => $customAssignmentOverdue,
            'combinedData' => $combinedData,
            'count' => $customAssignmentOverdueCount
        ]);
    }

    public function viewAssignment($assignmentCode)
    //make changes
    // 1. check if gameroom_code available or not in gameroom_model if not check in game model
    {

        $customCodeExists = CustomGameAssignmentModel::where('custom_game_assignment_code',$assignmentCode)->first();
        if($customCodeExists){
            info('This is a custom game code');
            $student = session()->get('Student Data');
            $assignment = CustomGameAssignmentModel::where('custom_game_assignment_code', $assignmentCode)->first();

            $gameroomId = $assignment->gameroom_code;
            Log::info("Gameroom Data", ['data' => $gameroomId]);

            //make if conditions here

            $gameroom = GameroomModel::where('gameroom_code', $gameroomId)->first();
            Log::info("Gameroom Data", ['data' => $gameroom]);

            $gameTitle = $gameroom->gameroom_type;
            Log::info("Gameroom Data", ['data' => $gameTitle]);

            switch($gameTitle)
            {
                case "Multiple Choice Question":
                    $assignmentData = CustomGameAssignmentModel::with('questions')->where('custom_game_assignment_code',$assignmentCode)->get();
                    $assignmentData = MCQQuestionModel::with('choices')->where('custom_game_assignment_code',$assignmentCode)->get();
                    $combinedData = ['Assignment Data' => $assignment, 'Question Data' => $assignmentData, 'Game Room Data' => $gameroom, 'Student Data' => $student];
                    // return response()->json(['data' => $combinedData]);
                    return view('TeacherDashboard.customTeacherGame.mcq', compact('combinedData'));
                    break;
                case "Guess The Picture":
                    $assignmentData = CustomGameAssignmentModel::with('pictures')->where('custom_game_assignment_code',$assignmentCode)->get();
                    $combinedData = ['Assignment Data' => $assignment, 'Question Data' => $assignmentData, 'Game Room Data' => $gameroom, 'Student Data' => $student];
                    // return response()->json([
                    //     'data' => $combinedData,
                    // ]);
                    return view('TeacherDashboard.customTeacherGame.picture', compact('combinedData'));
                    break;
                case "Numbers":
                    $assignmentData = CustomGameAssignmentModel::with('maths')->where('custom_game_assignment_code',$assignmentCode)->get();
                    $combinedData = ['Assignment Data' => $assignment, 'Question Data' => $assignmentData, 'Game Room Data' => $gameroom, 'Student Data' => $student];
                    // return response()->json([
                    //         'data' => $combinedData,
                    // ]);
                    return view('TeacherDashboard.customTeacherGame.numbers', compact('combinedData'));
                    break;
                default:
                    return response()->json([
                        'message' => 'Assignment Not available',
                    ]);
            }
        }else{
            info('this is a game code');
            $studentData = session()->get('Student Data');
            $token = $studentData['game_token'];
            $id = $studentData['student_id'];
            $gameAssignmentCodeExists = GameAssignmentModel::where('game_assignment_code',$assignmentCode)->first();
            if($gameAssignmentCodeExists){
                $gameCode = $gameAssignmentCodeExists['game_code'];
                Log::info("GameCode Data", ['data' => $gameCode]);
                $gameData = OcktedGameModel::where('game_code',$gameCode)->first();
                $gameUrl = $gameData['game_url'];

                $encryptFunc = new OcktedGamingController();
                $encryptAssignmentCode = $encryptFunc->encryptToken($assignmentCode);
                return redirect()->away($gameUrl . '?token=' . urlencode($token) . '&code=' . urlencode($assignmentCode) . '&id=' . urlencode($id));
            }

        }

    }

    public function submitCustomAssignment(Request $request, $assignmentCode)
    {
        try{
            info('Hitting Submit Assignment Method');
            Log::info("Assignment", ['code' => $assignmentCode]);

            $assignmentType = CustomGameAssignmentModel::with('gameroom')->where('custom_game_assignment_code',$assignmentCode)->first();
            $gameroomType = $assignmentType['gameroom']['gameroom_type'];
            // return response()->json([
            //     'data' => $assignmentType,
            //     'game' => $gameroomType
            // ]);


            $score = 0;
            $today = Carbon::today();
            $classroomCode = session()->get('Class Room Code');

            switch($gameroomType){

                case 'Multiple Choice Question':
                    $assignmentCodeExists = CustomAssignmentCompleteModel::where('custom_game_assignment_code',$assignmentCode)->first();
                    if($assignmentCodeExists){
                                    $questions = MCQQuestionModel::where('custom_game_assignment_code', $assignmentCode)->get();
                                    $answer = $request->input('answers');

                                    foreach($questions as $question) {
                                        $mcqId = $question->mcq_id;
                                        $correctAns = $question->mcq_correct;

                                        if (isset($answer[$mcqId])) {
                                            $userAns = $answer[$mcqId];

                                            if ($userAns == $correctAns) {
                                                $score++;
                                            } else {
                                                info('wrong');
                                            }
                                        } else {
                                            info('Student skipped this question');
                                        }
                                    }

                                    $student = session()->get('Student Data');
                                    $studentId = $student->student_id;

                                    $assignment = CustomGameAssignmentModel::where('custom_game_assignment_code',$assignmentCode)->first();
                                    $dueDate = $assignment['due_date'];
                                    Log::info("Due Date", ['data' => $dueDate]);

                                    $assignmentCompleteExists = CustomAssignmentCompleteModel::where([
                                        ['student_id', '=', $studentId],
                                        ['custom_game_assignment_code', '=', $assignmentCode]
                                    ])->first();

                                    Log::info("STUDENT EXISTS",['user' => $assignmentCompleteExists]);

                                    if ($assignmentCompleteExists) {
                                        //Update existing record
                                        if($today > $dueDate){
                                            $assignmentCompleteExists->update([
                                                'score' => $score,
                                                'assignment_status' => 'overdue',
                                                'submitted_at' => $today,
                                            ]);
                                        }else{
                                            $assignmentCompleteExists->update([
                                                'score' => $score,
                                                'assignment_status' => 'completed',
                                                'submitted_at' => $today,
                                            ]);
                                        }
                                    } else {
                                        //Create a new entry if the student doesn't have one
                                        if($today > $dueDate){
                                            CustomAssignmentCompleteModel::create([
                                                'student_id' => $studentId,
                                                'custom_game_assignment_code' => $assignmentCode,
                                                'score' => $score,
                                                'assignment_status' => 'overdue',
                                                'submitted_at' => $today,
                                            ]);
                                        }else{
                                            CustomAssignmentCompleteModel::create([
                                                'student_id' => $studentId,
                                                'custom_game_assignment_code' => $assignmentCode,
                                                'score' => $score,
                                                'assignment_status' => 'completed',
                                                'submitted_at' => $today,

                                            ]);
                                        }
                                    }

                                    session()->flash('assignment completed', true);
                                    return redirect()->route('view-classroom-assignment', ['classroom_code' => $classroomCode]);
                    }else{
                        $gamescore = $request->input('score');
                        $token = $request->input('token');
                        $assignCode = $request->input('code');
                        $studentId = $request->input('id');

                        Log::info("student_id", ['id' => $studentId]);


                        $decryptFunc = new OcktedGamingController();
                        $decryptAssignmentCode = $decryptFunc->decryptToken($assignmentCode);
                        $decryptToken = $decryptFunc->decryptToken($token);

                        $gameAssignmentCode = GameAssignmentCompleteModel::where('game_assignment_code',$decryptAssignmentCode)->first();


                        $decryptFunc = new OcktedGamingController();
                        $decryptToken = $decryptFunc->decryptToken($token);

                        $today = Carbon::now();

                        $studentIdExists = GameAssignmentCompleteModel::where('student_id', $studentId)->where('game_assignment_code', $assignmentCode)->first();
                        Log::info("student exists", ['id' => $studentIdExists]);
                        info('passed this point');

                        if($studentIdExists){
                            GameAssignmentCompleteModel::where('student_id', $studentId)
                            ->where('game_assignment_code', $assignmentCode)
                            ->update([
                                'score' => $gamescore,
                                'assignment_status' => 'completed',
                                'submitted_at' => $today,
                            ]);
                        }else{
                            $assignment = GameAssignmentCompleteModel::create([
                                'student_id' => $studentId,
                                'game_assignment_code' => $assignmentCode,
                                'score' => $gamescore,
                                'assignment_status' => 'completed',
                                'submitted_at' => $today,
                            ]);
                        }
                    }
                    break;

                case 'Guess The Picture':
                    $assignmentCodeExists = CustomAssignmentCompleteModel::where('custom_game_assignment_code',$assignmentCode)->first();
                    if($assignmentCodeExists){
                        info('assignment Exists ??');
                                    $questions = PictureQuestionModel::where('custom_game_assignment_code', $assignmentCode)->get();
                                    $answer = $request->input('answers');

                                    Log::info('answer',['data' => $answer]);

                                    foreach($questions as $question) {
                                        $mcqId = $question->picture_game_id;
                                        $correctAns = $question->correct;

                                        if (isset($answer[$mcqId])) {
                                            $userAns = $answer[$mcqId];

                                            if ($userAns == $correctAns) {
                                                $score++;
                                            } else {
                                                info('wrong');
                                            }
                                        } else {
                                            info('Student skipped this question');
                                        }
                                    }
                                    Log::info("SCORE", ['data' => $score]);
                                    $student = session()->get('Student Data');
                                    $studentId = $student->student_id;

                                    $assignment = CustomGameAssignmentModel::where('custom_game_assignment_code',$assignmentCode)->first();
                                    $dueDate = $assignment['due_date'];
                                    Log::info("Due Date", ['data' => $dueDate]);

                                    $assignmentCompleteExists = CustomAssignmentCompleteModel::where([
                                        ['student_id', '=', $studentId],
                                        ['custom_game_assignment_code', '=', $assignmentCode]
                                    ])->first();

                                    Log::info("STUDENT EXISTS",['user' => $assignmentCompleteExists]);

                                    if ($assignmentCompleteExists) {
                                        //Update existing record
                                        if($today > $dueDate){
                                            $assignmentCompleteExists->update([
                                                'score' => $score,
                                                'assignment_status' => 'overdue',
                                                'submitted_at' => $today,
                                            ]);
                                        }else{
                                            $assignmentCompleteExists->update([
                                                'score' => $score,
                                                'assignment_status' => 'completed',
                                                'submitted_at' => $today,
                                            ]);
                                        }
                                    } else {
                                        //Create a new entry if the student doesn't have one
                                        if($today > $dueDate){
                                            CustomAssignmentCompleteModel::create([
                                                'student_id' => $studentId,
                                                'custom_game_assignment_code' => $assignmentCode,
                                                'score' => $score,
                                                'assignment_status' => 'overdue',
                                                'submitted_at' => $today,
                                            ]);
                                        }else{
                                            CustomAssignmentCompleteModel::create([
                                                'student_id' => $studentId,
                                                'custom_game_assignment_code' => $assignmentCode,
                                                'score' => $score,
                                                'assignment_status' => 'completed',
                                                'submitted_at' => $today,

                                            ]);
                                        }
                                    }

                                    session()->flash('assignment completed', true);
                                    return redirect()->route('view-classroom-assignment', ['classroom_code' => $classroomCode]);
                    }
                    break;

                case 'Numbers':
                    $assignmentCodeExists = CustomAssignmentCompleteModel::where('custom_game_assignment_code',$assignmentCode)->first();
                    if($assignmentCodeExists){
                        info('assignment Exists ??');
                                    $questions = MathQuestionModel::where('custom_game_assignment_code', $assignmentCode)->get();
                                    $answer = $request->input('answers');

                                    Log::info('answer',['data' => $answer]);

                                    foreach($questions as $question) {
                                        $mcqId = $question->math_game_id;
                                        $correctAns = $question->correct;

                                        if (isset($answer[$mcqId])) {
                                            $userAns = $answer[$mcqId];

                                            if ($userAns == $correctAns) {
                                                $score++;
                                            } else {
                                                info('wrong');
                                            }
                                        } else {
                                            info('Student skipped this question');
                                        }
                                    }
                                    Log::info("SCORE", ['data' => $score]);
                                    $student = session()->get('Student Data');
                                    $studentId = $student->student_id;

                                    $assignment = CustomGameAssignmentModel::where('custom_game_assignment_code',$assignmentCode)->first();
                                    $dueDate = $assignment['due_date'];
                                    Log::info("Due Date", ['data' => $dueDate]);

                                    $assignmentCompleteExists = CustomAssignmentCompleteModel::where([
                                        ['student_id', '=', $studentId],
                                        ['custom_game_assignment_code', '=', $assignmentCode]
                                    ])->first();

                                    Log::info("STUDENT EXISTS",['user' => $assignmentCompleteExists]);

                                    if ($assignmentCompleteExists) {
                                        //Update existing record
                                        if($today > $dueDate){
                                            $assignmentCompleteExists->update([
                                                'score' => $score,
                                                'assignment_status' => 'overdue',
                                                'submitted_at' => $today,
                                            ]);
                                        }else{
                                            $assignmentCompleteExists->update([
                                                'score' => $score,
                                                'assignment_status' => 'completed',
                                                'submitted_at' => $today,
                                            ]);
                                        }
                                    } else {
                                        //Create a new entry if the student doesn't have one
                                        if($today > $dueDate){
                                            CustomAssignmentCompleteModel::create([
                                                'student_id' => $studentId,
                                                'custom_game_assignment_code' => $assignmentCode,
                                                'score' => $score,
                                                'assignment_status' => 'overdue',
                                                'submitted_at' => $today,
                                            ]);
                                        }else{
                                            CustomAssignmentCompleteModel::create([
                                                'student_id' => $studentId,
                                                'custom_game_assignment_code' => $assignmentCode,
                                                'score' => $score,
                                                'assignment_status' => 'completed',
                                                'submitted_at' => $today,

                                            ]);
                                        }
                                    }

                                    session()->flash('assignment completed', true);
                                    return redirect()->route('view-classroom-assignment', ['classroom_code' => $classroomCode]);
                    }
                    break;

                default:
                    return response()->json([
                        'message' => 'This game is not valid'
                    ]);
                    break;
            }


        }catch(Exception $e)
        {
            Log::error("erorr", ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()]);

        }

    }

    public function gameView()
    {
        $student = session()->get('Student Data');
        $studentId = $student->student_id;
        $games = OcktedGameModel::all();
        $score = OcktedStudentModel::with('scores')->where('student_id', $studentId)->first();
        $totalScore = $score->scores->sum('score');
        // return response()->json([
        //     'student' => $student,
        //     'games' => $games,
        //     'score' => $score,
        //     'totalScore' => $totalScore
        // ]);
        return view('Student.student-games', [
            'student' => $student,
            'games' => $games,
            'totalScore' => $totalScore
        ]);
    }

    public function playGame($gameCode)
    {

        Log::info("Game", ['code' => $gameCode]);
        $game = OcktedGameModel::where('game_code', $gameCode)->first();
        $gameUrl = $game->game_url;
        Log::info("Game", ['url' => $gameUrl]);
        $student = session()->get('Student Data');
        $token = $student->game_token;
        Log::info("Game", ['token' => $token]);

        $encryptFunc = new OcktedGamingController();
        $encryptGameToken = $encryptFunc->encryptToken($token);
        $returnUrl = 'http://127.0.0.1:8008/return';
        // $returnUrl = 'https://games.prayagedu.com/return';

        // $fullUrl = $gameUrl . '?token=' . urlencode($encryptGameToken) . '&url=' . urlencode($returnUrl) . '&gamecode=' . urlencode($gameCode);


        $combinedData = (object) [
            'gameUrl' => $gameUrl,
            'token' => $encryptGameToken,
            'returnUrl' => $returnUrl,
            'code' => $gameCode,
        ];

        // return response()->json([
        //     'data' => $combinedData,
        // ]);
        session()->put('Student Data', $student);

        return view('Student.redirecting', compact('combinedData'));


    }

    public function storeScore(Request $request)
    {

        info('SCORE');
        $score = $request->input('score');
        $code = $request->input('code');
        $token = $request->input('gameToken');


        $decryptFunc = new OcktedGamingController();
        $decryptToken = $decryptFunc->decryptToken($token);

        $student = OcktedStudentModel::where('game_token', $decryptToken)->first();

        $studentId = $student->student_id;

        $score = OcktedScoreModel::create([
            'score' => $score,
            'student_id' => $studentId,
            'game_code' => $code,
        ]);
    }

    public function returnToken(Request $request)
    {
        //Retrieve token from the query parameter
        $token = $request->query('token');
        $code = $request->query('code');

        if($token && !$code){
            $decryptFunc = new OcktedGamingController();
            $decryptToken = $decryptFunc->decryptToken($token);
            $student = OcktedStudentModel::where('game_token', $decryptToken)->first();
            session()->put('Student Data', $student);
            return redirect()->route('ockted');
        }

        Log::info('token', ['data' => $token]);
        Log::info('code', ['data' => $code]);

        info('hitting return function with token: ' . $token);
        info('hitting return function');
        $decryptFunc = new OcktedGamingController();
        $decryptToken = $decryptFunc->decryptToken($token);

        $student = OcktedStudentModel::where('game_token', $decryptToken)->first();

        session()->put('Student Data', $student);

        Log::info('session data in return', ['data' => session()->get('Student Data')]);

        $scoreData = OcktedScoreModel::with('student')->where('game_code',$code)->first();
        $game = OcktedGameModel::where('game_code',$code)->first();

        session()->flash('game-played', [
            'status' => true,
            'game' => $game->game_title ?? 'Unknown Game',
            'score' => $scoreData->score ?? null,
        ], true);

        // session()->flash('game-played', true);

        // return response()->json([
        //     'score' => $scoreData,
        //     'game' => $game
        // ]);

        return redirect()->route('ockted');
    }

    public function leaderboard()
    {

        $student = session()->get('Student Data');
        $studentId = $student->student_id;
        $score = OcktedStudentModel::with('scores')->where('student_id', $studentId)->first();
        $totalScore = $score->scores->sum('score');


        $studentScores = DB::table('ockted_score')
        ->join('ockted_students', 'ockted_score.student_id', '=', 'ockted_students.student_id')
        ->select(
            'ockted_students.student_id',
            'ockted_students.student_name',
            'ockted_students.profile_picture',
            DB::raw('SUM(ockted_score.score) as total_score')
        )
        ->groupBy('ockted_students.student_id', 'ockted_students.student_name', 'ockted_students.profile_picture')
        ->orderByDesc('total_score')
        ->get();

        // return response()->json([
            // 'score' => $studentScores
        // ]);

        return view('Student.leaderboard', [
            'scores' => $studentScores,
            'student' => $student,
            'TotalScore' => $totalScore
        ]);
    }
}


// not working queries
// $studentAssignment = DB::table('custom_assignment_complete')
        //                     ->join('custom_game_assignments', 'custom_assignment_complete.custom_game_assignment_code','=', 'custom_game_assignments.custom_game_assignment_code')
        //                     ->join('gamerooms', 'custom_game_assignments.gameroom_code', '=', 'gamerooms.gameroom_code')
        //                     ->join('classrooms', 'gamerooms.classroom_code', '=', 'classrooms.classroom_code')
        //                     ->join('classroom_mapping', 'classrooms.classroom_code', '=', 'classroom_mapping.classroom_code')
        //                     ->join('ockted_students', 'classroom_mapping.student_id', '=', 'ockted_students.student_id')
        //                     ->select('custom_assignment_complete.*','custom_game_assignments.*', 'ockted_students.*')
        //                     ->where('classrooms.classroom_code', $classroomCode)
        //                     ->where('custom_assignment_complete.assignment_status', 'completed')
        //                     ->where('custom_game_assignments.custom_game_assignment_code', 'AS4248')
        //                     ->get();

        // $studentAssignment = DB::table('custom_assignment_complete')
        // ->join('custom_game_assignments', 'custom_assignment_complete.custom_game_assignment_code', '=', 'custom_game_assignments.custom_game_assignment_code')
        // ->join('gamerooms', 'custom_game_assignments.gameroom_code', '=', 'gamerooms.gameroom_code')
        // ->join('classrooms', 'gamerooms.classroom_code', '=', 'classrooms.classroom_code')
        // ->join('classroom_mapping', function ($join) {
        //      $join->on('classrooms.classroom_code', '=', 'classroom_mapping.classroom_code')
        //           ->on('custom_assignment_complete.student_id', '=', 'classroom_mapping.student_id');
        // })
        // ->join('ockted_students', 'classroom_mapping.student_id', '=', 'ockted_students.student_id')
        // ->select('custom_assignment_complete.*','custom_game_assignments.*', 'ockted_students.*')
        // ->where('classrooms.classroom_code', $classroomCode)
        // ->where('custom_assignment_complete.assignment_status', 'completed')
        // ->where('custom_game_assignments.custom_game_assignment_code', 'AS9844')
        // ->get();


        // $pendingAssignment = DB::table('custom_game_assignments')
        // ->whereNotExists(function ($query) use ($studentId) {
        //     $query->select(DB::raw(1))
        //           ->from('custom_assignment_complete')
        //           ->whereRaw('custom_assignment_complete.custom_game_assignment_code = custom_game_assignments.custom_game_assignment_code')
        //           ->where('custom_assignment_complete.student_id', $studentId);
        // })
        // ->get();

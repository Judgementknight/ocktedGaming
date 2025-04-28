<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassroomModel;
use App\Models\OcktedStudentModel;
use App\Models\ClassroomMappingModel;
use App\Models\GameroomModel;
use App\Models\OcktedGameModel;
use App\Models\Assignment\CustomGameAssignmentModel;
use App\Models\Assignment\GameAssignmentModel;
use Illuminate\Support\Facades\DB;
use App\Models\GameTypeModel\MCQChoiceModel;
use App\Models\GameTypeModel\MCQQuestionModel;
use App\Models\Assignment\CustomAssignmentCompleteModel;
use App\Models\Assignment\GameAssignmentCompleteModel;
use App\Models\GameTypeModel\PictureQuestionModel;
use App\Models\GameTypeModel\MathQuestionModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OcktedTeacherController extends Controller
{
    public function createClassroom(Request $request)
    {
        try{
            info('Creating GameRoom Process');
            $teacherSession = session()->get('Teacher Data');
            Log::info('Teacher Session', ['data:' => session('Teacher Data')]);
            info('Hitting this request');

            $schoolCode = $teacherSession['school_code'];
            $teacherId = $teacherSession['teacher_id'];
            $classRoomCode = $this->createClassRoomCode();

            $field = $request->validate([
               'classroom_title' => 'required|string',
               'classroom_description' => 'required|string|max',
               'class_level' => 'required|string',
               'classroom_color' => 'required|string',
            ]);

            info('validation pass');

            $classRoomData = [
                'classroom_title' => $field['classroom_title'],
                'classroom_description' => $field['classroom_description'],
                'class_level' => $field['class_level'],
                'classroom_color' => $field['classroom_color'],
                'teacher_id' => $teacherId,
                'classroom_code' => $classRoomCode,
                'school_code' => $schoolCode,
            ];

            Log::info("ClassRoom", ['data' => $classRoomData]);

            $classroomExists = ClassroomModel::where('teacher_id', $teacherId)->where('classroom_title', $field['classroom_title'])->first();

            if($classroomExists){
                session()->flash('classroom-exists', true);
                return redirect()->route('ockted');
            }

            $classroom = ClassroomModel::create($classRoomData);
            Log::info("ClassRoom", ['data' => $classroom]);
            session()->flash('classroom-created', true);

            return redirect()->route('ockted');
        }catch(Exception $e){
            Log::error("Error", ['error' => $e->getMessage()]);
        }
    }

    public function createGameRoom(Request $request)
    {
        $code = session()->get('Class Room Code');
        Log::info("Class Room Code", ['code' => $code]);
        $gameroomCode = $this->createGameroomCode();

        $field = $request->validate([
            'gameroom_type' => 'required|string',
            'gameroom_color' => 'required|string',
        ]);
        Log::info("Gameroom",['data' => $field]);

        $gameroomExists = GameroomModel::where('gameroom_type', $field['gameroom_type'])->where('classroom_code',$code)->first();
        if($gameroomExists){
            session()->flash('gameroom-exists', true);
            return redirect()->back();
        }
        $gameroom = GameroomModel::create([
            'gameroom_type' => $field['gameroom_type'],
            'gameroom_color' => $field['gameroom_color'],
            'gameroom_code' => $gameroomCode,
            'classroom_code' => $code,
        ]);

        session()->flash('gameroom-created', true);
        return redirect()->back();

    }

    public function classroomDetails($classroomCode)
    {
        // what to display in gameroomDetail
        // 1. Student in gameroom
        // 2. Gameroom Link
        // 3. Teacher
        // 4. Assignment
        // 5. Total Student
        // 6. Total Assignment
        // 7. Game Data in select option
        // 8. Game Room Data

        info('Class room Details');
        // $gameroomCode = $request->input('gameroom_code');
        Log::info("Class Room", ['code:' => $classroomCode]);

        $classroomStudent = ClassroomModel::with('students')
            ->where('classroom_code', $classroomCode)
            ->first();

        Log::info("Student in Room", ['data' => $classroomStudent]);

        // $totalStudent = count($classroomStudent->students);
        // Log::info("total students", ['total' => $totalStudent]);


        // 2. Game Room Link
        $classroomLink = "https://127.0.0.1:8008/api/join-room/{$classroomCode}";

        // 4. GameRoom Assignment
        $gameroom = GameroomModel::where('classroom_code', $classroomCode)->get();
        $totalgameroom = count($gameroom);


        // $roomDetails = ['Room Link' => $gameroomLink, 'Students' => $gameroom];


        // 7. Game Data
        $games = OcktedGameModel::where('game_status', 'active')->get();
        Log::info("Games", ['data' => $games]);

        // 8. Class Room Data
        $classRoom = ClassroomModel::where('classroom_code', $classroomCode)->get();

        session()->put('Class Room Code', $classroomCode);

        // $assignments = DB::table('classrooms')
        //                ->join('gamerooms', 'classrooms.classroom_code', '=', 'gamerooms.classroom_code')
        //                ->join('custom_game_assignments', 'gamerooms.gameroom_code', '=', 'custom_game_assignments.gameroom_code')
        //                ->where('classrooms.classroom_code', $classroomCode)
        //                ->select('custom_game_assignments.*')
        //                ->get();

        $assignments = DB::table('custom_game_assignments')
        ->join('gamerooms', 'custom_game_assignments.gameroom_code', '=', 'gamerooms.gameroom_code')
        ->join('classrooms', 'gamerooms.classroom_code', '=', 'classrooms.classroom_code')
        // Use leftJoin so assignments with no completions still show up.
        ->leftJoin('custom_assignment_complete', 'custom_game_assignments.custom_game_assignment_code', '=', 'custom_assignment_complete.custom_game_assignment_code')
        ->where('classrooms.classroom_code', $classroomCode)
        ->select(
            'custom_game_assignments.assignment_id',
            'custom_game_assignments.custom_game_assignment_code',
            'custom_game_assignments.gameroom_code',
            'custom_game_assignments.assignment_title',
            'custom_game_assignments.due_date',
            DB::raw("SUM(CASE WHEN custom_assignment_complete.assignment_status = 'completed' THEN 1 ELSE 0 END) as completed_students")
        )
        ->groupBy(
            'custom_game_assignments.assignment_id',
            'custom_game_assignments.custom_game_assignment_code',
            'custom_game_assignments.gameroom_code',
            'custom_game_assignments.assignment_title',
            'custom_game_assignments.due_date'
        )
        ->get();

        $gameAssignments = GameAssignmentModel::with('game')->where('classroom_code',$classroomCode)->get();

        $stats = DB::table('game_assignments')
            ->leftJoin('classroom_mapping', function($j){
                $j->on('game_assignments.classroom_code', '=', 'classroom_mapping.classroom_code');
            })
            ->leftJoin('game_assignment_complete', function($j){
                $j->on('game_assignments.game_assignment_code', '=', 'game_assignment_complete.game_assignment_code')
                ->where('game_assignment_complete.assignment_status', 'completed');
            })
            ->where('game_assignments.classroom_code', $classroomCode)
            ->select(
                'game_assignments.assignment_id',
                'game_assignments.game_assignment_code',
                'game_assignments.assignment_title',
                'game_assignments.due_date',
                DB::raw('COUNT(DISTINCT classroom_mapping.student_id) as total_students'),
                DB::raw('COUNT(DISTINCT game_assignment_complete.student_id) as completed_students')
            )
            ->groupBy(
                'game_assignments.assignment_id',
                'game_assignments.game_assignment_code',
                'game_assignments.assignment_title',
                'game_assignments.due_date'
            )
            ->get();

        // this is what the above query is doin
        // SELECT
        //     game_assignments.assignment_id,
        //     game_assignments.game_assignment_code,
        //     game_assignments.assignment_title,
        //     game_assignments.due_date,
        //     COUNT(DISTINCT classroom_mapping.student_id) AS total_students,
        //     COUNT(DISTINCT game_assignment_complete.student_id) AS completed_students
        //     FROM game_assignments
        //     LEFT JOIN classroom_mapping
        //     ON game_assignments.classroom_code = classroom_mapping.classroom_code
        //     LEFT JOIN game_assignment_complete
        //     ON game_assignments.game_assignment_code = game_assignment_complete.game_assignment_code
        //         AND game_assignment_complete.assignment_status = 'completed'
        //     WHERE game_assignments.classroom_code = :classroomCode
        //     GROUP BY
        //     game_assignments.assignment_id,
        //     game_assignments.game_assignment_code,
        //     game_assignments.assignment_title,
        //     game_assignments.due_date;

        $totalAssignment = count($assignments);

        $totalStudent = DB::table('classrooms')
                        ->join('classroom_mapping', 'classrooms.classroom_code', '=', 'classroom_mapping.classroom_code')
                        ->join('ockted_students', 'classroom_mapping.student_id', '=', 'ockted_students.student_id')
                        ->where('classroom_mapping.classroom_code', $classroomCode)
                        ->count();

        $combinedData = ['Game Data' => $games, 'Class Room Link' => $classroomLink, 'Game Room' => $gameroom, 'Class Room' => $classRoom, 'Total Game Room' => $totalgameroom, 'Student in Room' => $classroomStudent, 'Total Student' => $totalStudent, 'Assignments' => $assignments, 'Total Assignment' => $totalAssignment, 'Game Assignment' => $stats];
        Log::info("Room", ['data' => $combinedData]);

        $assignA = collect($combinedData['Assignments'] ?? []);
        $assignB = collect($combinedData['Game Assignment'] ?? []);

        $all = $assignA->merge($assignB)->map(function($a) use($combinedData) {
            return (object)[
                'code'              => $a->custom_game_assignment_code
                                       ?? $a->game_assignment_code,
                'title'             => $a->assignment_title,
                'due_date'          => $a->due_date,
                'completed_students'=> $a->completed_students ?? 0,
                'total_students'    => $a->total_students
                                       ?? $combinedData['Total Student'] ?? 0,
            ];
        });

        $totalGames = count($games);

        $totalAssignmentCount = count($all);

        // return response()->json([
        //     'data' => $combinedData,
        //     'assignments' => $all,
        //     'Total Assignment' => $all->count(),
        //     'Total Student'    => $combinedData['Total Student'],
        //     'totalGames' => $totalGames
        // ]);

        // return view('TeacherDashboard.teacher-classroom', compact('combinedData'));
        return view('TeacherDashboard.teacher-classroom', [
            'combinedData'     => $combinedData,
            'assignments'      => $all,
            'totalAssignments' => $all->count(),
            'totalStudents'    => $combinedData['Total Student'],
            'totalAssignmentCount' => $totalAssignmentCount,
            'totalGames' => $totalGames
        ]);
    }

    public function viewGameRoom($gameroom_code)
    {
        info('hitting gameroom');
        $classroomCode = session()->get('Class Room Code');
        $gameroom = GameroomModel::where('gameroom_code', $gameroom_code)->first();
        if(!$gameroom){
            return response()->json([
                'message' => 'Game View Error'
            ]);
        }
        $gameroomType = $gameroom['gameroom_type'];
        $combinedData = ['Class Room' => $classroomCode, 'Game Room' => $gameroom];
        info('hitting assignment controller');
        session()->put('Game Room Code', $gameroom_code);

        // return response()->json([
        //     'data' => $combinedData,
        // ]);

        switch($gameroomType) {
            case "Multiple Choice Question":
                return view('TeacherDashboard.Assignment.teacher-mcq-room', compact('combinedData'));
                break;
            case "Guess The Picture":
                return view('TeacherDashboard.Assignment.teacher-picture-room', compact('combinedData'));
                break;
            case "Numbers":
                return view('TeacherDashboard.Assignment.teacher-math-room', compact('combinedData'));
                break;
            default:
                return response()->json([
                    'message' => 'No Game Room',
                ]);
        }
    }

    public function createAssignment(Request $request)
    {
        info('hitting create assignment');
        $validated = $request->validate([
            'assignment_title' => 'required|string',
            'due_date' => 'required|date',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string|max:500',
            'questions.*.choices' => 'required|array|min:2',
            'questions.*.correct' => 'required|string',
        ]);

        info('pass validate');

        // Verify correct answer exists in choices
        foreach ($validated['questions'] as $question) {
            if (!in_array($question['correct'], $question['choices'])) {
                return back()->withErrors(['correct' => 'Correct answer must be one of the choices']);
            }
        }

        Log::info('session???',['data' => session('Game Room Code')]);

        // Create assignment
        $assignment = CustomGameAssignmentModel::create([
            'custom_game_assignment_code' => $this->createAssignmentCode(),
            'gameroom_code' => session()->get('Game Room Code'),
            'assignment_title' => $validated['assignment_title'],
            'due_date' => $validated['due_date'],
        ]);

        // Create questions and choices
        foreach ($validated['questions'] as $questionData) {
            $question = MCQQuestionModel::create([
                'custom_game_assignment_code' => $assignment->custom_game_assignment_code,
                'mcq_question' => $questionData['text'],
                'mcq_correct' => $questionData['correct'],
            ]);

            foreach ($questionData['choices'] as $choice) {
                MCQChoiceModel::create([
                    'mcq_id' => $question->mcq_id,
                    'option_text' => $choice
                ]);
            }
        }

        // === AUTO-CREATE PENDING ASSIGNMENTS FOR STUDENTS ===
        // Find the Gameroom
        $gameroom = GameroomModel::where('gameroom_code', $assignment->gameroom_code)->first();

        if (!$gameroom) {
            return back()->withErrors(['gameroom' => 'Gameroom not found']);
        }

        // Find the Classroom linked to this Gameroom
        $students = ClassroomMappingModel::where('classroom_code', $gameroom->classroom_code)->get();

        if ($students->isNotEmpty()) {
            // return back()->withErrors(['students' => 'No students found in this classroom']);
            // Insert a pending assignment entry for each student
            foreach ($students as $student) {
                CustomAssignmentCompleteModel::create([
                    'student_id' => $student->student_id,
                    'custom_game_assignment_code' => $assignment->custom_game_assignment_code,
                    'assignment_status' => 'pending', // Default status
                ]);
            }
        }


        session()->flash('assignment-created', true);
        return redirect()->back();
    }

    public function createPictureAssignment(Request $request)
    {
        info('Hitting Picture Assignment');
        $validated = $request->validate([
            'assignment_title' => 'string|required',
            'due_date' => 'required|date',
            'pictures' => 'required|array|min:1',
            'pictures.*.image_url' => 'required|string',
            'pictures.*.question_text' => 'required|string',
            'pictures.*.correct_answer' => 'required|string',
        ]);

        $assignment = CustomGameAssignmentModel::create([
            'assignment_title' => $validated['assignment_title'],
            'due_date' => $validated['due_date'],
            'custom_game_assignment_code' => $this->createAssignmentCode(),
            'gameroom_code' => session()->get('Game Room Code'),
        ]);

        foreach($validated['pictures'] as $pictureData)
        {
            $picture = PictureQuestionModel::create([
                'custom_game_assignment_code' => $assignment->custom_game_assignment_code,
                'question' => $pictureData['question_text'],
                'image_url' => $pictureData['image_url'],
                'correct' => $pictureData['correct_answer'],
            ]);
        }

                // === AUTO-CREATE PENDING ASSIGNMENTS FOR STUDENTS ===
        // Find the Gameroom
        $gameroom = GameroomModel::where('gameroom_code', $assignment->gameroom_code)->first();

        if (!$gameroom) {
            return back()->withErrors(['gameroom' => 'Gameroom not found']);
        }

        // Find the Classroom linked to this Gameroom
        $students = ClassroomMappingModel::where('classroom_code', $gameroom->classroom_code)->get();

        if ($students->isNotEmpty()) {
            // return back()->withErrors(['students' => 'No students found in this classroom']);
            // Insert a pending assignment entry for each student
            foreach ($students as $student) {
                CustomAssignmentCompleteModel::create([
                    'student_id' => $student->student_id,
                    'custom_game_assignment_code' => $assignment->custom_game_assignment_code,
                    'assignment_status' => 'pending', // Default status
                ]);
            }
        }


        session()->flash('assignment-created', true);
        return redirect()->back();


    }

    public function createMathAssignment(Request $request)
    {
        try {
            $validated = $request->validate([
                'assignment_title' => 'required|string|max:255',
                'due_date' => 'required|date|after:now',
                'math_questions' => 'required|array|min:1|max:20',
                'math_questions.*.problem_image' => [
                    'nullable',
                    'string',
                    'regex:/^data:image\/[a-zA-Z+]+;base64,/i'
                ],
                'math_questions.*.problem_text' => 'nullable|string|max:500',
                'math_questions.*.correct_answer' => 'required|numeric',
            ]);

            // Validate at least one of text or image per question
            foreach ($request->math_questions as $index => $question) {
                if (empty($question['problem_text']) && empty($question['problem_image'])) {
                    return back()->withErrors([
                        "math_questions.$index" => "Each question must have either text or image"
                    ])->withInput();
                }
            }

            $assignment = CustomGameAssignmentModel::create([
                'assignment_title' => $validated['assignment_title'],
                'due_date' => $validated['due_date'],
                'custom_game_assignment_code' => $this->createAssignmentCode(),
                'gameroom_code' => session()->get('Game Room Code'),
            ]);

            foreach ($validated['math_questions'] as $index => $mathData) {
                $imagePath = null;

                if (!empty($mathData['problem_image'])) {
                    try {
                        $imageData = base64_decode(preg_replace(
                            '#^data:image/\w+;base64,#i',
                            '',
                            $mathData['problem_image']
                        ));

                        Log::info('Processing image for question: ' . $index);

                        if (!$imageData) {
                            throw new \Exception('Invalid base64 image data');
                        }

                        $imageName = 'math_'.Str::random(20).'_'.time().'.png';
                        $storagePath = 'math_images/'.$imageName;

                        if (!Storage::disk('public')->put($storagePath, $imageData)) {
                            throw new \Exception('Failed to store image');
                        }

                        $imagePath = $storagePath;
                    } catch (\Exception $e) {
                        Log::error('Image processing failed: '.$e->getMessage(), [
                            'question_index' => $index
                        ]);

                        return back()->withErrors([
                            "math_questions.$index.problem_image" => "Invalid image format or unable to process image"
                        ])->withInput();
                    }
                }

                MathQuestionModel::create([
                    'custom_game_assignment_code' => $assignment->custom_game_assignment_code,
                    'question' => $mathData['problem_text'],
                    'img' => $imagePath,
                    'correct' => $mathData['correct_answer'],
                ]);
            }

            // Handle student assignments
            $gameroom = GameroomModel::where('gameroom_code', $assignment->gameroom_code)->first();

            if (!$gameroom) {
                return back()->withErrors(['gameroom' => 'Gameroom not found'])->withInput();
            }

            $students = ClassroomMappingModel::where('classroom_code', $gameroom->classroom_code)->get();

            if ($students->isNotEmpty()) {
                $assignmentData = [];
                foreach ($students as $student) {
                    $assignmentData[] = [
                        'student_id' => $student->student_id,
                        'custom_game_assignment_code' => $assignment->custom_game_assignment_code,
                        'assignment_status' => 'pending',
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }

                try {
                    CustomAssignmentCompleteModel::insert($assignmentData);
                } catch (\Exception $e) {
                    Log::error('Student assignment creation failed: '.$e->getMessage());
                    return back()->withErrors(['students' => 'Failed to create student assignments'])->withInput();
                }
            }

            session()->flash('assignment-created', true);
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Assignment creation failed: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()->withErrors(['system' => 'An unexpected error occurred. Please try again.'])->withInput();
        }
    }

    public function createGameAssignment(Request $request)
    {
        $classroomCode = session()->get('Class Room Code');

        info('hitting creating game Assignment');
        $assignmentCode = $this->createAssignmentCode();

        $gameCode = $request->input('game_code');
        $dueDate = $request->input('due_date');
        Log::info("Code", ['data' => $dueDate]);

        $game = OcktedGameModel::where('game_code',$gameCode)->first();
        $gameTitle = $game->game_title;

        $students = ClassroomMappingModel::with('student')->where('classroom_code', $classroomCode)->get();

        $assignment = GameAssignmentModel::create([
            'game_assignment_code' => $assignmentCode,
            'assignment_title' => $gameTitle,
            'game_code' => $gameCode,
            'due_date' => $dueDate,
            'classroom_code' => $classroomCode
        ]);

        if($students->isNotEmpty()){
            foreach($students as $student) {
                GameAssignmentCompleteModel::create([
                    'student_id' => $student->student_id,
                    'game_assignment_code' => $assignment->game_assignment_code,
                    'assignment_status' => 'pending',
                ]);
            }
        }

        return response()->json([
            'student in classroom' => $students,
            'game' => $game,
            'title' => $gameTitle
        ]);
        session()->flash('assignment-created', true);
        return redirect()->back();

    }

    public function joinclassRoomForm($classroomCode)
    {
        info('Hitting Join Room Form');
        Log::info("Room",['data' => $classroomCode]);

        $classroom = ClassroomModel::with('teacher')->where('classroom_code', $classroomCode)->first();

        // return response()->json([
        //     'classroom' => $classroom
        // ]);
        return view('TeacherDashboard.join-gameroom-form', compact('classroom'));

    }

    public function joinGameRoom(Request $request)
    {
        info('HITTING JOIN ROOM POST');
        $studentId = $request->input('student_id');
        $classroomCode = $request->input('classroom_code');

        $studentExists = OcktedStudentModel::where('student_id', $studentId)->first();
        if(!$studentExists){
            session()->flash('missing-id-classroom', true);
            return redirect()->back();
        }

        $studentInClassRoomExists = ClassroomMappingModel::where('student_id', $studentId)->where('classroom_code', $classroomCode)->first();

        if($studentInClassRoomExists){
            session()->flash('already-join-classroom', true);
            return redirect()->back();
        }

        $Room = ClassroomMappingModel::create([
            'student_id' => $studentId,
            'classroom_code' => $classroomCode,
        ]);

        Log::info("Student Assign", ['room' => $Room]);
        session()->flash('classroom-join-sucess', true);
        return redirect()->back();
    }

    public function viewAssignment($gameroomCode, $assignmentCode)
    {
        $gameroom = GameroomModel::where('gameroom_code', $gameroomCode)->first();
        $gameroomType = $gameroom['gameroom_type'];

        switch($gameroomType) {
            case "Multiple Choice Question":
                $assignment = DB::table('custom_game_assignments')
                              ->join('mcq_questions', 'custom_game_assignments.custom_game_assignment_code', '=', 'mcq_questions.custom_game_assignment_code')
                              ->join('mcq_options', 'mcq_questions.mcq_id', '=', 'mcq_options.mcq_id')
                              ->where('custom_game_assignments.custom_game_assignment_code', $assignmentCode)
                              ->select('custom_game_assignments.*', 'mcq_questions.*', 'mcq_options.*')
                              ->get();

                $combinedData = ['Game Room Data' => $gameroom, 'Assignment Data' => $assignment];
                return view('TeacherDashboard.customTeacherGame.mcq', compact('combinedData'));
            break;
            case "Guess The Picture":
                return view('TeacherDashboard.customTeacherGame.picture');
                break;
            case "Numbers":
                return view('TeacherDashboard.customTeacherGame.numbers');
                break;
            default:
                return response()->json([
                    'message' => 'Assignment Not available',
                ]);
        }

        // return response()->json([
        //     'data' => $assignment,
        //     'gameroom' => $gameroom,
        //     'type' => $gameroomType
        // ]);
    }

    public function viewAssignmentDetails($assignmentCode)
    {
        info('Hitting Assignment Stats');

        $assignment1 = CustomGameAssignmentModel::where('custom_game_assignment_code', $assignmentCode)->first();
        $assignment2 = GameAssignmentModel::where('game_assignment_code', $assignmentCode)->first();



        $assignment1Collect = collect($assignment1 ? [$assignment1] : []);
        $assignment2Collect = collect($assignment2 ? [$assignment2] : []);

        $allAssignment = $assignment1Collect->merge($assignment2Collect)->map(function($a) {
            return (object) [
                'assignment_title' => $a->assignment_title,
                'due_date' => $a->due_date,
            ];
        });

        $assignmentData = $allAssignment->first();

        $session = session()->all();
        $classroomCode = session()->get('Class Room Code');

        $totalStudents = ClassroomModel::with('students')->where('classroom_code', $classroomCode)->first(); // Use first() instead of get()
        $total = $totalStudents ? $totalStudents->students : []; // Check if data exists
        $count = count($total);

        Log::info('Session Data', ['data' => $session]);

        $students = DB::table('ockted_students')
        ->join('classroom_mapping', 'ockted_students.student_id', '=', 'classroom_mapping.student_id')
        ->join('classrooms', 'classroom_mapping.classroom_code', '=', 'classrooms.classroom_code')
        ->join('gamerooms', 'classrooms.classroom_code', '=', 'gamerooms.classroom_code')
        ->join('custom_game_assignments', 'gamerooms.gameroom_code', '=', 'custom_game_assignments.gameroom_code')
        ->leftJoin('custom_assignment_complete', function($join) use ($assignmentCode) {
            $join->on('custom_game_assignments.custom_game_assignment_code', '=', 'custom_assignment_complete.custom_game_assignment_code')
                 ->on('ockted_students.student_id', '=', 'custom_assignment_complete.student_id');
        })
        ->select(
            'ockted_students.*',
            'custom_assignment_complete.assignment_status',
            'custom_assignment_complete.score',
            'custom_assignment_complete.submitted_at',
            'custom_assignment_complete.id as completion_id'
        )
        ->where('custom_game_assignments.custom_game_assignment_code', $assignmentCode)
        ->groupBy(
            'ockted_students.id',
            'ockted_students.student_id',
            'ockted_students.student_name',
            'ockted_students.school_code',
            'ockted_students.student_status',
            'ockted_students.profile_picture',
            'ockted_students.rank',
            'ockted_students.game_token',
            'ockted_students.last_active_at',
            'ockted_students.created_at',
            'ockted_students.updated_at',
            'custom_assignment_complete.assignment_status',
            'custom_assignment_complete.score',
            'custom_assignment_complete.submitted_at',
            'custom_assignment_complete.id'
        )
        ->get();

        $students2 = DB::table('ockted_students')
        ->join('classroom_mapping', 'ockted_students.student_id', '=', 'classroom_mapping.student_id')
        ->join('classrooms', 'classroom_mapping.classroom_code', '=', 'classrooms.classroom_code')
        ->join('game_assignments', 'classrooms.classroom_code', '=', 'game_assignments.classroom_code')
        ->leftJoin('game_assignment_complete', function($join) use ($assignmentCode) {
            $join->on('game_assignments.game_assignment_code', '=', 'game_assignment_complete.game_assignment_code')
                 ->on('ockted_students.student_id', '=', 'game_assignment_complete.student_id');
        })
        ->select(
            'ockted_students.*',
            'game_assignment_complete.assignment_status',
            'game_assignment_complete.score',
            'game_assignment_complete.submitted_at',
            // 'custom_assignment_complete.id as completion_id'
        )
        ->where('game_assignments.game_assignment_code', $assignmentCode)
        ->groupBy(
            'ockted_students.id',
            'ockted_students.student_id',
            'ockted_students.student_name',
            'ockted_students.school_code',
            'ockted_students.student_status',
            'ockted_students.profile_picture',
            'ockted_students.rank',
            'ockted_students.game_token',
            'ockted_students.last_active_at',
            'ockted_students.created_at',
            'ockted_students.updated_at',
            'game_assignment_complete.assignment_status',
            'game_assignment_complete.score',
            'game_assignment_complete.submitted_at',
            // 'game_assignment_complete.id'
        )
        ->get();

        $student1 = collect($students ?? []);
        $student2 = collect($students2 ?? []);

        $studentAll = $student1->merge($student2)->map(function($a) {
            return (object) [
                'student_name' => $a->student_name ?? [],
                'score' => $a->score,
                'assignment_status' => $a->assignment_status,
                'submitted_at' => $a->submitted_at,
            ];
        });

        $combinedData = ['Total Student' => $count, 'Classroom Code' => $classroomCode];

        // return response()->json([
        //     'data' => $combinedData,
        //     'Assignment' => $allAssignment,
        //     'Students' => $studentAll,
        // ]);

        return view('TeacherDashboard.teacher-assignment', [
            'combinedData' => $combinedData,
            'Assignment' => $assignmentData,
            'Students' => $studentAll,
        ]);

    }

    function createClassRoomCode()
    {
        info('hitting create room code');
        $classRoomCode = 'CR' . rand(1000, 9999);
        $classRoomCodeExists = ClassroomModel::where('classroom_code', $classRoomCode)->first();
        if($classRoomCodeExists){
            return $this->createclassRoomCode();
        }else{
            return $classRoomCode;
        }
    }

    function createGameroomCode()
    {
        info('hitting create assignment code');
        $gameroomCode = 'GR' . rand(1000, 9999);
        $gameroomCodeExists = GameroomModel::where('gameroom_code', $gameroomCode)->first();
        if($gameroomCodeExists){
            return $this->createGameRoomCode();
        }else{
            return $gameroomCode;
        }
    }

    function createAssignmentCode()
    {
        info('hitting create assignment code');
        $assignmentCode = 'AS' . rand(1000, 9999);
        $assignmentCodeExists = CustomGameAssignmentModel::where('custom_game_assignment_code', $assignmentCode)->first();
        if($assignmentCodeExists){
            return $this->createAssignmentCode();
        }else{
            return $assignmentCode;
        }
    }
}



//     i need to fetch both the data from both the table ockted_game_model and gameroom_model

// cos in the game_assignment i have multiple asssignment
// so i want to view all the assignment

// but the assignment are from both ockted_game and gameroom_table

// here

// let me send u all the table model
// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use App\Models\OcktedScoreModel;

// class OcktedGameModel extends Model
// {
//     protected $primaryKey = 'game_id';

//     protected $table = 'ockted_games';

//     public $timestamps = true;

//     protected $fillable = [
//         'game_source',
//         'game_code',  //which is stored as gameroom_code in custom_game_assignments table
//         'game_title',
//         'game_description',
//         'game_banner',
//         'game_url',
//         'game_status',
//     ];


// }

// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use App\Models\GameTypeModel\MCQQuestionModel;

// class GameAssignmentModel extends Model
// {
//     protected $table = 'custom_game_assignments';

//     protected $primaryKey = 'assignment_id';

//     public $timestamps = true;

//     protected $fillable = [
//         'custom_game_assignment_code',
//         'gameroom_code',
//         'assignment_title',
//         'due_date',
//     ];

// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use App\Models\ClassroomModel;

// class GameroomModel extends Model
// {
//     protected $table = 'gamerooms';

//     protected $primaryKey = 'id';

//     public $timestamps = true;

//     protected $fillable = [
//         'gameroom_code',
//         'gameroom_type',
//         'gameroom_color',
//         'classroom_code',
//     ];

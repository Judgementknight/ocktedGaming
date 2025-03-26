<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OcktedGameroomModel;
use App\Models\OcktedStudentModel;
use App\Models\GameRoomAssignmentModel;
use Illuminate\Support\Facades\Log;

class OcktedTeacherController extends Controller
{
    public function createOcktedGameRoom(Request $request)
    {
        try{
            $teacherSession = session()->get('Teacher Data');
            Log::info('Teacher Session', ['data:' => session('Teacher Data')]);
            info('Hitting this request');

            $schoolCode = $teacherSession['school_code'];
            $teacherId = $teacherSession['teacher_id'];
            $gameRoomCode = $this->createGameRoomCode();
            $class = $request->input('class_level_gameroom');

            $gameRoomData = [
                'teacher_id' => $teacherId,
                'gameroom_code' => $gameRoomCode,
                'school_code' => $schoolCode,
                'class_level_gameroom' => $class,
            ];
            Log::info("GameRoom", ['data' => $gameRoomData]);

            $gameroom = OcktedGameroomModel::create($gameRoomData);
            Log::info("GameRoom", ['data' => $gameroom]);

            return redirect()->route('ockted');
        }catch(Exception $e){
            Log::error("Error", ['error' => $e->getMessage()]);
        }
    }

    public function gameroomDetails($gameroomCode)
    {
        info('Game Details');
        // $gameroomCode = $request->input('gameroom_code');
        Log::info("Game Room", ['code:' => $gameroomCode]);

        $gameroom = OcktedGameroomModel::with('students')
            ->where('gameroom_code', $gameroomCode)
            ->first();

        Log::info("Room", ['data' => $gameroom]);


        $gameroomLink = "http://127.0.0.1:8008/api/join-room/{$gameroomCode}";

        $roomDetails = ['Room Link' => $gameroomLink, 'Students' => $gameroom];
        // return response()->json([
        //     'data' => $roomDetails,
        // ]);
        return view('TeacherDashboard.teacher-gameroom', compact('roomDetails'));
    }

    public function joinRoomForm($gameRoomCode)
    {
        info('Hitting Join Room Form');
        Log::info("Room",['data' => $gameRoomCode]);

        $code = $gameRoomCode;
        return view('TeacherDashboard.join-gameroom-form', compact('code'));

    }

    public function joinGameRoom(Request $request)
    {
        info('HITTING JOIN ROOM POST');
        $studentId = $request->input('student_id');
        $gameRoomCode = $request->input('gameroom_code');

        $studentExists = OcktedStudentModel::where('student_id', $studentId)->first();
        if(!$studentExists){
            return response()->json([
                'message' => 'This ID does not Exists',
            ]);
        }


        $studentInGameRoomExists = GameRoomAssignmentModel::where('student_id', $studentId)->where('gameroom_code', $gameRoomCode)->first();

        if($studentInGameRoomExists){
            return response()->json([
                'message' => 'You Have Already Joined This room',
            ]);
        }

        $Room = GameRoomAssignmentModel::create([
            'student_id' => $studentId,
            'gameroom_code' => $gameRoomCode,
        ]);

        Log::info("Student Assign", ['room' => $Room]);
        return view('TeacherDashboard.student-form-success');
    }


    function createGameRoomCode()
    {
        $gameRoomCode = 'OGGR' . rand(1000, 9999);
        $gameRoomCodeExists = OcktedGameroomModel::where('gameroom_code', $gameRoomCode)->first();
        if(!$gameRoomCode){
            return $this->createGameRoomCode();
        }else{
            return $gameRoomCode;
        }
    }
}

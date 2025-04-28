<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\OcktedGamingController;
use App\Http\Controllers\FetchGameController;
use App\Http\Controllers\OcktedDashboardController;
use App\Http\Controllers\OcktedTeacherController;
use App\Http\Controllers\OcktedStudentController;


//Middleware
use App\Http\Middleware\EnsureTokenValid;
use App\Http\Middleware\EnsureApiToken;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\UpdateLastActive;
use App\Http\Middleware\CheckNewUserOrOld;
use App\Http\Middleware\CheckLastVisitedPage;
use App\Http\Middleware\RememberAdminToken;


//ENTRY POINT


// ADMIN GET


Route::middleware([StartSession::class])->group(function(){

    Route::get('/dashboard/login',[OcktedDashboardController::class,'renderLogin'])->name('login');
    Route::get('/admin/dashboard',[OcktedDashboardController::class,'renderDashboard'])->name('dashboard');

    Route::get('/dashboard/students',[OcktedDashboardController::class,'studentDetails'])->name('student-details');
    Route::get('/dashboard/students-query',[OcktedDashboardController::class,'studentQuery'])->name('student-query');

    Route::get('/dashboard/teachers',[OcktedDashboardController::class,'teacherDetails'])->name('teacher-details');
    Route::get('/dashboard/teachers-query',[OcktedDashboardController::class,'teacherQuery'])->name('teacher-query');

    Route::get('/dashboard/games',[OcktedDashboardController::class,'gamesDetails'])->name('games-details');
    Route::get('/dashboard/games-query',[OcktedDashboardController::class,'gamesQuery'])->name('games-query');


    Route::get('/dashboard/add-games', [OcktedDashboardController::class, 'acceptExternalGames'])->name('AddGames');
    Route::get('/dashboard/player-history',[OcktedDashboardController::class,'playerHistory'])->name('player-history');


});

// Route::get('/no-access', function(){
//     return view('Student.NoAccess');
// })->name('no-access');

Route::middleware([StartSession::class])->group(function() {

     //GET REQUEST
     Route::get('/welcome', [OcktedGamingController::class,'displayWelcomePage'])->name('welcome');
     Route::get('/ocktedGaming',[OcktedGamingController::class,'ocktedHomepage'])->name('ockted');
     Route::get('/leaderboard',[OcktedGamingController::class,'leaderboard'])->name('leaderboard');
     Route::get('/history',[OcktedGamingController::class,'history'])->name('history');
     Route::get('/get-user',[OcktedGamingController::class,'innit']);

     //TEACHER GET
     Route::get('/classroom-details/{classroom_code}', [OcktedTeacherController::class, 'classroomDetails'])->name('classroom-details');
     Route::get('/join-room/{classroom_code}',[OcktedTeacherController::class,'joinclassRoomForm'])->name('join-form');
     Route::get('/game-room/{gameroom_code}',[OcktedTeacherController::class, 'viewGameRoom'])->name('view-gameroom');
     Route::get('/view-assignment-details/{assignment_code}',[OcktedTeacherController::class, 'viewAssignmentDetails'])->name('view-assignment-details');
     // Route::get('/assignment/{gameroom_code}/{assignment_code}',[OcktedTeacherController::class,'viewAssignment'])->name('view-assignment');

     // STUDENT GET
     Route::get('/view-classroom/{classroom_code}',[OcktedStudentController::class, 'viewClassroomAssignment'])->name('view-classroom-assignment');
     Route::get('/assignment/{assignment_code}',[OcktedStudentController::class,'viewAssignment'])->name('view-assignment');
     Route::get('/games',[OcktedStudentController::class,'gameView'])->name('view-game');
     Route::get('/play/{game_code}',[OcktedStudentController::class,'playGame'])->name('play-game');
     Route::get('/return',[OcktedStudentController::class,'returnToken'])->name('return');
     Route::get('/leaderboard',[OcktedStudentController::class,'leaderboard'])->name('leaderboard');

     Route::get('/assignment-completed/{classroom_code}',[OcktedStudentController::class,'viewAssignmentComplete'])->name('view-complete');
     Route::get('/assignment-overdue/{classroom_code}',[OcktedStudentController::class,'viewAssignmentOverdue'])->name('view-overdue');
     Route::get('/assignment-pending/{classroom_code}',[OcktedStudentController::class,'viewAssignmentPending'])->name('view-pending');

     Route::get('/create-student',[OcktedGamingController::class, 'createOcktedStudent'])->name('create-ockted-student');
     Route::get('/create-teacher',[OcktedGamingController::class, 'createOcktedTeacher'])->name('create-ockted-teacher');

    // STUDENT POST


    //POST REQUEST
    // Route::get('/create-student',[OcktedGamingController::class, 'createOcktedStudent'])->name('create-ockted-student');
    // Route::get('/create-teacher',[OcktedGamingController::class, 'createOcktedTeacher'])->name('create-ockted-teacher');

    Route::get('/get-session', [OcktedGamingController::class, 'startinit'])->name('trigger');

});



// OCKTED GAMING
Route::middleware([StartSession::class])->group(function () {

    Route::get('/', function() {
        return redirect()->route('welcome');
    });

    Route::get('/test',function () {
        return view('Main-Pages.test');
    });

    // STUDENT POST
    Route::post('/submit-score',[OcktedStudentController::class,'storeScore'])->name('store-score');
    Route::post('/submit-assignment/{assignment_code}',[OcktedStudentController::class,'submitCustomAssignment'])->name('submit-assignment');

    //POST REQUEST
    // Route::get('/create-student',[OcktedGamingController::class, 'createOcktedStudent'])->name('create-ockted-student');
    // Route::get('/create-teacher',[OcktedGamingController::class, 'createOcktedTeacher'])->name('create-ockted-teacher');

    //Teacher POST
    Route::post('/create-classroom',[OcktedTeacherController::class, 'createClassroom'])->name('create-classroom');
    Route::post('/create-gameroom', [OcktedTeacherController::class, 'createGameRoom'])->name('create-gameroom');
    Route::post('/create-mcq-assignment',[OcktedTeacherController::class,'createAssignment'])->name('create-assignment');
    Route::post('/create-picture-assignment',[OcktedTeacherController::class,'createPictureAssignment'])->name('create-picture-assignment');
    Route::post('/create-math-assignment',[OcktedTeacherController::class,'createMathAssignment'])->name('create-math-assignment');
    Route::post('/create-game-assignment',[OcktedTeacherController::class,'createGameAssignment'])->name('create-game-assignment');

    Route::post('/join-room',[OcktedTeacherController::class,'joinGameRoom'])->name('join-room');

    // Route::post('/requestaccess',[OcktedGamingController::class,'requestAccess'])->name('request_game');
    // Route::post('/submit-score',[OcktedGamingController::class,'acceptScore']);
    // Route::post('/request-user-data',[OcktedGamingController::class,'isTokenValid']);

});

// OCKTED ADMIN DASHBOARD


    Route::middleware([EnsureApiToken::class])->post('/add-game', [OcktedDashboardController::class, 'addGame'])->name('add-game');
    Route::middleware([EnsureApiToken::class])->post('/edit-game-status', [OcktedDashboardController::class,'editGameStatus'])->name('edit-game-status');
    Route::middleware([EnsureApiToken::class])->post('/update-player',[OcktedDashboardController::class,'playerUpdate'])->name('update-player');
    Route::middleware([EnsureApiToken::class])->post('/remove-player',[OcktedDashboardController::class,'removePlayer'])->name('remove-player');
    Route::post('/send-game',[OcktedDashboardController::class,'receiveGameWithPost'])->name('send-game');


    Route::middleware([StartSession::class,])->group(function(){
        Route::post('/admin/login',[OcktedDashboardController::class,'adminLogin'])->name('login-verify');
        Route::post('/admin/logout',[OcktedDashboardController::class,'adminLogout'])->name('logout');
    });


    Route::post('/admin/register',[OcktedDashboardController::class,'adminRegister']);



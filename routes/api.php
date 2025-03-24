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


//Middleware
use App\Http\Middleware\EnsureTokenValid;
use App\Http\Middleware\EnsureApiToken;
use Illuminate\Session\Middleware\StartSession;
use App\Http\Middleware\UpdateLastActive;
use App\Http\Middleware\CheckNewUserOrOld;
use App\Http\Middleware\CheckLastVisitedPage;
use App\Http\Middleware\RememberAdminToken;


// OCKTED GAMING
Route::middleware([StartSession::class, UpdateLastActive::class])->group(function () {

    //GET REQUEST
    Route::get('/welcome', [OcktedGamingController::class,'displayWelcomePage'])->name('welcome');
    Route::middleware([CheckNewUserOrOld::class])->get('/ocktedGaming',[OcktedGamingController::class,'ocktedHomepage'])->name('ockted');
    Route::middleware([CheckNewUserOrOld::class])->get('/leaderboard',[OcktedGamingController::class,'leaderboard'])->name('leaderboard');
    Route::middleware([CheckNewUserOrOld::class])->get('/history',[OcktedGamingController::class,'history'])->name('history');
    Route::get('/get-user',[OcktedGamingController::class,'innit']);

    //POST REQUEST
    Route::post('/welcome/create-user',[OcktedGamingController::class, 'createOcktedUserName'])->name('create-ockted-user');
    Route::post('/requestaccess',[OcktedGamingController::class,'requestAccess'])->name('request_game');
    Route::post('/submit-score',[OcktedGamingController::class,'acceptScore']);
    Route::post('/request-user-data',[OcktedGamingController::class,'isTokenValid']);

});



// OCKTED DASHBOARD
Route::middleware([StartSession::class])->group(function(){

    //ADMIN ROUTES
    Route::middleware([EnsureTokenValid::class])->get('/dashboard/players',[OcktedDashboardController::class,'playerDetails'])->name('player');
    Route::middleware([EnsureTokenValid::class])->get('/dashboard/games',[OcktedDashboardController::class,'displayGamesList'])->name('game');
    Route::middleware([EnsureTokenValid::class])->get('/dashboard/add-games', [OcktedDashboardController::class, 'acceptExternalGames'])->name('AddGames');
    Route::middleware([EnsureTokenValid::class])->get('/dashboard/player-history',[OcktedDashboardController::class,'playerHistory'])->name('player-history');

    Route::get('/dashboard', function(){
        return view('Dashboard.Pages.main-dash');
    })->name('dashboard');

    Route::get('/redirect-last-page', function () {
        // This will redirect to the last visited page
        return redirect(session()->get('last_visited_page'));
    })->name('redirect.to.last.page');



    Route::middleware([EnsureApiToken::class])->post('/add-game', [OcktedDashboardController::class, 'addGame'])->name('add-game');
    Route::middleware([EnsureApiToken::class])->post('/edit-game-status', [OcktedDashboardController::class,'editGameStatus'])->name('edit-game-status');
    Route::middleware([EnsureApiToken::class])->post('/update-player',[OcktedDashboardController::class,'playerUpdate'])->name('update-player');
    Route::middleware([EnsureApiToken::class])->post('/remove-player',[OcktedDashboardController::class,'removePlayer'])->name('remove-player');
    Route::post('/send-game',[OcktedDashboardController::class,'receiveGameWithPost'])->name('send-game');


    //ACCESS ROUTES
    Route::post('/admin/logout',[OcktedDashboardController::class,'adminLogout'])->name('logout');
    Route::get('/dashboard/login',[OcktedDashboardController::class,'renderLogin'])->name('login');
    Route::post('/admin/login',[OcktedDashboardController::class,'adminLogin'])->name('login-verify');
    Route::post('/admin/register',[OcktedDashboardController::class,'adminRegister']);

});


//TEACHER ROUTES


// Route::get('/user', function (Request $request) {
    //     return $request->user();
    // })->middleware('auth:sanctum');

    // Route::post('/register',[AccountController::class,'register'])->name('register-controller');

    // Route::middleware(StartSession::class)->post('/login',[AccountController::class,'login'])->name('login-controller');

    // Route::middleware([StartSession::class, CheckAccountSession::class])->post('/logout',[AccountController::class,'logout'])->name('logout-controller');

    // Route::get('/register-page', function(){
    //     return view('Auth.register');
    // })->name('register-page');

    // Route::get('/login-page', function(){
    //     return view('Auth.login');
    // })->name('login-page');


    // Route::middleware([StartSession::class, CheckAccountSession::class])->get('/home', function(){
    //     session()->put('last_visited_page', url()->current());
    //     Log::info("Session", session()->all());
    //     return view('Main-Pages.homepage');
    // })->name('home-page');


    // // Route::middleware(CheckAccountSession::class)->get('/leaderboard', function(){
    // //     return view('Main-Pages.leaderboard');
    // // })->name('leaderboard-page');

    // Route::get('/homepage', function(){
    //     return view('Main-Pages.homepage');
    // })->name('homepage');

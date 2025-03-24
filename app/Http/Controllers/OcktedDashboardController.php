<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminModel;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Http;
use App\Models\OcktedGameModel;
use App\Models\OcktedUserModel;
use Illuminate\Support\Facades\DB;


class OcktedDashboardController extends Controller
{

    public function renderLogin()
    {
        return view('Dashboard.Pages.dash-login');
    }

    public function adminRegister(Request $request)
    {
        try{
            Log::info("Its hititng");
            $field = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            $hashPassword = Hash::make($field['password']);
            $admin = AdminModel::create([
                'username' => $field['username'],
                'password' => $hashPassword,
            ]);

            return response()->json([
                'message' => 'Admin Register Success'
            ]);

            Log::info("hashPassword",['password' => $hashPassword]);
        }catch(Exceptiom $e){
            Log::error("Error",['eror'=> $e->getMessage()]);
        }

    }

    public function adminLogin(Request $request, FlasherInterface $flasher)
    {
        try{
            $field = $request->validate([
                'username' => 'required|string|exists:admin,username',
                'password' => 'required|string',

            ]);

            $remember = $request->filled('remember'); // true if checkbox is checked

            $user = AdminModel::where('username', $field['username'])->first();
            Log::info("User",['data'=> $user]);

            if(!$user || !Hash::check($field['password'], $user->password)){
                session()->flash('toast', [
                    'type' => 'error',
                    'message' => 'Invalid Credentials.'
                ]);
                return back();
            }



            $token = Str::random(60);
            $hashToken = Hash::make($token);
            $user->update(['api_token'=> $hashToken]);

            session()->put('admin_token',$token);

            if ($remember) {
                $user->update(['remember_token' => $token]);
                session()->put('remember_token', $token); // Store remember_token in the session as well
            }
            
            Log::info('Session data:', session()->all());

            session()->flash('welcome_toast', true);

            Log::info("sessionkamsdl", session()->all());

            return redirect()->route('dashboard');
        }catch(Exception $e){
            Log::error("Error Login",['error'=>$e->getMessage()]);
        }
    }

    public function adminLogout(Request $request,  FlasherInterface $flasher)
    {
        $admin = $request->attributes->get('admin');  //request data which is being stored from middleware

        if(!$admin){
            $admin = AdminModel::first();  //backup admin data fetch
        }

        $admin->update(['api_token' => null]);
        $admin->update(['remember_token' => null]);


        session()->forget('admin_token');

        session()->flash('logout_toast', true); // This will be cleared after the next request
        return redirect()->route('login');
    }



    //DASHBOARD CONTROLLERS
    public function playerDetails(Request $request)
    {
        $playersQuery = DB::table('ockted_users')
            ->leftJoin('ockted_score', 'ockted_users.user_id', '=', 'ockted_score.user_id')
            ->select(
                'ockted_users.*',
                DB::raw('COUNT(ockted_score.game_code) as game_count'),
                DB::raw('SUM(ockted_score.score) as total_score')
            )
            ->groupBy(
                'ockted_users.id',
                'ockted_users.ockted_username',
                'ockted_users.user_id',
                'ockted_users.username',
                'ockted_users.school_code',
                'ockted_users.profile_picture',
                'ockted_users.game_token',
                'ockted_users.user_status',
                'ockted_users.rank',
                'ockted_users.created_at',
                'ockted_users.updated_at',
                'ockted_users.last_active_at'
            );

        // Fetch all players (without pagination yet)
        $playersCollection = collect($playersQuery->get());
        // 🔍 Apply Search Filter
        if ($request->has('search')) {
            $search = $request->search;
            $playersCollection = $playersCollection->filter(function ($player) use ($search) {
                return stripos($player->username, $search) !== false;
            });
        }

        // 🔄 Apply Sorting by Name
        if ($request->input('sort_by_name') === 'name') {
            $order = $request->input('sort_order', 'asc');
            $playersCollection = $order === 'asc'
                ? $playersCollection->sortBy('username')
                : $playersCollection->sortByDesc('username');
        }

        // 🟢 Apply Status Filter
        if ($status = $request->input('status')) {
            $playersCollection = $playersCollection->filter(function ($player) use ($status) {
                return strcasecmp($player->user_status, $status) === 0;
            });
        }

        // 🔥 Apply Sorting by Score
        if ($request->input('score')) {
            $playersCollection = $request->input('score') === 'high'
                ? $playersCollection->sortByDesc('total_score')
                : $playersCollection->sortBy('total_score');
        }

        // 🎮 Apply Sorting by Games Played
        if ($request->input('games')) {
            $playersCollection = $request->input('games') === 'top'
                ? $playersCollection->sortByDesc('game_count')
                : $playersCollection->sortBy('game_count');
        }

        // 📄 Apply Pagination AFTER filtering & sorting
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $currentItems = $playersCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $players = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentItems,
            $playersCollection->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('Dashboard.Pages.player-dash', compact('players'));
    }

    public function playerHistory(Request $request)
    {
        $playersQuery = DB::table('ockted_users')
        ->join('ockted_score', 'ockted_users.user_id', '=' , 'ockted_score.user_id')
        ->select('ockted_users.user_id','ockted_users.username','ockted_score.score','ockted_score.game_code','ockted_score.created_at')
        ->groupBy('ockted_users.user_id','ockted_users.username','ockted_score.score','ockted_score.game_code','ockted_score.created_at');

        $playersCollection = collect($playersQuery->get());


         // 🔍 Apply Search Filter
         if ($request->has('search')) {
            $search = $request->search;
            $playersCollection = $playersCollection->filter(function ($player) use ($search) {
                return stripos($player->username, $search) !== false;
            });
        }

        // 🔄 Apply Sorting by user_id (Ascending or Descending)
        if ($request->input('user_id')) {
            $playersCollection = $request->input('user_id') === 'high'
                ? $playersCollection->sortByDesc('user_id')
                : $playersCollection->sortBy('user_id');
        }

        // 🔄 Apply Sorting by Name
        if ($request->input('sort_by_name') === 'name') {
            $order = $request->input('sort_order', 'asc');
            $playersCollection = $order === 'asc'
                ? $playersCollection->sortBy('username')
                : $playersCollection->sortByDesc('username');
        }

        // 📅 Date Filtering (Today, This Week, This Month)
        if ($filter = $request->input('date_filter')) {
            $playersCollection = $playersCollection->filter(function ($player) use ($filter) {
                $createdAt = \Carbon\Carbon::parse($player->created_at);
                $today = \Carbon\Carbon::today();
                if ($filter === 'today') {
                    return $createdAt->isToday();
                } elseif ($filter === 'this_week') {
                    return $createdAt->greaterThanOrEqualTo($today->startOfWeek());
                } elseif ($filter === 'this_month') {
                    return $createdAt->greaterThanOrEqualTo($today->startOfMonth());
                }
                return true;
            });
        }


                // 📄 Apply Pagination AFTER filtering & sorting
                $perPage = 10;
                $currentPage = $request->input('page', 1);
                $currentItems = $playersCollection->slice(($currentPage - 1) * $perPage, $perPage)->values();

                $players = new \Illuminate\Pagination\LengthAwarePaginator(
                    $currentItems,
                    $playersCollection->count(),
                    $perPage,
                    $currentPage,
                    ['path' => $request->url(), 'query' => $request->query()]
                );
                // return response()->json([
                //     'data' => $players,
                // ]);


        return view('Dashboard.Pages.player-history', compact('players'));
    }

    public function acceptExternalGames()
    {
        $Server1 = [];
        $Server2 = [];

        try {
            $response1 = Http::timeout(2)->get('http://127.0.0.1:8005/game-data');
            $Server1 = $response1->successful() ? $response1->json() ?? [] : [];
            // Log::info("Game Data", ['Data:' => $Server1]);
        }catch (\Exception $e) {
            Log::info("Server 1 API failed", ['error' => $e->getMessage()]);
        }

        try{
            $response2 = Http::timeout(2)->get('http://localhost:8003/api/games');
            $Server2 = $response2->successful() ? $response2->json() ?? [] : [];
            Log::info('Game Data 2', ['data:' => $Server2]);
        }catch(\Exception $e){
            Log::info("ERROR CONNECTING WITH SERVER 2", ['error' => $e->getMessage()]);
        }


        $game = OcktedGameModel::latest()->take(3)->get();

        $gameData = ['Server 1' => $Server1, 'Server 2' => $Server2, 'Recent Games' => $game];


        // RENDER ONLY ADDED GAMES??
        // $externalGames = $gameData['Server 1']['Game Data'] ?? [];
        // Filter the external games so that only games not yet added are passed to the view
        // $filteredGames = array_filter($externalGames, function ($game) use ($addedGameCodes) {
        //     return !in_array($game['game_code'], $addedGameCodes);
        // });

        // $data['serverGames'] = [
        //     'sender' => $gameData['Server 1']['sender'],
        //     'Game Data' => $filteredGames,
        // ];
        // return response()->json([
        //     'data' => $gameData,
        // ]);

        return view('Dashboard.Pages.add-games', compact('gameData'));
    }

    public function receiveGameWithPost(Request $request)
    {
        Log::info("IT HITTING");
        $title = $request->input('game_title');
        $code = $request->input('game_code');
        $banner = $request->input('game_banner');
        $url = $request->input('game_url');
        $source = $request->input('game_source');
        $description = $request->input('game_description');

        $gameData = ['game_title' => $title, 'game_code' => $code, 'game_banner' => $banner, 'game_url' => $url, 'game_source' => $source, 'game_description' => $description];

        Log::info("Game Data", ['data:' => $gameData]);

    }

    public function addGame(Request $request, FlasherInterface $flasher)
    {
        Log::info("IT HITTING asdasd");
        $title = $request->input('game_title');
        $code = $request->input('game_code');
        $banner = $request->input('game_banner');
        $url = $request->input('game_url');
        $source = $request->input('game_source');
        $description = $request->input('game_description');

        $gameData = ['game_title' => $title, 'game_code' => $code, 'game_banner' => $banner, 'game_url' => $url, 'game_source' => $source, 'game_description' => $description];

        $game = OcktedGameModel::where('game_code', $code)->first();

        if($game){
            session()->flash('game_already_exists', true);
            return redirect()->back();
            Log::info("Game Exists", ['data' => $game]);

        }else{
            Log::info("GAME DOESNT EXISTS");
                $field = $request->validate([
                    'game_title' => 'required|string',
                    'game_code' => 'required|string|unique:ockted_games,game_code',
                    'game_url' => 'required|string',
                    'game_banner' => 'string|nullable',
                    'game_source' => 'string|nullable',
                    'game_description' => 'string|nullable',
                ]);
            $game = OcktedGameModel::create([
                'game_status' => 'Active',
                'game_title' => $field['game_title'],
                'game_description' => $field['game_description'],
                'game_code' => $field['game_code'],
                'game_url' => $field['game_url'],
                'game_banner' => $field['game_banner'],
                'game_source' => $field['game_source'],
            ]);

            Log::info("Game Added Successfuly", ['game' => $game]);
            session()->flash('game_added', true);
            return redirect()->back();

            return response()->json([
                'message' => 'game Added Sucessfully',
            ]);
        }
    }

    public function displayGamesList(Request $request)
    {
        // Create a query builder for OcktedGameModel
        $query = OcktedGameModel::query();

        // 🔍 Apply Search Filter Before Paginating
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('game_title', 'like', "%{$search}%")->orWhere('game_source', 'like', "%{$search}%");  // Search in game_source  // Efficient search with SQL
        }

        // 🟢 Apply Status Filter: Ensure correct status is being toggled
        // $status = $request->input('status', 'active');  // Default to 'active' if not provided
        // if (in_array($status, ['active', 'inactive'])) {
        //     $query->where('game_status', $status);  // Apply status filter directly in SQL
        // }

        $status = $request->input('status');  // Do not set default, allow for no filter initially
        if ($status && in_array($status, ['active', 'inactive'])) {
            $query->where('game_status', $status);  // Apply status filter directly in SQL
        }


        // Paginate the filtered results
        $games = $query->paginate(10)->withQueryString();  // Paginate after filtering

        // Return the view with paginated games
        return view('Dashboard.Pages.games-dash', compact('games'));
    }

    public function editGameStatus(Request $request)
    {
        Log::info("Its hitting");
        $status = $request->input('game_status');
        $game_code = $request->input('game_code');

        $data = ['game_status' => $status, 'game_code' => $game_code];

        Log::info("Data", ['data:' => $data]);

        $game = OcktedGameModel::where('game_code', $game_code)->first();
        Log::info("Game",['data' => $game]);

        if(!$game){
            return response()->json([
                'message' => 'Game Code Doesnt Exists',
            ]);
        }
        Log::info("Game", ['status' => $game->game_status]);

        if($game->game_status === 'Active'){
            $game->update([
                'game_status' => 'Inactive',
            ]);


        }else{
            $game->update([
                'game_status' => 'Active',
            ]);

        }
        Log::info("Update Done", ['new Status' => $game]);

        session()->flash('active_toast', true);
        return redirect()->back();

        // if($game->game_status === 'Active'){
        //     $game = update(['game_status' => 'Inactive']);
        // }else{
        //     $game =update(['game_status' => 'Active']);
        // }

        return response()->json([
            'message' => 'Data Received',
        ]);

    }

    public function playerUpdate(Request $request)
    {
        try{
            Log::info("It's hitting");

            // // Validate incoming request
            $validatedData = $request->validate([
                'username' => 'nullable|string',
                'school_code' => 'nullable|string',
                'game_token' => 'required|string', //Ensure the game_token is passed
                'rank' => 'nullable|string',
            ]);


            // Find player by game_token
            $player = OcktedUserModel::where('game_token', $validatedData['game_token'])->first();

            if (!$player) {
                return response()->json(['message' => 'Player not found'], 404);
            }

            Log::info("player", ['data' => $player]);

            // Update player data
            $player->update([
                'username' => $validatedData['username'] ?? $player->username, //Only update if new value
                'school_code' => $validatedData['school_code'] ?? $player->school_code, //Only update if new value
                'rank' => $field['rank'] ?? $player->rank,
            ]);



            Log::info("Player Updated", ['data' => $player]);
            session()->flash('player_updated', true);
            return redirect()->back();
            // return response()->json([
            //     'message' => 'player updated',
            // ]);

        }catch(Exception $e){
            Log::error("erorr", ['error' => $e->getMessage()]);
        }


    }

    public function removePlayer(Request $request)
    {
        try{
            info("ITS HITITNG");
            $token = $request->input();

            $player = OcktedUserModel::where('game_token', $token)->first();

            $player->delete();
            info("PLAYER DELETED");
            session()->flash('player_remove', true);
            return redirect()->back();
        }catch(Exception $e){
            Log::error("Error", ['message' => $e->getMessage()]);
        }
    }
}

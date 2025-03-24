<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchGameController extends Controller
{
    public function fetchGame()
    {
        $response = Http::get('http://127.0.0.1:8005/game-data');
        if($response->successful()){
            $gameData = $response->json();
            Log::info("Game Data", ["Data" => $gameData]);
            // return response()->json([
            //     'Data' => $gameData,
            // ]);
        }
    }
}

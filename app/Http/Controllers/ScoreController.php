<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ScoreModel;

class ScoreController extends Controller
{
    public function handleScore(Request $request)
    {
        try{
            $field = $request->validate([
                'game_id' => 'integer|required',
                'game_title' => 'required|string',
                'game_description' => 'required|string',
                'game_level' => 'required|string',
                'game_score' => 'required|string',
                'username' => 'required|string',
            ]);

            $score = ScoreModel::create($field);

            return response()->json([
                'message' => 'Score Successfully sent',
                'Data' => $score
            ]);
        }catch(\Exception $e){
            Log::error("Error", ["Error" => $e->getMessage()]);
            return response()->json([
                'message' => 'Error Sending Score',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function showScore()
    {
        $score = ScoreModel::get()->all();
        return response()->json([
            'score' => $score
        ]);
        // return view('pages.score', compact('score'));
    }
}

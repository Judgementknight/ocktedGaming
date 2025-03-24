<?php

namespace App\Http\Controllers;

use App\Models\AccountModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    public function register(Request $request)
    {
        try{
            $field = $request->validate([
                'username' => 'required|string',
                'email' => 'required|email|unique:user_accounts,email',
                'password' => 'required|string|min:8',
            ]);

            $password = Hash::make($field['password']);

            $account = AccountModel::create([
                'username' => $field['username'],
                'email' => $field['email'],
                'password' => $password,
            ]);

            Log::info($account);


            return redirect()->route('login-page');

        }catch(Exception $e){
            Log::error("Error Registering",  ["Error"=>$e->getMessage()]);
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error Registering. Please Try Again Later',
            ],500);
        }
    }

        public function login(Request $request)
        {
            try{
                $field = $request->validate([
                    'email' => 'required|email|exists:user_accounts,email',
                    'password' => 'required|string|min:8',
                ]);

                $account = AccountModel::where('email',$request->email)->first();

                if($account && Hash::check($request->password, $account->password)){

                    $sessionToken = Str::random(60);

                    session()->regenerate();
                    session()->put('session_token',$sessionToken);
                    session()->put('user_id',$account->user_id);
                    session()->save();
                    $apiToken = Str::random(60);
                    $account->update(['api_token' => $apiToken]);

                    // // $account->refresh();
                    // return response()->json([
                    //     'session' => session()->all(),
                    // ]);
                    return redirect()->route('home-page');

                }

                $response = Http::post('prayag_edu_API',[
                    'email' => $field['email'],
                    'password' => $field['password'],
                ]);

                if($response->failed()){
                    return response()->json([
                        'message' => 'Invalid Credentials',
                    ],402);
                }

                $sessionToken = Str::random(20);

                session()->regenerate();
                session()->put('session_token',$sessionToken);
                // session()->put('user_id',$response['user_id']);
                session()->save();


                // $apiToken = Str::random(60);
                // $account->update(['api_token' => $apiToken]);

                return redirect()->route('home-page');

            }catch(Exception $e){
                Log::error("Eorror", ['Error' => $e->getMessage()]);
                return response()->json([
                    'error' => $e->getMessage(),
                ]);
            }
        }

    public function logout(Request $request)
    {
        $account = AccountModel::find(session('user_id'));

        if($account)
        {
            $account->update(['api_token' => null]);
        }

        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('login-page');
        // return response()->json([
        //     'message' => 'Log out Successful'
        // ]);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckNewUserOrOld
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the user data from session
        $user = session()->get('User Data');

        // Log the session data for debugging (you can remove this later in production)
        Log::info('Session Data: has gametoken', ['user' => $user]);

        // Check if the session data exists and if the game_token exists
        if (!$user || !isset($user->game_token) || !$user->game_token) {
            // Redirect to welcome page if there's no game_token
            return redirect()->route('welcome');
        }

        // If the game_token exists, continue with the request
        return $next($request);
    }
}

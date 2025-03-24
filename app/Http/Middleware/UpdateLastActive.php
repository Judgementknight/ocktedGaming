<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\OcktedUserModel;

class UpdateLastActive
{
    public function handle($request, Closure $next)
    {
        // Check if the user data exists in the session
        Log::info('session data kjlasdkas', ['data' => session()->all()]);

        if (session()->has('User Data')) {
            // Get the user model from the session
            Log::info("it is checking");
            $user = session('User Data');

            // Retrieve the user_id from the stored user object
            $userId = $user->user_id;

            Log::info("user session", ['data' => $userId]);
            // Update the last active time for the user in the database

            // Get the current time and the last active time from the user
            // $currentTime = Carbon::now();
            // $lastActiveTime = Carbon::parse($user->last_active_at);

            // if($lastActiveTime->diffInMinutes($currentTime) > 1) {
            //     OcktedUserModel::where('user_id', $userId)->update(['user_status' => 'Inactive']);
            // } else{
            //     OcktedUserModel::where('user_id', $userId)->update(['user_status' => 'Active']);
            // }

            // OcktedUserModel::where('user_id', $userId)->update(['last_active_at' => $currentTime]);
             // Update the last active time for the user in the database and set user status to 'Active'
            $last = OcktedUserModel::where('user_id', $userId)->update([
                'last_active_at' => Carbon::now(),
                'user_status' => 'Active' // Ensure the user is marked as Active
            ]);
            Log::info("UPDATED", ['data' => $last]);
        }

        return $next($request);
    }
}

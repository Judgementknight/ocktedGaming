<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\OcktedStudentModel;

class UpdateLastActive
{
    public function handle($request, Closure $next)
    {


        if (session()->has('Student Data')) {
            // Get the user model from the session
            Log::info("Last Active Middleware is triggering");
            $student = session()->get('Student Data');

            // Retrieve the user_id from the stored user object
            $studentId = $student->ocktedgaming_id;

            Log::info("user session", ['data' => $studentId]);
             // Update the last active time for the user in the database and set user status to 'Active'
            $last = OcktedStudentModel::where('ocktedgaming_id', $studentId)->update([
                'last_active_at' => Carbon::now(),
                'student_status' => 'Active' // Ensure the user is marked as Active
            ]);
            Log::info("UPDATED last active at status", ['data' => $last]);
        }

        return $next($request);
    }
}

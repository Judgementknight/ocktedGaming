<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use App\Models\AdminModel;

class RememberAdminToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Log::info("Admin Session", session()->all());
        $sessionToken = session()->get('remember_token');

        $admin = AdminModel::first();
        $rememberToken = $admin->remember_token;

        if($rememberToken){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('login');
        }

        Log::info("ADMIN REMEMBER TOKEN", ['token' => $admin->remember_token]);
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EnsureTokenValid
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('dashboard/login')) {
            return $next($request);
        }

        // Log::info('ENSURE TOKEN VALID is trigerring');
        // $token = session('admin_token');
        $token = session()->get('admin_token');

        // Log::info('ENSURE TOKEN VALID ttoken', ['token' => $token]);


        if (!$token) {
            return redirect()->route('login')->with('error', 'jadlskjklUnauthorized access.');
        }

        // Retrieve the sole admin record.
        $admin = AdminModel::first();

        if (!$admin || !Hash::check($token, $admin->api_token)) {
            return redirect()->route('login')->with('error', 'logindaslUnauthorized access.');
        }

        // Optionally attach the admin record to the request.
        $request->attributes->set('admin', $admin);

        return $next($request);
    }
}

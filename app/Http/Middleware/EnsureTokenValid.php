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
        // Log::info('ENSURE TOKEN VALID is trigerring');
        // $token = session('admin_token');
        $token = session()->get('admin_token');

        // Log::info('ENSURE TOKEN VALID ttoken', ['token' => $token]);


        if (!$token) {
            return redirect('api/dashboard/login')->with('error', 'Unauthorized access.');
        }

        // Retrieve the sole admin record.
        $admin = AdminModel::first();

        if (!$admin || !Hash::check($token, $admin->api_token)) {
            return redirect('api/dashboard/login')->with('error', 'Unauthorized access.');
        }

        // Optionally attach the admin record to the request.
        $request->attributes->set('admin', $admin);

        return $next($request);
    }
}

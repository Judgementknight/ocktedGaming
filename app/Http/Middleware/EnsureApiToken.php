<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AdminModel;
use Illuminate\Support\Facades\Hash;

class EnsureApiToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized no header token',
            ], 401);
        }

        $token = str_replace('Bearer ', '', $token);

        // Since there's only one admin, retrieve that record directly.
        $admin = AdminModel::first();

        if (!$admin || !Hash::check($token, $admin->api_token)) {
            return response()->json([
                'message' => 'Unauthorized no api token',
            ], 401);
        }

        // Optionally attach the admin record to the request.
        $request->attributes->set('admin', $admin);

        return $next($request);
    }
}


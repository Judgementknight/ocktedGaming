<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckLastVisitedPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Exclude the redirect route from being stored as the last visited page
        if ($request->method() === 'GET' && !$request->ajax() && !$request->routeIs('redirect.to.last.page')) {
            session()->put('last_visited_page', $request->fullUrl());
            Log::info('Session Last Page', ['last_visited_page' => session()->get('last_visited_page')]);
        }

        // Check if the user should be redirected to the last visited page
        if ($request->routeIs('redirect.to.last.page') && session()->has('last_visited_page')) {
            return redirect(session()->get('last_visited_page'));
        }

        return $next($request);
    }

}

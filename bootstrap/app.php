<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureTokenValid;
use App\Http\Middleware\EnsureApiToken;
use Illuminate\Session\Middleware\StartSession;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
            // $middleware->append(StartSession::class); // Add session middleware
            // $middleware->append(\App\Http\Middleware\EnsureTokenValid::class);
            // $middleware->append(\App\Http\Middleware\EnsureApiToken::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

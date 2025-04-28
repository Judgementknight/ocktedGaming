<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Http\Middle\CheckLastVisitedPage;
use App\Http\Middle\CheckAccountSession;
use App\Http\Middleware\EnsureTokenValid;
use App\Http\Middleware\EnsureApiToken;
use App\Http\Middleware\UpdateLastActive;
use App\Http\Middleware\CheckNewOrOld;
use App\Http\Middleware\RememberAdminToken;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,  //Ensure Sanctum handles frontend requests
            \Illuminate\Session\Middleware\StartSession::class, // enable session to work on api.php routes
            'throttle:api',         //Throttle:Limits the number of requests (for rate limiting).
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            EnsureTokenValid::class,
            EnsureApiToken::class,
            UpdateLastActive::class,
            CheckNewOrOld::class,
            CheckLastVisitedPage::class,
            RememberAdminToken::class,
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,  //Ensure Sanctum handles frontend requests
            \Illuminate\Session\Middleware\StartSession::class, // enable session to work on api.php routes
            'throttle:api',         //Throttle:Limits the number of requests (for rate limiting).
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            EnsureTokenValid::class,
            EnsureApiToken::class,
            UpdateLastActive::class,
            CheckNewOrOld::class,
            CheckLastVisitedPage::class,
            RememberAdminToken::class,
        ],
            // \App\Http\Middle\CheckAccountSession::class,
        // 'check' => CheckAccountSession::class,
        // 'last_visit' => CheckLastVisitedPage::class,

    ];

}

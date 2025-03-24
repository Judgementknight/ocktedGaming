<?php

use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\DeactivateInactiveUsers;
use Illuminate\Support\Facades\Schedule;

// Schedule the deactivation task every minute
// Schedule::command('users:deactivate')->everyMinute();

Schedule::command('users:deactivate')->everyMinute();

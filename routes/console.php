<?php

use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\DeactivateInactiveUsers;
use App\Console\Commands\AssignmentOverdue;
use App\Console\Commands\CustomAssignmentOverdue;

use Illuminate\Support\Facades\Schedule;

// Schedule the deactivation task every minute
// Schedule::command('users:deactivate')->everyMinute();

// Schedule::command('users:deactivate')->everyMinute();

// Schedule::command('assignment:overdue')->daily()->everyMinute();

Schedule::command('customassignment:overdue')->everyMinute();




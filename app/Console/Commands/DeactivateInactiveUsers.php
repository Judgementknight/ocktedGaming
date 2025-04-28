<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use App\Models\OcktedUserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeactivateInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'users:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate users who have been inactive for more than 1 minute';

    /**
     * Execute the console command.
    */
    public function handle()
    {
        $inactiveUsers = OcktedUserModel::where('last_active_at', '<', Carbon::now()->subMinute(1))
        ->update(['user_status' => 'Inactive']);
        $this->info("Deactivated $inactiveUsers users.");
        info('Command Run every minute inactive users');

        // $this->info("Deactivated $inactiveUsers user(s).");
    }
}

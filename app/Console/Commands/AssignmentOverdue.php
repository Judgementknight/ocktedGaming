<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Assignment\CustomAssignmentCompleteModel;
use App\Models\Assignment\CustomGameAssignmentModel;
use App\Models\Assignment\GameAssignmentCompleteModel;
use App\Models\Assignment\GameAssignmentModel;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AssignmentOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'assignment:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set Assignment to Overdue when pass Due Date';

    /**
     * Execute the console command.
    */
    public function handle()
    {

        $now = Carbon::now();

        $assignment = GameAssignmentCompleteModel::where('assignment_status', 'pending')->whereHas('assignment', function($a) use ($now) {
            $a->where('due_date', '<', $now);
        })->update(['assignment_status' => 'overdue']);

        $this->info("✅ Marked {$assignment} assignment(s) as overdue.");

    }
}

// $inactiveUsers = OcktedUserModel::where('last_active_at', '<', Carbon::now()->subMinute(1))
// ->update(['user_status' => 'Inactive']);
   // $this->info("Deactivated $inactiveUsers users.");
        // info('Command Run every minute');

        // $this->info("Deactivated $inactiveUsers user(s).");

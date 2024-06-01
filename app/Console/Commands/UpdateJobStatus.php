<?php

namespace App\Console\Commands;

use Illuminate\support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Job;

class UpdateJobStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateStatus:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        $expiredJobs = Job::where('end_date', '<', $now)
            ->where('status', '=', 'pending')->get();

        foreach ($expiredJobs as $expiredJob) {
            $expiredJob->update(['status' => 'rejected']);
        }
    }
}

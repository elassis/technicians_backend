<?php

namespace App\Console\Commands;

use Illuminate\support\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
      DB::table('jobs')
          ->where('end_date','<', $now)
          ->where('status','=','pending')
          ->update([
            'status' => 'rejected'
          ]);
       /*  return 0; */
    }
}

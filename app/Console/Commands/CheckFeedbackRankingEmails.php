<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Job;
use App\User;
use App\Jobs\SendFeedbackRankingEmailJob;

class CheckFeedbackRankingEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:request_feedback_ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command creates a job to send emails to provide feedback';

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

        //get all jobs that end date is less than today's date
        $now = Carbon::now();
        $jobs = Job::where('end_date', '<', $now)->where('status', '=', 'accepted')->get();
        $protocol = app()->environment('production') ? 'https://' : 'http://';
        if ($jobs) {
            foreach ($jobs as $job) {
                //getting client's email, technician's name, the profession
                $clientEmail = User::findOrFail($job->user_id)->email;
                $tecnicianUser = $job->technician->user;
                $technicianName = $tecnicianUser->first_name . ' ' . $tecnicianUser->last_name;
                $profession = $job->profession->name;
                $link = $protocol . env('SANCTUM_STATEFUL_DOMAINS') . '/jobs/rank/' . $job->id; //fix link address

                $data = array(
                    'technician' => $technicianName,
                    'job' => $profession,
                    'link' => $link,
                );

                SendFeedbackRankingEmailJob::dispatch($clientEmail, $data);
            }
        }

        $this->info('check needed to feedback jobs and sent emails');
    }
}

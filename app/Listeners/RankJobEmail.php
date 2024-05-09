<?php

namespace App\Listeners;

use App\Events\RankJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RankJobEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RankJob  $event
     * @return void
     */
    public function handle(RankJob $event)
    {
        $details = [
          'job' => $event->job,
          'link' => $event->link,
          'technician' => $event->technician,
        ];

        \Mail::to($event->email)->send(new \App\Mail\JobRankingEmail($details));

    }
}

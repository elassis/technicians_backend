<?php

namespace App\Listeners;

use App\Events\JobRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmail
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
   * @param  JobRequested  $event
   * @return void
   */
  public function handle(JobRequested $event)
  {
    $details = [
      'user' => $event->user,
      'job' => $event->job
    ];

    \Mail::to($event->email)->send(new \App\Mail\JobRequestMail($details));
  }
}

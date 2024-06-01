<?php

namespace App\Listeners;

use App\Events\JobRequestReponse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendResponseEmail
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
   * @param  JobRequestReponse  $event
   * @return void
   */
  public function handle(JobRequestReponse $event)
  {
    $details = [
      'user'     => $event->tech_info,
      'response' => $event->response
    ];

    \Mail::to($event->user_email)->send(new \App\Mail\JobRequestResponseMail($details));
  }
}

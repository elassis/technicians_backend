<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobRequestReponse
{
  use Dispatchable, InteractsWithSockets, SerializesModels;
  public $response;
  public $tech_info;
  public $user_email;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct($tech_info, $user_email, $response)
  {
    $this->response = $response;
    $this->tech_info = $tech_info;
    $this->user_email = $user_email;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return \Illuminate\Broadcasting\Channel|array
   */
  public function broadcastOn()
  {
    return new PrivateChannel('channel-name');
  }
}

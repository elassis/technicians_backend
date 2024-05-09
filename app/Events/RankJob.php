<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RankJob
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $link, $job, $technician, $email;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($link, $job, $technician, $email)
    {
        $this->job = $job;
        $this->link = $link;
        $this->email = $email;
        $this->technician = $technician;
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

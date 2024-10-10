<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $numChannel;
    /**
     * Create a new event instance.
     */
    public function __construct($message, $numChannel)
    {
        $this->message = $message;
        $this->numChannel = $numChannel;
    }

    public function broadcastAs()
    {
        return 'my-event';
    }

    public function broadcastOn()
    {
        return ['my-channel' . $this->numChannel];
    }

    public function broadcastWith()
    {
        return ["message" => $this->message];
    }
}

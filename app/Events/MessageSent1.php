<?php

namespace App\Events;
// use App\Models\User;
// use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;



class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var User
     */
    public $user;

    /**
     * Message details
     *
     * @var Message
     */
    public $message;
    public $numChannel;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $user, $message, $numChannel)
    {
        $this->user = $user;
        $this->message = $message;
        $this->numChannel = $numChannel;
       // Log::info('MesagePushec contruct1');
       // dd('fff');
        
    }



    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('chat');
    // }
    // public function broadcastOn()
    // {
    //     return ['my-channel'];
    //     
    // }

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

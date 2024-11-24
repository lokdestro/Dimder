<?php

namespace App\Websocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Websocket implements MessageComponentInterface
{
    protected $clients;
    private $connections = [];

    public function __construct() {
        Log::info("0000000000000000  __construct" );
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        Log::info("0000000000000000  onOpen" );
        echo "New connection! ({$conn->resourceId})\n";

    }

    public function onMessage(ConnectionInterface $from, $msg) {

        Log::info("0000000000000000  onMessage  msg = " . $msg);
        echo "\n0001-------Начало-------------";
        echo "\n------     " . json_encode(Carbon::now()->format('Y-m-d H:i:s')) . "     ----\n";
        $stdout = fopen('php://stdout', 'w');
        fwrite($stdout, $msg);
        $data = json_decode($msg);
        fwrite($stdout, print_r($data, true));

        $info = $data->info;
        $senderId = $data->sender_id;
        $consumerId = $data->consumer_id;

        $message = Message::create([
            'sender_id' => $senderId,
            'consumer_id' => $consumerId,
            'info' => $info
        ]);

        $user = Auth::user();
        Log::info($user);
        Log::info($responseMessage);

        $responseMessage = json_encode([
            'id' => $message->id,
            'sender_id' => $user->id,
            'consumer_id' => $message->consumer_id,
            'info' => $message->info,
        ]);
        Log::info(responseMessage);
        
        if (isset($this->clients[$consumerId])) {
            $this->clients[$consumerId]->send($responseMessage); // Отправляем сообщение только получателю
            Log::info("Message sent to consumer_id: " . $consumerId);
        } else {
            Log::warning("Client with consumer_id {$consumerId} is not connected.");
        }
    }

    public function onClose(ConnectionInterface $conn) {
        Log::info("0000000000000000  onClose" );
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        Log::info("0000000000000000  onError" );
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
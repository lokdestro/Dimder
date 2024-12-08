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
    protected $clients = [];
    private $connections = [];
    private $consumerToconn = [];
    private $resourseToUser = [];

    public function __construct() {
        // Log::info("0000000000000000  __construct" );
        // $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients[$conn->resourceId] = $conn;
        Log::info("0000000000000000  onOpen" );
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        Log::info("0000000000000000  onMessage  msg = " . $msg);
        echo "\n0001-------Начало-------------";
        Log::info("1");
        echo "\n------     " . json_encode(Carbon::now()->format('Y-m-d H:i:s')) . "     ----\n";
        Log::info("2");
        $stdout = fopen('php://stdout', 'w');
        Log::info("3");
        fwrite($stdout, $msg);
        Log::info("4");
        $data = json_decode($msg);
        $user = Auth::user();
        // if (empty($user)) {
        //     Log::info("USER NOT FOUND");
        //     return;
        // }
        $type = $data->type ?? '';
        if ($data->type == 'init') {
            Log::info("INIT");
            $this->consumerToconn[$data->sender_id] = $from->resourceId;
            // $this->resourseToUser[$from->resourceId] = $user->id;
            Log::info("INIT1");
            $this->resourseToUser[$from->resourceId] = $data->sender_id;
            Log::info("INIT2");
            return;
        }
        fwrite($stdout, print_r($data, true));
        Log::info("5");
        $body = $data->body;
        $senderId = $data->sender_id;
        $consumerId = $data->consumer_id;
        Log::info("6");
        $message = Message::create([
            'sender_id' => $senderId,
            'consumer_id' => $consumerId,
            'info' => $body,
            'type' => $type
        ]);
        Log::info("7");
        // Log::info($user);

        $responseMessage = json_encode([
            'id' => $message->id,
            'sender_id' => $senderId,
            'consumer_id' => $consumerId,
            'body' => $body,
            'type' => $type
        ]);
        Log::info("8");
        Log::info($responseMessage);
        Log::info("9");
        if (isset($this->consumerToconn[$consumerId])) {
            $this->clients[$this->consumerToconn[$consumerId]]->send($responseMessage);
            Log::info("Message sent to consumer_id: " . $consumerId);
        } else {
            Log::warning("Client with consumer_id {$consumerId} is not connected.");
        }
    }

    public function onClose(ConnectionInterface $conn) {
        Log::info("0000000000000000  onClose");
        Log::info($this->resourseToUser);
        Log::info($conn->resourceId);
        $user_id = $this->resourseToUser[$conn->resourceId];
        Log::info("0000000000000000  onClose1");
        unset($this->resourseToUser[$conn->resourceId]);
        Log::info("0000000000000000  onClose2");
        unset($this->clients[$this->consumerToconn[$user_id]]);
        Log::info("0000000000000000  onClose3");
        unset($this->consumerToconn[$user_id]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        Log::info("0000000000000000  onError" );
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}
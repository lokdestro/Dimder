<?php

namespace App\Websocket;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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


        foreach ($this->clients as $client) {
           // if ($from !== $client) {
                $client->send($msg);
           // }
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
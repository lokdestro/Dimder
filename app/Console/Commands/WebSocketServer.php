<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use App\Websocket\Websocket;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the WebSocket server';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        // $this->signature = env('APP_ENV') === 'testing' ? 'webSocket {action} {--port=8086}' : 'webSocket {action} {--port=8080}';
        parent::__construct();
    }
    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Websocket()
                )
            ),
            8080
        );

        $this->info("WebSocket server started on port 8080");
        $server->run();
    }
}

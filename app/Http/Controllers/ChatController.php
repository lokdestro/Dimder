<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MyEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $message = 'Hello, this is a real-time notification!';
        // store request into database if required
        if (isset($request->numChannel)){
            event(new MyEvent($message, $request->numChannel));
        }

        return response()->json('Notification sent!');
    }

    public function sendMessage(Request $request)
    {
      //  $user = Auth::user();
      Log::info("0000000000000000" . $request->get('message'));
        if ($request->has('message')){ 
            $data=$request->get('message');
            $numChannel=$request->get('numChannel');
            $consumerId = $request->get('consumer_id');
            $message = Message::create([
                'sender_id' => $sender->id,
                'consumer_id' => $consumerId,
                'info' => $info
            ]);
            $newMessage=new MyEvent($data, $numChannel);
            broadcast($newMessage);
            return response()->json(['status' => 'Message sent successfully', 'message' => $message]);
        }
        return ['status' => 'Message Error'];
    }

    public function fetchMessages(Request $request)
    {
        $senderId = Auth::id();
        $consumerId = $request->get('consumer_id');
        $messages = Message::where(function($query) use ($senderId, $consumerId) {
                $query->where('sender_id', $senderId)
                      ->where('consumer_id', $consumerId);
            })
            ->orWhere(function($query) use ($senderId, $consumerId) {
                $query->where('sender_id', $consumerId)
                      ->where('consumer_id', $senderId);
            })
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return response()->json($messages);
    }
}

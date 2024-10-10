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
            // $message = $user->messages()->create([
            //  'message' => $data
            //  ]);
            $newMessage=new MyEvent($data, $numChannel);
            broadcast($newMessage);//->toOthers();
            //broadcast(new MessageSent($user,$message,$numChannel))->toOthers();
            return ['status' => 'Message OK'];
        }
        return ['status' => 'Message Error'];
    }
}

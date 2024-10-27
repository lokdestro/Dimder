<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MyEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Отправка уведомления в реальном времени.
     *
     * @OA\Post(
     *     path="/store",
     *     summary="Отправка уведомления",
     *     tags={"Chat"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="numChannel", type="string", example="general"),
     *             @OA\Property(property="message", type="string", example="Hello, this is a real-time notification!")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Уведомление отправлено"),
     *     @OA\Response(response=400, description="Ошибка запроса")
     * )
     */
    public function store(Request $request)
    {
        $message = 'Hello, this is a real-time notification!';

        if (isset($request->numChannel)) {
            event(new MyEvent($message, $request->numChannel));
        }

        return response()->json('Notification sent!');
    }

    /**
     * Отправка сообщения.
     *
     * @OA\Post(
     *     path="/sendMessage",
     *     summary="Отправка сообщения",
     *     tags={"Chat"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Hello, world!"),
     *             @OA\Property(property="numChannel", type="string", example="general")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Сообщение отправлено успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Message OK")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Ошибка отправки сообщения",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="Message Error")
     *         )
     *     )
     * )
     */
    public function sendMessage(Request $request)
    {
        Log::info("Message Log: " . $request->get('message'));

        if ($request->has('message')) {
            $data = $request->get('message');
            $numChannel = $request->get('numChannel');

            $newMessage = new MyEvent($data, $numChannel);
            broadcast($newMessage);

            return ['status' => 'Message OK'];
        }
        return ['status' => 'Message Error'];
    }
}

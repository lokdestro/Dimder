<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Events\MyEvent;
use Illuminate\Support\Facades\Log;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка отправки уведомления через метод store.
     *
     * @return void
     */
    public function testStoreNotification()
    {
        Event::fake(); // Подделываем события для проверки
        $payload = [
            'numChannel' => 'general',
            'message' => 'Hello, this is a real-time notification!'
        ];

        $response = $this->postJson('/store', $payload);

        // Проверка ответа и вызова события
        $response->assertStatus(200);
        $response->assertJson(['Notification sent!']);
        Event::assertDispatched(MyEvent::class, function ($event) use ($payload) {
            return $event->message === $payload['message'] && $event->numChannel === $payload['numChannel'];
        });
    }

    /**
     * Проверка отправки сообщения через метод sendMessage.
     *
     * @return void
     */
    public function testSendMessage()
    {
        Event::fake();
        Log::shouldReceive('info')->once()->with('Message Log: Hello, world!');

        $payload = [
            'message' => 'Hello, world!',
            'numChannel' => 'general'
        ];

        $response = $this->postJson('/sendMessage', $payload);

        // Проверка ответа и отправки события
        $response->assertStatus(200);
        $response->assertJson(['status' => 'Message OK']);
        Event::assertDispatched(MyEvent::class, function ($event) use ($payload) {
            return $event->message === $payload['message'] && $event->numChannel === $payload['numChannel'];
        });
    }

    /**
     * Проверка ошибки при отсутствии сообщения в запросе в методе sendMessage.
     *
     * @return void
     */
    public function testSendMessageWithoutMessage()
    {
        $payload = [
            'numChannel' => 'general'
        ];

        $response = $this->postJson('/sendMessage', $payload);

        // Ожидаем ошибку с соответствующим ответом
        $response->assertStatus(200);
        $response->assertJson(['status' => 'Message Error']);
    }
}

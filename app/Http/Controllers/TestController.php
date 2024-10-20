<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="API для управления пользователями и профилями",
 *      description="Пример API для создания, редактирования и удаления профилей пользователей.",
 * )
 */

class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/test",
     *     summary="Выполнение операций с пользователями и профилями",
     *     description="Метод создает нового пользователя и профиль, обновляет информацию профиля, удаляет профиль и возвращает информацию о пользователе.",
     *     tags={"TestController"},
     *     @OA\Response(
     *         response=200,
     *         description="Успешная операция",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string", example="Финансы"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="ali"),
     *                 @OA\Property(property="email", type="string", example="tishkovdima05@gmail.com"),
     *                 @OA\Property(
     *                     property="profile",
     *                     type="object",
     *                     @OA\Property(property="country", type="string", example="Minsk"),
     *                     @OA\Property(property="city", type="string", example="minsk"),
     *                     @OA\Property(property="bio", type="string", example="Обновленная информация о пользователе")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="button",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Кнопка 1")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ресурс не найден",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Внутренняя ошибка сервера",
     *     )
     * )
     */
    public function index(){
        // user::create([
        //     'name' => 'ali',
        //     'email' => 'tishkovdima05@gmail.com',
        //     'password' => '1234'
        // ]);

        // Profile::create([
        //     'user_id' => 1,
        //     'photo' => '',
        //     'bio' => '',
        //     'country' => 'Minsk',
        //     'city' => 'minsk',
        //     'birthday' => date("Y-m-d H:i:s"),
        //     'sex' => 'male',
        //     'interests' => ''
        // ]);

        // $button = Button::where('owner_id', $userId)->first();

        // Profile::where('user_id', 1)->delete();


        // $profile = Profile::where('user_id', 2)->first();

        // if ($profile) {
        //     $profile->bio = 'Обновленная информация о пользователе';
        //     $profile->city = 'Брест';
        //     $profile->save();
        // }


        $user = User::where('id', 1)
                        ->with(['profile'])
                        ->first();
        // return  [
        //     'title' => 'Финансы',
        //     'name' => $button->name,
        //     'user' => $user,
        //     'button' => $button,

        // ];
        \Log::info($user);
        return view("welcome", $user);
    }

}

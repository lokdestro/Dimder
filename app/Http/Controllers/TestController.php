<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;

class TestController extends Controller
{
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

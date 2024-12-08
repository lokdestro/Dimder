<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class CookieController extends Controller
{
    // Установить cookies
    public function setCookie()
    {
        Cookie::queue('language', 'ru', 60); // Добавить cookie на 60 минут
        Log::info('add cookie');
        return response('Cookie добавлена!');
    }

    // Получить cookies
    public function getCookie(Request $request)
    {
        $value = $request->cookie('language');
        Log::info('get cookie');
        return response()->json(['language' => $value]);
       
    }

    // Удалить cookies
    public function deleteCookie()
    {
        Log::info('del cookie');
        Cookie::queue(Cookie::forget('language')); // Удаляем cookie
        return response('Cookie удалена!');
    }
}


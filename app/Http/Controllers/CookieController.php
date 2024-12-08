<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class CookieController extends Controller
{
    public function setCookie(Request $request)
    {
        try {
            $language = $request->input('language');

            if (!$language) {
                return response()->json(['error' => 'Язык не указан.'], 400);
            }

            Cookie::queue('language', $language, 60);

            Log::info('Cookie "language" установлена с языком: ' . $language);

            return response()->json([
                'success' => true,
                'message' => 'Cookie установлена.',
                'language' => $language,
            ]);
        } catch (\Exception $e) {
            Log::error('Ошибка при установке Cookie: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ошибка при установке Cookie.',
            ], 500);
        }
    }

    public function getCookie(Request $request)
    {
        $value = $request->cookie('language');
        return response()->json(['language' => $value]);
    }

    public function deleteCookie()
    {
        Cookie::queue(Cookie::forget('language'));
        Log::info('Cookie "language" удалена.');
        return response('Cookie удалена!');
    }
}


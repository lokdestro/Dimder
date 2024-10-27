<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class PageController extends BaseController
{
    /**
     * Отображение страницы "Welcome".
     *
     * @OA\Get(
     *     path="/index",
     *     summary="Отображение главной страницы",
     *     tags={"Pages"},
     *     @OA\Response(
     *         response=200,
     *         description="Главная страница",
     *         @OA\MediaType(
     *             mediaType="text/html"
     *         )
     *     )
     * )
     */
    public function index()
    {
        Log::info("Главная страница отображена.");
        return view('welcome');
    }

    /**
     * Отображение страницы "Page".
     *
     * @OA\Get(
     *     path="/page",
     *     summary="Отображение дополнительной страницы",
     *     tags={"Pages"},
     *     @OA\Response(
     *         response=200,
     *         description="Страница page",
     *         @OA\MediaType(
     *             mediaType="text/html"
     *         )
     *     )
     * )
     */
    public function page()
    {
        $x = 20; // Локальная переменная
        return view('page');
    }
}

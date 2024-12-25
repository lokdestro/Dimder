<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [PageController::class, 'index'])->name('main');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('jwt.auth')->group(function() {
    Route::get('getData',[AuthController::class, 'getData']);
});

Route::middleware('auth.token')->group(function () {
    Route::get('getData',[AuthController::class, 'getData'])->name('getData');
});

Route::get('/filter-profiles', [SearchController::class, 'filterProfiles']);
Route::get('/user/{userId}/chats', [ChatController::class, 'getUserChats']);
Route::get('/profile/get/{user_id}', [ProfileController::class, 'getProfile'])->name('get-profile');
Route::post('/profile/update/{user_id}', [ProfileController::class, 'updateProfile'])->name('update-profile');

Route::get('/confirm/{hash}', [AuthController::class, 'confirmEmail'])->name('confirmEmailName');
Route::get('/set-cookie', [CookieController::class, 'setCookie']);
Route::get('/get-cookie', [CookieController::class, 'getCookie']);
Route::post('/delete-cookie', [CookieController::class, 'deleteCookie']);
Route::post('/search', [SearchController::class, 'search'])->name('search');

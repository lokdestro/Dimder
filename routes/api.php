<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
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

Route::post('/store', [ChatController::class, 'store']);
Route::post('/sendMessage', [ChatController::class, 'sendMessage']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/signin', [AuthController::class, 'showSignIn']);
Route::get('/signup', [AuthController::class, 'showSignUp']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('jwt.auth')->group(function() {
    Route::get('getData',[AuthController::class, 'getData']);
});

Route::middleware('auth.token')->group(function () {
    Route::get('getData',[AuthController::class, 'getData'])->name('getData');
});

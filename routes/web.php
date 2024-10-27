<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PageController::class, 'index']);
Route::get('/page', [TestController::class, 'index']);
Route::post('/chat',[ChatController::class, 'store']);
Route::post('/messages', [ChatsController::class, 'sendMessage']);
Route::get('login', [AuthController::class, 'signin'])->name('signin');
Route::get('register', [AuthController::class, 'signup'])->name('signup');
Route::get('logout', [AuthController::class, 'weblogout'])->name('weblogout');

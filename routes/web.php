<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;

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
Route::get('/confirm/{hash}', [AuthController::class, 'confirmEmail'])->name('confirmEmailName');
Route::get('/set-cookie', [CookieController::class, 'setCookie']);
Route::get('/get-cookie', [CookieController::class, 'getCookie']);
Route::post('/delete-cookie', [CookieController::class, 'deleteCookie']);
Route::post('/search', [SearchController::class, 'search'])->name('search');

Route::get('/filter-profiles', [SearchController::class, 'filterProfiles']);
Route::get('/user/{userId}/chats', [ChatController::class, 'getUserChats']);
Route::get('/profile/get/{user_id}', [ProfileController::class, 'getProfile'])->name('get-profile');
Route::post('/profile/update/{user_id}', [ProfileController::class, 'updateProfile'])->name('update-profile');


// fetch('/search', { 
//     method: 'POST', 
//     body: {search : 'abcc'},
//     headers: { 
//         'Content-Type': 'application/json' 
//     }, 
// }) 
// .then(response => { 
//     console.log(response)
//     if (!response.ok) { 
//         throw new Error('Network response was not ok ' + response.statusText); 
//     } 
//     return response.json(); 
// }) 
// .then(data => { 
//     console.log('Success:', data); 
// }) 
// .catch((error) => { 
//     console.error('Error:', error); 
// });
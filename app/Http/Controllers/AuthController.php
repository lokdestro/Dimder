<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\ConfirmEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmOperatorAssignMail;
use App\Services\SearchService;

use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function signin(Request $request)
    {
        return view('login');
    }
    public function signup(Request $request)
    {
        return view('register');
    }
    public function weblogout(Request $request)
    {
        return view('logout');
    }

    public function confirmEmail(Request $request, $hash) {
        Log::info('call confirm');
        $confirm = ConfirmEmail::where([
            'confirm_hasn' => $hash
        ])->first();
        if (!empty($confirm)) {
            Log::info('find confirm hash');
            $user = User::where([
                'id' => $confirm->user_id
            ])->first();
            if (!empty($user)) {
                Log::info('find user');
                $user->email_comfirmed = 1;
                $user->save();
            }
        }
        Log::info("confirmEmail end");

    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where([
            'email' => $request->email
        ])->first();
        if (empty($user)){
            Log::critical('user not found');
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 'error',
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            Log::critical('Неверный пароль');
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 'error',
            ], 401);
        }

        $token = $user->api_token;

        if (!$token) {
            Log::critical('User не зарегестрирован');
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 'error',
            ], 401);
        }

        $user = Auth::user();
        Log::info("LOGIN SUCCESS");
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }
    public function register(Request $request)
    {

        Log::debug($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5',
        ]);
        $user = User::where([
            'email' => $request->email
        ])->get();
        if (count($user) > 0){
            Log::critical($user);
            return response()->json(['message' => 'Error', 'status' => 'error', 'user' => null]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $profile = Profile::create([
            'surname' => $request->surname,
            'user_id' => $user->id,
            'name' => $request->name,
            'photo' => "",
            'country' => "",
            'bio' => "",
            'city' => "",
            'birthday' => now(),
            'sex' => "",
            'interests' => "",
        ]);
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        $user->api_token = $token;
        $user->save();
        $email = $request->email;
        Log::info("1");
        $inf = $request->only('email', 'name');
        Log::info("2");
        $hash = md5($email);
        Log::info($hash);
        $confirmEmail = ConfirmEmail::create([
            'user_id' => $user->id,
            'confirm_hasn' => $hash,
        ]);
        Log::info('add confirmEmail');
        // try {
        //     Mail::to($email)->send(new ConfirmOperatorAssignMail($hash));
        // } catch (Exception $ex) {
        //     Log::critical($user, 'EMAIL');
        // }

        $to = $email; // Адрес получателя
        $subject = 'Подтверждение'; // Тема письма
        $message =  "<p><a href='https://lokdestro.ru/confirm/$hash'></a>Подтверждение</p>" ; // Текст письма
        
        // Заголовки для письма
        $headers = "From: sender@example.com\r\n";
        $headers .= "Reply-To: sender@example.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";  // Устанавливаем кодировку и тип контента
        
        // Отправка письма
        if(mail($to, $subject, $message, $headers)) {
            echo 'Письмо успешно отправлено!';
        } else {
            echo 'Ошибка при отправке письма.';
        }

        $user = Auth::user();
        Log::info($user);

        return  response()->json(['message' => 'User register successfully', 
                                  'status' => 'success', 
                                  'user' => $user, 
                                  'token' => $token
                                ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // $user = User::where([
        //     'email' => $request->email
        // ])->get();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return response()->json([
            'message' => 'Successfully logged out',
            'status' => 'success'
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function getData()
    {
        $users = User::all();
        return response()->json([
            'users' =>  $users,
            'status' => 'success'

        ]);
    }
}
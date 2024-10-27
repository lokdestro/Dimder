<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
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
            return response()->json([
                'message' => 'Unauthorized3',
                'status' => 'error',
            ], 401);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized1',
                'status' => 'error',
            ], 401);
        }

        $token = $user->api_token;

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized2',
                'status' => 'error',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token,
        ]);
    }
    public function register(Request $request)
    {
        Log::info($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
         //   'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5',
        ]);
        $user = User::where([
            'email' => $request->email
        ])->get();
        if (count($user) > 0){
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
        $user = Auth::user();
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
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
    /**
     * Display login page.
     *
     * @OA\Get(
     *     path="/signin",
     *     summary="Display login page",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Login page loaded")
     * )
     */
    public function signin(Request $request)
    {
        return view('login');
    }

    /**
     * Display registration page.
     *
     * @OA\Get(
     *     path="/signup",
     *     summary="Display registration page",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Registration page loaded")
     * )
     */
    public function signup(Request $request)
    {
        return view('register');
    }

    /**
     * Display logout page.
     *
     * @OA\Get(
     *     path="/weblogout",
     *     summary="Display logout page",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Logout page loaded")
     * )
     */
    public function weblogout(Request $request)
    {
        return view('logout');
    }

    /**
     * User login.
     *
     * @OA\Post(
     *     path="/login",
     *     summary="User login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $user = User::where(['email' => $request->email])->first();
        if (empty($user) || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Unauthorized', 'status' => 'error'], 401);
        }

        $token = $user->api_token ?? JWTAuth::attempt($request->only('email', 'password'));

        return response()->json(['status' => 'success', 'user' => Auth::user(), 'token' => $token]);
    }

    /**
     * User registration.
     *
     * @OA\Post(
     *     path="/register",
     *     summary="User registration",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John"),
     *             @OA\Property(property="surname", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User registered successfully"),
     *     @OA\Response(response=400, description="User already exists")
     * )
     */
    public function register(Request $request)
    {
        Log::info($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:5',
        ]);
        if (User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'Error', 'status' => 'error', 'user' => null]);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Profile::create([
            'surname' => $request->surname,
            'user_id' => $user->id,
            'name' => $request->name,
        ]);

        $token = JWTAuth::attempt($request->only('email', 'password'));

        return response()->json(['message' => 'User registered successfully', 'status' => 'success', 'user' => $user, 'token' => $token]);
    }

    /**
     * User logout.
     *
     * @OA\Post(
     *     path="/logout",
     *     summary="User logout",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Successfully logged out")
     * )
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out', 'status' => 'success']);
    }

    /**
     * Refresh JWT token.
     *
     * @OA\Post(
     *     path="/refresh",
     *     summary="Refresh JWT token",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Token refreshed")
     * )
     */
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

    /**
     * Get user data.
     *
     * @OA\Get(
     *     path="/getData",
     *     summary="Get all users",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Users retrieved successfully")
     * )
     */
    public function getData()
    {
        $users = User::all();
        return response()->json(['users' => $users, 'status' => 'success']);
    }
}

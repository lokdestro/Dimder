<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('AUTH-TOKEN');
        Log::info($token);
        Log::info($request);
        if (empty($token) || !$this->isValidToken($token)) {
            return response()->json(['message' => 'Unauthorized23', 'status' => 'error'], 401);
        }
        return $next($request);
    }

    private function isValidToken(string $token): bool
    {
        $user = User::where('api_token', $token)->first();
        Log::info($token);
        Log::info($user);
        if ($user) {
            Auth::login($user);
            return true;
        }
        Log::info("false");
        return false;
    }
}

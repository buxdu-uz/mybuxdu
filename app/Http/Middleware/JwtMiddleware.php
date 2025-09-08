<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        try {
            // Django SIMPLE_JWT_SECRET_KEY ni ishlatish kerak
            $secret = env('JWT_SECRET');

            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            $user = User::updateOrCreate([
                'user_type' => $decoded->user_type,
                'user_id' => $decoded->user_id,
                'hemis_id' => $decoded->hemis_id,
                'hemis_id_number' => $decoded->hemis_id_number,
            ],[]);

            session()->put('user', $user);

            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 401);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Users\Resources\UserLoginResource;
use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $token = $request->bearerToken();
        try {
            // Django SIMPLE_JWT_SECRET_KEY ni ishlatish kerak
            $secret = env('JWT_SECRET');
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            return $this->successResponse('', $decoded);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}

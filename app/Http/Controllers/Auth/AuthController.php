<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Users\Resources\UserLoginResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse($token, new UserLoginResource($user));
        }

        return $this->errorResponse('Login yoki parol xato!');
    }
}

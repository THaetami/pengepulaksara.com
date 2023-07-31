<?php

namespace App\Http\Controllers;

use App\Helpers\JsonResponseHelper;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return JsonResponseHelper::respondFail("email atau password salah", 401);
        }

        return response()->json([
            'status' => 'success',
            'token' => [
                'accessToken' => $token,
            ]
        ], 201)->cookie('token', $token, 60, null, null, false, true);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function check()
    {
        return response()->json(['valid' => true]);
    }
}

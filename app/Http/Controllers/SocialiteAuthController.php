<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SocialiteAuthController extends Controller
{
    public function redirect($provider)
    {
        return response()->json([
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function callbackGithub($provider)
    {
        try {
            $github_user = Socialite::driver($provider)->stateless()->user();

            $user = User::where('google_id', $github_user->id)->first();

            if (!$user) {
                $randomPassword = Str::random(8, 'alnum');
                $user = User::firstOrCreate(
                    ['google_id' => $github_user->id],
                    [
                        'name' => $github_user->nickname,
                        'email' => $github_user->email,
                        'username' => $github_user->nickname,
                        'password' => Hash::make($randomPassword)
                    ]
                );
            }

            $token = Auth::login($user);

            return response()->json([
                'status' => 'success',
                'token' => [
                    'accessToken' => $token,
                ]
            ], 201)->cookie('token', $token, 60, null, null, false, true);

        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengotentikasi.'], 500);
        }
    }

}

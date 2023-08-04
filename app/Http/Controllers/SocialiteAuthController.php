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

    public function callbackGithub($provider = 'google')
    {
        try {
            $social_user = Socialite::driver($provider)->stateless()->user();

            $id = ($provider === 'github') ? 'git-' . $social_user->id : 'gog' .$social_user->getId();
            $name = ($provider === 'github') ? $social_user->nickname : $social_user->getName();
            $email = ($provider === 'github') ? $social_user->email : $social_user->getEmail();
            $username = ($provider === 'github') ? $social_user->nickname: $this->generateUsername($email);

            $cek_username = User::where('username', $username)->first();
            $new_username = ($cek_username) ? $username . Str::random(7, 'alnum') : $username;

            $user = User::where('social_id', $id)
                        ->orWhere('email', $email)
                        ->first();

            if (!$user) {
                $randomPassword = Str::random(8, 'alnum');
                $user = User::firstOrCreate(
                    ['social_id' => $id],
                    [
                        'name' => $name,
                        'email' => $email,
                        'username' => $new_username,
                        'password' => Hash::make($randomPassword),
                    ]
                );
            }

            $token = Auth::login($user);

            return response()->json([
                'status' => 'success',
                'token' => [
                    'accessToken' => $token,
                ],
            ], 201)->cookie('token', $token, 60, null, null, false, true);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Gagal mengotentikasi.'], 500);
        }
    }

    private function generateUsername($email)
    {
        $username = substr($email, 0, strpos($email, '@'));
        return str_replace('.', '_', $username);
    }

}

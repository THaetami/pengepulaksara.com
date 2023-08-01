<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['redirect']]);
    // }

    public function redirect()
    {
        return Socialite::driver('github')->stateless()->redirect();
    }

    public function callbackGoogle(Request $request)
    {
        try {
            $google_user = Socialite::driver('github')->stateless()->user();
            dd($google_user);

            // $user = User::firstOrCreate(
            //     ['google_id' => $google_user->getId()],
            //     [
            //         'name' => $google_user->getName(),
            //         'email' => $google_user->getEmail(),
            //         'username' => $this->generateUsername($google_user->getEmail()),
            //     ]
            // );
            // dd($user);

            // $token = Auth::login($user);

            // return response()->json([
            //     'status' => 'success',
            //     'token' => [
            //         'accessToken' => $token,
            //     ]
            // ], 201)->cookie('token', $token, 60, null, null, false, true);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => 'Failed to authenticate.'], 500);
        }
    }

    private function generateUsername($email)
    {
        $username = substr($email, 0, strpos($email, '@'));
        return str_replace('.', '_', $username);
    }
}

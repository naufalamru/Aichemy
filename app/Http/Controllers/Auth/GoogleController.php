<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            // TANPA stateless
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $googleUser->getName(),
                    'email'    => $googleUser->getEmail(),
                    'username' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(24)),
                ]);
            }

            Auth::login($user);

            return redirect()->route('home');

        } catch (\Throwable $e) {
            dd("Google Login Error: " . $e->getMessage());
        }
    }
}

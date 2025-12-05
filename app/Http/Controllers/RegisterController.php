<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        // Data yang sudah tervalidasi otomatis
        $data = $request->validated();

        // Simpan user baru
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),

        ]);

        // Login otomatis
        Auth::login($user);

        return redirect()->route('/login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
{
    $login = $request->login;

    // Tentukan apakah login pakai email atau username
    $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $credentials = [
        $field => $login,
        'password' => $request->password,
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Cek apakah ada intended destination dari query parameter atau POST
        $intended = $request->query('intended') ?: $request->input('intended');
        if ($intended === 'chatbot') {
            return redirect()->route('chatbot');
        } elseif ($intended === 'tanya-ai') {
            return redirect()->route('tanya-ai');
        }

        return redirect()->route('home');
    }

    return back()->withErrors([
        'login' => 'Email/username atau password salah.',
    ])->onlyInput('login');
}


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

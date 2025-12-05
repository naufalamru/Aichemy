<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\querysainsController;
use App\Http\Controllers\ChatController;

// ============================================
// PUBLIC ROUTES (bisa diakses siapa saja)
// ============================================
Route::get('/', [HomeController::class, 'indexPublic'])->name('index');

// ============================================
// GUEST ROUTES (hanya bisa diakses kalau belum login)
// ============================================
Route::middleware('guest')->group(function () {
    // Register
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.action');

    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.action');

    // Google OAuth
    Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

// ============================================
// PROTECTED ROUTES (harus login dulu)
// ============================================
Route::middleware('auth')->group(function () {
    // Home/Dashboard (setelah login)
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home/chat-ai', [ChatController::class, 'chat'])->name('chat');



Route::get('/querysains', function () {
    return view('querysains');
});

Route::post('/querysains/ask', [querysainsController::class, 'ask']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

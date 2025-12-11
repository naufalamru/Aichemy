<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\querysainsController;
use App\Http\Controllers\ChatController;
use Laravel\Socialite\Facades\Socialite;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [HomeController::class, 'indexPublic'])->name('index');

/* GOOGLE OAUTH */

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');


// ============================================
// GUEST ROUTES
// ============================================
Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.action');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.action');

});

// ============================================
// PROTECTED ROUTES (harus login)
// ============================================
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // PAGE CHAT AI
    Route::get('/chatbot', function () {
        return view('home');
    })->name('chatbot');

     // Chat Features
    Route::post('/chat/send', [ChatController::class, 'send']);
    Route::get('/chat/histories', [ChatController::class, 'histories']);
    Route::get('/chat/messages/{id}', [ChatController::class, 'messages']);

    // ENDPOINT CHATBOT (dipanggil frontend)
    Route::post('/chatbot/ask', [ChatController::class, 'ask'])->name('chat.ask');

    // Query Sains
    Route::get('/tanya-ai', [querysainsController::class, 'query'])->name('tanya-ai');
    Route::post('/querysains/ask', [querysainsController::class, 'ask'])->name('querysains.ask');
    Route::get('/querysains/histories', [querysainsController::class, 'histories'])->name('querysains.histories');
    Route::get('/querysains/messages/{id}', [querysainsController::class, 'messages'])->name('querysains.messages');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alchemy - Login</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-login.css') }}">
</head>
<body>
    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <div class="toast-icon"></div>
        <div class="toast-content">
            <div class="toast-title"></div>
            <div class="toast-message"></div>
        </div>
        <button class="toast-close">&times;</button>
    </div>

    <a href="{{ route('index') }}" class="logo">
        <img src="{{ asset('images/logo2.png') }}" alt="Alchemy logo" class="logo-img">
    </a>


    <div class="login-container">
        <div class="left-section">
            <div class="welcome-text">
                <h1>Welcome Back<br>to <span class="alchemy-text">AIchemy!</span></h1>
            </div>
            @php
                $preferred = public_path('images/login.png');
                $fallback = asset('images/lab-img.png');
                $imgSrc = file_exists($preferred) ? asset('images/login.png') : $fallback;
            @endphp
            <img src="{{ $imgSrc }}" alt="Lab illustration" class="illustration img-asset">
        </div>

        <div class="right-section">
            <div class="login-header">
                <h2>Login Here</h2>
            </div>

            <!-- Alert Messages -->
            @if (session('status'))
                <div class="session-alert">
                    <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 16v-4M12 8h.01"/>
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if (session('success'))
                <div class="session-alert">
                    <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="session-alert">
                    <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('login.action') }}" method="POST" id="loginForm" novalidate>
                @csrf
                @if(request()->has('intended'))
                    <input type="hidden" name="intended" value="{{ request('intended') }}">
                @endif
                <div class="form-group">
                    <div class="form-group">
                        <label for="login">Email atau Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c1.1-1.1 2-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <input type="text"
                                name="login"
                                placeholder="Email atau Username"
                                value="{{ old('login') }}"
                                required autofocus>
                        </div>

                        @error('login')
                            <div class="error-message">
                                <svg class="error-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password" name="password"
                               placeholder="Enter your password" required>
                        <button type="button" class="toggle-password" id="togglePassword"
                                title="Toggle password visibility" aria-label="Toggle password visibility">
                            <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="display:none;">
                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.67 21.67 0 0 1 5.06-6.28"/>
                                <path d="M1 1l22 22"/>
                                <path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <svg class="error-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="login-btn" id="loginBtn">
                    <span class="btn-text">Login</span>
                    <span class="btn-loader" style="display:none;">
                        <svg class="spinner" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="3"/>
                        </svg>
                    </span>
                </button>
            </form>

            <div class="divider">
                <span>atau</span>
            </div>

            <div class="google-login">
                <a href="{{ route('google') }}" class="google-btn">
                    <svg class="google-icon" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span>Login with Google</span>
                </a>
            </div>

            <div class="register-link">
                Not registered yet? <a href="{{ route('register') }}">Create an account</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth-login.js') }}"></script>
</body>
</html>

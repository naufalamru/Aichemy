<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — Alchemy</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
    <link rel="stylesheet" href="{{ asset('css/auth-signup.css') }}">
</head>
<body>

    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <svg class="toast-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 6L9 17l-5-5"/>
        </svg>
        <span id="toast-message"></span>
    </div>

    <a href="{{ route('index') }}" class="logo">
        <img src="{{ asset('images/logo2.png') }}" alt="Alchemy logo" class="logo-img">
    </a>

    <!-- Animated Background -->
    <div class="background-animation">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="pattern-overlay"></div>
            <div class="left-content">
                <div class="logo-animated">
                    <svg class="sparkle-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2v20M2 12h20M6 6l12 12M18 6L6 18"/>
                    </svg>
                </div>
                <h1 class="brand-title">AIchemy</h1>
                <p class="brand-subtitle">Get personalized skincare advice instantly</p>

                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Ask anything about skincare</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Discover routines that work for you</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Expert insights in seconds</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="form-container">
                <div class="form-header">
                    <h2>Create Your Account</h2>
                    <p>Ask, learn, and improve your skin in minutes</p>
                </div>

                <form id="signupForm" method="POST" action="{{ route('register.action') }}" novalidate>
                    @csrf

                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                            <div class="input-border"></div>
                        </div>
                        <div class="error-message" id="name-error"></div>
                        @error('name') <div class="error-message show">{{ $message }}</div> @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <input type="email" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                            <div class="input-border"></div>
                        </div>
                        <div class="error-message" id="email-error"></div>
                        @error('email') <div class="error-message show">{{ $message }}</div> @enderror
                    </div>

                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <input type="text" id="username" name="username" placeholder="Pilih username" value="{{ old('username') }}" required>
                            <div class="input-border"></div>
                        </div>
                        <div class="error-message" id="username-error"></div>
                        @error('username') <div class="error-message show">{{ $message }}</div> @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password" name="password" placeholder="Buat password" required>
                            <button type="button" class="toggle-password" data-target="password">
                                <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <div class="input-border"></div>
                        </div>
                        <!-- Password Strength Meter -->
                        <div class="password-strength" id="password-strength" style="display: none;">
                            <div class="strength-info">
                                <span class="strength-label">Kekuatan Password:</span>
                                <span class="strength-text" id="strength-text">Lemah</span>
                            </div>
                            <div class="strength-bar">
                                <div class="strength-fill" id="strength-fill"></div>
                            </div>
                        </div>
                        <div class="error-message" id="password-error"></div>
                        @error('password') <div class="error-message show">{{ $message }}</div> @enderror
                    </div>

                    <!-- Password Confirmation Field -->
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <div class="input-wrapper">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
                            <button type="button" class="toggle-password" data-target="password_confirmation">
                                <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <div class="input-border"></div>
                        </div>
                        <div class="error-message" id="password_confirmation-error"></div>
                        @error('password_confirmation') <div class="error-message show">{{ $message }}</div> @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <span class="btn-text">Sign Up</span>
                        <span class="btn-loader" style="display: none;">
                            <svg class="spinner" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.25"/>
                                <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" opacity="0.75"/>
                            </svg>
                            Membuat Akun...
                        </span>
                    </button>

                    <!-- Google Sign Up -->
                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <a href="{{ route('google.redirect') }}" class="google-btn">
                        <svg class="google-icon" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#3cb4a1" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#22fb05ff" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span>Sign Up with Google</span>
                    </a>
                </form>

                <!-- Login Link -->
                <div class="footer-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth-signup.js') }}"></script>
</body>
</html>

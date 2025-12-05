<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alchemy - Where AI Meets Chemistry</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <!-- Particles Background -->
    <div class="particles-bg" id="particles"></div>

    <!-- NAVBAR -->
    <header class="navbar" id="navbar">
        <div class="nav-inner container">
            <div class="brand">
                <a href="/" class="logo">✨ Alchemy</a>
            </div>

            <nav class="nav-links" id="navLinks">
                <a href="#home" class="nav-link">Home</a>
                <a href="#how" class="nav-link">How it Works</a>
                <a href="#about" class="nav-link">Tentang Kami</a>
                <a href="#team" class="nav-link">Team</a>
            </nav>

            <div class="auth">
                <a href="{{ route('login') }}" class="btn-login">LOGIN</a>
                <a href="{{ route('register') }}" class="btn-signup">Sign Up →</a>
            </div>

            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero" id="home">
        <div class="hero-inner container">
            <div class="hero-left">
                <div class="hero-badge">🧬 AI-Powered Skincare</div>
                <h1 class="hero-title">
                    Where AI Meets Chemistry
                    <span class="gradient-text">to Empower Your Skin</span>
                </h1>
                <p class="hero-desc">
                    Melalui teknologi Agentic AI, Alchemy menganalisis kebutuhan kulitmu dan merekomendasikan produk yang paling cocok untukmu.
                </p>
                <div class="hero-buttons">
                    <a href="/login" class="cta cta-primary">
                        <span>🧠 Coba Sekarang!</span>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <a href="#how" class="cta cta-secondary">
                        <span>Pelajari Lebih Lanjut</span>
                    </a>
                </div>

                <!-- Stats Mini -->
                <div class="hero-stats">
                    <div class="stat-mini">
                        <div class="stat-number">3000+</div>
                        <div class="stat-label">Pengguna</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Bahan Aktif</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Akurasi</div>
                    </div>
                </div>
            </div>

            <div class="hero-right">
                <div class="hero-image-wrapper">
                    <div class="floating-card card-1">
                        <span class="card-icon">🧪</span>
                        <span class="card-text">AI Analysis</span>
                    </div>
                    <div class="floating-card card-2">
                        <span class="card-icon">✨</span>
                        <span class="card-text">Smart Match</span>
                    </div>
                    <div class="floating-card card-3">
                        <span class="card-icon">💎</span>
                        <span class="card-text">Perfect Skin</span>
                    </div>
                    <img src="{{ asset('images/heri_img.png') }}" alt="Alchemy Hero" class="hero-img">
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="scroll-indicator">
            <div class="mouse">
                <div class="wheel"></div>
            </div>
            <p>Scroll Down</p>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how container" id="how">
        <div class="section-header">
            <span class="section-badge">💡 Our Process</span>
            <h2 class="section-title">How it Works?</h2>
            <p class="section-subtitle">Tiga langkah sederhana menuju kulit impianmu</p>
        </div>

        <div class="how-grid">
            <div class="how-illustration">
                <img src="{{ asset('images/lab-img.png') }}" alt="Lab Illustration">
                <div class="glow-effect"></div>
            </div>

            <div class="how-steps">
                <div class="step" data-step="1">
                    <div class="step-header">
                        <div class="step-number">1</div>
                        <h3 class="step-title">Input Data Kulit</h3>
                    </div>
                    <p class="step-content">Masukkan kebutuhan dan kondisi kulitmu secara detail</p>
                    <div class="step-progress"></div>
                </div>

                <div class="step" data-step="2">
                    <div class="step-header">
                        <div class="step-number">2</div>
                        <h3 class="step-title">AI Analysis</h3>
                    </div>
                    <p class="step-content">Agentic AI menganalisis profil kulit & data kimia produk secara mendalam</p>
                    <div class="step-progress"></div>
                </div>

                <div class="step" data-step="3">
                    <div class="step-header">
                        <div class="step-number">3</div>
                        <h3 class="step-title">Rekomendasi Personal</h3>
                    </div>
                    <p class="step-content">Dapatkan rekomendasi skincare berbasis sains yang cocok untukmu</p>
                    <div class="step-progress"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- NUMBERS / STATS -->
    <section class="numbers">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">📊 Our Impact</span>
                <h2 class="section-title">Alchemy in Numbers</h2>
            </div>

            <div class="numbers-grid">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value" data-count="3000">0</div>
                    <div class="stat-desc">Pengguna Dianalisis</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🧪</div>
                    <div class="stat-value" data-count="500">0</div>
                    <div class="stat-desc">Data Bahan Aktif</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-value" data-count="98">0</div>
                    <div class="stat-desc">Akurasi Rekomendasi</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TENTANG KAMI -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">🔬 About Us</span>
                <h2 class="section-title">Tentang Kami</h2>
            </div>

            <div class="about-content">
                <div class="about-box">
                    <p>
                        Alchemy adalah platform rekomendasi skincare berbasis Agentic AI
                        yang dirancang untuk menghubungkan ilmu kimia, dermatologi, dan
                        teknologi kecerdasan buatan. Kami menganalisis profil kulit,
                        kebutuhan pengguna, serta ribuan data bahan aktif untuk menghasilkan
                        rekomendasi yang presisi dan berbasis sains.
                    </p>
                    <p>
                        Dengan Alchemy, setiap pengguna dapat memperoleh rekomendasi produk
                        yang relevan, logis, dan dapat dipertanggungjawabkan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY ALCHEMY -->
    <section class="why-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">⭐ Our Advantages</span>
                <h2 class="section-title">Why Alchemy?</h2>
            </div>

            <div class="why-cards">
                <div class="why-card">
                    <div class="why-icon">📊</div>
                    <h3>Rekomendasi Berbasis Data</h3>
                    <p>Analisis mendalam dari ribuan data produk dan bahan aktif</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">🤖</div>
                    <h3>Agentic AI yang Lebih Pintar</h3>
                    <p>Teknologi AI terkini untuk hasil yang lebih akurat</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">🎨</div>
                    <h3>Personalisasi Maksimal</h3>
                    <p>Rekomendasi yang disesuaikan dengan kebutuhan unikmu</p>
                </div>

                <div class="why-card">
                    <div class="why-icon">💰</div>
                    <h3>Hemat Biaya & Waktu</h3>
                    <p>Tidak perlu trial error, langsung dapat produk yang tepat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- OUR TEAM -->
    <section class="team-section" id="team">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">👨‍💻 Meet The Team</span>
                <h2 class="section-title">Our Team</h2>
                <p class="section-subtitle">Tim passionate di balik Alchemy</p>
            </div>
        </div>

        <div class="team-slider">
            <div class="team-wrapper" id="teamWrapper">
                <div class="team-card">
                    <div class="team-photo">
                        <div class="team-overlay">
                            <span>🔬</span>
                        </div>
                    </div>
                    <h4>Rudy Peter Chandra</h4>
                    <p>Machine Learning</p>
                </div>

                <div class="team-card">
                    <div class="team-photo">
                        <div class="team-overlay">
                            <span>🤖</span>
                        </div>
                    </div>
                    <h4>M. Mirza Ralfie</h4>
                    <p>Machine Learning</p>
                </div>

                <div class="team-card">
                    <div class="team-photo">
                        <div class="team-overlay">
                            <span>🧠</span>
                        </div>
                    </div>
                    <h4>Huwaida Adilya Putri</h4>
                    <p>Machine Learning</p>
                </div>

                <div class="team-card">
                    <div class="team-photo">
                        <div class="team-overlay">
                            <span>💻</span>
                        </div>
                    </div>
                    <h4>Aqilla Baidhar Putra</h4>
                    <p>Front End & Back End</p>
                </div>

                <div class="team-card">
                    <div class="team-photo">
                        <img src="{{ asset('images/nopal.jpg') }}" alt="Naufal Amru">
                        <div class="team-overlay">
                            <span>⚡</span>
                        </div>
                    </div>
                    <h4>Naufal Amru</h4>
                    <p>Front End & Back End</p>
                </div>

                <div class="team-card">
                    <div class="team-photo">
                        <div class="team-overlay">
                            <span>🎨</span>
                        </div>
                    </div>
                    <h4>Rosa Linda Salsabila</h4>
                    <p>Front End & Back End</p>
                </div>
            </div>

            <!-- Slider Controls -->
            <button class="slider-btn prev" id="prevBtn">❮</button>
            <button class="slider-btn next" id="nextBtn">❯</button>
        </div>
    </section>

    <!-- CTA BOTTOM -->
    <section class="cta-block">
        <div class="container">
            <div class="cta-inner">
                <div class="cta-content">
                    <h3>✨ Ready to Discover Your Perfect Skincare Formula?</h3>
                    <p>Biarkan Agentic AI kami menganalisis kulitmu dan memberi rekomendasi terbaik.</p>
                </div>
                <div class="cta-action">
                    <a href="#" class="cta cta-large">
                        <span>🧠 Coba Sekarang!</span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="container footer-inner">
            <div class="footer-left">
                <h3 class="logo">✨ Alchemy</h3>
                <p>Platform skincare berbasis Agentic AI yang menganalisis kebutuhan kulit dan data bahan aktif untuk memberikan rekomendasi produk yang akurat dan berbasis sains.</p>
                <div class="social-links">
                    <a href="#" class="social-link">📧</a>
                    <a href="#" class="social-link">🐦</a>
                    <a href="#" class="social-link">📷</a>
                </div>
            </div>

            <div class="footer-menu">
                <h4>Menu</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#how">How it Works</a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>

            <div class="footer-contact">
                <h4>Contact</h4>
                <p>📧 aichemy@gmail.com</p>
                <p>📍 Jakarta, Indonesia</p>
            </div>
        </div>

        <div class="copyright">
            <div class="container">
                <p>© 2025 Alchemy. All rights reserved. Made with ❤️ by Alchemy Team</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">↑</button>

    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>

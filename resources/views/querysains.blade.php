<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanya AI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/query.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>

    <style>
        /* User dropdown + caret (button appearance uses .btn-signup from style.css) */
        .user-menu{position:relative;display:inline-block}
        .user-btn{display:inline-flex;align-items:center;gap:10px;border-radius:28px;padding:10px 22px;font-weight:700;cursor:pointer;border:0;color:#fff;box-shadow:0 6px 18px rgba(0,0,0,0.06);transition:transform .12s ease,box-shadow .12s ease}
        .user-btn:active{transform:translateY(1px)}
        .user-btn .dropdown-icon{opacity:.9;width:18px;height:18px}

        .user-dropdown{position:absolute;right:0;top:calc(100% + 10px);background:#ffffff;border-radius:12px;box-shadow:0 10px 30px rgba(13,38,62,0.12);min-width:180px;opacity:0;transform:translateY(-6px) scale(.98);transition:opacity .18s ease,transform .18s ease;z-index:60;padding:8px}
        .user-dropdown.show{opacity:1;transform:translateY(0) scale(1)}
        .user-dropdown form{margin:0}
        .user-dropdown button{background:transparent;border:none;color:#153;cursor:pointer;padding:10px 12px;width:100%;text-align:left;border-radius:8px;font-weight:600}

        .user-dropdown::before{content:"";position:absolute;top:-7px;right:22px;width:12px;height:12px;background:#fff;transform:rotate(45deg);box-shadow:-2px -2px 6px rgba(13,38,62,0.04);border-radius:2px}

        /* basic container style fallback removed to allow external CSS to control layout */
    </style>
</head>
<body>

    <!-- Navigation -->
    <header class="navbar" id="navbar">
        <div class="nav-inner container">
            <div class="brand">
                <a href="{{ route('index') }}" class="logo">✨ Alchemy</a>
            </div>

            <nav class="nav-links" id="navLinks">
                <a href="{{ route('index') }}" class="nav-link">Home</a>
                <a href="{{ route('index') }}" class="nav-link">Tentang Kami</a>
                @auth
                    <a href="{{ route('chatbot') }}" class="nav-link">Chatbot</a>
                    <a href="{{ route('tanya-ai') }}" class="nav-link">Tanya AI</a>
                @else
                    <a href="{{ route('login') }}?intended=chatbot" class="nav-link">Chatbot</a>
                    <a href="{{ route('login') }}?intended=tanya-ai" class="nav-link">Tanya AI</a>
                @endauth
            </nav>

            <div class="auth">
                @auth
                    <div class="user-menu">
                        <button class="user-btn btn-signup" type="button" aria-expanded="false">
                            <i data-lucide="user" class="btn-icon"></i>
                            <span class="user-name">Hi, {{ Auth::user()->name }}</span>
                            <i data-lucide="chevron-down" class="dropdown-icon"></i>
                        </button>
                        <div class="user-dropdown" role="menu">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-logout">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-login">LOGIN</a>
                    <a href="{{ route('register') }}" class="btn-signup">Sign Up →</a>
                @endauth
            </div>

            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div class="mobile-menu" id="mobileMenu">
            <a href="#home" class="mobile-nav-link">Home</a>
            <a href="#about" class="mobile-nav-link">Tentang Kami</a>
            @auth
                <a href="{{ route('chatbot') }}" class="mobile-nav-link">Chatbot</a>
                <a href="{{ route('tanya-ai') }}" class="mobile-nav-link">Tanya AI</a>
                <div class="mobile-user-wrap">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-logout mobile-btn">Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-login mobile-btn">Login</a>
                <a href="{{ route('register') }}" class="btn btn-signup mobile-btn">Sign Up →</a>
            @endauth
        </div>
    </header>

    <!-- Main content: the AI question form -->
    <main style="padding:100px 12px;">
        <div class="chat-header">
            <h1>👩‍🔬 Tanya AI — Alchemy Assistant</h1>
            <p>Tanyakan apapun tentang skincare dan bahan aktif kepada AI kami</p>
        </div>
        <div class="ai-container">

            <form id="aiForm">
                <label>Tulis Pertanyaan Kamu:</label>
                <textarea id="question" placeholder="Contoh: Jelaskan apa itu robotika cerdas..."></textarea>
                <button type="submit" class="ai-submit">Kirim ke AI</button>
            </form>

            <div id="response-area"></div>
        </div>
    </main>

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

    <script>
        // mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });
            document.addEventListener('click', (e) => {
                if (!mobileToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                }
            });
        }

        // user dropdown toggle
        document.addEventListener('click', function (e) {
            const btn = document.querySelector('.user-btn');
            const dd = document.querySelector('.user-dropdown');
            if (!btn || !dd) return;
            if (btn.contains(e.target)) {
                dd.classList.toggle('show');
                btn.setAttribute('aria-expanded', dd.classList.contains('show'));
            } else if (!dd.contains(e.target)) {
                dd.classList.remove('show');
                btn.setAttribute('aria-expanded', 'false');
            }
        });

        async function queryToFlowise(question) {
            const response = await fetch("/querysains/ask", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ""
                },
                body: JSON.stringify({ question })
            });

            const contentType = response.headers.get('content-type') || '';
            if (contentType.includes('application/json')) {
                return await response.json();
            } else {
                const text = await response.text();
                return { error: `Server returned non-JSON response (status ${response.status})`, status: response.status, body: text };
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("aiForm");
            const textarea = document.getElementById("question");
            const responseArea = document.getElementById("response-area");

            form.addEventListener("submit", async function (e) {
                e.preventDefault();
                const prompt = textarea.value.trim();
                if (prompt === "") {
                    responseArea.innerHTML = `<div class="error-box"><strong>Error:</strong> Pertanyaan tidak boleh kosong.</div>`;
                    return;
                }
                responseArea.innerHTML = `<div class="result-box"><strong>Sedang memproses...</strong></div>`;
                try {
                    const data = await queryToFlowise(prompt);
                    responseArea.innerHTML = `<div class="result-box"><strong>Jawaban:</strong><br><br>${data.text || data.answer || JSON.stringify(data)}</div>`;
                } catch (err) {
                    responseArea.innerHTML = `<div class="error-box"><strong>Error:</strong> Gagal memproses AI.</div>`;
                    console.error(err);
                }
            });
        });
    </script>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanya AI</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">

    <link rel="stylesheet" href="{{ asset('css/query.css') }}">

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
                <a href="{{ route('index') }}" class="logo">
                    <img src="{{ asset('images/logo1.png') }}" alt="Alchemy logo" class="logo-img">
                    <span class="logo-text">Alchemy</span>
                </a>
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
                            <span class="user-name">👤 Hi, {{ Auth::user()->name }}</span>
                            <span class="arrow">▼</span>
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

    <!-- Main Content -->
    <div class="page-wrapper">
        <div class="container-main">
            <!-- Hero Section -->
            <section class="hero-compact">
                <div class="hero-content-center">
                    <h1 class="hero-title-main">
                        <img src="{{ asset('images/logo2.png') }}" alt="Alchemy" class="hero-logo-img">
                    </h1>
                    <p class="hero-subtitle">Platform skincare berbasis <span class="text-highlight">Agentic AI</span> yang menganalisis kebutuhan kulit dan data bahan aktif untuk memberikan rekomendasi produk yang akurat dan berbasis sains.</p>
                </div>
            </section>

            <!-- Chat Layout -->
            <div class="chat-layout-main">
                <!-- Sidebar History -->
                <aside class="history-sidebar">
                    <div class="sidebar-header">
                        <button class="new-chat-btn" onclick="startNewQuery()">
                            <span>➕</span>
                            <span>Pertanyaan Baru</span>
                        </button>
                    </div>
                    <div class="history-title">History</div>
                    <div class="history-list" id="history-list">
                        <!-- History items will be populated here -->
                        <div class="history-empty">Belum ada riwayat pertanyaan</div>
                    </div>
                </aside>

                <!-- Main Content Area -->
                <main class="query-main-area">
                    <div class="chat-header-box">
                        <div class="chat-icon-title">
                            <span class="icon-robot">👩‍🔬</span>
                            <div class="chat-title">
                                <h2 class="chat-title-main">Tanya AI — Alchemy Assistant</h2>
                                <p class="chat-subtitle">Tanyakan apapun tentang skincare dan bahan aktif kepada AI kami</p>
                            </div>
                        </div>
                    </div>

                    <div class="query-content-container">
                        <div class="ai-container">
                            <form id="aiForm">
                                <label>Tulis Pertanyaan Kamu:</label>
                                <textarea id="question" placeholder="Contoh: Kandungan yang cocok untuk kulit kering..."></textarea>
                                <button type="submit" class="ai-submit">
                                    <span>Kirim</span>
                                <span>➤</span>
                                </button>
                            </form>

                            <div id="response-area"></div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


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
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="{{ route('chatbot') }}">Chatbot</a></li>
                    <li><a href="{{ route('tanya-ai') }}">Tanya AI</a></li>
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
                <p>© 2025 Alchemy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // ================== UI INTERACTIONS ==================
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

        // ================== HISTORY STATE ==================
        let currentHistoryId = null;
        let isSending = false;

        // Utility: get CSRF token
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }

        // ================== SEND QUERY (via backend) ==================
        async function sendQuery() {
            const textarea = document.getElementById("question");
            const responseArea = document.getElementById("response-area");
            const form = document.getElementById("aiForm");
            const prompt = textarea.value.trim();

            if (!prompt || isSending) return;

            // Tampilkan loading state
            isSending = true;
            responseArea.innerHTML = `<div class="result-box"><strong>Sedang memproses...</strong></div>`;

            try {
                const res = await fetch("/querysains/ask", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getCsrfToken()
                    },
                    body: JSON.stringify({
                        question: prompt,
                        history_id: currentHistoryId
                    })
                });

                if (!res.ok) {
                    let errText = `Server returned ${res.status}`;
                    try {
                        const errJson = await res.json();
                        errText = errJson.message || errJson.error || JSON.stringify(errJson);
                    } catch (e) {
                        errText = await res.text();
                    }
                    responseArea.innerHTML = `<div class="error-box"><strong>Error:</strong> ${errText}</div>`;
                    return;
                }

                const data = await res.json();

                // Handle response structure
                const newHistoryId = data.history_id || data.historyId || null;
                const answer = data.answer || data.text || data.reply || JSON.stringify(data);

                if (newHistoryId) {
                    currentHistoryId = newHistoryId;
                    localStorage.setItem('lastQueryHistoryId', newHistoryId);
                }

                // Tampilkan jawaban dengan markdown rendering
                const parsedAnswer = typeof marked !== 'undefined' ? marked.parse(answer) : answer;
                responseArea.innerHTML = `<div class="result-box"><strong>Jawaban:</strong><br><br>${parsedAnswer}</div>`;

                // Update daftar history di sidebar
                await loadHistories();

                // Setelah histories di-update, highlight history yang sedang aktif
                if (currentHistoryId) {
                    const activeBtn = document.querySelector(`[data-history-id="${currentHistoryId}"]`);
                    if (activeBtn) {
                        const prev = document.querySelector('.history-item.active');
                        if (prev) prev.classList.remove('active');
                        activeBtn.classList.add('active');
                    }
                }

                // Kosongkan textarea
                textarea.value = '';

            } catch (err) {
                console.error("Send query error:", err);
                responseArea.innerHTML = `<div class="error-box"><strong>Error:</strong> Terjadi kesalahan saat mengirim pertanyaan. Cek console.</div>`;
            } finally {
                isSending = false;
            }
        }

        // ================== LOAD HISTORIES ==================
        async function loadHistories() {
            const list = document.getElementById("history-list");
            if (!list) {
                console.error("Elemen #history-list tidak ditemukan di DOM");
                return null;
            }
            list.innerHTML = `<div class="history-empty">Memuat riwayat...</div>`;

            try {
                const res = await fetch("/querysains/histories", {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": getCsrfToken(),
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    credentials: 'same-origin'
                });

                if (!res.ok) {
                    const errorText = await res.text();
                    console.error("Error response:", errorText);

                    if (res.status === 401 || res.status === 403) {
                        list.innerHTML = `<div class="history-empty">Silakan login untuk melihat riwayat</div>`;
                    } else {
                        list.innerHTML = `<div class="history-empty">Gagal memuat history (server ${res.status})</div>`;
                    }
                    return null;
                }

                const contentType = res.headers.get("content-type");
                let histories;
                if (contentType && contentType.includes("application/json")) {
                    histories = await res.json();
                } else {
                    const raw = await res.text();
                    try {
                        histories = JSON.parse(raw);
                    } catch (parseErr) {
                        console.error("Parse histories error:", parseErr, raw);
                        list.innerHTML = `<div class="history-empty">Gagal membaca data history (respon bukan JSON)</div>`;
                        return null;
                    }
                }

                if (!histories || histories.length === 0) {
                    list.innerHTML = `<div class="history-empty">Belum ada riwayat pertanyaan. Mulai pertanyaan baru!</div>`;
                    return null;
                }

                list.innerHTML = "";
                histories.forEach(h => {
                    const btn = document.createElement("button");
                    btn.className = "history-item";
                    btn.dataset.historyId = h.id;
                    btn.innerHTML = `
                        <span class="history-icon">💬</span>
                        <span class="history-text">${escapeHtml(h.title || ('Pertanyaan #' + h.id))}</span>
                        <span class="history-meta">${formatTimestamp(h.updated_at || h.created_at)}</span>
                    `;

                    btn.onclick = () => {
                        // highlight selected
                        const prev = document.querySelector('.history-item.active');
                        if (prev) prev.classList.remove('active');
                        btn.classList.add('active');

                        openHistory(h.id);
                    };

                    list.appendChild(btn);
                });

                return histories;

            } catch (err) {
                console.error("Load histories error:", err);
                list.innerHTML = `<div class="history-empty">Terjadi kesalahan saat memuat history: ${err.message}</div>`;
                return null;
            }
        }

        // ================== OPEN HISTORY (load messages) ==================
        async function openHistory(id) {
            currentHistoryId = id;
            localStorage.setItem('lastQueryHistoryId', id);

            const textarea = document.getElementById("question");
            const responseArea = document.getElementById("response-area");
            responseArea.innerHTML = `<div class="result-box"><strong>Memuat percakapan...</strong></div>`;

            try {
                const res = await fetch(`/querysains/messages/${id}`, {
                    headers: {
                        "X-CSRF-TOKEN": getCsrfToken()
                    },
                    credentials: 'same-origin'
                });

                if (!res.ok) {
                    responseArea.innerHTML = `<div class="error-box"><strong>Error:</strong> Gagal memuat pesan (server ${res.status})</div>`;
                    return;
                }

                const messages = await res.json();

                // Clear and render messages
                if (!messages || messages.length === 0) {
                    responseArea.innerHTML = `<div class="result-box">Percakapan kosong.</div>`;
                    textarea.value = "";
                    return;
                }

                // Tampilkan pertanyaan terakhir dan jawaban terakhir
                let lastQuestion = "";
                let lastAnswer = "";

                messages.forEach(m => {
                    const sender = m.sender || m.role || (m.from === 'user' ? 'user' : 'bot');
                    const content = m.content || m.text || m.message || JSON.stringify(m);

                    if (sender === 'user') {
                        lastQuestion = content;
                    } else if (sender === 'bot') {
                        lastAnswer = content;
                    }
                });

                textarea.value = lastQuestion;
                // Render markdown untuk jawaban
                const parsedAnswer = typeof marked !== 'undefined' ? marked.parse(lastAnswer) : lastAnswer;
                responseArea.innerHTML = `<div class="result-box"><strong>Jawaban:</strong><br><br>${parsedAnswer}</div>`;

            } catch (err) {
                console.error("Open history error:", err);
                responseArea.innerHTML = `<div class="error-box"><strong>Error:</strong> Terjadi kesalahan saat memuat pesan.</div>`;
            }
        }

        // ================== HELPERS ==================
        function startNewQuery() {
            currentHistoryId = null;
            localStorage.removeItem('lastQueryHistoryId');

            const textarea = document.getElementById("question");
            const responseArea = document.getElementById("response-area");

            textarea.value = "";
            responseArea.innerHTML = "";

            // remove active highlight in history list
            const prev = document.querySelector('.history-item.active');
            if (prev) prev.classList.remove('active');
        }

        function escapeHtml(unsafe) {
            return String(unsafe)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function formatTimestamp(ts) {
            if (!ts) return '';
            const d = new Date(ts);
            if (isNaN(d)) return '';
            return d.toLocaleString('id-ID', {
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // ================== INITIALIZE APP ==================
        async function initializeApp() {
            // Pastikan lucide sudah dimuat sebelum digunakan
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            } else {
                console.warn('Lucide belum dimuat');
            }

            // Tunggu sebentar untuk memastikan session sudah ready
            await new Promise(resolve => setTimeout(resolve, 100));

            // Load histories saat buka halaman
            const histories = await loadHistories();

            // Setelah histories dimuat, cek apakah ada query terakhir yang harus di-load
            if (histories && histories.length > 0) {
                const lastHistoryId = localStorage.getItem('lastQueryHistoryId');

                if (lastHistoryId) {
                    // Validasi bahwa history ID masih ada di daftar histories
                    const historyExists = histories.some(h => h.id == lastHistoryId);
                    if (historyExists) {
                        // Auto-load query terakhir
                        const historyBtn = document.querySelector(`[data-history-id="${lastHistoryId}"]`);
                        if (historyBtn) {
                            historyBtn.classList.add('active');
                            await openHistory(lastHistoryId);
                        }
                    }
                }
            }

            // Form submit handler
            const form = document.getElementById("aiForm");
            if (form) {
                form.addEventListener("submit", async function (e) {
                    e.preventDefault();
                    await sendQuery();
                });
            }
        }

        // Clear localStorage saat logout
        document.addEventListener('DOMContentLoaded', function() {
            const logoutForms = document.querySelectorAll('form[action*="logout"]');
            logoutForms.forEach(form => {
                if (form) {
                    form.addEventListener('submit', function() {
                        localStorage.removeItem('lastQueryHistoryId');
                    });
                }
            });
        });

        // Panggil initializeApp setelah DOM ready dan script lucide dimuat
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('load', initializeApp);
            });
        } else {
            window.addEventListener('load', initializeApp);
        }
    </script>

    <!-- Load external scripts di akhir untuk memastikan DOM sudah ready -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        // Initialize lucide icons setelah script dimuat
        if (typeof lucide !== 'undefined' && lucide.createIcons) {
            lucide.createIcons();
        } else {
            window.addEventListener('load', function() {
                if (typeof lucide !== 'undefined' && lucide.createIcons) {
                    lucide.createIcons();
                }
            });
        }
    </script>
</body>
</html>

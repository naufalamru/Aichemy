<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alchemy - Skincare AI Platform</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <!-- Navigation -->
    <header class="navbar" id="navbar">
        <div class="nav-inner container">
            <div class="brand">
                <a href="/home" class="logo">
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
                            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
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

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ route('index') }}" class="mobile-nav-link">Home</a>
            <a href="{{ route('index') }}" class="mobile-nav-link">Tentang Kami</a>
            @auth
                <a href="{{ route('chatbot') }}" class="mobile-nav-link">Chatbot</a>
                <a href="{{ route('tanya-ai') }}" class="mobile-nav-link">Tanya AI</a>
                <div class="mobile-user-wrap">
                    <form action="{{ route('logout') }}" method="POST" id="logoutFormMobile">
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
                        <button class="new-chat-btn" onclick="startNewChat()">
                            <span>➕</span>
                            <span>Chat Baru</span>
                        </button>
                    </div>
                    <div class="history-title">History</div>
                    <div class="history-list" id="history-list">
                        <!-- History items will be populated here -->
                        <div class="history-empty">Memuat riwayat...</div>
                    </div>
                </aside>

                <!-- Main Chat Area -->
                <main class="chat-main-area">
                    <div class="chat-header-box">
                        <div class="chat-icon-title">
                            <span class="icon-robot">🤖</span>
                            <div class="chat-title">
                                <h2 class="chat-title-main">Chatbot — Alchemy Skin Advisor</h2>
                                <p class="chat-subtitle">Ngobrol bebas dengan AI untuk tanya apa saja soal skincare</p>
                            </div>
                        </div>
                    </div>

                    <div class="chat-messages-container" id="chatMessages">
                        <!-- Welcome Message -->
                        <div class="message bot">
                            <div class="message-avatar">🤖</div>
                            <div class="message-bubble">
                                <p>Hi! I'm Alchemy, your personal AI skincare assistant. <br> Ada yang bisa aku bantu untuk kulitmu?</p>
                            </div>
                        </div>
                    </div>

                    <div class="chat-input-wrapper">
                        <div class="input-box">
                            <input
                                type="text"
                                class="chat-input-field"
                                id="messageInput"
                                placeholder="Ask Your Question"
                                onkeypress="handleKeyPress(event)"
                                autocomplete="off"
                            >
                            <button class="send-btn" id="sendBtn" onclick="sendMessage()">
                                <span>Kirim</span>
                                <span>➤</span>
                            </button>
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
                <h3 class="logo" style="color: #f2efe9!important;">✨ Alchemy</h3>
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

        // ================== CHAT FUNCTIONS (MAINTAIN EXISTING BEHAVIOR) ==================
        function addMessage(sender, text) {
            const chatMessages = document.getElementById("chatMessages");

            const msg = document.createElement("div");
            msg.className = "message " + sender;

            const bubble = sender === "bot"
                ? marked.parse(text)
                : text;

            msg.innerHTML = `
                <div class="message-avatar">${sender === "bot" ? "🤖" : "👤"}</div>
                <div class="message-bubble">${bubble}</div>
            `;

            chatMessages.appendChild(msg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // ============== HISTORY STATE ==============
        let currentHistoryId = null;
        let isSending = false;
        let loadingMessageElement = null;

        // Utility: get CSRF token
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }

        // ================== LOADING INDICATOR ==================
        function addLoadingMessage() {
            const chatMessages = document.getElementById("chatMessages");

            const loadingMsg = document.createElement("div");
            loadingMsg.className = "message bot loading-message";
            loadingMsg.id = "ai-loading-indicator";

            loadingMsg.innerHTML = `
                <div class="message-avatar">🤖</div>
                <div class="message-bubble loading-bubble">
                    <span class="loading-text">AIchemy is analyzing</span>
                    <span class="typing-dots">
                        <span>.</span>
                        <span>.</span>
                        <span>.</span>
                    </span>
                </div>
            `;

            chatMessages.appendChild(loadingMsg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            loadingMessageElement = loadingMsg;
        }

        function removeLoadingMessage() {
            if (loadingMessageElement) {
                loadingMessageElement.remove();
                loadingMessageElement = null;
            } else {
                // Fallback: cari elemen loading jika tidak ada reference
                const loadingEl = document.getElementById("ai-loading-indicator");
                if (loadingEl) {
                    loadingEl.remove();
                }
            }
        }

        // ================== SEND MESSAGE (via backend) ==================
        async function sendMessage() {
            const inputEl = document.getElementById("messageInput");
            const sendBtn = document.getElementById("sendBtn");
            const text = inputEl.value.trim();
            if (!text || isSending) return;

            // tampilkan pesan user di UI
            addMessage("user", text);
            inputEl.value = "";
            inputEl.focus();

            // disable input & show loading state
            isSending = true;
            sendBtn.disabled = true;
            sendBtn.setAttribute('aria-busy', 'true');

            // Tampilkan loading indicator
            addLoadingMessage();

            // kirim ke backend (harus ada route /chat/send)
            try {
                const res = await fetch("/chat/send", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getCsrfToken()
                    },
                    body: JSON.stringify({
                        message: text,
                        history_id: currentHistoryId
                    })
                });

                if (!res.ok) {
                    // coba baca pesan error dari response
                    let errText = `Server returned ${res.status}`;
                    try {
                        const errJson = await res.json();
                        errText = errJson.message || errJson.error || JSON.stringify(errJson);
                    } catch (e) {
                        // not json
                        errText = await res.text();
                    }
                    // Hapus loading indicator jika ada error
                    removeLoadingMessage();
                    addMessage("bot", `⚠️ Error: ${errText}`);
                    return;
                }

                const data = await res.json();

                // beberapa backend bisa mengembalikan struktur berbeda,
                // handle kemungkinan variasi: { history_id, reply } atau { success, answer } atau { answer }
                const newHistoryId = data.history_id || data.historyId || data.history?.id || null;
                const reply = data.reply || data.answer || data.answerText || (data.raw_response && (data.raw_response.text || data.raw_response.answer)) || null;

                if (newHistoryId) {
                    currentHistoryId = newHistoryId;
                    // Simpan ke localStorage supaya setelah refresh tetap ingat
                    localStorage.setItem('lastHistoryId', newHistoryId);
                }

                // Hapus loading indicator sebelum menampilkan jawaban
                removeLoadingMessage();

                if (reply) {
                    addMessage("bot", reply);
                } else if (data.text) {
                    // fallback ke field text
                    addMessage("bot", data.text);
                } else {
                    addMessage("bot", "⚠️ Bot tidak memberikan jawaban (response tidak terduga).");
                }

                // update daftar history di sidebar
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

            } catch (err) {
                console.error("Send message error:", err);
                // Hapus loading indicator jika ada error
                removeLoadingMessage();
                addMessage("bot", "⚠️ Terjadi kesalahan saat mengirim pesan. Cek console.");
            } finally {
                isSending = false;
                sendBtn.disabled = false;
                sendBtn.removeAttribute('aria-busy');
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
                console.log("Loading histories...");
                const res = await fetch("/chat/histories", {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": getCsrfToken(),
                        "Accept": "application/json",
                        "Content-Type": "application/json"
                    },
                    credentials: 'same-origin'
                });

                console.log("Response status:", res.status, res.statusText);

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
                console.log("Content-Type:", contentType);

                let histories;
                if (contentType && contentType.includes("application/json")) {
                    histories = await res.json();
                } else {
                    const raw = await res.text();
                    console.log("Raw response:", raw);
                    try {
                        histories = JSON.parse(raw);
                    } catch (parseErr) {
                        console.error("Parse histories error:", parseErr, raw);
                        list.innerHTML = `<div class="history-empty">Gagal membaca data history (respon bukan JSON)</div>`;
                        return null;
                    }
                }

                console.log("Histories loaded:", histories);

                if (!histories || histories.length === 0) {
                    list.innerHTML = `<div class="history-empty">Belum ada riwayat pesan. Mulai chat baru!</div>`;
                    return null;
                }

                list.innerHTML = "";
                histories.forEach(h => {
                    const btn = document.createElement("button");
                    btn.className = "history-item";
                    btn.dataset.historyId = h.id;
                    btn.innerHTML = `
                        <span class="history-icon">💬</span>
                        <span class="history-text">${escapeHtml(h.title || ('Chat #' + h.id))}</span>
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

                // Return histories untuk digunakan di tempat lain
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
            // Simpan ke localStorage supaya setelah refresh tetap ingat
            localStorage.setItem('lastHistoryId', id);

            // Hapus loading indicator jika ada
            removeLoadingMessage();

            const chatMessages = document.getElementById("chatMessages");
            chatMessages.innerHTML = `<div class="message bot"><div class="message-avatar">🤖</div><div class="message-bubble">Memuat percakapan...</div></div>`;

            try {
                const res = await fetch(`/chat/messages/${id}`, {
                    headers: {
                        "X-CSRF-TOKEN": getCsrfToken()
                    },
                    credentials: 'same-origin'
                });

                if (!res.ok) {
                    chatMessages.innerHTML = `<div class="message bot"><div class="message-avatar">🤖</div><div class="message-bubble">Gagal memuat pesan (server ${res.status})</div></div>`;
                    return;
                }

                const messages = await res.json();

                // clear and render messages
                chatMessages.innerHTML = "";
                if (!messages || messages.length === 0) {
                    chatMessages.innerHTML = `<div class="message bot"><div class="message-avatar">🤖</div><div class="message-bubble">Percakapan kosong.</div></div>`;
                    return;
                }

                messages.forEach(m => {
                    // kalau pesan disimpan dengan properti 'sender' dan 'content'
                    const sender = m.sender || m.role || (m.from === 'user' ? 'user' : 'bot');
                    const content = m.content || m.text || m.message || JSON.stringify(m);
                    addMessage(sender, content);
                });

            } catch (err) {
                console.error("Open history error:", err);
                chatMessages.innerHTML = `<div class="message bot"><div class="message-avatar">🤖</div><div class="message-bubble">Terjadi kesalahan saat memuat pesan.</div></div>`;
            }
        }

        // ================== HELPERS ==================
        function handleKeyPress(e) {
            if (e.key === "Enter") sendMessage();
        }

        function startNewChat() {
            currentHistoryId = null; // reset
            localStorage.removeItem('lastHistoryId'); // hapus dari localStorage juga

            const chatMessages = document.getElementById("chatMessages");
            chatMessages.innerHTML = `
                <div class="message bot">
                    <div class="message-avatar">🤖</div>
                    <div class="message-bubble">
                        <p>Hi! I'm Alchemy, your personal AI skincare assistant.</p>
                        <p>Ada yang bisa aku bantu untuk kulitmu?</p>
                    </div>
                </div>
            `;

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
            return d.toLocaleString();
        }

        // ================== UI INTERACTIONS ==================
        // Fungsi untuk initialize setelah semua script dimuat
        async function initializeApp() {
            // Pastikan lucide sudah dimuat sebelum digunakan
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            } else {
                console.warn('Lucide belum dimuat');
            }

            // Tunggu sebentar untuk memastikan session sudah ready
            await new Promise(resolve => setTimeout(resolve, 100));

            // load histories saat buka halaman
            const histories = await loadHistories();

            // Setelah histories dimuat, cek apakah ada chat terakhir yang harus di-load
            // Hanya auto-load jika ada lastHistoryId di localStorage (artinya user belum logout)
            if (histories && histories.length > 0) {
                const lastHistoryId = localStorage.getItem('lastHistoryId');

                // Hanya auto-load jika ada lastHistoryId (user masih dalam session yang sama)
                if (lastHistoryId) {
                    // Validasi bahwa history ID masih ada di daftar histories
                    const historyExists = histories.some(h => h.id == lastHistoryId);
                    if (historyExists) {
                        // Auto-load chat terakhir
                        const historyBtn = document.querySelector(`[data-history-id="${lastHistoryId}"]`);
                        if (historyBtn) {
                            historyBtn.classList.add('active');
                            await openHistory(lastHistoryId);
                        }
                    }
                    // Jika history tidak ditemukan, biarkan welcome message tetap muncul
                }
                // Jika tidak ada lastHistoryId (baru login setelah logout), biarkan welcome message tetap muncul
            }
            // Jika tidak ada histories, tetap tampilkan welcome message (sudah ada di HTML)

            // User dropdown toggle
            const userBtn = document.querySelector('.user-btn');
            const userDropdown = document.querySelector('.user-dropdown');

            if (userBtn && userDropdown) {
                userBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('show');
                });

                document.addEventListener('click', function() {
                    userDropdown.classList.remove('show');
                });
            }

            // Mobile menu toggle
            const mobileToggle = document.getElementById('mobileToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            if (mobileToggle) {
                mobileToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('active');
                });
            }

            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const navbar = document.getElementById('navbar');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        }

        // Clear localStorage saat logout
        document.addEventListener('DOMContentLoaded', function() {
            const logoutForms = document.querySelectorAll('#logoutForm, #logoutFormMobile');
            logoutForms.forEach(form => {
                if (form) {
                    form.addEventListener('submit', function() {
                        // Clear localStorage sebelum logout
                        localStorage.removeItem('lastHistoryId');
                    });
                }
            });
        });

        // Panggil initializeApp setelah DOM ready dan script lucide dimuat
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                // Tunggu sampai semua script selesai dimuat
                window.addEventListener('load', initializeApp);
            });
        } else {
            // DOM sudah ready, tunggu script lucide
            window.addEventListener('load', initializeApp);
        }
    </script>

    <!-- Load external scripts di akhir untuk memastikan DOM sudah ready -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</body>
</html>

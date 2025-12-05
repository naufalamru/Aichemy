<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Alchemy - Skincare AI Platform</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tanya-ai.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>

</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="container">
            <div class="nav-content">
                <!-- Logo -->
                <div class="logo">
                    <i data-lucide="sparkles" class="logo-icon"></i>
                    <a href="/home" class="logo-text">✨ Alchemy</a>
                </div>

                <!-- Desktop Menu -->
                <div class="desktop-menu">
                    <a href="#home" class="nav-link">Home</a>
                    <a href="#tanya-ai" class="nav-link">Tanya AI</a>
                    <a href="#tentang" class="nav-link">Tentang Kami</a>
                    @auth
                        <span class="user-greeting">Halo, {{ Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <i data-lucide="log-out" class="btn-icon"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i data-lucide="log-in" class="btn-icon"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-signup">Sign Up →</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" id="mobileMenuBtn">
                    <i data-lucide="menu" class="menu-icon"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="#home" class="mobile-nav-link">Home</a>
            <a href="#tanya-ai" class="mobile-nav-link">Tanya AI</a>
            <a href="#tentang" class="mobile-nav-link">Tentang Kami</a>
            @auth
                <div class="mobile-user-greeting">Halo, {{ Auth::user()->name }}</div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout mobile-btn">
                        <i data-lucide="log-out" class="btn-icon"></i>
                        <span>Logout</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-login mobile-btn">Login</a>
                <a href="{{ route('register') }}" class="btn btn-signup mobile-btn">Sign Up →</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-icon">
                    <i data-lucide="sparkles" class="hero-sparkles"></i>
                </div>
                <h1 class="hero-title">Alchemy</h1>
                <p class="hero-description">
                    Platform skincare berbasis <span class="highlight">Agentic AI</span> yang menganalisis kebutuhan kulit dan data bahan aktif untuk memberikan rekomendasi produk yang akurat dan berbasis sains.
                </p>
                <a href="/querysains" class="btn btn-cta">Mulai Konsultasi 🌿</a>
            </div>
        </div>
    </section>

    <!-- AI Chat Section -->
    <main class="main-content" id="/chat-ai">
        <div class="chat-header">
            <h1>👩‍🔬 Tanya AI — Alchemy Assistant</h1>
            <p>Tanyakan apapun tentang skincare dan bahan aktif kepada AI kami</p>
        </div>

        <div class="chat-container">
            <div class="chat-messages" id="chatMessages">
                <!-- Bot Welcome Message -->
                <div class="message bot">
                    <div class="message-avatar">🤖</div>
                    <div class="message-bubble">
                        Halo! Saya Alchemy AI Assistant. Saya siap membantu Anda dengan pertanyaan seputar skincare, analisis kulit, dan rekomendasi produk. Apa yang ingin Anda ketahui hari ini?
                    </div>
                </div>
            </div>

            <div class="chat-input-area">
                <div class="chat-input-container">
                    <input
                        type="text"
                        class="chat-input"
                        id="messageInput"
                        placeholder="Ketik pertanyaanmu…"
                        onkeypress="handleKeyPress(event)"
                    >
                    <button class="send-button" onclick="sendMessage()">
                        <span>Kirim</span>
                        <span>➤</span>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- About Section -->
    <section id="tentang" class="about-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Tentang Kami</h2>
                <div class="title-underline"></div>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🧬</div>
                    <h3 class="feature-title">Analisis Mendalam</h3>
                    <p class="feature-desc">AI kami menganalisis kebutuhan kulit Anda secara detail berdasarkan data ilmiah</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💊</div>
                    <h3 class="feature-title">Bahan Aktif</h3>
                    <p class="feature-desc">Rekomendasi berbasis bahan aktif yang terbukti efektif untuk kondisi kulit Anda</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">✨</div>
                    <h3 class="feature-title">Hasil Akurat</h3>
                    <p class="feature-desc">Sistem rekomendasi yang dipersonalisasi untuk hasil maksimal</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <div class="footer-logo">
                        <i data-lucide="sparkles" class="footer-logo-icon"></i>
                        <span class="footer-logo-text">Alchemy</span>
                    </div>
                    <p class="footer-desc">
                        Platform skincare berbasis Agentic AI yang menganalisis kebutuhan kulit dan data bahan aktif untuk memberikan rekomendasi produk yang akurat dan berbasis sains.
                    </p>
                </div>
                <div class="footer-menu">
                    <h3 class="footer-menu-title">Menu</h3>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#tanya-ai">Tanya AI</a></li>
                        <li><a href="#tentang">Tentang Kami</a></li>
                        @auth
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="footer-logout">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="footer-contact">Contact: aichemy@gmail.com</p>
                <p class="footer-copyright">© 2025 Alchemy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // ---- API CALL KE LARAVEL BACKEND ----
        async function queryToFlowise(question) {
            const response = await fetch(
                "/api/chat",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ""
                    },
                    body: JSON.stringify({ question })
                }
            );
            return await response.json();
        }

        // ---- KIRIM PESAN ----
        async function sendMessage() {
            const input = document.getElementById("messageInput");
            const message = input.value.trim();
            if (message === "") return;

            addMessage(message, "user");
            input.value = "";

            const loadingId = addLoadingBubble();

            try {
                const res = await queryToFlowise(message);

                removeLoadingBubble(loadingId);

                if (res.error) {
                    addMessage("⚠️ Error: " + res.error, "bot");
                    console.error("Chat error:", res);
                } else {
                    const botText = res.answer || JSON.stringify(res);
                    addMessage(botText, "bot");
                }

            } catch (error) {
                removeLoadingBubble(loadingId);
                console.error("Chat exception:", error);
                addMessage("⚠️ Terjadi kesalahan: " + error.message + "\n\nCoba lagi dalam beberapa saat ya!", "bot");
            }
        }

        // ---- TAMBAH PESAN ----
        function addMessage(text, sender) {
            const chatMessages = document.getElementById("chatMessages");
            const div = document.createElement("div");
            div.className = `message ${sender}`;

            if (sender === "bot") {
                div.innerHTML = `
                    <div class="message-avatar">🤖</div>
                    <div class="message-bubble">${text}</div>
                `;
            } else {
                div.innerHTML = `
                    <div class="message-bubble">${text}</div>
                    <div class="message-avatar">👤</div>
                `;
            }

            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // ---- ENTER UNTUK KIRIM ----
        function handleKeyPress(event) {
            if (event.key === "Enter") sendMessage();
        }

        // ---- LOADING BUBBLE ----
        function addLoadingBubble() {
            const id = "loading-" + Date.now();
            const chatMessages = document.getElementById("chatMessages");

            const bubble = document.createElement("div");
            bubble.className = "message bot";
            bubble.id = id;
            bubble.innerHTML = `
                <div class="message-avatar">🤖</div>
                <div class="message-bubble"><span>• • •</span></div>
            `;

            chatMessages.appendChild(bubble);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return id;
        }

        function removeLoadingBubble(id) {
            const bubble = document.getElementById(id);
            if (bubble) bubble.remove();
        }
    </script>
    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>

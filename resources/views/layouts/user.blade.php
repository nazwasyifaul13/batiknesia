<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Batiknesia - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* LIGHT MODE */
        :root {
            --bg-primary-light: linear-gradient(145deg, #fef9f0 0%, #fff5e6 50%, #fef0e0 100%);
            --bg-card-light: rgba(255, 255, 255, 0.92);
            --text-primary-light: #2c1810;
            --text-secondary-light: #5c3d2e;
            --accent-light: #c4a747;
            --accent-glow-light: rgba(196, 167, 71, 0.35);
            --border-light: rgba(196, 167, 71, 0.25);
            --navbar-bg-light: rgba(255, 255, 255, 0.94);
            --shadow-light: 0 8px 32px rgba(0, 0, 0, 0.06);
            --shadow-hover-light: 0 20px 45px rgba(0, 0, 0, 0.12);
        }

        /* DARK MODE */
        :root {
            --bg-primary-dark: linear-gradient(145deg, #0a0805 0%, #1a140f 50%, #0f0c08 100%);
            --bg-card-dark: rgba(22, 30, 62, 0.88);
            --text-primary-dark: #f5ead8;
            --text-secondary-dark: #e0cba8;
            --accent-dark: #e6b84e;
            --accent-glow-dark: rgba(230, 184, 78, 0.4);
            --border-dark: rgba(230, 184, 78, 0.2);
            --navbar-bg-dark: rgba(22, 30, 62, 0.94);
            --shadow-dark: 0 8px 32px rgba(0, 0, 0, 0.25);
            --shadow-hover-dark: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        /* LIGHT MODE - WARNA LEBIH TAJAM */
        [data-theme="light"] {
            --bg-primary: linear-gradient(135deg, #faf0e6 0%, #f5e6d3 50%, #faf0e6 100%);
            --bg-card: rgba(255, 255, 255, 0.98);
            --text-primary: #1a0f0a;
            --text-secondary: #4a2a1a;
            --text-muted: #8b6914;
            --accent: #b8860b;
            --accent-dark: #8b6914;
            --accent-light: rgba(184, 134, 11, 0.12);
            --border: rgba(184, 134, 11, 0.35);
            --navbar-bg: rgba(255, 255, 255, 0.96);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        [data-theme="dark"] {
            --bg-primary: var(--bg-primary-dark);
            --bg-card: var(--bg-card-dark);
            --text-primary: var(--text-primary-dark);
            --text-secondary: var(--text-secondary-dark);
            --accent: var(--accent-dark);
            --accent-glow: var(--accent-glow-dark);
            --border: var(--border-dark);
            --navbar-bg: var(--navbar-bg-dark);
            --shadow: var(--shadow-dark);
            --shadow-hover: var(--shadow-hover-dark);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* PARTICLES */
        .particles-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }
        .particle {
            position: absolute;
            background: radial-gradient(circle, var(--accent), rgba(196,167,71,0.3), transparent);
            border-radius: 50%;
            animation: floatParticle linear infinite;
            opacity: 0;
        }
        .particle-large {
            position: absolute;
            background: radial-gradient(circle, rgba(255,255,255,0.1), transparent);
            border-radius: 50%;
            animation: floatLarge ease-in-out infinite;
        }
        @keyframes floatParticle {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            5% { opacity: 0.5; }
            85% { opacity: 0.3; }
            100% { transform: translateY(-20vh) rotate(360deg); opacity: 0; }
        }
        @keyframes floatLarge {
            0% { transform: translateY(100vh) scale(0.8); opacity: 0; }
            20% { opacity: 0.2; }
            80% { opacity: 0.15; }
            100% { transform: translateY(-20vh) scale(1.2); opacity: 0; }
        }

        /* FLOATING ORBS */
        .floating-orb {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-glow), transparent);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
            animation: floatOrb 20s ease-in-out infinite;
        }
        @keyframes floatOrb {
            0%,100% { transform: translate(0, 0) scale(1); opacity: 0.25; }
            25% { transform: translate(70px, -60px) scale(1.2); opacity: 0.4; }
            50% { transform: translate(-50px, 50px) scale(0.8); opacity: 0.3; }
            75% { transform: translate(60px, 60px) scale(1.1); opacity: 0.35; }
        }

        /* NAVBAR */
        .top-nav {
            background: var(--navbar-bg);
            backdrop-filter: blur(12px);
            padding: 12px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
            transition: all 0.3s;
            max-width: 1280px;
            margin: 0 auto;
            border-radius: 0 0 24px 24px;
            box-shadow: var(--shadow);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo-img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            transition: all 0.3s;
        }
        .logo-img:hover { transform: scale(1.05) rotate(5deg); }
        .logo span {
            font-family: 'Poppins', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: 1px;
        }

        .nav-links { display: flex; gap: 32px; }
        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), #8b7355);
            transition: width 0.3s;
            border-radius: 2px;
        }
        .nav-links a:hover::after,
        .nav-links a.active::after { width: 100%; }
        .nav-links a:hover,
        .nav-links a.active { color: var(--accent); }

        .user-menu { display: flex; align-items: center; gap: 16px; }
        .user-name { font-size: 14px; font-weight: 500; color: var(--text-primary); }
        .user-avatar {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--accent), #8b7355);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .user-avatar:hover { transform: scale(1.1); box-shadow: 0 0 15px var(--accent-glow); }
        .user-avatar i { color: #2c1810; font-size: 18px; }
        .logout-btn {
            background: none; border: none;
            color: var(--accent); cursor: pointer;
            font-size: 18px; transition: all 0.3s;
        }
        .logout-btn:hover { transform: scale(1.1); color: var(--accent); }

        /* THEME TOGGLE AESTHETIC */
        .theme-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 54px;
            height: 54px;
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 99;
            border: 1px solid var(--border);
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }
        .theme-toggle:hover {
            transform: scale(1.12);
            background: var(--accent);
            box-shadow: 0 0 25px var(--accent-glow);
        }
        .theme-toggle:hover i { color: #2c1810; }
        .theme-toggle i {
            font-size: 24px;
            color: var(--accent);
            transition: all 0.3s;
        }

        /* MAIN CONTENT */
        .main-container {
            position: relative;
            z-index: 1;
            max-width: 1280px;
            margin: 0 auto;
            padding: 28px;
        }

        /* PAGE HEADER - CENTERED */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .page-header h1 {
            font-family: 'Poppins', sans-serif;
            font-size: 34px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }
        .page-header p {
            font-size: 15px;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }
        .page-header .decorative-line {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #8b7355, var(--accent));
            margin: 20px auto 0;
            border-radius: 3px;
            animation: lineExpand 1s ease-out;
        }
        @keyframes lineExpand {
            from { width: 0; opacity: 0; }
            to { width: 80px; opacity: 1; }
        }

        /* CARD PREMIUM */
        .card-premium {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border-radius: 28px;
            padding: 28px;
            border: 1px solid var(--border);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            box-shadow: var(--shadow);
            animation: cardFloat 6s ease-in-out infinite;
        }
        @keyframes cardFloat {
            0%,100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        .card-premium:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
            animation-play-state: paused;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #8b7355);
            border: none;
            padding: 12px 28px;
            border-radius: 50px;
            color: #2c1810;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px var(--accent-glow);
            color: white;
            gap: 12px;
        }

        .btn-secondary {
            background: transparent;
            border: 1.5px solid var(--accent);
            padding: 12px 28px;
            border-radius: 50px;
            color: var(--text-primary);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-secondary:hover {
            background: rgba(196,167,71,0.1);
            transform: translateY(-2px);
            gap: 12px;
        }

        .mobile-menu-btn { display: none; background: none; border: none; color: var(--accent); font-size: 24px; cursor: pointer; }
        .mobile-nav {
            display: none;
            position: fixed;
            top: 70px;
            left: 16px; right: 16px;
            background: var(--navbar-bg);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 16px;
            z-index: 99;
            border: 1px solid var(--border);
        }
        .mobile-nav a {
            display: block;
            padding: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            transition: all 0.3s;
        }
        .mobile-nav a:last-child { border-bottom: none; }
        .mobile-nav a:hover { color: var(--accent); padding-left: 16px; }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-menu-btn { display: block; }
            .user-name { display: none; }
            .top-nav { padding: 12px 20px; margin: 0 10px; }
            .main-container { padding: 16px; }
            .page-header h1 { font-size: 24px; }
        }
        
    </style>
    @stack('styles')
</head>
<body>
    <!-- PARTICLES -->
    <div class="particles-bg" id="particlesBg"></div>
    <div class="particles-bg" id="particlesLargeBg"></div>
    
    <!-- FLOATING ORBS -->
    <div class="floating-orb" style="width: 400px; height: 400px; top: -180px; right: -180px;"></div>
    <div class="floating-orb" style="width: 300px; height: 300px; bottom: -120px; left: -120px;"></div>
    <div class="floating-orb" style="width: 250px; height: 250px; top: 40%; right: 10%;"></div>
    <div class="floating-orb" style="width: 200px; height: 200px; bottom: 20%; left: 5%;"></div>

    <nav class="top-nav">
        <div class="logo">
            <img src="{{ asset('images/logos/logo-batik.png') }}" class="logo-img" onerror="this.src='https://placehold.co/45x45'">
            <span>BATIKNESIA</span>
        </div>
        <div class="nav-links">
            <a href="{{ route('user.dashboard') }}" class="@if(Route::is('user.dashboard')) active @endif">Dashboard</a>
            <a href="{{ route('user.products') }}" class="@if(Route::is('user.products')) active @endif">Products</a>
            <a href="{{ route('user.tryon') }}" class="@if(Route::is('user.tryon')) active @endif">Try On</a>
            <a href="{{ route('user.education') }}" class="@if(Route::is('user.education')) active @endif">Education</a>
            <a href="{{ route('user.orders') }}" class="@if(Route::is('user.orders')) active @endif">Orders</a>
            <a href="{{ route('user.tracking') }}" class="@if(Route::is('user.tracking')) active @endif">Tracking</a>
        </div>
        <div class="user-menu">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <div class="user-avatar" onclick="window.location='{{ route('user.profile') }}'">
                @if(Auth::user()->avatar)
                    <img src="{{ asset(Auth::user()->avatar) }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()"><i class="fas fa-bars"></i></button>
            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                @csrf
                <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </nav>

    <div class="mobile-nav" id="mobileNav">
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
        <a href="{{ route('user.products') }}">Products</a>
        <a href="{{ route('user.tryon') }}">Try On</a>
        <a href="{{ route('user.education') }}">Education</a>
        <a href="{{ route('user.orders') }}">Orders</a>
        <a href="{{ route('user.tracking') }}">Tracking</a>
    </div>

    <div class="main-container">
        @yield('content')
    </div>

    <div class="theme-toggle" onclick="toggleTheme()">
        <i class="fas fa-moon" id="themeIcon"></i>
    </div>

    <script>
        function createParticles() {
            const container1 = document.getElementById('particlesBg');
            const container2 = document.getElementById('particlesLargeBg');
            
            for (let i = 0; i < 300; i++) {
                const p = document.createElement('div');
                p.classList.add('particle');
                const size = Math.random() * 8 + 2;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = Math.random() * 25 + 10 + 's';
                p.style.animationDelay = Math.random() * 20 + 's';
                container1.appendChild(p);
            }
            
            for (let i = 0; i < 60; i++) {
                const p = document.createElement('div');
                p.classList.add('particle-large');
                const size = Math.random() * 30 + 15;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = Math.random() * 35 + 25 + 's';
                p.style.animationDelay = Math.random() * 25 + 's';
                container2.appendChild(p);
            }
        }
        createParticles();

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const newTheme = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            const icon = document.getElementById('themeIcon');
            if (newTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        const saved = localStorage.getItem('theme');
        if (saved) {
            document.documentElement.setAttribute('data-theme', saved);
            const icon = document.getElementById('themeIcon');
            if (saved === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        }

        function toggleMobileMenu() {
            const nav = document.getElementById('mobileNav');
            nav.style.display = nav.style.display === 'block' ? 'none' : 'block';
        }
    </script>
    @stack('scripts')
    <!-- Floating Chat Button -->
<style>
    .floating-chat {
        position: fixed;
        bottom: 100px;
        right: 24px;
        z-index: 999;
    }
    .chat-btn {
        width: 60px;
        height: 60px;
        background: linear-gradient(145deg, var(--accent), #8b7355);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        animation: pulseChat 2s infinite;
        border: none;
    }
    .chat-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(196,167,71,0.5);
    }
    .chat-btn i {
        font-size: 28px;
        color: #2c1810;
    }
    .chat-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    @keyframes pulseChat {
        0%,100% { box-shadow: 0 5px 20px rgba(0,0,0,0.2); }
        50% { box-shadow: 0 5px 30px rgba(196,167,71,0.6); }
    }

    /* Chat Window */
    .chat-window {
        position: fixed;
        bottom: 170px;
        right: 24px;
        width: 350px;
        height: 500px;
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        display: none;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid var(--border);
        z-index: 1000;
        animation: slideUp 0.3s ease;
    }
    .chat-window.open { display: flex; }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .chat-header {
        background: linear-gradient(135deg, var(--accent), #8b7355);
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chat-header h4 { color: white; margin: 0; font-size: 16px; font-weight: 600; }
    .chat-header span { font-size: 11px; color: rgba(255,255,255,0.8); }
    .chat-close {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }
    .chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .chat-message {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 18px;
        font-size: 13px;
    }
    .chat-message.user {
        align-self: flex-end;
        background: linear-gradient(135deg, var(--accent), #8b7355);
        color: #2c1810;
        border-bottom-right-radius: 5px;
    }
    .chat-message.admin {
        align-self: flex-start;
        background: var(--bg-primary);
        border: 1px solid var(--border);
        color: var(--text-primary);
        border-bottom-left-radius: 5px;
    }
    .chat-input-area {
        padding: 12px;
        border-top: 1px solid var(--border);
        display: flex;
        gap: 10px;
    }
    .chat-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid var(--border);
        border-radius: 30px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 13px;
    }
    .chat-input:focus { outline: none; border-color: var(--accent); }
    .chat-send {
        background: var(--accent);
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        color: #2c1810;
        transition: all 0.3s;
    }
    .chat-send:hover { transform: scale(1.05); background: #8b7355; color: white; }

    @media (max-width: 480px) {
        .chat-window { width: calc(100vw - 40px); right: 20px; bottom: 150px; }
    }
</style>

<div class="floating-chat">
    <button class="chat-btn" id="chatToggleBtn">
        <i class="fas fa-comment-dots"></i>
        <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
    </button>
    
    <div class="chat-window" id="chatWindow">
        <div class="chat-header">
            <div>
                <h4>Batiknesia Assistant</h4>
                <span>Admin akan membalas pesan Anda</span>
            </div>
            <button class="chat-close" id="chatCloseBtn"><i class="fas fa-times"></i></button>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="chat-message admin">
                <i class="fas fa-robot"></i> Halo! Ada yang bisa saya bantu? Tanyakan tentang batik, virtual try on, atau pesanan Anda.
            </div>
        </div>
        
        <div class="chat-input-area">
            <input type="text" class="chat-input" id="chatInput" placeholder="Tulis pesan...">
            <button class="chat-send" id="chatSendBtn"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<script>
    // Chat Elements
    const chatToggle = document.getElementById('chatToggleBtn');
    const chatWindow = document.getElementById('chatWindow');
    const chatClose = document.getElementById('chatCloseBtn');
    const chatInput = document.getElementById('chatInput');
    const chatSend = document.getElementById('chatSendBtn');
    const chatMessages = document.getElementById('chatMessages');
    const chatBadge = document.getElementById('chatBadge');
    let lastChatId = 0;
    
    // Toggle Chat Window
    chatToggle.addEventListener('click', () => {
        chatWindow.classList.toggle('open');
        if (chatWindow.classList.contains('open')) {
            chatInput.focus();
            loadChatMessages();
            startChatPolling();
            chatBadge.style.display = 'none';
        } else {
            stopChatPolling();
        }
    });
    
    chatClose.addEventListener('click', () => {
        chatWindow.classList.remove('open');
        stopChatPolling();
    });
    
    // Send Message
    async function sendChatMessage() {
        const message = chatInput.value.trim();
        if (!message) return;
        
        appendChatMessage(message, 'user');
        chatInput.value = '';
        
        const loadingMsg = appendChatMessage('Mengirim...', 'admin', true);
        
        try {
            const response = await fetch('{{ route("user.chat.send") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ message: message })
            });
            const data = await response.json();
            loadingMsg.remove();
            
            if (data.success) {
                appendChatMessage('Pesan terkirim. Admin akan membalas segera.', 'admin');
                updateUnreadBadge();
            } else {
                appendChatMessage('Gagal mengirim pesan. Coba lagi.', 'admin');
            }
        } catch (error) {
            loadingMsg.remove();
            appendChatMessage('Terjadi kesalahan. Coba lagi.', 'admin');
        }
    }
    
    function appendChatMessage(text, sender, isLoading = false) {
        const div = document.createElement('div');
        div.className = `chat-message ${sender}`;
        div.innerHTML = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        if (isLoading) return div;
        return null;
    }
    
    async function loadChatMessages() {
        try {
            const response = await fetch('{{ route("user.chat.messages") }}');
            const data = await response.json();
            
            if (data.messages && data.messages.length > 0) {
                const existingMessages = chatMessages.querySelectorAll('.chat-message:not(.chat-message:first-child)');
                existingMessages.forEach(msg => msg.remove());
                
                data.messages.forEach(msg => {
                    appendChatMessage(msg.message, msg.sender === 'admin' ? 'admin' : 'user');
                    if (msg.id > lastChatId) lastChatId = msg.id;
                });
            }
        } catch (error) {}
    }
    
    async function updateUnreadBadge() {
        try {
            const response = await fetch('{{ route("user.chat.unread") }}');
            const data = await response.json();
            if (data.count > 0 && !chatWindow.classList.contains('open')) {
                chatBadge.style.display = 'flex';
                chatBadge.textContent = data.count > 9 ? '9+' : data.count;
            } else {
                chatBadge.style.display = 'none';
            }
        } catch (error) {}
    }
    
    let chatPollingInterval;
    function startChatPolling() {
        if (chatPollingInterval) clearInterval(chatPollingInterval);
        chatPollingInterval = setInterval(async () => {
            try {
                const response = await fetch('{{ route("user.chat.messages") }}?last_id=' + lastChatId);
                const data = await response.json();
                if (data.messages && data.messages.length > 0) {
                    data.messages.forEach(msg => {
                        if (msg.id > lastChatId) {
                            appendChatMessage(msg.message, msg.sender === 'admin' ? 'admin' : 'user');
                            lastChatId = msg.id;
                        }
                    });
                }
                updateUnreadBadge();
            } catch (error) {}
        }, 5000);
    }
    
    function stopChatPolling() {
        if (chatPollingInterval) { clearInterval(chatPollingInterval); chatPollingInterval = null; }
    }
    
    chatSend.addEventListener('click', sendChatMessage);
    chatInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') sendChatMessage(); });
    
    updateUnreadBadge();
</script>
</body>
</html>
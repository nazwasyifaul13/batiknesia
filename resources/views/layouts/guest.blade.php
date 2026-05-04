<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Batiknesia - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-primary: #fefaf5;
            --bg-secondary: #ffffff;
            --text-primary: #2c1a10;
            --text-secondary: #6b4423;
            --text-muted: #9e7a5c;
            --accent: #c9a03d;
            --accent-dark: #a07e2e;
            --accent-light: rgba(201, 160, 61, 0.1);
            --border: rgba(201, 160, 61, 0.2);
            --shadow-sm: 0 4px 20px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-primary: #0f0c08;
            --bg-secondary: #1a140f;
            --text-primary: #f5ead8;
            --text-secondary: #e0cba8;
            --text-muted: #b89a6e;
            --accent: #c9a03d;
            --accent-dark: #a07e2e;
            --accent-light: rgba(201, 160, 61, 0.08);
            --border: rgba(201, 160, 61, 0.15);
            --shadow-sm: 0 4px 20px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a03d' fill-opacity='0.04'%3E%3Cpath d='M30 10 L35 20 L45 22 L38 30 L40 40 L30 35 L20 40 L22 30 L15 22 L25 20 Z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-repeat: repeat;
            pointer-events: none;
            z-index: 0;
        }

        /* Native Navbar untuk Guest Pages */
        .guest-navbar {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1300px;
            background: var(--bg-secondary);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 12px 28px;
            border-radius: 80px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .guest-navbar.scrolled {
            top: 0;
            width: 100%;
            border-radius: 0;
            padding: 10px 40px;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-icon i {
            font-size: 20px;
            color: #1a140f;
        }
        .logo span {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: var(--accent);
        }

        .theme-toggle {
            display: flex;
            gap: 5px;
            background: var(--accent-light);
            border-radius: 50px;
            padding: 5px;
        }
        .theme-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
            background: transparent;
            color: var(--text-muted);
            font-size: 14px;
            transition: all 0.3s;
        }
        .theme-btn.active {
            background: var(--accent);
            color: #1a140f;
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-primary);
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            right: -280px;
            width: 280px;
            height: 100%;
            background: var(--bg-secondary);
            backdrop-filter: blur(20px);
            z-index: 1001;
            padding: 80px 25px 25px;
            transition: right 0.3s ease;
            box-shadow: -5px 0 20px rgba(0,0,0,0.1);
        }
        .mobile-menu.open {
            right: 0;
        }
        .mobile-menu .mobile-nav-link {
            display: block;
            padding: 12px 0;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 16px;
            border-bottom: 1px solid var(--border);
        }
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            display: none;
        }
        .mobile-overlay.active {
            display: block;
        }
        .mobile-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-primary);
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hamburger { display: block; }
            .guest-navbar { padding: 10px 20px; top: 10px; width: 95%; border-radius: 40px; }
        }

        .main-guest {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px;
            position: relative;
            z-index: 1;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        .floating-particle {
            position: absolute;
            background: radial-gradient(circle, var(--accent), transparent);
            border-radius: 50%;
            opacity: 0;
            animation: particleRise 12s linear infinite;
        }
        @keyframes particleRise {
            0% { transform: translateY(100vh); opacity: 0; }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            100% { transform: translateY(-20vh); opacity: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="animated-bg" id="particles"></div>
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>
    
    <div class="mobile-menu" id="mobileMenu">
        <button class="mobile-close" onclick="closeMobileMenu()"><i class="fas fa-times"></i></button>
        <a href="{{ url('/') }}" class="mobile-nav-link">Beranda</a>
        <a href="{{ url('/#features') }}" class="mobile-nav-link">Fitur</a>
        <a href="{{ url('/#productsCarousel') }}" class="mobile-nav-link">Koleksi</a>
        <a href="{{ url('/#testimonials') }}" class="mobile-nav-link">Testimoni</a>
        <a href="{{ route('login') }}" class="mobile-nav-link" style="color: var(--accent);">Masuk</a>
        <a href="{{ route('register') }}" class="mobile-nav-link">Daftar</a>
    </div>

    <nav class="guest-navbar" id="guestNavbar">
        <div class="nav-container">
            <div class="logo" onclick="window.location.href='{{ url('/') }}'">
                <div class="logo-icon"><i class="fas fa-feather-alt"></i></div>
                <span>BATIKNESIA</span>
            </div>
            <div class="nav-links">
                <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                <a href="{{ url('/#features') }}" class="nav-link">Fitur</a>
                <a href="{{ url('/#productsCarousel') }}" class="nav-link">Koleksi</a>
                <a href="{{ url('/#testimonials') }}" class="nav-link">Testimoni</a>
                <div class="theme-toggle">
                    <button class="theme-btn" id="guestThemeLight" onclick="setTheme('light')"><i class="fas fa-sun"></i></button>
                    <button class="theme-btn" id="guestThemeDark" onclick="setTheme('dark')"><i class="fas fa-moon"></i></button>
                </div>
                <a href="{{ route('login') }}" class="nav-link" style="color: var(--accent); font-weight: 600;">Masuk</a>
                <a href="{{ route('register') }}" class="nav-link">Daftar</a>
            </div>
            <button class="hamburger" onclick="openMobileMenu()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <main class="main-guest">
        @yield('content')
    </main>

    <script>
        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            const lightBtn = document.getElementById('guestThemeLight');
            const darkBtn = document.getElementById('guestThemeDark');
            if (lightBtn && darkBtn) {
                lightBtn.classList.toggle('active', theme === 'light');
                darkBtn.classList.toggle('active', theme === 'dark');
            }
        }
        const saved = localStorage.getItem('theme') || 'light';
        setTheme(saved);

        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('guestNavbar');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        function openMobileMenu() {
            document.getElementById('mobileMenu').classList.add('open');
            document.getElementById('mobileOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeMobileMenu() {
            document.getElementById('mobileMenu').classList.remove('open');
            document.getElementById('mobileOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function createParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i = 80; i++) {
                const p = document.createElement('div');
                p.classList.add('floating-particle');
                const size = Math.random() * 5 + 2;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = Math.random() * 12 + 8 + 's';
                p.style.animationDelay = Math.random() * 10 + 's';
                container.appendChild(p);
            }
        }
        createParticles();
    </script>
    @stack('scripts')
</body>
</html>
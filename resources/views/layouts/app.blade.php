<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Batiknesia - @yield('title', 'Warisan Batik Nusantara')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Theme Variables */
        :root {
            --bg-primary: #fefaf5;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-sidebar: linear-gradient(180deg, #2c1810 0%, #1a0f0a 100%);
            --text-primary: #2c1a10;
            --text-secondary: #6b4423;
            --text-muted: #9e7a5c;
            --accent: #c9a03d;
            --accent-dark: #a07e2e;
            --accent-light: rgba(201, 160, 61, 0.08);
            --border: rgba(201, 160, 61, 0.2);
            --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 16px 45px rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] {
            --bg-primary: #0f0c08;
            --bg-secondary: #1a140f;
            --bg-card: #1f1913;
            --bg-sidebar: linear-gradient(180deg, #1a0f0a 0%, #0d0805 100%);
            --text-primary: #f5ead8;
            --text-secondary: #e0cba8;
            --text-muted: #b89a6e;
            --accent: #c9a03d;
            --accent-dark: #a07e2e;
            --accent-light: rgba(201, 160, 61, 0.08);
            --border: rgba(201, 160, 61, 0.15);
            --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.2);
            --shadow-md: 0 8px 30px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 16px 45px rgba(0, 0, 0, 0.4);
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        h1, h2, h3, h4, .logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            letter-spacing: -0.3px;
        }

        /* ========== NAVBAR PREMIUM (Seperti Landing Page) ========== */
        .navbar-premium {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1300px;
            background: var(--bg-secondary);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 12px 32px;
            border-radius: 80px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .navbar-premium.scrolled {
            top: 0;
            width: 100%;
            border-radius: 0;
            padding: 10px 40px;
            box-shadow: var(--shadow-md);
        }
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Logo */
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }
        .logo-box {
            width: 46px;
            height: 46px;
            background: transparent;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-box img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 12px;
        }
        .logo-text {
            font-family: 'Poppins', sans-serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: -0.5px;
        }
        @media (max-width: 480px) {
            .logo-text { font-size: 18px; }
            .logo-box { width: 38px; height: 38px; }
            .logo-box img { width: 34px; height: 34px; }
        }

        /* Nav Links */
        .nav-links {
            display: flex;
            gap: 35px;
            align-items: center;
        }
        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent-dark));
            transition: width 0.3s;
        }
        .nav-link:hover::after { width: 100%; }
        .nav-link:hover { color: var(--accent); }
        .btn-login {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: #1a140f;
            padding: 8px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(201,160,61,0.3); color: white; }
        @media (max-width: 768px) { .nav-links { display: none; } }

        /* Theme Toggle */
        .theme-toggle-nav {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--text-primary);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: all 0.3s;
        }
        .theme-toggle-nav:hover {
            background: var(--accent-light);
        }

        /* Hamburger Button */
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--text-primary);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .hamburger-btn:hover {
            background: var(--accent-light);
        }

        /* ========== MOBILE SIDEBAR ========== */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100%;
            background: var(--bg-sidebar);
            z-index: 1000;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.3);
        }
        .mobile-sidebar.open {
            transform: translateX(0);
        }
        .mobile-sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(201,160,61,0.15);
        }
        .mobile-sidebar-logo {
            width: 70px;
            height: 70px;
            background: rgba(201,160,61,0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }
        .mobile-sidebar-logo i { font-size: 35px; color: var(--accent); }
        .mobile-sidebar-header h2 { font-family: 'Poppins', sans-serif; font-size: 20px; color: var(--accent); }
        .mobile-sidebar-nav { padding: 20px; }
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: #d4c5a9;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s;
            margin-bottom: 8px;
        }
        .mobile-nav-link i { width: 22px; font-size: 16px; }
        .mobile-nav-link:hover, .mobile-nav-link.active {
            background: rgba(201,160,61,0.15);
            color: var(--accent);
        }
        .mobile-sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(201,160,61,0.1);
        }
        .mobile-logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: rgba(220, 53, 69, 0.1);
            border: none;
            border-radius: 12px;
            color: #ef4444;
            cursor: pointer;
            font-size: 14px;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        .sidebar-overlay.active {
            display: block;
        }

        /* Main Content */
        .main-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 32px 32px;
        }
        @media (max-width: 768px) {
            .main-content { padding: 90px 20px 20px; }
            .hamburger-btn { display: block; }
            .navbar-premium { padding: 10px 20px; top: 10px; width: 95%; border-radius: 40px; }
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--accent-light); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <!-- Mobile Sidebar -->
    <aside class="mobile-sidebar" id="mobileSidebar">
        <div class="mobile-sidebar-header">
            <div class="mobile-sidebar-logo">
                @if(file_exists(public_path('images/logos/logo-batik.png')))
                    <img src="{{ asset('images/logos/logo-batik.png') }}" style="width: 50px; height: 50px; border-radius: 15px;">
                @else
                    <i class="fas fa-feather-alt"></i>
                @endif
            </div>
            <h2>BATIKNESIA</h2>
            <p style="font-size: 10px; color: rgba(201,160,61,0.6);">Warisan Nusantara</p>
        </div>
        <nav class="mobile-sidebar-nav">
            <a href="{{ route('user.dashboard') }}" class="mobile-nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('user.products') }}" class="mobile-nav-link {{ request()->routeIs('user.products') ? 'active' : '' }}">
                <i class="fas fa-store"></i> Produk
            </a>
            <a href="{{ route('user.tryon') }}" class="mobile-nav-link {{ request()->routeIs('user.tryon') ? 'active' : '' }}">
                <i class="fas fa-magic"></i> Try On
            </a>
            <a href="{{ route('user.education') }}" class="mobile-nav-link {{ request()->routeIs('user.education') ? 'active' : '' }}">
                <i class="fas fa-graduation-cap"></i> Edukasi
            </a>
            <a href="{{ route('user.orders') }}" class="mobile-nav-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">
                <i class="fas fa-shopping-bag"></i> Pesanan
            </a>
            <a href="{{ route('user.cart') }}" class="mobile-nav-link {{ request()->routeIs('user.cart') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Keranjang
            </a>
        </nav>
        <div class="mobile-sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mobile-logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Navbar Premium (Seperti Landing Page) -->
    <header>
        <nav class="navbar-premium" id="navbar">
            <div class="nav-container">
                <div class="logo" onclick="window.location.href='{{ route('user.dashboard') }}'">
                    <div class="logo-box">
                        @if(file_exists(public_path('images/logos/logo-batik.png')))
                            <img src="{{ asset('images/logos/logo-batik.png') }}" alt="Logo">
                        @else
                            <i class="fas fa-feather-alt"></i>
                        @endif
                    </div>
                    <span class="logo-text">BATIKNESIA</span>
                </div>
                <div class="nav-links">
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('user.products') }}" class="nav-link {{ request()->routeIs('user.products') ? 'active' : '' }}">Produk</a>
                    <a href="{{ route('user.tryon') }}" class="nav-link {{ request()->routeIs('user.tryon') ? 'active' : '' }}">Virtual Try On</a>
                    <a href="{{ route('user.education') }}" class="nav-link {{ request()->routeIs('user.education') ? 'active' : '' }}">Edukasi</a>
                    <a href="{{ route('user.orders') }}" class="nav-link {{ request()->routeIs('user.orders') ? 'active' : '' }}">Pesanan</a>
                </div>
                
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button onclick="toggleTheme()" class="theme-toggle-nav" id="themeToggle">
                        <i id="themeIcon" class="fas fa-moon"></i>
                    </button>
                    
                    <div class="user-dropdown-container" style="position: relative;">
                        <button class="user-dropdown-btn" onclick="toggleUserDropdown()" style="display: flex; align-items: center; gap: 12px; background: none; border: none; cursor: pointer;">
                            <div style="width: 42px; height: 42px; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user" style="color: #1a140f;"></i>
                            </div>
                            <div class="user-info-nav" style="display: none;">
                                <div style="font-size: 13px; font-weight: 600; color: var(--text-primary);">{{ Auth::user()->name ?? 'User' }}</div>
                                <div style="font-size: 10px; color: var(--accent);">Member</div>
                            </div>
                            <i class="fas fa-chevron-down" style="font-size: 12px; color: var(--text-muted);"></i>
                        </button>
                        
                        <div class="user-dropdown-menu" id="userDropdownMenu" style="position: absolute; top: 55px; right: 0; width: 260px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 20px; box-shadow: var(--shadow-lg); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s; z-index: 1000;">
                            <div style="padding: 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user" style="font-size: 22px; color: #1a140f;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ Auth::user()->name ?? 'User' }}</div>
                                    <div style="font-size: 11px; color: var(--text-muted);">{{ Auth::user()->email ?? 'user@batiknesia.com' }}</div>
                                </div>
                            </div>
                            <a href="{{ route('user.profile') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-secondary); text-decoration: none; transition: all 0.3s;">
                                <i class="fas fa-user-circle"></i> Profil Saya
                            </a>
                            <a href="{{ route('user.orders') }}" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: var(--text-secondary); text-decoration: none; transition: all 0.3s;">
                                <i class="fas fa-shopping-bag"></i> Pesanan Saya
                            </a>
                            <div style="height: 1px; background: var(--border); margin: 8px 0;"></div>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; display: flex; align-items: center; gap: 12px; padding: 12px 16px; color: #ef4444; background: none; border: none; cursor: pointer; font-size: 14px;">
                                    <i class="fas fa-sign-out-alt"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>

                    <button class="hamburger-btn" onclick="toggleMobileSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <script>
        // Mobile Sidebar
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // User Dropdown
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdownMenu');
            dropdown.classList.toggle('show');
            if (dropdown.classList.contains('show')) {
                dropdown.style.opacity = '1';
                dropdown.style.visibility = 'visible';
                dropdown.style.transform = 'translateY(0)';
            } else {
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-10px)';
            }
        }

        document.addEventListener('click', function(event) {
            const container = document.querySelector('.user-dropdown-container');
            const dropdown = document.getElementById('userDropdownMenu');
            if (container && !container.contains(event.target)) {
                dropdown.classList.remove('show');
                dropdown.style.opacity = '0';
                dropdown.style.visibility = 'hidden';
                dropdown.style.transform = 'translateY(-10px)';
            }
        });

        // Theme Toggle
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

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        const themeIcon = document.getElementById('themeIcon');
        if (savedTheme === 'dark') {
            themeIcon?.classList.remove('fa-moon');
            themeIcon?.classList.add('fa-sun');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
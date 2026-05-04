<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | Batiknesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* LIGHT MODE */
        :root {
            --bg-primary-light: linear-gradient(135deg, #fef9f0 0%, #fff5e6 100%);
            --bg-sidebar-light: linear-gradient(180deg, #1a0f0a 0%, #2c1a10 100%);
            --bg-card-light: rgba(255, 255, 255, 0.96);
            --text-primary-light: #2c1810;
            --text-secondary-light: #5c3d2e;
            --text-sidebar-light: #f5ead8;
            --text-sidebar-muted-light: #e0cba8;
            --accent-light: #c4a747;
            --accent-glow-light: rgba(196, 167, 71, 0.2);
            --border-light: rgba(196, 167, 71, 0.3);
            --shadow-light: 0 8px 32px rgba(0, 0, 0, 0.06);
            --shadow-hover-light: 0 12px 40px rgba(0, 0, 0, 0.12);
            --sidebar-active-light: rgba(196, 167, 71, 0.15);
        }

        /* DARK MODE */
        :root {
            --bg-primary-dark: linear-gradient(135deg, #0a0805 0%, #1a140f 100%);
            --bg-sidebar-dark: linear-gradient(180deg, #0a0805 0%, #1a1208 100%);
            --bg-card-dark: rgba(22, 30, 62, 0.94);
            --text-primary-dark: #f5ead8;
            --text-secondary-dark: #e0cba8;
            --text-sidebar-dark: #f5ead8;
            --text-sidebar-muted-dark: #c4a747;
            --accent-dark: #e6b84e;
            --accent-glow-dark: rgba(230, 184, 78, 0.2);
            --border-dark: rgba(230, 184, 78, 0.2);
            --shadow-dark: 0 8px 32px rgba(0, 0, 0, 0.25);
            --shadow-hover-dark: 0 15px 45px rgba(0, 0, 0, 0.35);
            --sidebar-active-dark: rgba(230, 184, 78, 0.15);
        }

        [data-theme="light"] {
            --bg-primary: var(--bg-primary-light);
            --bg-sidebar: var(--bg-sidebar-light);
            --bg-card: var(--bg-card-light);
            --text-primary: var(--text-primary-light);
            --text-secondary: var(--text-secondary-light);
            --text-sidebar: var(--text-sidebar-light);
            --text-sidebar-muted: var(--text-sidebar-muted-light);
            --accent: var(--accent-light);
            --accent-glow: var(--accent-glow-light);
            --border: var(--border-light);
            --shadow: var(--shadow-light);
            --shadow-hover: var(--shadow-hover-light);
            --sidebar-active: var(--sidebar-active-light);
        }

        [data-theme="dark"] {
            --bg-primary: var(--bg-primary-dark);
            --bg-sidebar: var(--bg-sidebar-dark);
            --bg-card: var(--bg-card-dark);
            --text-primary: var(--text-primary-dark);
            --text-secondary: var(--text-secondary-dark);
            --text-sidebar: var(--text-sidebar-dark);
            --text-sidebar-muted: var(--text-sidebar-muted-dark);
            --accent: var(--accent-dark);
            --accent-glow: var(--accent-glow-dark);
            --border: var(--border-dark);
            --shadow: var(--shadow-dark);
            --shadow-hover: var(--shadow-hover-dark);
            --sidebar-active: var(--sidebar-active-dark);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            transition: all 0.3s;
            overflow-x: hidden;
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
            background: radial-gradient(circle, var(--accent), transparent);
            border-radius: 50%;
            animation: floatParticle linear infinite;
            opacity: 0;
        }
        @keyframes floatParticle {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            5% { opacity: 0.4; }
            85% { opacity: 0.3; }
            100% { transform: translateY(-20vh) rotate(360deg); opacity: 0; }
        }

        /* FLOATING ORBS */
        .floating-orb {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle, var(--accent-glow), transparent);
            filter: blur(40px);
            pointer-events: none;
            z-index: 0;
            animation: floatOrb 18s ease-in-out infinite;
        }
        @keyframes floatOrb {
            0%,100% { transform: translate(0, 0) scale(1); opacity: 0.3; }
            25% { transform: translate(50px, -40px) scale(1.2); opacity: 0.5; }
            50% { transform: translate(-30px, 30px) scale(0.8); opacity: 0.4; }
            75% { transform: translate(40px, 40px) scale(1.1); opacity: 0.5; }
        }

        /* SIDEBAR - LEBIH LEBAR (280px) */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: var(--bg-sidebar);
            backdrop-filter: blur(12px);
            z-index: 100;
            transition: all 0.3s;
            border-right: 1px solid rgba(255,255,255,0.08);
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 4px 0 25px rgba(0,0,0,0.15);
        }
        
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: rgba(255,255,255,0.08); border-radius: 10px; }
        .sidebar::-webkit-scrollbar-thumb { background: var(--accent); border-radius: 10px; }
        
        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 15px;
        }
        .sidebar-header img {
            width: 70px;
            margin-bottom: 15px;
            border-radius: 50%;
            padding: 6px;
            background: rgba(196,167,71,0.15);
            transition: all 0.3s;
            border: 2px solid var(--accent);
        }
        .sidebar-header img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(196,167,71,0.4);
        }
        .sidebar-header h3 {
            color: var(--accent);
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 2px;
        }
        .sidebar-header p {
            color: var(--text-sidebar-muted);
            font-size: 11px;
            opacity: 0.8;
            margin-top: 5px;
        }
        
        .sidebar-menu {
            padding: 10px 16px;
        }
        .sidebar-menu .menu-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-sidebar-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 15px 12px 8px 12px;
            margin-top: 5px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            margin-bottom: 6px;
            color: var(--text-sidebar);
            text-decoration: none;
            border-radius: 14px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }
        .sidebar-menu a i { 
            width: 24px; 
            font-size: 16px; 
            text-align: center;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover {
            background: var(--sidebar-active);
            color: var(--accent);
            transform: translateX(5px);
        }
        .sidebar-menu a.active {
            background: linear-gradient(90deg, var(--accent-glow), transparent);
            color: var(--accent);
            border-left: 3px solid var(--accent);
        }
        .sidebar-menu a.active i {
            color: var(--accent);
        }
        .sidebar-menu a:hover i {
            transform: scale(1.1);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 280px;
            padding: 24px 32px;
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        /* TOP NAVBAR */
        .top-navbar {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 14px 28px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .page-title h2 { 
            font-size: 22px; 
            font-weight: 700; 
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }
        .page-title p { 
            font-size: 12px; 
            color: var(--text-secondary); 
            margin-top: 3px;
        }
        .user-info { display: flex; align-items: center; gap: 20px; }
        .user-name { 
            font-size: 14px; 
            font-weight: 500; 
            color: var(--text-primary);
        }
        .user-avatar {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--accent), #8b7355);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            cursor: default;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .user-avatar i { color: #2c1810; font-size: 18px; }
        .logout-btn {
            background: none;
            border: none;
            color: var(--accent);
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s;
        }
        .logout-btn:hover { transform: scale(1.1); color: var(--accent); }

        /* THEME TOGGLE - DI POJOK KANAN ATAS */
        .theme-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--bg-card);
            padding: 8px 16px;
            border-radius: 40px;
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow);
        }
        .theme-toggle:hover {
            background: var(--accent);
            transform: translateY(-2px);
        }
        .theme-toggle:hover i, .theme-toggle:hover span {
            color: #2c1810;
        }
        .theme-toggle i {
            font-size: 16px;
            color: var(--accent);
            transition: all 0.3s;
        }
        .theme-toggle span {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            transition: all 0.3s;
        }

        /* CARDS */
        .card-admin {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid var(--border);
            padding: 24px;
            transition: all 0.3s;
            box-shadow: var(--shadow);
        }
        .card-admin:hover { 
            transform: translateY(-4px); 
            box-shadow: var(--shadow-hover); 
        }

        .btn-admin {
            background: linear-gradient(135deg, var(--accent), #8b7355);
            border: none;
            padding: 10px 24px;
            border-radius: 40px;
            color: #2c1810;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-admin:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 6px 20px var(--accent-glow); 
            color: white; 
        }

        /* MOBILE */
        .menu-toggle-btn {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 102;
            background: var(--accent);
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 15px; }
            .menu-toggle-btn { display: flex; align-items: center; justify-content: center; }
            .top-navbar { flex-direction: column; gap: 15px; align-items: flex-start; }
            .theme-toggle { align-self: flex-end; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="particles-bg" id="particlesBg"></div>
    <div class="floating-orb" style="width: 350px; height: 350px; top: -150px; right: -150px;"></div>
    <div class="floating-orb" style="width: 250px; height: 250px; bottom: -100px; left: -100px;"></div>

    <!-- MOBILE TOGGLE -->
    <button class="menu-toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars" style="color: #2c1810; font-size: 18px;"></i>
    </button>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logos/logo-batik.png') }}" alt="Logo">
            <h3>BATIKNESIA</h3>
            <p>Administrator Panel</p>
        </div>
        <div class="sidebar-menu">
            <div class="menu-label">Main Navigation</div>
            <a href="{{ route('admin.dashboard') }}" class="@if(Route::is('admin.dashboard')) active @endif">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            
            <div class="menu-label">Management</div>
            <a href="{{ route('admin.orders.index') }}" class="@if(Route::is('admin.orders*')) active @endif">
                <i class="fas fa-shopping-cart"></i> Pesanan
            </a>
            <a href="{{ route('admin.products.index') }}" class="@if(Route::is('admin.products*')) active @endif">
                <i class="fas fa-box"></i> Produk
            </a>
            <a href="{{ route('admin.batik-patterns.index') }}" class="@if(Route::is('admin.batik-patterns*')) active @endif">
                <i class="fas fa-palette"></i> Motif Batik
            </a>
            <a href="{{ route('admin.education.index') }}" class="@if(Route::is('admin.education*')) active @endif">
                <i class="fas fa-graduation-cap"></i> Edukasi
            </a>
            
            <div class="menu-label">Users & Communication</div>
            <a href="{{ route('admin.users.index') }}" class="@if(Route::is('admin.users*')) active @endif">
                <i class="fas fa-users"></i> Pengguna
            </a>
            <a href="{{ route('admin.chats') }}" class="@if(Route::is('admin.chats*')) active @endif">
                <i class="fas fa-comment-dots"></i> Chat User
            </a>
            
            <div class="menu-label">Reports & Analytics</div>
            <a href="{{ route('admin.reports.index') }}" class="@if(Route::is('admin.reports*')) active @endif">
                <i class="fas fa-chart-line"></i> Laporan
            </a>
            <a href="{{ route('admin.tryon-history.index') }}" class="@if(Route::is('admin.tryon-history*')) active @endif">
                <i class="fas fa-history"></i> Try On History
            </a>
            
            <div class="menu-label" style="margin-top: 20px;"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="width:100%; background:none; border:none; text-align:left; padding:12px 16px; color:var(--text-sidebar); cursor:pointer; border-radius:14px; display:flex; align-items:center; gap:12px; font-size:14px; font-weight:500; transition:all 0.3s;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="top-navbar">
            <div class="page-title">
                <h2>@yield('title', 'Dashboard')</h2>
                <p>@yield('subtitle', 'Selamat datang di panel admin Batiknesia')</p>
            </div>
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="theme-toggle" onclick="toggleTheme()">
                    <i class="fas fa-moon" id="themeIcon"></i>
                    <span id="themeText">Dark Mode</span>
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <div class="user-avatar">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <button class="logout-btn" onclick="document.getElementById('logoutForm').submit()">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}">@csrf</form>
                </div>
            </div>
        </div>
        @yield('content')
    </div>

    <script>
        function createParticles() {
            const container = document.getElementById('particlesBg');
            for (let i = 0; i < 180; i++) {
                const p = document.createElement('div');
                p.classList.add('particle');
                p.style.width = (Math.random() * 7 + 2) + 'px';
                p.style.height = p.style.width;
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = Math.random() * 22 + 8 + 's';
                p.style.animationDelay = Math.random() * 15 + 's';
                container.appendChild(p);
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
            const text = document.getElementById('themeText');
            
            if (newTheme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                text.textContent = 'Light Mode';
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                text.textContent = 'Dark Mode';
            }
        }
        
        const saved = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
        if (saved === 'dark') {
            document.getElementById('themeIcon')?.classList.remove('fa-moon');
            document.getElementById('themeIcon')?.classList.add('fa-sun');
            document.getElementById('themeText') && (document.getElementById('themeText').textContent = 'Light Mode');
        } else {
            document.getElementById('themeText') && (document.getElementById('themeText').textContent = 'Dark Mode');
        }
        
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
    @stack('scripts')
</body>
</html>
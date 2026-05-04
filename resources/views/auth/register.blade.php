<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Register | Batiknesia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        /* LIGHT MODE - WARNA CERAH */
        :root {
            --bg-right-light: linear-gradient(145deg, #c4a747 0%, #e8d4a8 50%, #f5e6c8 100%);
            --bg-left-light: rgba(255,255,255,0.85);
            --text-primary-light: #2c1810;
            --text-secondary-light: #6b4423;
            --text-muted-light: #9e7a5c;
            --accent-light: #c4a747;
            --accent-glow-light: rgba(196, 167, 71, 0.35);
            --border-light: rgba(196, 167, 71, 0.25);
            --input-bg-light: rgba(255,255,255,0.95);
            --brand-color-light: #2c1810;
        }

        /* DARK MODE - WARNA GELAP */
        :root {
            --bg-right-dark: linear-gradient(145deg, #0a0805 0%, #1a1208 100%);
            --bg-left-dark: rgba(0,0,0,0.55);
            --text-primary-dark: #f5ead8;
            --text-secondary-dark: #e0cba8;
            --text-muted-dark: #c9a97a;
            --accent-dark: #e6b84e;
            --accent-glow-dark: rgba(230,184,78,0.45);
            --border-dark: rgba(230,184,78,0.3);
            --input-bg-dark: rgba(30,20,12,0.95);
            --brand-color-dark: #f5ead8;
        }

        [data-theme="light"] {
            --bg-right: var(--bg-right-light);
            --bg-left: var(--bg-left-light);
            --text-primary: var(--text-primary-light);
            --text-secondary: var(--text-secondary-light);
            --text-muted: var(--text-muted-light);
            --accent: var(--accent-light);
            --accent-glow: var(--accent-glow-light);
            --border: var(--border-light);
            --input-bg: var(--input-bg-light);
            --brand-color: var(--brand-color-light);
        }

        [data-theme="dark"] {
            --bg-right: var(--bg-right-dark);
            --bg-left: var(--bg-left-dark);
            --text-primary: var(--text-primary-dark);
            --text-secondary: var(--text-secondary-dark);
            --text-muted: var(--text-muted-dark);
            --accent: var(--accent-dark);
            --accent-glow: var(--accent-glow-dark);
            --border: var(--border-dark);
            --input-bg: var(--input-bg-dark);
            --brand-color: var(--brand-color-dark);
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        [data-theme="light"] body {
            background: linear-gradient(135deg, #fef9f0 0%, #fff5e6 100%);
        }

        [data-theme="dark"] body {
            background: linear-gradient(135deg, #0a0805 0%, #1a140f 100%);
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
            border-radius: 50%;
            animation: floatParticle linear infinite;
            opacity: 0;
        }
        .particle.gold {
            background: radial-gradient(circle, #ffd700, #c4a747, transparent);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
            animation: floatGold 12s ease-in-out infinite;
        }
        .particle.white {
            background: radial-gradient(circle, #ffffff, #f0e6d8, transparent);
            animation: floatWhite 14s ease-in-out infinite;
        }
        .particle.glow {
            background: radial-gradient(circle, #fff8e0, #ffd700, transparent);
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.9);
            animation: floatGlow 10s ease-in-out infinite;
        }

        @keyframes floatGold {
            0% { transform: translateY(100vh) rotate(0deg) scale(0.8); opacity: 0; }
            10% { opacity: 0.9; transform: scale(1.2); }
            30% { opacity: 1; }
            70% { opacity: 0.8; }
            100% { transform: translateY(-20vh) rotate(360deg) scale(0.6); opacity: 0; }
        }
        @keyframes floatWhite {
            0% { transform: translateY(100vh) rotate(0deg) scale(0.6); opacity: 0; }
            15% { opacity: 0.7; transform: scale(1); }
            60% { opacity: 0.6; }
            100% { transform: translateY(-20vh) rotate(-360deg) scale(0.4); opacity: 0; }
        }
        @keyframes floatGlow {
            0% { transform: translateY(100vh) rotate(0deg) scale(0.5); opacity: 0; }
            8% { opacity: 1; transform: scale(1.4); box-shadow: 0 0 40px rgba(255, 215, 0, 1); }
            30% { opacity: 0.9; }
            70% { opacity: 0.7; }
            100% { transform: translateY(-20vh) rotate(540deg) scale(0.5); opacity: 0; }
        }

        .twinkle-star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkleStar 4s ease-in-out infinite;
        }
        @keyframes twinkleStar {
            0%,100% { opacity: 0.1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.5); box-shadow: 0 0 10px rgba(255,215,0,0.8); }
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(12px);
            border-radius: 50px;
            padding: 5px;
            display: flex;
            gap: 5px;
            border: 1px solid var(--border);
        }
        .theme-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: transparent;
            color: var(--accent);
            font-size: 16px;
            transition: all 0.3s;
            border: none;
        }
        .theme-btn.active {
            background: var(--accent);
            color: #1a140f;
            box-shadow: 0 0 15px var(--accent-glow);
        }

        .auth-wrapper {
            display: flex;
            width: 100%;
            height: 100vh;
            position: relative;
            z-index: 10;
        }

        /* LEFT PANEL - FORM REGISTER */
        .auth-left {
            flex: 1;
            background: var(--bg-left);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            animation: fadeInLeft 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            border-right: 1px solid var(--border);
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .left-content {
            max-width: 400px;
            width: 100%;
        }

        .form-header-register {
            text-align: center;
            margin-bottom: 25px;
        }
        .form-header-register h2 {
            font-size: 30px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        .form-header-register p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .form-group-register {
            margin-bottom: 18px;
        }
        .form-group-register label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .input-wrapper-register {
            position: relative;
        }
        .input-wrapper-register i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent);
            font-size: 14px;
        }
        .input-wrapper-register input {
            width: 100%;
            padding: 14px 18px 14px 48px;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            font-size: 13px;
            background: var(--input-bg);
            color: var(--text-primary);
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        .input-wrapper-register input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }

        .password-wrapper-register {
            position: relative;
        }
        .password-wrapper-register i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent);
            font-size: 14px;
        }
        .password-wrapper-register input {
            width: 100%;
            padding: 14px 48px 14px 48px;
            border: 1.5px solid var(--border);
            border-radius: 50px;
            font-size: 13px;
            background: var(--input-bg);
            color: var(--text-primary);
            transition: all 0.3s;
        }
        .password-wrapper-register input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }
        .toggle-password-register {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--accent);
            background: none;
            border: none;
            font-size: 14px;
        }

        .btn-submit-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--accent), #a07e2e);
            border: none;
            border-radius: 50px;
            color: #1a140f;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Poppins', sans-serif;
        }
        .btn-submit-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px var(--accent-glow);
            color: white;
            gap: 14px;
        }

        .footer-link-register {
            text-align: center;
            margin-top: 25px;
            padding-top: 22px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-muted);
        }
        .footer-link-register a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .terms-register {
            margin-top: 15px;
            font-size: 11px;
            color: var(--text-muted);
            text-align: center;
        }
        .terms-register a {
            color: var(--accent);
            text-decoration: none;
        }

        .error-alert-register {
            background: rgba(220,53,69,0.15);
            border-left: 3px solid #dc2626;
            backdrop-filter: blur(5px);
            padding: 12px 18px;
            border-radius: 50px;
            margin-bottom: 22px;
            font-size: 12px;
            color: #dc2626;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* RIGHT PANEL - WELCOME (Light Mode: Cerah / Dark Mode: Gelap) */
        .auth-right {
            flex: 1;
            background: var(--bg-right-light: linear-gradient(145deg, #C17A5E 0%, #E09F7E 40%, #E8C49A 100%));
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(2px);
        }
        .auth-right::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 70% 40%, var(--accent-glow), transparent 70%);
            animation: rotateSlow 25s linear infinite;
        }
        @keyframes rotateSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .right-content {
            position: relative;
            z-index: 2;
            max-width: 450px;
            width: 100%;
            text-align: center;
            animation: fadeInRight 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .logo-right {
            margin-bottom: 30px;
            text-align: center;
        }
        .logo-img-register {
            width: 130px;
            height: auto;
            margin: 0 auto 15px;
            display: block;
            filter: drop-shadow(0 0 20px rgba(0,0,0,0.1));
            animation: logoFloat 3s ease-in-out infinite;
        }
        @keyframes logoFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .logo-right h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 4px;
            color: var(--brand-color);
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .logo-right p {
            font-size: 11px;
            color: var(--text-muted);
            letter-spacing: 5px;
        }

        .welcome-text-register {
            margin-bottom: 30px;
            text-align: center;
        }
        .welcome-text-register h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--brand-color);
        }
        .welcome-text-register p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .feature-list-register {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 20px;
        }
        .feature-item-register {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 10px 20px;
            background: rgba(255,255,255,0.5);
            border-radius: 50px;
            backdrop-filter: blur(5px);
            transition: all 0.3s;
            border: 1px solid rgba(196,167,71,0.2);
        }
        .feature-item-register:hover {
            background: rgba(196,167,71,0.15);
            border-color: var(--accent);
            transform: translateX(8px);
        }
        .feature-item-register i {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--accent), rgba(196,167,71,0.3));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
        }
        .feature-item-register span {
            font-size: 13px;
            color: var(--text-primary);
            font-weight: 500;
        }

        @media (max-width: 850px) {
            .auth-wrapper { flex-direction: column; }
            .auth-left, .auth-right { flex: auto; min-height: 50vh; height: auto; }
            body { overflow-y: auto; height: auto; }
        }
    </style>
</head>
<body>
    <div class="particles-bg" id="particlesBg"></div>
    <div class="particles-bg" id="twinkleStarsBg"></div>

    <div class="theme-toggle">
        <button class="theme-btn" id="themeLight" onclick="setTheme('light')"><i class="fas fa-sun"></i></button>
        <button class="theme-btn" id="themeDark" onclick="setTheme('dark')"><i class="fas fa-moon"></i></button>
    </div>

    <div class="auth-wrapper">
        <!-- LEFT PANEL - FORM REGISTER -->
        <div class="auth-left">
            <div class="left-content">
                <div class="form-header-register">
                    <h2>Buat Akun Baru</h2>
                    <p>Isi data diri untuk bergabung</p>
                </div>

                @if ($errors->any())
                    <div class="error-alert-register">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group-register">
                        <label>Nama Lengkap</label>
                        <div class="input-wrapper-register">
                            <i class="fas fa-user"></i>
                            <input type="text" name="name" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="form-group-register">
                        <label>Email</label>
                        <div class="input-wrapper-register">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="email" placeholder="email@example.com" required>
                        </div>
                    </div>

                    <div class="form-group-register">
                        <label>Password</label>
                        <div class="password-wrapper-register">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" placeholder="Buat password" required>
                            <button type="button" class="toggle-password-register" onclick="togglePassword()">
                                <i id="eyeIcon" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group-register">
                        <label>Konfirmasi Password</label>
                        <div class="password-wrapper-register">
                            <i class="fas fa-check-circle"></i>
                            <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Konfirmasi password" required>
                            <button type="button" class="toggle-password-register" onclick="toggleConfirmPassword()">
                                <i id="confirmEyeIcon" class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit-register">
                        <i class="fas fa-user-plus"></i> DAFTAR
                    </button>
                </form>

                <div class="footer-link-register">
                    <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk disini</a></p>
                </div>

                <div class="terms-register">
                    Dengan mendaftar, Anda menyetujui <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL - WELCOME (Light Mode: Cerah / Dark Mode: Gelap) -->
        <div class="auth-right">
            <div class="right-content">
                <div class="logo-right">
                    <img src="{{ asset('images/logos/logo-batik.png') }}" alt="Batiknesia Logo" class="logo-img-register" onerror="this.src='https://placehold.co/130x130?text=Batik'">
                    <h2>BATIKNESIA</h2>
                    <p>WARISAN NUSANTARA</p>
                </div>
                <div class="welcome-text-register">
                    <h3>Bergabung Bersama Kami</h3>
                    <p>Daftar sekarang untuk menjelajahi keindahan batik Nusantara</p>
                </div>
                <div class="feature-list-register">
                    <div class="feature-item-register"><i class="fas fa-magic"></i><span>Virtual Try On dengan AI</span></div>
                    <div class="feature-item-register"><i class="fas fa-graduation-cap"></i><span>Edukasi Motif Batik</span></div>
                    <div class="feature-item-register"><i class="fas fa-store"></i><span>Koleksi Batik Asli</span></div>
                    <div class="feature-item-register"><i class="fas fa-truck"></i><span>Lacak Pesanan Real-time</span></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function createParticles() {
            const container = document.getElementById('particlesBg');
            const types = ['gold', 'white', 'glow'];
            for (let i = 0; i < 400; i++) {
                const p = document.createElement('div');
                p.classList.add('particle', types[Math.floor(Math.random() * types.length)]);
                const size = Math.random() * 12 + 2;
                p.style.width = size + 'px';
                p.style.height = size + 'px';
                p.style.left = Math.random() * 100 + '%';
                p.style.animationDuration = Math.random() * 20 + 8 + 's';
                p.style.animationDelay = Math.random() * 15 + 's';
                container.appendChild(p);
            }
            const starContainer = document.getElementById('twinkleStarsBg');
            for (let i = 0; i < 100; i++) {
                const star = document.createElement('div');
                star.classList.add('twinkle-star');
                star.style.width = (Math.random() * 3 + 1) + 'px';
                star.style.height = star.style.width;
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDelay = Math.random() * 5 + 's';
                starContainer.appendChild(star);
            }
        }
        createParticles();

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            document.getElementById('themeLight').classList.toggle('active', theme === 'light');
            document.getElementById('themeDark').classList.toggle('active', theme === 'dark');
        }
        
        const saved = localStorage.getItem('theme') || 'light';
        setTheme(saved);

        function togglePassword() {
            const pwd = document.getElementById('password');
            const eye = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            } else {
                pwd.type = 'password';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            }
        }

        function toggleConfirmPassword() {
            const confirm = document.getElementById('confirmPassword');
            const eye = document.getElementById('confirmEyeIcon');
            if (confirm.type === 'password') {
                confirm.type = 'text';
                eye.classList.remove('fa-eye-slash');
                eye.classList.add('fa-eye');
            } else {
                confirm.type = 'password';
                eye.classList.remove('fa-eye');
                eye.classList.add('fa-eye-slash');
            }
        }
    </script>
</body>
</html>
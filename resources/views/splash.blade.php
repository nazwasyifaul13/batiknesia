<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Batiknesia | Warisan Batik Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, #0a0806 0%, #1a120b 50%, #0a0806 100%);
            overflow-x: hidden;
            overflow-y: auto;
            position: relative;
            min-height: 100vh;
        }

        /* Canvas Background */
        canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* Pattern Overlay */
        .pattern-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M50 15 L58 35 L78 40 L62 55 L68 75 L50 63 L32 75 L38 55 L22 40 L42 35 Z' fill='none' stroke='%23c4a747' stroke-width='0.8' opacity='0.06'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 80px;
            pointer-events: none;
            z-index: 1;
        }

        /* Gradient Overlay */
        .gradient-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(44,24,16,0.3) 0%, rgba(10,8,6,0.85) 100%);
            z-index: 2;
            pointer-events: none;
        }

        /* Falling Motifs Container */
        .falling-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 3;
            pointer-events: none;
        }

        .falling-motif {
            position: absolute;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0;
            animation: fallSmooth linear forwards;
        }

        @keyframes fallSmooth {
            0% { transform: translateY(-20vh) rotate(0deg); opacity: 0.7; }
            20% { opacity: 0.9; }
            80% { opacity: 0.6; }
            100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
        }

        /* Main Container */
        .splash-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
        }

        .hero-section {
            text-align: center;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* LOGO PERSEGI BESAR - MUNCUL */
        .logo-wrapper-splash {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 50px;
            position: relative;
        }

        .logo-persegi-splash {
            width: 220px;
            height: 220px;
            background: linear-gradient(145deg, #2c1810, #1a0f0a);
            border-radius: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5), inset 0 1px 0 rgba(255,255,255,0.08);
            border: 2px solid rgba(196, 167, 71, 0.5);
            animation: logoPulse 2.5s ease-in-out infinite, logoFloat 4s ease-in-out infinite;
        }

        @media (max-width: 600px) {
            .logo-persegi-splash { width: 160px; height: 160px; border-radius: 40px; }
            .logo-persegi-splash img { width: 100px !important; height: 100px !important; }
            .logo-persegi-splash i { font-size: 70px !important; }
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); box-shadow: 0 30px 60px rgba(196,167,71,0.2); }
        }

        .logo-persegi-splash img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            border-radius: 0;
        }

        .logo-persegi-splash i {
            font-size: 95px;
            color: #c4a747;
        }

        /* Rings */
        .ring-splash-1 {
            position: absolute;
            top: -18px;
            left: -18px;
            right: -18px;
            bottom: -18px;
            border: 2px solid rgba(196, 167, 71, 0.3);
            border-radius: 72px;
            animation: spinClockwise 15s linear infinite;
        }

        .ring-splash-2 {
            position: absolute;
            top: -32px;
            left: -32px;
            right: -32px;
            bottom: -32px;
            border: 1.5px dashed rgba(196, 167, 71, 0.2);
            border-radius: 86px;
            animation: spinCounterClockwise 20s linear infinite;
        }

        .ring-splash-3 {
            position: absolute;
            top: -46px;
            left: -46px;
            right: -46px;
            bottom: -46px;
            border: 0.5px dotted rgba(196, 167, 71, 0.15);
            border-radius: 100px;
            animation: spinClockwise 25s linear infinite;
        }

        @keyframes spinClockwise {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes spinCounterClockwise {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }

        /* Title */
        .title-splash {
            font-family: 'Playfair Display', serif;
            font-size: 72px;
            font-weight: 800;
            background: linear-gradient(135deg, #f4ecd8 0%, #c4a747 35%, #e6d5b8 65%, #c4a747 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 8px;
            margin-bottom: 15px;
            animation: gradientShift 4s linear infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        @media (max-width: 600px) {
            .title-splash { font-size: 44px; letter-spacing: 4px; }
        }

        .subtitle-splash {
            font-size: 14px;
            letter-spacing: 12px;
            color: rgba(196, 167, 71, 0.8);
            margin-bottom: 30px;
            font-weight: 300;
            text-transform: uppercase;
        }

        @media (max-width: 600px) {
            .subtitle-splash { font-size: 9px; letter-spacing: 6px; }
        }

        /* Divider */
        .divider-splash {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }

        .divider-line-splash {
            width: 100px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #c4a747, #c4a747, transparent);
        }

        .divider-diamond-splash {
            width: 10px;
            height: 10px;
            background: #c4a747;
            transform: rotate(45deg);
            animation: diamondGlow 2s ease-in-out infinite;
        }

        @keyframes diamondGlow {
            0%, 100% { opacity: 0.5; transform: rotate(45deg) scale(1); }
            50% { opacity: 1; transform: rotate(45deg) scale(1.2); }
        }

        .description-splash {
            font-size: 16px;
            color: #d4c5a9;
            line-height: 1.8;
            margin-bottom: 45px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* CTA Button */
        .cta-button-splash {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(135deg, rgba(196,167,71,0.15), rgba(139,115,85,0.08));
            backdrop-filter: blur(10px);
            border: 1.5px solid rgba(196, 167, 71, 0.5);
            color: #c4a747;
            padding: 16px 50px;
            border-radius: 60px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 2px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 60px;
        }

        .cta-button-splash:hover {
            background: linear-gradient(135deg, #c4a747, #8b7355);
            color: #2c1810;
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(196,167,71,0.4);
            gap: 22px;
        }

        /* Motif Gallery */
        .motif-gallery-splash {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .motif-card-splash {
            width: 100px;
            padding: 18px 12px;
            background: rgba(196, 167, 71, 0.08);
            border: 1px solid rgba(196, 167, 71, 0.2);
            border-radius: 24px;
            text-align: center;
            transition: all 0.3s ease;
            animation: motifFloat 3s ease-in-out infinite;
        }

        .motif-card-splash:nth-child(1) { animation-delay: 0s; }
        .motif-card-splash:nth-child(2) { animation-delay: 0.2s; }
        .motif-card-splash:nth-child(3) { animation-delay: 0.4s; }
        .motif-card-splash:nth-child(4) { animation-delay: 0.6s; }
        .motif-card-splash:nth-child(5) { animation-delay: 0.8s; }

        @keyframes motifFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        .motif-card-splash:hover {
            background: rgba(196, 167, 71, 0.2);
            border-color: #c4a747;
            transform: scale(1.08) translateY(-5px);
        }

        .motif-card-splash i {
            font-size: 32px;
            color: #c4a747;
            margin-bottom: 10px;
            display: block;
        }

        .motif-card-splash span {
            font-size: 11px;
            color: #d4c5a9;
        }

        /* Stats Section */
        .stats-section-splash {
            display: flex;
            justify-content: center;
            gap: 60px;
            flex-wrap: wrap;
            margin-top: 40px;
            padding-top: 40px;
            border-top: 1px solid rgba(196,167,71,0.15);
        }

        .stat-item-splash {
            text-align: center;
        }

        .stat-number-splash {
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 700;
            color: #c4a747;
        }

        .stat-label-splash {
            font-size: 11px;
            color: rgba(196,167,71,0.6);
            letter-spacing: 2px;
        }

        .footer-splash {
            text-align: center;
            padding: 40px 20px 30px;
            font-size: 11px;
            color: rgba(196, 167, 71, 0.35);
            letter-spacing: 3px;
        }

        @media (max-width: 640px) {
            .motif-card-splash { width: 70px; padding: 12px 8px; }
            .motif-card-splash i { font-size: 24px; }
            .motif-card-splash span { font-size: 9px; }
            .stats-section-splash { gap: 30px; }
            .stat-number-splash { font-size: 26px; }
        }
    </style>
</head>
<body>
    <canvas id="particleCanvas"></canvas>
    <div class="gradient-overlay"></div>
    <div class="pattern-overlay"></div>

    <!-- Falling Motifs -->
    <div class="falling-container" id="fallingContainer"></div>

    <div class="splash-container">
        <div class="hero-section">
            <!-- LOGO PERSEGI BESAR - MUNCUL -->
            <div class="logo-wrapper-splash">
                <div class="logo-persegi-splash">
                    <div class="ring-splash-1"></div>
                    <div class="ring-splash-2"></div>
                    <div class="ring-splash-3"></div>
                    @if(file_exists(public_path('images/logos/logo-batik.png')))
                        <img src="{{ asset('images/logos/logo-batik.png') }}" alt="Batiknesia Logo">
                    @else
                        <i class="fas fa-feather-alt"></i>
                    @endif
                </div>
            </div>

            <h1 class="title-splash">BATIKNESIA</h1>
            <div class="subtitle-splash">WARISAN NUSANTARA</div>

            <div class="divider-splash">
                <span class="divider-line-splash"></span>
                <span class="divider-diamond-splash"></span>
                <span class="divider-line-splash"></span>
            </div>

            <p class="description-splash">
                Melestarikan Keindahan Batik Indonesia<br>
                Dari Nusantara Untuk Dunia
            </p>

            <a href="{{ route('login') }}" class="cta-button-splash">
                <span>MULAI PERJALANAN</span>
                <i class="fas fa-arrow-right"></i>
            </a>

            <!-- Motif Gallery -->
            <div class="motif-gallery-splash">
                <div class="motif-card-splash"><i class="fas fa-palette"></i><span>Motif</span></div>
                <div class="motif-card-splash"><i class="fas fa-tshirt"></i><span>Kain</span></div>
                <div class="motif-card-splash"><i class="fas fa-graduation-cap"></i><span>Edukasi</span></div>
                <div class="motif-card-splash"><i class="fas fa-magic"></i><span>Try On</span></div>
                <div class="motif-card-splash"><i class="fas fa-heart"></i><span>Budaya</span></div>
            </div>

            <!-- Stats -->
            <div class="stats-section-splash">
                <div class="stat-item-splash">
                    <div class="stat-number-splash">100+</div>
                    <div class="stat-label-splash">MOTIF BATIK</div>
                </div>
                <div class="stat-item-splash">
                    <div class="stat-number-splash">25+</div>
                    <div class="stat-label-splash">KOTA ASAL</div>
                </div>
                <div class="stat-item-splash">
                    <div class="stat-number-splash">10K+</div>
                    <div class="stat-label-splash">PENGGUNA</div>
                </div>
            </div>
        </div>

        <div class="footer-splash">
            B A T I K &nbsp; | &nbsp; B U D A Y A &nbsp; | &nbsp; I N D O N E S I A
        </div>
    </div>

    <script>
        // Canvas Particle Animation
        const canvas = document.getElementById('particleCanvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        
        function createParticles() {
            for (let i = 0; i < 150; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    radius: Math.random() * 3 + 1,
                    alpha: Math.random() * 0.4 + 0.05,
                    speedX: (Math.random() - 0.5) * 0.2,
                    speedY: (Math.random() - 0.5) * 0.2 + 0.2,
                });
            }
        }
        
        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            const gradient = ctx.createLinearGradient(0, 0, canvas.width, canvas.height);
            gradient.addColorStop(0, '#0a0806');
            gradient.addColorStop(0.5, '#1a120b');
            gradient.addColorStop(1, '#0a0806');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(196, 167, 71, ${p.alpha})`;
                ctx.fill();
                p.x += p.speedX;
                p.y += p.speedY;
                if (p.x < -10) p.x = canvas.width + 10;
                if (p.x > canvas.width + 10) p.x = -10;
                if (p.y < -10) p.y = canvas.height + 10;
                if (p.y > canvas.height + 10) p.y = -10;
            });
            requestAnimationFrame(drawParticles);
        }
        
        resizeCanvas();
        createParticles();
        drawParticles();
        window.addEventListener('resize', () => { resizeCanvas(); particles = []; createParticles(); });
        
        // Falling Motifs
        const motifs = [
            "url('data:image/svg+xml,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"%3E%3Cpath fill=\"%23c4a747\" opacity=\"0.4\" d=\"M50 20 L60 40 L80 45 L65 60 L70 80 L50 68 L30 80 L35 60 L20 45 L40 40 Z\"/%3E%3C/svg%3E')",
            "url('data:image/svg+xml,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"%3E%3Ccircle fill=\"%23c4a747\" opacity=\"0.3\" cx=\"50\" cy=\"50\" r=\"25\"/%3E%3C/svg%3E')",
            "url('data:image/svg+xml,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"%3E%3Cpath fill=\"%23c4a747\" opacity=\"0.35\" d=\"M30 30 L50 20 L70 30 L80 50 L70 70 L50 80 L30 70 L20 50 Z\"/%3E%3C/svg%3E')"
        ];
        
        const container = document.getElementById('fallingContainer');
        for (let i = 0; i < 60; i++) {
            const motif = document.createElement('div');
            motif.classList.add('falling-motif');
            const size = Math.random() * 60 + 30;
            motif.style.width = size + 'px';
            motif.style.height = size + 'px';
            motif.style.backgroundImage = motifs[Math.floor(Math.random() * motifs.length)];
            motif.style.left = Math.random() * 100 + '%';
            motif.style.animationDuration = Math.random() * 7 + 5 + 's';
            motif.style.animationDelay = Math.random() * 12 + 's';
            container.appendChild(motif);
        }
    </script>
</body>
</html>
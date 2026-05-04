<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Batiknesia | Warisan Batik Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            min-height: 100vh;
            background: linear-gradient(145deg, #2c1810 0%, #4a2c1a 50%, #2c1810 100%);
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            position: relative;
        }
        
        /* Background Pattern */
        .bg-pattern-splash {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c4a747' fill-opacity='0.08'%3E%3Cpath d='M40 10 L45 25 L60 30 L45 35 L40 50 L35 35 L20 30 L35 25 Z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-repeat: repeat;
            pointer-events: none;
            z-index: 0;
        }
        
        /* Falling Motifs */
        .falling-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }
        
        .falling-motif {
            position: absolute;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0;
            animation: fallSmooth linear forwards;
            filter: drop-shadow(0 0 5px rgba(196,167,71,0.3));
        }
        
        @keyframes fallSmooth {
            0% {
                transform: translateY(-20vh) rotate(0deg);
                opacity: 0.6;
            }
            80% {
                opacity: 0.4;
            }
            100% {
                transform: translateY(110vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Main Content */
        .splash-content {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        }
        
        .splash-card {
            text-align: center;
            padding: 50px 40px;
            background: rgba(244, 236, 216, 0.96);
            backdrop-filter: blur(15px);
            border-radius: 48px;
            border: 1px solid rgba(196, 167, 71, 0.4);
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
            max-width: 500px;
            width: 90%;
            animation: fadeInUp 0.8s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-wrapper {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--vintage-dark), #3d2a1a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .logo-wrapper i {
            font-size: 50px;
            color: var(--vintage-gold);
        }
        
        .splash-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 800;
            background: linear-gradient(135deg, #5c4033, #c4a747);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: 2px;
        }
        
        .splash-card p {
            color: #8b7355;
            margin: 15px 0 30px;
            font-size: 16px;
        }
        
        .btn-enter {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #5c4033, #3d2a1a);
            color: white;
            padding: 14px 35px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(196,167,71,0.5);
        }
        
        .btn-enter:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(196,167,71,0.3);
            gap: 15px;
        }
        
        .motif-badge {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 35px;
        }
        
        .motif-badge span {
            width: 35px;
            height: 35px;
            background: rgba(196,167,71,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
        
        @media (max-width: 768px) {
            .splash-card { padding: 35px 25px; }
            .splash-card h1 { font-size: 32px; }
            .btn-enter { padding: 12px 25px; }
        }
    </style>
</head>
<body>
    <div class="bg-pattern-splash"></div>
    
    <div class="falling-container" id="fallingContainer"></div>
    
    <div class="splash-content">
        <div class="splash-card">
            <div class="logo-wrapper">
                <i class="fas fa-feather-alt"></i>
            </div>
            <h1>BATIKNESIA</h1>
            <p>Melestarikan Warisan Budaya Indonesia<br>Melalui Kain Batik Nusantara</p>
            <a href="{{ route('login') }}" class="btn-enter">
                <span>Jelajahi Sekarang</span>
                <i class="fas fa-arrow-right"></i>
            </a>
            <div class="motif-badge">
                <span><i class="fas fa-palette"></i></span>
                <span><i class="fas fa-tshirt"></i></span>
                <span><i class="fas fa-graduation-cap"></i></span>
                <span><i class="fas fa-magic"></i></span>
            </div>
        </div>
    </div>
    
    <script>
        // Create falling batik motifs
        const motifs = [
            "url('https://cdn-icons-png.flaticon.com/512/1895/1895515.png')",
            "url('https://cdn-icons-png.flaticon.com/512/3296/3296919.png')",
            "url('https://cdn-icons-png.flaticon.com/512/4194/4194788.png')"
        ];
        
        for(let i = 0; i < 50; i++) {
            let motif = document.createElement('div');
            motif.classList.add('falling-motif');
            let size = Math.random() * 60 + 25;
            motif.style.width = size + 'px';
            motif.style.height = size + 'px';
            motif.style.backgroundImage = motifs[Math.floor(Math.random() * motifs.length)];
            motif.style.left = Math.random() * 100 + '%';
            motif.style.animationDuration = Math.random() * 6 + 5 + 's';
            motif.style.animationDelay = Math.random() * 10 + 's';
            motif.style.opacity = Math.random() * 0.5 + 0.2;
            document.getElementById('fallingContainer').appendChild(motif);
        }
    </script>
</body>
</html>
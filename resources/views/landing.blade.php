<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Batiknesia | Warisan Batik Nusantara</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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
            --bg-card: #ffffff;
            --bg-navbar: rgba(255, 255, 255, 0.96);
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
            --shadow-xl: 0 24px 60px rgba(0, 0, 0, 0.12);
        }

        [data-theme="dark"] {
            --bg-primary: #0f0c08;
            --bg-secondary: #1a140f;
            --bg-card: #1f1913;
            --bg-navbar: rgba(15, 12, 8, 0.96);
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
            --shadow-xl: 0 24px 60px rgba(0, 0, 0, 0.5);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        html { scroll-behavior: smooth; }

        /* Animated Background Particles */
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
            background: radial-gradient(circle, #c9a03d, transparent);
            border-radius: 50%;
            animation: floatParticle linear infinite;
            opacity: 0;
        }
        @keyframes floatParticle {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.5; }
            90% { opacity: 0.5; }
            100% { transform: translateY(-20vh) rotate(360deg); opacity: 0; }
        }

        /* Gradient Background */
        .gradient-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(201,160,61,0.06) 0%, transparent 40%),
                        radial-gradient(circle at 80% 70%, rgba(160,126,46,0.04) 0%, transparent 40%);
            z-index: 0;
            pointer-events: none;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1300px;
            background: var(--bg-navbar);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 12px 32px;
            border-radius: 80px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }
        .navbar.scrolled { top: 10px; width: 88%; padding: 10px 32px; box-shadow: var(--shadow-md); }
        .nav-container { display: flex; justify-content: space-between; align-items: center; }

        .logo { display: flex; align-items: center; gap: 12px; cursor: pointer; }
        .logo-box { width: 46px; height: 46px; background: transparent; border-radius: 14px; display: flex; align-items: center; justify-content: center; }
        .logo-box img { width: 42px; height: 42px; object-fit: cover; border-radius: 12px; }
        .logo-text { font-family: 'Poppins', sans-serif; font-size: 24px; font-weight: 700; color: var(--accent); letter-spacing: -0.5px; }
        @media (max-width: 480px) { .logo-text { font-size: 18px; } .logo-box { width: 38px; height: 38px; } }

        .nav-links { display: flex; gap: 35px; align-items: center; }
        .nav-link { color: var(--text-secondary); text-decoration: none; font-weight: 500; transition: all 0.3s; position: relative; font-size: 14px; font-family: 'Poppins', sans-serif; }
        .nav-link::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 0; height: 2px; background: linear-gradient(90deg, var(--accent), var(--accent-dark)); transition: width 0.3s; }
        .nav-link:hover::after { width: 100%; }
        .nav-link:hover { color: var(--accent); }
        .btn-login { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color: #1a140f; padding: 8px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s; font-size: 13px; font-family: 'Poppins', sans-serif; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(201,160,61,0.3); color: white; }
        .btn-register-nav { background: transparent; border: 1.5px solid var(--accent); color: var(--accent); padding: 8px 24px; border-radius: 50px; text-decoration: none; font-weight: 600; transition: all 0.3s; font-size: 13px; font-family: 'Poppins', sans-serif; }
        .btn-register-nav:hover { background: var(--accent); color: #1a140f; transform: translateY(-2px); }

        /* Hamburger Menu */
        .hamburger { display: none; background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-primary); width: 42px; height: 42px; border-radius: 12px; transition: all 0.3s; }
        .hamburger:hover { background: var(--accent-light); }
        .mobile-sidebar { position: fixed; top: 0; right: -100%; width: 280px; height: 100%; background: var(--bg-secondary); backdrop-filter: blur(20px); z-index: 1001; transition: right 0.3s ease; padding: 80px 20px 30px; box-shadow: -5px 0 30px rgba(0,0,0,0.1); }
        .mobile-sidebar.open { right: 0; }
        .mobile-sidebar .mobile-nav-link { display: flex; align-items: center; gap: 12px; padding: 14px 16px; color: var(--text-secondary); text-decoration: none; font-size: 15px; font-weight: 500; border-radius: 12px; transition: all 0.3s; }
        .mobile-sidebar .mobile-nav-link:hover { background: var(--accent-light); color: var(--accent); }
        .mobile-sidebar .mobile-divider { height: 1px; background: var(--border); margin: 15px 0; }
        .mobile-close { position: absolute; top: 20px; right: 20px; background: none; border: none; font-size: 24px; cursor: pointer; color: var(--text-primary); }
        .sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; display: none; }
        .sidebar-overlay.active { display: block; }

        @media (max-width: 768px) { .nav-links { display: none; } .hamburger { display: block; } .navbar { padding: 12px 20px; top: 15px; width: 92%; } }

        /* Hero Section - FONT SIMPLE */
        .hero { min-height: 100vh; display: flex; align-items: center; padding: 100px 40px 80px; position: relative; z-index: 2; }
        .hero-container { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 70px; align-items: center; }
        .hero-badge { display: inline-block; background: var(--accent-light); backdrop-filter: blur(10px); padding: 6px 22px; border-radius: 50px; font-size: 12px; color: var(--accent); margin-bottom: 24px; border: 1px solid var(--border); font-weight: 500; letter-spacing: 1px; font-family: 'Poppins', sans-serif; }
        .hero-title { font-family: 'Poppins', sans-serif; font-size: 62px; font-weight: 700; line-height: 1.1; margin-bottom: 24px; color: var(--text-primary); letter-spacing: -0.02em; }
        .hero-title .gradient-text { background: linear-gradient(135deg, var(--accent), #e8c46a, var(--accent-dark)); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .hero-desc { font-size: 16px; color: var(--text-muted); line-height: 1.7; margin-bottom: 40px; font-family: 'Poppins', sans-serif; }
        .hero-buttons { display: flex; gap: 20px; flex-wrap: wrap; }
        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color: #1a140f; padding: 14px 42px; border-radius: 60px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 12px; transition: all 0.3s; font-size: 15px; font-family: 'Poppins', sans-serif; }
        .btn-primary:hover { transform: translateY(-3px); gap: 18px; color: white; }
        .btn-outline { border: 1.5px solid var(--accent); color: var(--accent); padding: 14px 42px; border-radius: 60px; text-decoration: none; font-weight: 600; transition: all 0.3s; background: transparent; font-size: 15px; font-family: 'Poppins', sans-serif; }
        .btn-outline:hover { background: var(--accent); color: #1a140f; transform: translateY(-3px); }

        .hero-carousel-wrapper { width: 100%; max-width: 480px; margin: 0 auto; position: relative; }
        .hero-carousel { position: relative; width: 100%; border-radius: 36px; overflow: hidden; box-shadow: var(--shadow-xl); border: 1px solid var(--border); aspect-ratio: 1/1; }
        .hero-carousel-container { display: flex; transition: transform 0.5s ease; height: 100%; }
        .hero-carousel-slide { flex: 0 0 100%; height: 100%; }
        .hero-carousel-slide img { width: 100%; height: 100%; object-fit: cover; }
        .hero-carousel-btn { position: absolute; top: 50%; transform: translateY(-50%); width: 40px; height: 40px; background: rgba(0,0,0,0.5); backdrop-filter: blur(10px); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: white; z-index: 10; transition: all 0.3s; }
        .hero-carousel-btn:hover { background: var(--accent); color: #1a140f; }
        .hero-carousel-prev { left: 15px; }
        .hero-carousel-next { right: 15px; }
        .hero-carousel-dots { position: absolute; bottom: 15px; left: 0; right: 0; display: flex; justify-content: center; gap: 10px; z-index: 10; }
        .hero-carousel-dot { width: 8px; height: 8px; background: rgba(255,255,255,0.5); border-radius: 50%; cursor: pointer; transition: all 0.3s; }
        .hero-carousel-dot.active { background: var(--accent); width: 24px; border-radius: 10px; }
        .hero-empty-image { width: 100%; max-width: 480px; margin: 0 auto; background: linear-gradient(145deg, var(--accent-light), var(--bg-card)); border-radius: 36px; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); color: var(--text-muted); font-size: 14px; text-align: center; font-family: 'Poppins', sans-serif; }

        @media (max-width: 1024px) { .hero-container { grid-template-columns: 1fr; text-align: center; } .hero-buttons { justify-content: center; } .hero-title { font-size: 48px; } .hero-carousel-wrapper, .hero-empty-image { max-width: 380px; } }
        @media (max-width: 768px) { .hero { padding: 100px 20px 60px; } .hero-title { font-size: 36px; } .btn-primary, .btn-outline { padding: 10px 28px; font-size: 13px; } .hero-carousel-wrapper, .hero-empty-image { max-width: 280px; } .hero-carousel-btn { width: 30px; height: 30px; font-size: 12px; } }

        /* Stats - ANGKA JELAS */
        .stats { padding: 70px 40px; background: var(--bg-secondary); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .stats-grid { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; text-align: center; }
        .stat-number { font-family: 'Poppins', sans-serif; font-size: 52px; font-weight: 800; color: var(--accent); margin-bottom: 10px; letter-spacing: -1px; }
        .stat-label { font-size: 13px; color: var(--text-muted); letter-spacing: 2px; text-transform: uppercase; font-weight: 500; font-family: 'Poppins', sans-serif; }
        @media (max-width: 768px) { .stats { padding: 50px 20px; } .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 30px; } .stat-number { font-size: 42px; } }
        @media (max-width: 480px) { .stats-grid { grid-template-columns: 1fr; } }

        /* Features */
        .features { padding: 100px 40px; background: var(--bg-primary); }
        .section-title { text-align: center; font-family: 'Poppins', sans-serif; font-size: 42px; font-weight: 700; margin-bottom: 16px; color: var(--text-primary); letter-spacing: -0.02em; }
        .section-subtitle { text-align: center; color: var(--text-muted); font-size: 16px; margin-bottom: 70px; max-width: 600px; margin-left: auto; margin-right: auto; font-family: 'Poppins', sans-serif; }
        .section-title span { color: var(--accent); position: relative; }
        .section-title span::after { content: ''; position: absolute; bottom: -10px; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, var(--accent), transparent); }
        .features-grid { max-width: 1400px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 30px; }
        .feature-card { background: var(--bg-card); backdrop-filter: blur(10px); border: 1px solid var(--border); border-radius: 24px; padding: 40px 28px; text-align: center; transition: all 0.4s; box-shadow: var(--shadow-sm); }
        .feature-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-lg); border-color: var(--accent); }
        .feature-icon { width: 75px; height: 75px; background: linear-gradient(145deg, var(--accent-light), rgba(160,126,46,0.05)); border-radius: 24px; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; transition: all 0.3s; }
        .feature-card:hover .feature-icon { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); }
        .feature-card:hover .feature-icon i { color: #1a140f; }
        .feature-icon i { font-size: 36px; color: var(--accent); transition: all 0.3s; }
        .feature-card h3 { font-size: 22px; font-weight: 600; color: var(--text-primary); margin-bottom: 12px; font-family: 'Poppins', sans-serif; }
        .feature-card p { color: var(--text-muted); font-size: 14px; line-height: 1.6; font-family: 'Poppins', sans-serif; }
        @media (max-width: 1024px) { .features-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) { .features { padding: 60px 20px; } .section-title { font-size: 32px; } .features-grid { grid-template-columns: 1fr; } }

        /* Products Carousel */
        .products-carousel { padding: 100px 40px 120px; background: var(--bg-secondary); }
        .carousel-header { text-align: center; margin-bottom: 60px; }
        .carousel-container { position: relative; max-width: 1400px; margin: 0 auto; }
        .carousel-wrapper { overflow-x: auto; scroll-snap-type: x mandatory; scroll-behavior: smooth; -webkit-overflow-scrolling: touch; scrollbar-width: none; cursor: grab; padding: 10px 0 20px; }
        .carousel-wrapper:active { cursor: grabbing; }
        .carousel-wrapper::-webkit-scrollbar { display: none; }
        .carousel-track { display: flex; gap: 28px; padding: 10px 15px; }
        .carousel-slide { flex: 0 0 280px; scroll-snap-align: start; }
        @media (min-width: 1200px) { .carousel-slide { flex: 0 0 300px; } }
        @media (max-width: 768px) { .carousel-slide { flex: 0 0 260px; } }
        .product-card-carousel { background: var(--bg-card); border-radius: 20px; overflow: hidden; transition: all 0.35s ease; cursor: pointer; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03); border: 1px solid var(--border); height: 100%; display: flex; flex-direction: column; }
        .product-card-carousel:hover { transform: translateY(-6px); box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.15); border-color: var(--accent); }
        .product-img-carousel { height: 230px; background: linear-gradient(145deg, #f3ede5, #ebe3d8); display: flex; align-items: center; justify-content: center; overflow: hidden; }
        [data-theme="dark"] .product-img-carousel { background: linear-gradient(145deg, #251f18, #1f1913); }
        .product-img-carousel img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
        .product-card-carousel:hover .product-img-carousel img { transform: scale(1.03); }
        .product-img-carousel i { font-size: 70px; color: var(--accent); opacity: 0.6; }
        .product-info-carousel { padding: 18px 16px 20px; flex: 1; display: flex; flex-direction: column; }
        .product-title-carousel { font-size: 17px; font-weight: 600; color: var(--text-primary); margin-bottom: 6px; font-family: 'Poppins', sans-serif; }
        .product-desc-carousel { font-size: 12px; color: var(--text-muted); line-height: 1.45; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; font-family: 'Poppins', sans-serif; }
        .product-price-carousel { font-size: 20px; font-weight: 700; color: var(--accent); margin: 6px 0 12px; font-family: 'Poppins', sans-serif; }
        .product-btn-carousel { display: inline-block; background: transparent; border: 1.5px solid var(--accent); color: var(--accent); padding: 9px 16px; border-radius: 40px; font-size: 12px; font-weight: 500; transition: all 0.25s ease; width: 100%; text-align: center; cursor: pointer; margin-top: auto; font-family: 'Poppins', sans-serif; }
        .product-btn-carousel:hover { background: var(--accent); color: #1f1a15; border-color: transparent; }
        .carousel-nav { display: flex; justify-content: center; gap: 16px; margin-top: 40px; }
        .carousel-btn { width: 46px; height: 46px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; color: var(--accent); font-size: 18px; }
        .carousel-btn:hover { background: var(--accent); color: #1a140f; transform: scale(1.05); border-color: transparent; }
        .carousel-indicators { display: flex; justify-content: center; gap: 10px; margin-top: 25px; }
        .carousel-dot { width: 8px; height: 8px; background: var(--border); border-radius: 50%; cursor: pointer; transition: all 0.3s ease; }
        .carousel-dot.active { background: var(--accent); width: 24px; border-radius: 10px; }
        @media (max-width: 768px) { .products-carousel { padding: 60px 20px 80px; } .carousel-header .section-title { font-size: 32px; } .carousel-btn { width: 38px; height: 38px; font-size: 14px; } .product-img-carousel { height: 200px; } }

        /* Testimonials */
        .testimonials { padding: 100px 40px; background: var(--bg-primary); overflow: hidden; }
        .testimonials-container { max-width: 1400px; margin: 0 auto; position: relative; }
        .testimonials-track { display: flex; transition: transform 0.5s ease; gap: 30px; }
        .testimonial-card { flex: 0 0 350px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 24px; padding: 35px 28px; text-align: center; transition: all 0.3s; }
        .testimonial-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-md); border-color: var(--accent); }
        .testimonial-stars { margin-bottom: 15px; color: #fbbf24; font-size: 14px; letter-spacing: 3px; }
        .testimonial-text { color: var(--text-secondary); font-style: italic; margin-bottom: 20px; line-height: 1.6; font-size: 14px; font-family: 'Poppins', sans-serif; }
        .testimonial-name { font-weight: 600; color: var(--accent); margin-top: 10px; font-family: 'Poppins', sans-serif; }
        .testimonial-role { font-size: 12px; color: var(--text-muted); font-family: 'Poppins', sans-serif; }
        .testimonials-nav { display: flex; justify-content: center; gap: 16px; margin-top: 40px; }
        .testimonials-btn { width: 46px; height: 46px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; color: var(--accent); font-size: 18px; }
        .testimonials-btn:hover { background: var(--accent); color: #1a140f; }
        .testimonials-dots { display: flex; justify-content: center; gap: 12px; margin-top: 25px; }
        .testimonial-dot { width: 8px; height: 8px; background: var(--border); border-radius: 50%; cursor: pointer; transition: all 0.3s; }
        .testimonial-dot.active { background: var(--accent); width: 24px; border-radius: 10px; }
        @media (max-width: 768px) { .testimonials { padding: 60px 20px; } .testimonial-card { flex: 0 0 280px; padding: 25px 20px; } .testimonials-btn { width: 38px; height: 38px; font-size: 14px; } }

        /* CTA */
        .cta { padding: 100px 40px; background: linear-gradient(135deg, #1a140f, #0f0c08); text-align: center; }
        .cta-card { max-width: 700px; margin: 0 auto; color: white; }
        .cta-card h2 { font-family: 'Poppins', sans-serif; font-size: 42px; font-weight: 600; margin-bottom: 16px; letter-spacing: -0.02em; }
        .cta-card p { font-size: 16px; margin-bottom: 32px; opacity: 0.9; font-family: 'Poppins', sans-serif; }
        .btn-cta { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color: #1a140f; padding: 14px 42px; border-radius: 50px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; font-family: 'Poppins', sans-serif; }
        .btn-cta:hover { transform: translateY(-3px); gap: 15px; color: white; }
        @media (max-width: 600px) { .cta { padding: 60px 20px; } .cta-card h2 { font-size: 28px; } }

        /* Footer */
        .footer { background: #1a140f; padding: 60px 40px 30px; }
        .footer-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; }
        .footer-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .footer-logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .footer-logo-icon i { font-size: 18px; color: #1a140f; }
        .footer-logo span { font-size: 18px; font-weight: 700; color: var(--accent); font-family: 'Poppins', sans-serif; }
        .footer-about { color: #a0825a; font-size: 13px; line-height: 1.6; font-family: 'Poppins', sans-serif; }
        .footer-title { font-size: 16px; font-weight: 600; color: var(--accent); margin-bottom: 20px; font-family: 'Poppins', sans-serif; }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: #a0825a; text-decoration: none; font-size: 13px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; font-family: 'Poppins', sans-serif; }
        .footer-links a:hover { color: var(--accent); transform: translateX(6px); }
        .footer-bottom { text-align: center; padding-top: 40px; margin-top: 40px; border-top: 1px solid rgba(255,255,255,0.1); color: #a0825a; font-size: 12px; font-family: 'Poppins', sans-serif; }
        @media (max-width: 1024px) { .footer-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .footer { padding: 40px 20px 20px; } .footer-grid { grid-template-columns: 1fr; gap: 30px; } }

        .theme-toggle-landing { position: fixed; bottom: 25px; left: 25px; z-index: 1000; background: var(--bg-card); backdrop-filter: blur(20px); border: 1px solid var(--border); border-radius: 60px; padding: 6px; display: flex; gap: 10px; box-shadow: var(--shadow-md); }
        .theme-btn-landing { width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: none; background: transparent; color: var(--text-muted); font-size: 18px; transition: all 0.3s; }
        .theme-btn-landing.active { background: var(--accent); color: #1a140f; box-shadow: 0 0 12px rgba(201,160,61,0.5); }
        @media (max-width: 768px) { .theme-toggle-landing { bottom: 15px; left: 15px; } .theme-btn-landing { width: 36px; height: 36px; font-size: 15px; } }

        .back-to-top { position: fixed; bottom: 30px; right: 30px; width: 46px; height: 46px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 100; opacity: 0; visibility: hidden; transition: all 0.3s; }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { transform: translateY(-3px); background: var(--accent-dark); }
        .back-to-top i { color: #1a140f; font-size: 20px; }
    </style>
</head>
<body>
    <div class="particles-bg" id="particlesBg"></div>
    <div class="gradient-bg"></div>

    <div class="theme-toggle-landing">
        <button class="theme-btn-landing" id="themeLight" onclick="setTheme('light')"><i class="fas fa-sun"></i></button>
        <button class="theme-btn-landing" id="themeDark" onclick="setTheme('dark')"><i class="fas fa-moon"></i></button>
    </div>

    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>

    <div class="mobile-sidebar" id="mobileSidebar">
        <button class="mobile-close" onclick="closeMobileSidebar()"><i class="fas fa-times"></i></button>
        <a href="#home" class="mobile-nav-link" onclick="closeMobileSidebar()"><i class="fas fa-home"></i> Beranda</a>
        <a href="#features" class="mobile-nav-link" onclick="closeMobileSidebar()"><i class="fas fa-magic"></i> Fitur</a>
        <a href="#productsCarousel" class="mobile-nav-link" onclick="closeMobileSidebar()"><i class="fas fa-tshirt"></i> Koleksi</a>
        <a href="#testimonials" class="mobile-nav-link" onclick="closeMobileSidebar()"><i class="fas fa-star"></i> Testimoni</a>
        <div class="mobile-divider"></div>
        <a href="{{ route('register') }}" class="mobile-nav-link" onclick="closeMobileSidebar()"><i class="fas fa-user-plus"></i> Daftar</a>
        <a href="{{ route('login') }}" class="mobile-nav-link" onclick="closeMobileSidebar()"><i class="fas fa-sign-in-alt"></i> Masuk</a>
    </div>

    <div class="back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="fas fa-arrow-up"></i>
    </div>

    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="logo" onclick="window.location.href='#home'">
                <div class="logo-box">
                    <img src="{{ asset('images/logos/logo-batik.png') }}" alt="Logo" onerror="this.src='https://placehold.co/42x42/c9a03d/1a140f?text=B'">
                </div>
                <span class="logo-text">BATIKNESIA</span>
            </div>
            <div class="nav-links">
                <a href="#home" class="nav-link">Beranda</a>
                <a href="#features" class="nav-link">Fitur</a>
                <a href="#productsCarousel" class="nav-link">Koleksi</a>
                <a href="#testimonials" class="nav-link">Testimoni</a>
                <a href="{{ route('register') }}" class="btn-register-nav">Daftar</a>
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            </div>
            <button class="hamburger" id="hamburgerBtn" onclick="toggleMobileSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <section id="home" class="hero">
        <div class="hero-container">
            <div data-aos="fade-up" data-aos-duration="800">
                <div class="hero-badge">✦ Warisan Nusantara ✦</div>
                <h1 class="hero-title"><span class="gradient-text">Batik</span> Indonesia<br>Identitas <span class="gradient-text">Bangsa</span></h1>
                <p class="hero-desc">Jelajahi keindahan batik Nusantara dengan teknologi virtual try on, edukasi mendalam, dan koleksi batik asli dari berbagai daerah di Indonesia.</p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang <i class="fas fa-arrow-right"></i></a>
                    <a href="#productsCarousel" class="btn-outline">Lihat Koleksi</a>
                </div>
            </div>

            @php
                $heroImages = [];
                if(isset($products) && $products->count() > 0) {
                    foreach($products as $product) {
                        if($product->image && file_exists(public_path($product->image))) {
                            $heroImages[] = $product->image;
                        }
                    }
                }
            @endphp

            @if(count($heroImages) > 0)
            <div class="hero-carousel-wrapper">
                <div class="hero-carousel" id="heroCarousel">
                    <div class="hero-carousel-container" id="heroCarouselContainer">
                        @foreach($heroImages as $img)
                        <div class="hero-carousel-slide">
                            <img src="{{ asset($img) }}" alt="Batik Indonesia">
                        </div>
                        @endforeach
                    </div>
                    @if(count($heroImages) > 1)
                    <div class="hero-carousel-btn hero-carousel-prev" id="heroCarouselPrev"><i class="fas fa-chevron-left"></i></div>
                    <div class="hero-carousel-btn hero-carousel-next" id="heroCarouselNext"><i class="fas fa-chevron-right"></i></div>
                    <div class="hero-carousel-dots" id="heroCarouselDots"></div>
                    @endif
                </div>
            </div>
            @else
            <div class="hero-empty-image">
                <i class="fas fa-camera" style="font-size: 48px; margin-bottom: 15px;"></i><br>
                Belum ada gambar produk<br>
                <span style="font-size: 12px;">Silakan tambahkan produk di dashboard admin</span>
            </div>
            @endif
        </div>
    </section>

    <div class="stats">
        <div class="stats-grid">
            <div class="stat-item"><div class="stat-number">100+</div><div class="stat-label">MOTIF BATIK</div></div>
            <div class="stat-item"><div class="stat-number">25+</div><div class="stat-label">KOTA ASAL</div></div>
            <div class="stat-item"><div class="stat-number">10K+</div><div class="stat-label">PENGGUNA</div></div>
            <div class="stat-item"><div class="stat-number">500+</div><div class="stat-label">PRODUK</div></div>
        </div>
    </div>

    <section id="features" class="features">
        <h2 class="section-title" data-aos="fade-up">Layanan <span>Unggulan</span></h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Nikmati berbagai layanan terbaik dari Batiknesia</p>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="0">
                <div class="feature-icon"><i class="fas fa-magic"></i></div>
                <h3>Virtual Try On</h3>
                <p>Coba motif batik secara virtual dengan teknologi AI</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Edukasi Batik</h3>
                <p>Pelajari filosofi di balik setiap motif batik</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-store"></i></div>
                <h3>Toko Batik</h3>
                <p>Dapatkan produk batik asli berkualitas</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon"><i class="fas fa-truck"></i></div>
                <h3>Lacak Pesanan</h3>
                <p>Pantau status pesanan Anda dengan mudah</p>
            </div>
        </div>
    </section>

    <section id="productsCarousel" class="products-carousel">
        <div class="carousel-header" data-aos="fade-up">
            <h2 class="section-title">Koleksi <span>Batik</span></h2>
            <p class="section-subtitle"> Geser ke kanan atau kiri untuk melihat koleksi batik pilihan</p>
        </div>
        <div class="carousel-container">
            <div class="carousel-wrapper" id="carouselWrapper">
                <div class="carousel-track" id="carouselTrack">
                    @forelse($products ?? [] as $product)
                    <div class="carousel-slide">
                        <div class="product-card-carousel" onclick="redirectToLogin()">
                            <div class="product-img-carousel">
                                @if($product->image && file_exists(public_path($product->image)))
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <i class="fas fa-tshirt"></i>
                                @endif
                            </div>
                            <div class="product-info-carousel">
                                <h3 class="product-title-carousel">{{ $product->name }}</h3>
                                <p class="product-desc-carousel">{{ Str::limit($product->description ?? 'Filosofi dan makna mendalam dari batik Nusantara', 60) }}</p>
                                <div class="product-price-carousel">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <button class="product-btn-carousel">Lihat Detail →</button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 60px;">
                        <i class="fas fa-box-open"></i>
                        <p>Belum ada produk. Silakan tambahkan produk di dashboard admin.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            <div class="carousel-nav">
                <button class="carousel-btn" id="carouselPrev"><i class="fas fa-chevron-left"></i></button>
                <button class="carousel-btn" id="carouselNext"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="carousel-indicators" id="carouselIndicators"></div>
        </div>
    </section>

    <section id="testimonials" class="testimonials">
        <h2 class="section-title" data-aos="fade-up">Apa Kata <span>Mereka?</span></h2>
        <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Testimoni dari para pecinta batik</p>
        <div class="testimonials-container">
            <div class="testimonials-track" id="testimonialsTrack">
                <div class="testimonial-card"><div class="testimonial-stars">★★★★★</div><p class="testimonial-text">"Virtual try on-nya luar biasa! Saya bisa melihat motif batik di foto saya sebelum membeli."</p><p class="testimonial-name">Siti Rahayu</p><p class="testimonial-role">Pecinta Batik, Jakarta</p></div>
                <div class="testimonial-card"><div class="testimonial-stars">★★★★★</div><p class="testimonial-text">"Edukasi batiknya lengkap banget. Sekarang saya lebih paham filosofi batik."</p><p class="testimonial-name">Budi Santoso</p><p class="testimonial-role">Kolektor Batik, Surabaya</p></div>
                <div class="testimonial-card"><div class="testimonial-stars">★★★★★</div><p class="testimonial-text">"Produk batiknya berkualitas, pengiriman cepat, pelayanan ramah. Recommended!"</p><p class="testimonial-name">Dewi Lestari</p><p class="testimonial-role">Designer Fashion, Bandung</p></div>
                <div class="testimonial-card"><div class="testimonial-stars">★★★★★</div><p class="testimonial-text">"Pengiriman super cepat, batiknya original dan motifnya bagus banget!"</p><p class="testimonial-name">Andi Wijaya</p><p class="testimonial-role">Pengusaha, Semarang</p></div>
                <div class="testimonial-card"><div class="testimonial-stars">★★★★★</div><p class="testimonial-text">"Luar biasa! Batiknya halus dan warnanya vivid. Saya suka banget!"</p><p class="testimonial-name">Rina Kartika</p>                    <p class="testimonial-role">Ibu Rumah Tangga, Bandung</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">★★★★★</div>
                    <p class="testimonial-text">"Pelayanan customer service sangat responsif. Terima kasih Batiknesia!"</p>
                    <p class="testimonial-name">Fajar Pratama</p>
                    <p class="testimonial-role">Karyawan Swasta, Surabaya</p>
                </div>
            </div>
            <div class="testimonials-nav">
                <button class="testimonials-btn" id="testimonialsPrev"><i class="fas fa-chevron-left"></i></button>
                <button class="testimonials-btn" id="testimonialsNext"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="testimonials-dots" id="testimonialsDots"></div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-card" data-aos="zoom-in">
            <h2>Mulai Perjalananmu</h2>
            <p>Bergabunglah dengan ribuan pecinta batik di Indonesia</p>
            <a href="{{ route('register') }}" class="btn-cta">Daftar Sekarang <i class="fas fa-arrow-right"></i></a>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-grid">
            <div>
                <div class="footer-logo">
                    <div class="footer-logo-icon"><i class="fas fa-feather-alt"></i></div>
                    <span>Batiknesia</span>
                </div>
                <p class="footer-about">Melestarikan keindahan batik Indonesia dari Nusantara untuk dunia.</p>
            </div>
            <div>
                <h4 class="footer-title">Jelajahi</h4>
                <ul class="footer-links">
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                    <li><a href="#features"><i class="fas fa-chevron-right"></i> Fitur</a></li>
                    <li><a href="#productsCarousel"><i class="fas fa-chevron-right"></i> Koleksi</a></li>
                    <li><a href="#testimonials"><i class="fas fa-chevron-right"></i> Testimoni</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-title">Layanan</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Virtual Try On</a></li>
                    <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Edukasi Batik</a></li>
                    <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Toko Batik</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-title">Kontak</h4>
                <ul class="footer-links">
                    <li><i class="fas fa-envelope"></i> info@batiknesia.com</li>
                    <li><i class="fas fa-phone"></i> +62 812 3456 7890</li>
                    <li><i class="fas fa-map-marker-alt"></i> Yogyakarta</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Batiknesia. All rights reserved. Warisan Budaya Indonesia</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 100, easing: 'ease-out' });

        // Create Particles
        function createParticles() {
            const container = document.getElementById('particlesBg');
            for (let i = 0; i < 120; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDuration = Math.random() * 15 + 8 + 's';
                particle.style.animationDelay = Math.random() * 10 + 's';
                container.appendChild(particle);
            }
        }
        createParticles();

        function toggleMobileSidebar() {
            document.getElementById('mobileSidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('active');
            document.body.style.overflow = document.getElementById('mobileSidebar').classList.contains('open') ? 'hidden' : '';
        }

        function closeMobileSidebar() {
            document.getElementById('mobileSidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            const backToTop = document.getElementById('backToTop');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                backToTop.classList.add('show');
            } else {
                navbar.classList.remove('scrolled');
                backToTop.classList.remove('show');
            }
        });

        function setTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('landingTheme', theme);
            document.getElementById('themeLight').classList.toggle('active', theme === 'light');
            document.getElementById('themeDark').classList.toggle('active', theme === 'dark');
        }
        const saved = localStorage.getItem('landingTheme') || 'light';
        setTheme(saved);

        function redirectToLogin() {
            Swal.fire({
                title: '✨ Login Diperlukan',
                text: 'Silakan login terlebih dahulu untuk melihat detail produk',
                icon: 'info',
                background: document.documentElement.getAttribute('data-theme') === 'dark' ? '#1a140f' : '#fefaf5',
                color: document.documentElement.getAttribute('data-theme') === 'dark' ? '#f5ead8' : '#2c1a10',
                confirmButtonColor: '#c9a03d',
                showCancelButton: true,
                confirmButtonText: 'Login Sekarang',
                cancelButtonText: 'Nanti Saja'
            }).then((result) => { if (result.isConfirmed) window.location.href = '{{ route("login") }}'; });
        }

        // Hero Carousel
        const heroContainer = document.getElementById('heroCarouselContainer');
        const heroPrev = document.getElementById('heroCarouselPrev');
        const heroNext = document.getElementById('heroCarouselNext');
        const heroDotsContainer = document.getElementById('heroCarouselDots');
        let heroSlides = [], heroCurrentIndex = 0, heroAutoInterval;
        function initHeroCarousel() {
            if (!heroContainer) return;
            heroSlides = Array.from(document.querySelectorAll('.hero-carousel-slide'));
            if (heroSlides.length <= 1) return;
            if (heroDotsContainer) {
                heroDotsContainer.innerHTML = '';
                heroSlides.forEach((_, i) => {
                    const dot = document.createElement('div');
                    dot.classList.add('hero-carousel-dot');
                    if (i === 0) dot.classList.add('active');
                    dot.addEventListener('click', () => goToHeroSlide(i));
                    heroDotsContainer.appendChild(dot);
                });
            }
            updateHeroCarousel();
            startHeroAutoPlay();
        }
        function updateHeroCarousel() { if (!heroContainer || heroSlides.length === 0) return; heroContainer.style.transform = `translateX(-${heroCurrentIndex * 100}%)`; document.querySelectorAll('.hero-carousel-dot').forEach((dot, i) => { dot.classList.toggle('active', i === heroCurrentIndex); }); }
        function goToHeroSlide(index) { if (index < 0) index = heroSlides.length - 1; if (index >= heroSlides.length) index = 0; heroCurrentIndex = index; updateHeroCarousel(); restartHeroAutoPlay(); }
        function nextHeroSlide() { goToHeroSlide(heroCurrentIndex + 1); }
        function prevHeroSlide() { goToHeroSlide(heroCurrentIndex - 1); }
        function startHeroAutoPlay() { if (heroAutoInterval) clearInterval(heroAutoInterval); heroAutoInterval = setInterval(() => nextHeroSlide(), 4000); }
        function restartHeroAutoPlay() { if (heroAutoInterval) clearInterval(heroAutoInterval); heroAutoInterval = setInterval(() => nextHeroSlide(), 4000); }
        if (heroPrev) heroPrev.addEventListener('click', () => { prevHeroSlide(); restartHeroAutoPlay(); });
        if (heroNext) heroNext.addEventListener('click', () => { nextHeroSlide(); restartHeroAutoPlay(); });
        setTimeout(initHeroCarousel, 300);

        // Main Products Carousel
        const wrapper = document.getElementById('carouselWrapper');
        const prevBtn = document.getElementById('carouselPrev');
        const nextBtn = document.getElementById('carouselNext');
        const indicatorsContainer = document.getElementById('carouselIndicators');
        let slides = [], currentIndex = 0, slideWidth = 0, autoPlayInterval;
        function updateSlides() {
            slides = Array.from(document.querySelectorAll('.carousel-slide'));
            if (slides.length === 0) return;
            if (indicatorsContainer) {
                indicatorsContainer.innerHTML = '';
                slides.forEach((_, index) => { const dot = document.createElement('div'); dot.classList.add('carousel-dot'); if (index === currentIndex) dot.classList.add('active'); dot.addEventListener('click', () => goToSlide(index)); indicatorsContainer.appendChild(dot); });
            }
            updateSlideWidth(); goToSlide(currentIndex, false);
        }
        function updateSlideWidth() { if (slides.length === 0) return; slideWidth = slides[0].offsetWidth + 28; }
        function goToSlide(index, smooth = true) { if (slides.length === 0) return; if (index < 0) index = 0; if (index >= slides.length) index = slides.length - 1; currentIndex = index; if (wrapper) wrapper.scrollTo({ left: currentIndex * slideWidth, behavior: smooth ? 'smooth' : 'auto' }); document.querySelectorAll('.carousel-dot').forEach((dot, i) => { dot.classList.toggle('active', i === currentIndex); }); }
        function nextSlide() { if (currentIndex < slides.length - 1) goToSlide(currentIndex + 1); else goToSlide(0); }
        function prevSlide() { if (currentIndex > 0) goToSlide(currentIndex - 1); else goToSlide(slides.length - 1); }
        function startAutoPlay() { if (autoPlayInterval) clearInterval(autoPlayInterval); autoPlayInterval = setInterval(() => nextSlide(), 5000); }
        if (prevBtn && nextBtn) { prevBtn.addEventListener('click', () => { prevSlide(); startAutoPlay(); }); nextBtn.addEventListener('click', () => { nextSlide(); startAutoPlay(); }); }
        if (wrapper) {
            wrapper.addEventListener('scroll', () => { if (slides.length === 0) return; const scrollPos = wrapper.scrollLeft; const newIndex = Math.round(scrollPos / slideWidth); if (newIndex !== currentIndex && newIndex >= 0 && newIndex < slides.length) { currentIndex = newIndex; document.querySelectorAll('.carousel-dot').forEach((dot, i) => { dot.classList.toggle('active', i === currentIndex); }); } });
            let isDown = false, startX, scrollLeft;
            wrapper.addEventListener('mousedown', (e) => { isDown = true; wrapper.style.cursor = 'grabbing'; startX = e.pageX - wrapper.offsetLeft; scrollLeft = wrapper.scrollLeft; });
            wrapper.addEventListener('mouseleave', () => { isDown = false; wrapper.style.cursor = 'grab'; });
            wrapper.addEventListener('mouseup', () => { isDown = false; wrapper.style.cursor = 'grab'; });
            wrapper.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - wrapper.offsetLeft; const walk = (x - startX) * 1.5; wrapper.scrollLeft = scrollLeft - walk; });
        }

        // Testimonials Carousel
        const testimonialsTrack = document.getElementById('testimonialsTrack');
        const testimonialsPrev = document.getElementById('testimonialsPrev');
        const testimonialsNext = document.getElementById('testimonialsNext');
        const testimonialsDots = document.getElementById('testimonialsDots');
        let testimonialCards = [], testimonialCurrentIndex = 0, testimonialAutoInterval, testimonialCardWidth = 0;
        function updateTestimonials() { if (testimonialCards.length === 0) return; testimonialCardWidth = testimonialCards[0].offsetWidth + 30; testimonialsTrack.style.transform = `translateX(-${testimonialCurrentIndex * testimonialCardWidth}px)`; document.querySelectorAll('.testimonial-dot').forEach((dot, i) => { dot.classList.toggle('active', i === testimonialCurrentIndex); }); }
        function nextTestimonial() { if (testimonialCurrentIndex < testimonialCards.length - 1) testimonialCurrentIndex++; else testimonialCurrentIndex = 0; updateTestimonials(); }
        function prevTestimonial() { if (testimonialCurrentIndex > 0) testimonialCurrentIndex--; else testimonialCurrentIndex = testimonialCards.length - 1; updateTestimonials(); }
        function startTestimonialAuto() { if (testimonialAutoInterval) clearInterval(testimonialAutoInterval); testimonialAutoInterval = setInterval(() => nextTestimonial(), 5000); }
        function initTestimonials() {
            testimonialCards = Array.from(document.querySelectorAll('.testimonial-card'));
            if (testimonialCards.length === 0) return;
            testimonialsDots.innerHTML = '';
            testimonialCards.forEach((_, i) => { const dot = document.createElement('div'); dot.classList.add('testimonial-dot'); if (i === 0) dot.classList.add('active'); dot.addEventListener('click', () => { testimonialCurrentIndex = i; updateTestimonials(); startTestimonialAuto(); }); testimonialsDots.appendChild(dot); });
            updateTestimonials(); startTestimonialAuto();
            let isDown = false, startX, scrollLeft;
            testimonialsTrack.addEventListener('mousedown', (e) => { isDown = true; testimonialsTrack.style.cursor = 'grabbing'; startX = e.pageX - testimonialsTrack.offsetLeft; scrollLeft = testimonialsTrack.scrollLeft; if (testimonialAutoInterval) clearInterval(testimonialAutoInterval); });
            testimonialsTrack.addEventListener('mouseleave', () => { isDown = false; testimonialsTrack.style.cursor = 'grab'; startTestimonialAuto(); });
            testimonialsTrack.addEventListener('mouseup', () => { isDown = false; testimonialsTrack.style.cursor = 'grab'; startTestimonialAuto(); });
            testimonialsTrack.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - testimonialsTrack.offsetLeft; const walk = (x - startX) * 2; testimonialsTrack.scrollLeft = scrollLeft - walk; });
        }
        if (testimonialsPrev) testimonialsPrev.addEventListener('click', () => { prevTestimonial(); startTestimonialAuto(); });
        if (testimonialsNext) testimonialsNext.addEventListener('click', () => { nextTestimonial(); startTestimonialAuto(); });

        window.addEventListener('resize', () => { updateSlideWidth(); goToSlide(currentIndex, false); updateTestimonials(); });
        setTimeout(() => { updateSlides(); startAutoPlay(); initTestimonials(); }, 300);

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) { e.preventDefault(); const target = document.querySelector(this.getAttribute('href')); if (target) target.scrollIntoView({ behavior: 'smooth' }); });
        });
    </script>
</body>
</html>
@props(['title', 'subtitle', 'products' => []])

<style>
    .hero-super {
        background: linear-gradient(135deg, #d4a373 0%, #fef3c7 30%, #fff8e0 70%, #faedcd 100%);
        border-radius: 48px;
        padding: 45px;
        margin-bottom: 50px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(255,255,255,0.5);
    }

    .hero-super::before {
        content: '';
        position: absolute;
        top: -20%;
        right: -5%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(196,167,71,0.2), transparent 70%);
        border-radius: 50%;
        animation: heroPulse 12s ease-in-out infinite;
    }

    .hero-super::after {
        content: '';
        position: absolute;
        bottom: -15%;
        left: -5%;
        width: 280px;
        height: 280px;
        background: radial-gradient(circle, rgba(139,115,85,0.15), transparent 70%);
        border-radius: 50%;
        animation: heroPulseReverse 14s ease-in-out infinite;
    }

    @keyframes heroPulse {
        0%,100% { transform: translate(0,0) scale(1); opacity: 0.4; }
        50% { transform: translate(-15px, -15px) scale(1.1); opacity: 0.7; }
    }

    @keyframes heroPulseReverse {
        0%,100% { transform: translate(0,0) scale(1); opacity: 0.3; }
        50% { transform: translate(15px, 15px) scale(1.15); opacity: 0.6; }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 40px;
    }

    .hero-text {
        flex: 1;
        min-width: 280px;
    }

    .hero-text h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 42px;
        font-weight: 800;
        color: #2c1810;
        margin-bottom: 15px;
        line-height: 1.2;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.05);
    }

    .hero-text h1 span {
        color: #b8860b;
        background: linear-gradient(135deg, #b8860b, #8b6914);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-text p {
        font-size: 16px;
        color: #4a3728;
        margin-bottom: 25px;
        max-width: 500px;
        line-height: 1.6;
        font-weight: 500;
    }

    .hero-date {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(12px);
        padding: 12px 24px;
        border-radius: 60px;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #5c3d2e;
        border: 1px solid rgba(196,167,71,0.4);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .hero-date i {
        color: #b8860b;
        font-size: 16px;
    }

    /* PRODUCT SLIDER - DI SAMPING (FLOATING CARDS) */
    .hero-slider-side {
        width: 380px;
        position: relative;
    }

    .slider-container-side {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
        scrollbar-width: thin;
    }

    .slider-container-side::-webkit-scrollbar {
        width: 6px;
    }

    .slider-container-side::-webkit-scrollbar-track {
        background: rgba(196,167,71,0.2);
        border-radius: 10px;
    }

    .slider-container-side::-webkit-scrollbar-thumb {
        background: #b8860b;
        border-radius: 10px;
    }

    .floating-product-card {
        display: flex;
        align-items: center;
        gap: 15px;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(8px);
        border-radius: 20px;
        padding: 12px;
        border: 1px solid rgba(196,167,71,0.3);
        transition: all 0.3s ease;
        cursor: pointer;
        animation: floatCard 4s ease-in-out infinite;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .floating-product-card:nth-child(1) { animation-delay: 0s; }
    .floating-product-card:nth-child(2) { animation-delay: 0.5s; }
    .floating-product-card:nth-child(3) { animation-delay: 1s; }
    .floating-product-card:nth-child(4) { animation-delay: 1.5s; }
    .floating-product-card:nth-child(5) { animation-delay: 2s; }
    .floating-product-card:nth-child(6) { animation-delay: 2.5s; }

    @keyframes floatCard {
        0%,100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-8px) rotate(1deg); }
    }

    .floating-product-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        border-color: #b8860b;
        animation-play-state: paused;
    }

    .floating-product-card img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 16px;
        border: 2px solid #fef3c7;
    }

    .floating-product-info {
        flex: 1;
    }

    .floating-product-info h4 {
        font-size: 14px;
        font-weight: 700;
        color: #2c1810;
        margin-bottom: 4px;
    }

    .floating-product-info p {
        font-size: 13px;
        font-weight: 700;
        color: #b8860b;
        margin: 0;
    }

    .floating-product-info small {
        font-size: 10px;
        color: #8b7355;
    }

    .floating-badge {
        background: #b8860b;
        color: white;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .hero-super { padding: 35px; }
        .hero-text h1 { font-size: 32px; }
        .hero-slider-side { width: 320px; }
    }

    @media (max-width: 900px) {
        .hero-content { flex-direction: column; }
        .hero-slider-side { width: 100%; margin-top: 20px; }
        .slider-container-side { flex-direction: row; overflow-x: auto; max-height: none; }
        .floating-product-card { min-width: 280px; }
    }

    @media (max-width: 768px) {
        .hero-super { padding: 25px; }
        .hero-text h1 { font-size: 26px; }
    }

    /* Dark Mode */
    [data-theme="dark"] .hero-super {
        background: linear-gradient(135deg, #1e1a2a 0%, #2a2438 50%, #1a1630 100%);
        border-color: rgba(196,167,71,0.2);
    }
    [data-theme="dark"] .hero-text h1 { color: #f5ead8; }
    [data-theme="dark"] .hero-text p { color: #c4c4d4; }
    [data-theme="dark"] .hero-date { background: rgba(0,0,0,0.4); color: #e0cba8; }
    [data-theme="dark"] .floating-product-card { background: rgba(30,30,50,0.9); border-color: rgba(196,167,71,0.2); }
    [data-theme="dark"] .floating-product-info h4 { color: #f5ead8; }
</style>

<div class="hero-super">
    <div class="hero-content">
        <div class="hero-text">
            <h1>{{ $title }} <span>{{ $subtitle ?? '' }}</span></h1>
            <p>@yield('hero-text', 'Temukan motif batik favoritmu dan dapatkan produk asli berkualitas dari berbagai daerah di Indonesia.')</p>
            <div class="hero-date">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</span>
            </div>
        </div>
        
        @if($products->count() > 0)
        <div class="hero-slider-side">
            <div class="slider-container-side">
                @foreach($products->take(6) as $product)
                <div class="floating-product-card" onclick="window.location='{{ route('user.product.detail', $product->id) }}'">
                    @if($product->image && file_exists(public_path($product->image)))
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div style="width:70px; height:70px; background:#e8dcca; border-radius:16px; display:flex; align-items:center; justify-content:center;">
                            <i class="fas fa-tshirt" style="font-size: 30px; color: #b8860b;"></i>
                        </div>
                    @endif
                    <div class="floating-product-info">
                        <h4>{{ Str::limit($product->name, 25) }}</h4>
                        <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <small><i class="fas fa-box"></i> Stok: {{ $product->stock }}</small>
                    </div>
                    <div class="floating-badge">
                        <i class="fas fa-tag"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
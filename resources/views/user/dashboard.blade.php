@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
@php
    $featuredProducts = \App\Models\Product::where('is_active', 1)->latest()->take(6)->get();
    $totalOrders = $totalOrders ?? 0;
    $totalTryOn = $totalTryOn ?? 0;
    $articlesRead = $articlesRead ?? 0;
    $favoriteMotifs = $favoriteMotifs ?? 0;
@endphp

<x-hero-section 
    title="Selamat Datang" 
    subtitle="di Batiknesia" 
    :products="$featuredProducts" 
/>

<style>
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 45px; }
    .stat-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 28px 20px;
        text-align: center;
        transition: all 0.3s;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    .stat-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-hover); }
    .stat-icon {
        width: 65px;
        height: 65px;
        background: var(--accent-glow);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
    }
    .stat-card:hover .stat-icon { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); }
    .stat-card:hover .stat-icon i { color: white; }
    .stat-icon i { font-size: 30px; color: var(--accent); transition: all 0.3s; }
    .stat-number { font-size: 36px; font-weight: 800; color: var(--text-primary); margin-bottom: 6px; }
    .stat-label { font-size: 13px; color: var(--text-secondary); font-weight: 500; }

    .feature-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; margin-bottom: 45px; }
    .feature-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 35px 28px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    .feature-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-hover); }
    .feature-icon {
        width: 85px;
        height: 85px;
        background: var(--accent-glow);
        border-radius: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
    }
    .feature-card:hover { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); }
    .feature-card:hover .feature-icon i { color: white; }
    .feature-icon i { font-size: 40px; color: var(--accent); transition: all 0.3s; }
    .feature-card h3 { font-size: 22px; font-weight: 700; margin-bottom: 12px; color: var(--text-primary); }
    .feature-card p { font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 25px; }

    .btn-feature {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: white;
        padding: 12px 32px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-feature:hover { transform: translateY(-2px); gap: 15px; box-shadow: 0 8px 20px var(--accent-glow); }

    .orders-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 28px;
        padding: 32px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    .section-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--text-primary);
    }
    .section-title i { color: var(--accent); font-size: 24px; }
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 0;
        border-bottom: 1px solid var(--border);
        transition: all 0.3s;
    }
    .order-item:hover { background: var(--accent-glow); transform: translateX(5px); border-radius: 20px; padding: 18px 12px; }
    .order-number { font-size: 15px; font-weight: 700; color: var(--text-primary); margin-bottom: 4px; }
    .order-date { font-size: 11px; color: var(--text-secondary); }
    .order-status { padding: 6px 16px; border-radius: 50px; font-size: 11px; font-weight: 600; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-processing { background: #dbeafe; color: #1e40af; }
    .status-delivered { background: #d1fae5; color: #065f46; }
    .status-shipped { background: #e0f2fe; color: #0891b2; }
    .order-total { font-weight: 700; color: var(--accent); font-size: 16px; }
    .empty-state { text-align: center; padding: 50px; color: var(--text-secondary); }
    .empty-state i { font-size: 55px; margin-bottom: 15px; opacity: 0.4; color: var(--accent); }

    @media (max-width: 1024px) { .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; } .feature-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; } }
    @media (max-width: 768px) { .stats-grid { grid-template-columns: 1fr; } .feature-grid { grid-template-columns: 1fr; } .order-item { flex-direction: column; align-items: flex-start; gap: 10px; } .order-total { align-self: flex-end; } }
</style>

<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon"><i class="fas fa-shopping-bag"></i></div><div class="stat-number">{{ $totalOrders }}</div><div class="stat-label">Total Pesanan</div></div>
    <div class="stat-card"><div class="stat-icon"><i class="fas fa-magic"></i></div><div class="stat-number">{{ $totalTryOn }}</div><div class="stat-label">Virtual Try On</div></div>
    <div class="stat-card"><div class="stat-icon"><i class="fas fa-graduation-cap"></i></div><div class="stat-number">{{ $articlesRead }}</div><div class="stat-label">Artikel Dibaca</div></div>
    <div class="stat-card"><div class="stat-icon"><i class="fas fa-heart"></i></div><div class="stat-number">{{ $favoriteMotifs }}</div><div class="stat-label">Motif Favorit</div></div>
</div>

<div class="feature-grid">
    <div class="feature-card" onclick="window.location='{{ route('user.tryon') }}'">
        <div class="feature-icon"><i class="fas fa-magic"></i></div>
        <h3>Virtual Try On</h3>
        <p>Coba motif batik secara virtual dengan teknologi AI yang akan menyarankan motif yang cocok untukmu.</p>
        <a href="{{ route('user.tryon') }}" class="btn-feature">Coba Sekarang <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="feature-card" onclick="window.location='{{ route('user.education') }}'">
        <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
        <h3>Edukasi Batik</h3>
        <p>Pelajari sejarah, filosofi, dan makna di balik setiap motif batik Nusantara.</p>
        <a href="{{ route('user.education') }}" class="btn-feature">Pelajari <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="feature-card" onclick="window.location='{{ route('user.products') }}'">
        <div class="feature-icon"><i class="fas fa-store"></i></div>
        <h3>Toko Batik</h3>
        <p>Dapatkan produk batik asli berkualitas dari berbagai daerah di Indonesia.</p>
        <a href="{{ route('user.products') }}" class="btn-feature">Belanja <i class="fas fa-arrow-right"></i></a>
    </div>
</div>

<div class="orders-card">
    <h3 class="section-title"><i class="fas fa-history"></i> Pesanan Terbaru</h3>
    @if(isset($recentOrders) && $recentOrders->count() > 0)
        @foreach($recentOrders as $order)
        <div class="order-item">
            <div><div class="order-number">#{{ $order->order_number ?? $order->id }}</div><div class="order-date"><i class="far fa-calendar-alt"></i> {{ $order->created_at->format('d M Y, H:i') }}</div></div>
            <span class="order-status status-{{ $order->status ?? 'pending' }}">{{ ucfirst($order->status ?? 'Pending') }}</span>
            <div class="order-total">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</div>
        </div>
        @endforeach
    @else
        <div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada pesanan</p><p style="font-size:12px; margin-top:8px;">Yuk mulai belanja batik sekarang</p></div>
    @endif
</div>
@endsection
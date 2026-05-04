@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<style>
    .welcome-section {
        margin-bottom: 30px;
    }
    
    .welcome-section h1 {
        font-size: 28px;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: #2c1810;
        margin-bottom: 5px;
    }
    
    .welcome-section p {
        color: #8b7355;
        font-size: 14px;
    }
    
    /* Stats Grid */
    .stats-grid-dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card-dashboard {
        background: var(--bg-card, #ffffff);
        border: 1px solid var(--border, #e8dcca);
        border-radius: 20px;
        padding: 22px 15px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .stat-card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(92,64,51,0.1);
    }
    
    .stat-icon {
        width: 55px;
        height: 55px;
        background: linear-gradient(145deg, rgba(196,167,71,0.12), rgba(139,115,85,0.06));
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }
    
    .stat-icon i {
        font-size: 28px;
        color: #c4a747;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 800;
        font-family: 'Playfair Display', serif;
        color: #2c1810;
        margin: 5px 0;
    }
    
    .stat-label {
        font-size: 12px;
        color: #8b7355;
        font-weight: 500;
    }
    
    /* Recent Orders Card */
    .recent-orders-card {
        background: var(--bg-card, #ffffff);
        border: 1px solid var(--border, #e8dcca);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    
    .recent-orders-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: 700;
        color: #2c1810;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #e8dcca;
    }
    
    .order-item {
        border-top: 1px solid #e8dcca;
        padding: 15px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .order-item:first-child {
        border-top: none;
        padding-top: 0;
    }
    
    .order-info {
        flex: 1;
    }
    
    .order-number {
        font-weight: 700;
        color: #2c1810;
        font-size: 14px;
    }
    
    .order-date {
        font-size: 11px;
        color: #8b7355;
        margin-top: 4px;
    }
    
    .order-status {
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .status-shipped {
        background: #e0e7ff;
        color: #3730a3;
    }
    
    .status-delivered {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .order-total {
        font-weight: 700;
        color: #c4a747;
        font-size: 15px;
        min-width: 120px;
        text-align: right;
    }
    
    .empty-orders {
        text-align: center;
        padding: 40px 20px;
        color: #8b7355;
    }
    
    .empty-orders i {
        font-size: 48px;
        color: #c4a747;
        margin-bottom: 15px;
        display: block;
        opacity: 0.5;
    }
    
    @media (max-width: 640px) {
        .order-item {
            flex-direction: column;
            align-items: flex-start;
        }
        .order-total {
            text-align: left;
        }
        .stats-grid-dashboard {
            gap: 12px;
        }
        .stat-card-dashboard {
            padding: 15px 10px;
        }
        .stat-number {
            font-size: 22px;
        }
    }
</style>

<div class="welcome-section">
    <h1>Halo, {{ Auth::user()->name }}! 👋</h1>
    <p>Selamat datang di Batiknesia - Jelajahi keindahan batik Nusantara</p>
</div>

<!-- Stats Cards -->
<div class="stats-grid-dashboard">
    <div class="stat-card-dashboard">
        <div class="stat-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="stat-number">{{ $totalOrders ?? 0 }}</div>
        <div class="stat-label">Total Pesanan</div>
    </div>
    <div class="stat-card-dashboard">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-number">{{ $pendingOrders ?? 0 }}</div>
        <div class="stat-label">Menunggu</div>
    </div>
    <div class="stat-card-dashboard">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-number">{{ $completedOrders ?? 0 }}</div>
        <div class="stat-label">Selesai</div>
    </div>
    <div class="stat-card-dashboard">
        <div class="stat-icon">
            <i class="fas fa-camera"></i>
        </div>
        <div class="stat-number">{{ $totalTryOn ?? 0 }}</div>
        <div class="stat-label">Try On</div>
    </div>
</div>

<!-- Recent Orders -->
<div class="recent-orders-card">
    <h3><i class="fas fa-history" style="color: #c4a747; margin-right: 8px;"></i> Pesanan Terbaru</h3>
    
    @if(isset($recentOrders) && $recentOrders->count() > 0)
        @foreach($recentOrders as $order)
        <div class="order-item">
            <div class="order-info">
                <div class="order-number">#{{ $order->order_number ?? $order->id }}</div>
                <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
            </div>
            <span class="order-status status-{{ $order->status ?? 'pending' }}">
                {{ ucfirst($order->status ?? 'Pending') }}
            </span>
            <div class="order-total">
                Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}
            </div>
        </div>
        @endforeach
    @else
        <div class="empty-orders">
            <i class="fas fa-inbox"></i>
            <p>Belum ada pesanan</p>
            <p style="font-size: 12px; margin-top: 8px;">Yuk mulai belanja batik sekarang!</p>
        </div>
    @endif
</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            background: '#fffcf5',
            confirmButtonColor: '#c4a747',
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endif
@endsection
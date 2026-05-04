@extends('layouts.user')

@section('title', 'Pesanan Saya')

@section('content')
@php
    $sliderProducts = \App\Models\Product::where('is_active', 1)->latest()->take(6)->get();
@endphp

<x-hero-section 
    title="Pesanan Saya" 
    subtitle="Lacak Pesanan" 
    :products="$sliderProducts" 
/>

<style>
    .stats-orders { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px; }
    .stat-order-card {
        background: var(--bg-card);
        border-radius: 24px;
        padding: 24px;
        text-align: center;
        border: 1px solid var(--border);
        transition: all 0.3s;
    }
    .stat-order-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-hover); }
    .stat-order-value { font-size: 32px; font-weight: 800; color: var(--accent); }
    .orders-card {
        background: var(--bg-card);
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .orders-table { width: 100%; border-collapse: collapse; }
    .orders-table th { text-align: left; padding: 16px; color: var(--text-secondary); font-size: 13px; font-weight: 600; border-bottom: 2px solid var(--border); }
    .orders-table td { padding: 16px; border-bottom: 1px solid var(--border); color: var(--text-primary); font-size: 14px; vertical-align: middle; }
    .orders-table tr:hover { background: var(--accent-glow); }
    .status-badge { padding: 5px 14px; border-radius: 30px; font-size: 12px; font-weight: 600; display: inline-block; }
    .status-badge.pending { background: #fef3c7; color: #92400e; }
    .status-badge.processing { background: #dbeafe; color: #1e40af; }
    .status-badge.shipped { background: #e0f2fe; color: #0891b2; }
    .status-badge.delivered { background: #d1fae5; color: #065f46; }
    .btn-detail { color: var(--accent); text-decoration: none; font-weight: 600; padding: 6px 12px; border-radius: 20px; background: var(--accent-glow); }
    .btn-detail:hover { background: var(--accent); color: white; }
    .payment-paid { color: #10b981; font-weight: 600; }
    .payment-unpaid { color: #f59e0b; font-weight: 600; }
    .pagination { margin-top: 25px; display: flex; justify-content: center; gap: 8px; padding: 20px; }
    .pagination .page-item .page-link { background: var(--bg-card); border: 1px solid var(--border); color: var(--text-primary); border-radius: 12px; padding: 8px 14px; }
    .pagination .page-item.active .page-link { background: var(--accent); color: #2c1810; }
    .empty-state { text-align: center; padding: 80px; background: var(--bg-card); border-radius: 28px; border: 1px solid var(--border); }
    .empty-state i { font-size: 65px; color: var(--accent); margin-bottom: 20px; opacity: 0.5; }

    @media (max-width: 768px) {
        .stats-orders { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .orders-table th, .orders-table td { padding: 12px 8px; font-size: 12px; }
        .orders-table { display: block; overflow-x: auto; }
    }
</style>

<div class="stats-orders">
    <div class="stat-order-card"><div class="stat-order-value">{{ $orders->total() }}</div><div class="stat-order-label">Total Pesanan</div></div>
    <div class="stat-order-card"><div class="stat-order-value">{{ $orders->where('status', 'pending')->count() }}</div><div class="stat-order-label">Menunggu</div></div>
    <div class="stat-order-card"><div class="stat-order-value">{{ $orders->where('status', 'processing')->count() }}</div><div class="stat-order-label">Diproses</div></div>
    <div class="stat-order-card"><div class="stat-order-value">{{ $orders->where('status', 'delivered')->count() }}</div><div class="stat-order-label">Selesai</div></div>
</div>

<div class="orders-card">
    @if($orders->count() > 0)
    <div style="overflow-x: auto;">
        <table class="orders-table">
            <thead><tr><th>Order ID</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Pembayaran</th><th>Aksi</th></table></thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>#{{ $order->order_number }}</strong><br><small style="font-size:10px;">{{ $order->created_at->format('d/m/Y H:i') }}</small></td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td><span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td><span class="payment-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span></td>
                    <td><a href="{{ route('user.order.detail', $order->id) }}" class="btn-detail">Detail →</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination">{{ $orders->links() }}</div>
    @else
    <div class="empty-state"><i class="fas fa-shopping-cart"></i><p>Belum ada pesanan</p><a href="{{ route('user.products') }}" class="btn-primary" style="margin-top:20px;">Belanja Sekarang</a></div>
    @endif
</div>
@endsection
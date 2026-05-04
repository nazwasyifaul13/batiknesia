@extends('layouts.user')

@section('title', 'Lacak Pesanan')

@push('styles')
<style>
    #map { height: 450px; width: 100%; border-radius: 24px; z-index: 1; margin-top: 20px; }
    .tracking-card { background: var(--bg-card); border-radius: 24px; padding: 24px; border: 1px solid var(--border); margin-bottom: 24px; }
    .order-select { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-primary); margin-bottom: 20px; }
    .status-step { display: flex; align-items: center; justify-content: space-between; margin: 30px 0; position: relative; }
    .status-step::before { content: ''; position: absolute; top: 30px; left: 40px; right: 40px; height: 2px; background: var(--border); z-index: 0; }
    .step { text-align: center; flex: 1; position: relative; z-index: 1; background: var(--bg-card); }
    .step .icon { width: 50px; height: 50px; background: var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; transition: all 0.3s; }
    .step.active .icon { background: var(--accent); box-shadow: 0 0 15px var(--accent-glow); }
    .step.active .icon i { color: #2c1810; }
    .step .icon i { font-size: 22px; color: var(--text-secondary); }
    .step span { font-size: 12px; color: var(--text-secondary); }
    .step.active span { color: var(--accent); font-weight: 600; }
    .empty-state { text-align: center; padding: 60px; background: var(--bg-card); border-radius: 28px; border: 1px solid var(--border); }
    .empty-state i { font-size: 55px; color: var(--accent); margin-bottom: 15px; opacity: 0.5; }
</style>
@endpush

@section('content')
@php
    $sliderProducts = \App\Models\Product::where('is_active', 1)->latest()->take(6)->get();
@endphp

<x-hero-section 
    title="Lacak Pesanan" 
    subtitle="Real-time Tracking" 
    :products="$sliderProducts" 
/>

<div class="tracking-card">
    @if($orders->count() > 0)
    <select id="orderSelect" class="order-select">
        <option value="">-- Pilih Pesanan --</option>
        @foreach($orders as $order)
        <option value="{{ $order->id }}" data-lat="{{ $order->current_lat ?? '-6.2' }}" data-lng="{{ $order->current_lng ?? '106.8' }}" data-status="{{ $order->status }}">
            #{{ $order->order_number }} - {{ ucfirst($order->status) }} - {{ $order->created_at->format('d M Y') }}
        </option>
        @endforeach
    </select>
    <div id="map"></div>
    <div class="status-step">
        <div class="step" id="stepPending"><div class="icon"><i class="fas fa-clock"></i></div><span>Pending</span></div>
        <div class="step" id="stepProcessing"><div class="icon"><i class="fas fa-cogs"></i></div><span>Processing</span></div>
        <div class="step" id="stepShipped"><div class="icon"><i class="fas fa-truck"></i></div><span>Shipped</span></div>
        <div class="step" id="stepDelivered"><div class="icon"><i class="fas fa-check-circle"></i></div><span>Delivered</span></div>
    </div>
    @else
    <div class="empty-state"><i class="fas fa-box-open"></i><p>Belum ada pesanan yang sedang diproses</p></div>
    @endif
</div>

<script>
    let map, marker;
    
    function initMap(lat, lng) {
        if (map) map.remove();
        map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: 'Map data &copy; OpenStreetMap contributors'
        }).addTo(map);
        marker = L.marker([lat, lng]).addTo(map);
    }
    
    function updateStatus(status) {
        document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
        if (status === 'pending') document.getElementById('stepPending').classList.add('active');
        else if (status === 'processing') document.getElementById('stepProcessing').classList.add('active');
        else if (status === 'shipped') document.getElementById('stepShipped').classList.add('active');
        else if (status === 'delivered') document.getElementById('stepDelivered').classList.add('active');
    }
    
    document.getElementById('orderSelect').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (this.value) {
            const lat = parseFloat(selected.dataset.lat);
            const lng = parseFloat(selected.dataset.lng);
            const status = selected.dataset.status;
            initMap(lat, lng);
            updateStatus(status);
        }
    });
    
    initMap(-6.2, 106.8);
</script>
@endsection
@extends('layouts.admin')

@section('title', 'Tracking Pesanan')

@push('styles')
<style>
    #map { height: 500px; width: 100%; border-radius: 20px; margin-bottom: 20px; }
    .order-list {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 15px;
        border: 1px solid var(--border);
        margin-bottom: 20px;
        max-height: 300px;
        overflow-y: auto;
    }
    .order-item {
        padding: 12px;
        border-bottom: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 12px;
    }
    .order-item:hover { background: var(--accent-glow); }
    .order-item.active { background: var(--accent-glow); border-left: 3px solid var(--accent); }
    .location-form {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid var(--border);
    }
    .location-form input {
        padding: 10px;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: var(--bg-primary);
        color: var(--text-primary);
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="order-list">
            <h5 style="margin-bottom: 15px;"><i class="fas fa-truck"></i> Daftar Pesanan</h5>
            @foreach($orders as $order)
            <div class="order-item" data-id="{{ $order->id }}" data-lat="{{ $order->current_lat ?? '-6.2' }}" data-lng="{{ $order->current_lng ?? '106.8' }}" data-status="{{ $order->status }}">
                <strong>#{{ $order->order_number }}</strong><br>
                <small>{{ $order->user->name }}</small><br>
                <span class="status-badge {{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
            @endforeach
        </div>
        <div class="location-form">
            <h5><i class="fas fa-map-marker-alt"></i> Update Lokasi</h5>
            <div class="mb-2">
                <label>Latitude</label>
                <input type="text" id="lat" class="form-control w-100">
            </div>
            <div class="mb-2">
                <label>Longitude</label>
                <input type="text" id="lng" class="form-control w-100">
            </div>
            <button class="btn-admin w-100" onclick="updateLocation()">Update Lokasi</button>
        </div>
    </div>
    <div class="col-md-8">
        <div id="map"></div>
    </div>
</div>

<script>
    let map, marker, currentOrderId;
    
    function initMap(lat, lng) {
        if (map) map.remove();
        map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: 'Map data &copy; OpenStreetMap'
        }).addTo(map);
        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
        marker.on('dragend', (e) => {
            document.getElementById('lat').value = e.target.getLatLng().lat;
            document.getElementById('lng').value = e.target.getLatLng().lng;
        });
    }
    
    document.querySelectorAll('.order-item').forEach(el => {
        el.addEventListener('click', function() {
            document.querySelectorAll('.order-item').forEach(e => e.classList.remove('active'));
            this.classList.add('active');
            currentOrderId = this.dataset.id;
            const lat = parseFloat(this.dataset.lat);
            const lng = parseFloat(this.dataset.lng);
            initMap(lat, lng);
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
        });
    });
    
    function updateLocation() {
        if (!currentOrderId) return alert('Pilih pesanan dulu');
        const lat = document.getElementById('lat').value;
        const lng = document.getElementById('lng').value;
        
        fetch('{{ route("admin.tracking.update") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ id: currentOrderId, lat: lat, lng: lng })
        }).then(() => { alert('Lokasi berhasil diupdate!'); });
    }
    
    initMap(-6.2, 106.8);
</script>
@endsection
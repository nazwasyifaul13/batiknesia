@extends('layouts.user')

@section('title', 'Detail Pesanan')

@section('content')
<div class="welcome-section">
    <h1>Detail Pesanan</h1>
    <p>Informasi lengkap pesanan Anda</p>
</div>

<div class="order-detail-container">
    <!-- Header Pesanan -->
    <div class="order-header">
        <div class="order-number">
            <i class="fas fa-receipt"></i>
            <span>{{ $order->order_number }}</span>
        </div>
        <div class="order-date">
            <i class="fas fa-calendar-alt"></i>
            <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div class="order-status">
            @if($order->status == 'pending')
                <span class="status-badge status-pending"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>
            @elseif($order->status == 'processing')
                <span class="status-badge status-processing"><i class="fas fa-box"></i> Dikemas</span>
            @elseif($order->status == 'shipped')
                <span class="status-badge status-shipped"><i class="fas fa-truck"></i> Dikirim</span>
            @elseif($order->status == 'delivered')
                <span class="status-badge status-delivered"><i class="fas fa-check-circle"></i> Selesai</span>
            @else
                <span class="status-badge status-cancelled"><i class="fas fa-times-circle"></i> Dibatalkan</span>
            @endif
        </div>
    </div>

    <!-- Progress Status -->
    <div class="order-progress">
        <div class="progress-step {{ $order->status == 'pending' || $order->status == 'processing' || $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}">
            <div class="step-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="step-label">Pesanan Dibuat</div>
        </div>
        <div class="progress-line {{ $order->status == 'processing' || $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}"></div>
        <div class="progress-step {{ $order->status == 'processing' || $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}">
            <div class="step-icon"><i class="fas fa-box"></i></div>
            <div class="step-label">Dikemas</div>
        </div>
        <div class="progress-line {{ $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}"></div>
        <div class="progress-step {{ $order->status == 'shipped' || $order->status == 'delivered' ? 'active' : '' }}">
            <div class="step-icon"><i class="fas fa-truck"></i></div>
            <div class="step-label">Dikirim</div>
        </div>
        <div class="progress-line {{ $order->status == 'delivered' ? 'active' : '' }}"></div>
        <div class="progress-step {{ $order->status == 'delivered' ? 'active' : '' }}">
            <div class="step-icon"><i class="fas fa-check-circle"></i></div>
            <div class="step-label">Selesai</div>
        </div>
    </div>

    <div class="detail-grid">
        <!-- Informasi Pengiriman -->
        <div class="detail-card">
            <h3><i class="fas fa-map-marker-alt"></i> Informasi Pengiriman</h3>
            @php
                $shipping = json_decode($order->shipping_address, true);
            @endphp
            <div class="info-row">
                <span class="info-label">Nama Penerima:</span>
                <span class="info-value">{{ $shipping['name'] ?? $order->user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat:</span>
                <span class="info-value">{{ $shipping['address'] ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Telepon:</span>
                <span class="info-value">{{ $order->phone ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Catatan:</span>
                <span class="info-value">{{ $order->notes ?? '-' }}</span>
            </div>
        </div>

        <!-- Informasi Pembayaran -->
        <div class="detail-card">
            <h3><i class="fas fa-credit-card"></i> Informasi Pembayaran</h3>
            <div class="info-row">
                <span class="info-label">Metode Pembayaran:</span>
                <span class="info-value">
                    @if($order->payment)
                        {{ strtoupper($order->payment->payment_method) }}
                        @if($order->payment->payment_method == 'cod')
                            <span class="payment-method-cod">(Bayar di Tempat)</span>
                        @endif
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Pembayaran:</span>
                <span class="info-value">
                    @if($order->payment_status == 'paid')
                        <span class="payment-status-paid"><i class="fas fa-check-circle"></i> Lunas</span>
                    @else
                        <span class="payment-status-unpaid"><i class="fas fa-clock"></i> Belum Dibayar</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Produk yang Dipesan -->
    <div class="detail-card full-width">
        <h3><i class="fas fa-boxes"></i> Produk yang Dipesan</h3>
        <div class="order-items">
            @foreach($order->items as $item)
            <div class="order-item">
                <div class="item-image">
                    @if($item->product->image)
                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}">
                    @else
                        <div class="image-placeholder"><i class="fas fa-tshirt"></i></div>
                    @endif
                </div>
                <div class="item-details">
                    <div class="item-name">{{ $item->product->name }}</div>
                    <div class="item-meta">
                        <span class="item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <span class="item-quantity">x {{ $item->quantity }}</span>
                        <span class="item-subtotal">= Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="order-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($order->total_amount - ($order->shipping_cost ?? 15000), 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Ongkos Kirim</span>
                <span>Rp {{ number_format($order->shipping_cost ?? 15000, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('user.orders') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Pesanan</a>
        @if($order->status == 'pending')
            <button onclick="cancelOrder({{ $order->id }})" class="btn-cancel"><i class="fas fa-times"></i> Batalkan Pesanan</button>
        @endif
    </div>
</div>

<style>
.welcome-section {
    background: rgba(196,167,71,0.1);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 28px;
    border-left: 4px solid #c4a747;
}
.welcome-section h1 {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: #fff;
}
.welcome-section p {
    font-family: 'Poppins', sans-serif;
    font-size: 14px;
    color: #c4a747;
    margin-top: 5px;
}

.order-detail-container {
    background: rgba(255,252,245,0.96);
    border-radius: 24px;
    padding: 24px;
    border: 1px solid rgba(196,167,71,0.2);
}

.order-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 20px;
    border-bottom: 1px solid rgba(196,167,71,0.15);
    margin-bottom: 20px;
}

.order-number {
    font-size: 18px;
    font-weight: 700;
    color: #2c1810;
}
.order-number i { color: #c4a747; margin-right: 8px; }

.order-date { color: #8b7355; font-size: 14px; }
.order-date i { margin-right: 8px; }

.order-progress {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 30px;
    padding: 20px 0;
}

.progress-step {
    text-align: center;
    flex: 1;
}

.step-icon {
    width: 50px;
    height: 50px;
    background: #e8dcca;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    transition: all 0.3s;
}
.progress-step.active .step-icon {
    background: #c4a747;
    color: white;
}
.step-icon i { font-size: 20px; color: #8b7355; }
.progress-step.active .step-icon i { color: white; }
.step-label { font-size: 12px; color: #8b7355; }
.progress-step.active .step-label { color: #c4a747; font-weight: 600; }

.progress-line {
    width: 60px;
    height: 2px;
    background: #e8dcca;
    margin: 0 -10px;
}
.progress-line.active { background: #c4a747; }

.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.detail-card {
    background: rgba(196,167,71,0.05);
    border-radius: 16px;
    padding: 20px;
}
.detail-card.full-width { grid-column: 1/-1; }
.detail-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 16px;
    color: #2c1810;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(196,167,71,0.2);
}
.detail-card h3 i { color: #c4a747; margin-right: 8px; }

.info-row {
    display: flex;
    margin-bottom: 12px;
}
.info-label {
    width: 120px;
    color: #8b7355;
    font-size: 13px;
}
.info-value {
    flex: 1;
    color: #2c1810;
    font-size: 13px;
    font-weight: 500;
}

.order-items {
    margin-bottom: 20px;
}
.order-item {
    display: flex;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid rgba(196,167,71,0.1);
}
.item-image {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    overflow: hidden;
}
.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.image-placeholder {
    width: 100%;
    height: 100%;
    background: #e8dcca;
    display: flex;
    align-items: center;
    justify-content: center;
}
.image-placeholder i { font-size: 30px; color: #c4a747; }

.item-details { flex: 1; }
.item-name {
    font-weight: 600;
    color: #2c1810;
    margin-bottom: 8px;
}
.item-meta {
    display: flex;
    gap: 15px;
    font-size: 13px;
}
.item-price { color: #8b7355; }
.item-quantity { color: #8b7355; }
.item-subtotal { color: #c4a747; font-weight: 600; }

.order-summary {
    border-top: 1px solid rgba(196,167,71,0.2);
    padding-top: 15px;
    text-align: right;
}
.summary-row {
    display: flex;
    justify-content: flex-end;
    gap: 30px;
    margin-bottom: 8px;
}
.summary-row.total {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid rgba(196,167,71,0.2);
    font-size: 16px;
    font-weight: 700;
}
.summary-row.total span:last-child { color: #c4a747; font-size: 18px; }

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 24px;
}
.btn-back, .btn-cancel {
    padding: 10px 24px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-back {
    background: #c4a747;
    color: #2c1810;
    border: none;
}
.btn-back:hover { background: #8b7355; color: white; }
.btn-cancel {
    background: transparent;
    color: #dc2626;
    border: 1px solid #dc2626;
}
.btn-cancel:hover { background: #dc2626; color: white; }

.status-badge {
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.status-pending { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-shipped { background: #fef3c7; color: #92400e; }
.status-delivered { background: #d1fae5; color: #065f46; }
.status-cancelled { background: #fee2e2; color: #991b1b; }

.payment-status-paid { color: #065f46; }
.payment-status-unpaid { color: #92400e; }
.payment-method-cod { display: block; font-size: 11px; color: #8b7355; }

@media (max-width: 768px) {
    .detail-grid { grid-template-columns: 1fr; }
    .order-header { flex-direction: column; gap: 10px; align-items: flex-start; }
    .order-progress { flex-direction: column; gap: 15px; }
    .progress-line { width: 2px; height: 20px; margin: 0; }
    .progress-step { display: flex; align-items: center; gap: 15px; width: 100%; }
    .step-icon { margin: 0; }
    .action-buttons { flex-direction: column; }
    .btn-back, .btn-cancel { text-align: center; }
    .order-item { flex-direction: column; align-items: center; text-align: center; }
    .item-meta { justify-content: center; }
    .summary-row { justify-content: space-between; }
}
</style>

<script>
function cancelOrder(id) {
    Swal.fire({
        title: 'Batalkan Pesanan?',
        text: 'Pesanan yang dibatalkan tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#8b7355',
        confirmButtonText: 'Ya, Batalkan!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/user/orders/' + id + '/cancel', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                if(data.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, confirmButtonColor: '#c4a747' })
                    .then(() => location.reload());
                }
            });
        }
    });
}
</script>
@endsection
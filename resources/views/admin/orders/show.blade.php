@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.orders.index') }}" style="color: #c4a747; text-decoration: none;">← Kembali ke Pesanan</a>
    <h1 style="font-family: 'Playfair Display', serif; font-size: 28px; color: #fff; margin-top: 10px;">Detail Pesanan</h1>
    <p style="color: #c4a747;">Informasi lengkap pesanan #{{ $order->order_number }}</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">
    <!-- Informasi Pelanggan -->
    <div class="stat-card">
        <h3 style="color: #2c1810; margin-bottom: 15px;">👤 Informasi Pelanggan</h3>
        @php
            $shipping = json_decode($order->shipping_address, true);
        @endphp
        <p><strong>Nama:</strong> {{ $shipping['name'] ?? $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>Telepon:</strong> {{ $order->phone ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $shipping['address'] ?? '-' }}</p>
        <p><strong>Catatan:</strong> {{ $order->notes ?? '-' }}</p>
    </div>

    <!-- Informasi Pesanan -->
    <div class="stat-card">
        <h3 style="color: #2c1810; margin-bottom: 15px;">📦 Informasi Pesanan</h3>
        <p><strong>No. Pesanan:</strong> {{ $order->order_number }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        <p><strong>Status Pesanan:</strong></p>
        
        <!-- Form Update Status -->
        <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" style="margin: 10px 0;">
            @csrf
            @method('PUT')
            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <select name="status" style="padding: 8px 15px; border-radius: 30px; border: 1px solid #e8dcca; background: white;">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>📦 Dikemas</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Dikirim</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                </select>
                <button type="submit" class="btn-vintage" style="padding: 8px 20px;">Update Status</button>
            </div>
        </form>
        
        <p style="margin-top: 10px;"><strong>Status Pembayaran:</strong> 
            <span style="padding: 3px 10px; border-radius: 20px; font-size: 11px; background: {{ $order->payment_status == 'paid' ? '#d1fae5' : '#fef3c7' }}; color: {{ $order->payment_status == 'paid' ? '#065f46' : '#92400e' }};">
                {{ $order->payment_status == 'paid' ? 'Lunas' : 'Belum Dibayar' }}
            </span>
        </p>
        <p><strong>Metode Pembayaran:</strong> 
            @if($order->payment)
                {{ strtoupper($order->payment->payment_method) }}
            @else
                -
            @endif
        </p>
    </div>

    <!-- Ringkasan Pembayaran -->
    <div class="stat-card">
        <h3 style="color: #2c1810; margin-bottom: 15px;">💰 Ringkasan Pembayaran</h3>
        <table style="width:100%;">
            <tr><td style="padding: 5px 0;">Subtotal</td><td style="text-align: right;">Rp {{ number_format($order->total_amount - ($order->shipping_cost ?? 15000), 0, ',', '.') }}</td></tr>
            <tr><td style="padding: 5px 0;">Ongkos Kirim</td><td style="text-align: right;">Rp {{ number_format($order->shipping_cost ?? 15000, 0, ',', '.') }}</td></tr>
            <tr style="border-top: 1px solid #e8dcca;"><td style="padding: 10px 0;"><strong>Total</strong></td><td style="text-align: right;"><strong style="color: #c4a747;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td></tr>
        </table>
    </div>
</div>

<!-- Produk yang Dipesan -->
<div class="stat-card" style="margin-top: 20px;">
    <h3 style="color: #2c1810; margin-bottom: 15px;">🛍️ Produk yang Dipesan</h3>
    <div style="overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e8dcca;">
                    <th style="padding: 12px; text-align: left;">Produk</th>
                    <th style="padding: 12px; text-align: center;">Jumlah</th>
                    <th style="padding: 12px; text-align: right;">Harga</th>
                    <th style="padding: 12px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr style="border-bottom: 1px solid #e8dcca;">
                    <td style="padding: 12px;">
                        @if($item->product->image)
                            <img src="{{ asset($item->product->image) }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px; margin-right: 10px;">
                        @endif
                        {{ $item->product->name }}
                    </td>
                    <td style="padding: 12px; text-align: center;">{{ $item->quantity }}</td>
                    <td style="padding: 12px; text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="padding: 12px; text-align: right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    @if(session('success'))
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', background: '#fffcf5', confirmButtonColor: '#c4a747' });
    @endif
    @if(session('error'))
    Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', background: '#fffcf5', confirmButtonColor: '#c4a747' });
    @endif
</script>
@endsection
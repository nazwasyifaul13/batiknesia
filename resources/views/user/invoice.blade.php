@extends('layouts.user')

@section('title', 'Invoice')

@section('content')
@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', background: '#fffcf5', confirmButtonColor: '#c4a747' });
</script>
@endif

<div style="max-width: 500px; margin: 0 auto;">
    <div class="feature-card" id="invoiceContent">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="font-family: 'Playfair Display', serif; color: #c4a747;">BATIKNESIA</h2>
            <p>Jl. Batik No. 123, Yogyakarta</p>
            <p>Telp: 0812-3456-7890</p>
            <hr style="margin: 15px 0;">
        </div>
        
        <h3>INVOICE</h3>
        <p><strong>No. Invoice:</strong> {{ $order->order_number }}</p>
        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
        <p><strong>Status:</strong> 
            <span style="padding: 3px 10px; border-radius: 20px; font-size: 11px; background: #fef3c7; color:#92400e;">
                Menunggu Pembayaran
            </span>
        </p>
        
        <hr style="margin: 15px 0;">
        
        <h4>Informasi Pelanggan</h4>
        @php
            $shipping = json_decode($order->shipping_address, true);
        @endphp
        <p><strong>Nama:</strong> {{ $shipping['name'] ?? Auth::user()->name }}</p>
        <p><strong>Alamat:</strong> {{ $shipping['address'] ?? '-' }}</p>
        <p><strong>Telepon:</strong> {{ $order->phone ?? '-' }}</p>
        
        <hr style="margin: 15px 0;">
        
        <h4>Detail Pesanan</h4>
        <table style="width:100%; border-collapse:collapse;">
            @foreach($order->items as $item)
            <tr>
                <td style="padding:5px 0;">{{ $item->product->name }} x{{ $item->quantity }}</td>
                <td style="padding:5px 0; text-align:right;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="padding:5px 0;">Ongkos Kirim</td>
                <td style="padding:5px 0; text-align:right;">Rp {{ number_format($order->shipping_cost ?? 15000, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top:1px solid #e8dcca;">
                <td style="padding:10px 0;"><strong>Total</strong></td>
                <td style="padding:10px 0; text-align:right;"><strong style="color:#c4a747;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
        
        <hr style="margin: 15px 0;">
        
        <!-- Informasi Pembayaran -->
        @if($order->payment && $order->payment->payment_method == 'cod')
        <div style="margin-top: 15px; padding: 12px; background: #d1fae5; border-radius: 12px; text-align: center;">
            <i class="fas fa-truck" style="font-size: 20px; color: #065f46;"></i>
            <p style="margin-top: 5px;"><strong>COD (Bayar di Tempat)</strong></p>
            <p style="font-size: 12px;">Bayar saat barang diterima</p>
        </div>
        @elseif($order->payment)
        <div style="margin-top: 15px; padding: 12px; background: #fef3c7; border-radius: 12px; text-align: center;">
            <i class="fas fa-university" style="font-size: 20px; color: #92400e;"></i>
            <p style="margin-top: 5px;"><strong>Transfer Bank {{ strtoupper($order->payment->payment_method) }}</strong></p>
            <p style="font-size: 12px;">
                @if($order->payment->payment_method == 'bca')
                    No Rek: 1234567890 a.n Batiknesia
                @elseif($order->payment->payment_method == 'mandiri')
                    No Rek: 0987654321 a.n Batiknesia
                @elseif($order->payment->payment_method == 'bri')
                    No Rek: 1122334455 a.n Batiknesia
                @endif
            </p>
        </div>
        @endif
        
        <div style="text-align: center; margin-top: 15px;">
            <p>Terima kasih telah berbelanja di Batiknesia!</p>
            <p style="font-size: 11px; color:#8b7355;">Pesanan akan diproses setelah pembayaran dikonfirmasi</p>
        </div>
    </div>
    
    <div style="display: flex; gap: 15px; margin-top: 20px; justify-content: center; flex-wrap: wrap;">
        <button onclick="shareInvoice()" class="btn-primary"><i class="fas fa-share-alt"></i> Bagikan</button>
        <button onclick="window.print()" class="btn-primary"><i class="fas fa-print"></i> Cetak</button>
        <a href="{{ route('user.orders') }}" class="btn-primary"><i class="fas fa-history"></i> Pesanan Saya</a>
    </div>
</div>

<script>
    function shareInvoice() {
        const invoiceContent = document.getElementById('invoiceContent').innerHTML;
        const win = window.open('', '_blank');
        win.document.write(`
            <html>
            <head><title>Invoice Batiknesia</title>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
            <style>body { font-family: 'Poppins', sans-serif; padding: 20px; }</style>
            </head>
            <body>${invoiceContent}</body>
            </html>
        `);
        win.print();
    }
</script>
@endsection
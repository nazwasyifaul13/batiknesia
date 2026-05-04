@extends('layouts.user')

@section('title', 'Checkout')

@section('content')
<div class="welcome-section">
    <h1>Checkout</h1>
    <p>Lengkapi data untuk menyelesaikan pembelian</p>
</div>

<div class="checkout-container">
    <!-- Form Pemesanan -->
    <div class="checkout-form card">
        <h3>📝 Informasi Pengiriman</h3>
        <form method="POST" action="{{ route('user.checkout.store') }}" id="checkoutForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="{{ $quantity }}">
            
            <div class="form-group">
                <label>Nama Penerima</label>
                <input type="text" name="receiver_name" value="{{ Auth::user()->name }}" required>
            </div>
            
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea name="address" rows="3" required placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan, Kota"></textarea>
            </div>
            
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="tel" name="phone" placeholder="081234567890" required>
            </div>
            
            <div class="form-group">
                <label>Catatan (opsional)</label>
                <textarea name="notes" rows="2" placeholder="Contoh: Tolong dibungkus rapi"></textarea>
            </div>
            
            <h3 style="margin: 20px 0 15px;">💳 Metode Pembayaran</h3>
            
            <div class="payment-methods">
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="bca" required>
                    <div class="payment-card">
                        <div class="payment-icon bca">BCA</div>
                        <div class="payment-info">
                            <strong>Transfer BCA</strong>
                            <small>No. Rek: 1234567890 a.n Batiknesia</small>
                        </div>
                    </div>
                </label>
                
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="mandiri">
                    <div class="payment-card">
                        <div class="payment-icon mandiri">Mandiri</div>
                        <div class="payment-info">
                            <strong>Transfer Mandiri</strong>
                            <small>No. Rek: 0987654321 a.n Batiknesia</small>
                        </div>
                    </div>
                </label>
                
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="bri">
                    <div class="payment-card">
                        <div class="payment-icon bri">BRI</div>
                        <div class="payment-info">
                            <strong>Transfer BRI</strong>
                            <small>No. Rek: 1122334455 a.n Batiknesia</small>
                        </div>
                    </div>
                </label>
                
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="cod">
                    <div class="payment-card">
                        <div class="payment-icon cod">COD</div>
                        <div class="payment-info">
                            <strong>COD (Bayar di Tempat)</strong>
                            <small>Bayar saat barang diterima</small>
                        </div>
                    </div>
                </label>
            </div>
            
            <button type="submit" class="btn-checkout">✅ Konfirmasi Pesanan</button>
        </form>
    </div>
    
    <!-- Ringkasan Pesanan -->
    <div class="order-summary card">
        <h3>🛍️ Ringkasan Pesanan</h3>
        
        <div class="product-summary">
            @if($product->image)
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="summary-image">
            @else
                <div class="summary-image-placeholder">
                    <i class="fas fa-tshirt"></i>
                </div>
            @endif
            <div class="summary-details">
                <h4>{{ $product->name }}</h4>
                <p>Jumlah: {{ $quantity }} pcs</p>
                <p class="summary-price">Rp {{ number_format($product->price * $quantity, 0, ',', '.') }}</p>
            </div>
        </div>
        
        <div class="summary-totals">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($product->price * $quantity, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Ongkos Kirim</span>
                <span>Rp 15.000</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>Rp {{ number_format(($product->price * $quantity) + 15000, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="shipping-info">
            <i class="fas fa-truck"></i>
            <span>Estimasi pengiriman: 2-5 hari kerja</span>
        </div>
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
.checkout-container {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 24px;
}
.card {
    background: rgba(255,252,245,0.96);
    border-radius: 20px;
    padding: 24px;
    border: 1px solid rgba(196,167,71,0.2);
}
.checkout-form h3 {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    color: #2c1810;
    margin-bottom: 20px;
}
.form-group {
    margin-bottom: 16px;
}
.form-group label {
    display: block;
    font-size: 13px;
    color: #8b7355;
    margin-bottom: 6px;
    font-weight: 500;
}
.form-group input, .form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #e8dcca;
    border-radius: 12px;
    font-family: 'Poppins', sans-serif;
    background: white;
}
.form-group input:focus, .form-group textarea:focus {
    outline: none;
    border-color: #c4a747;
}
.payment-methods {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 24px;
}
.payment-option {
    cursor: pointer;
}
.payment-option input {
    display: none;
}
.payment-option input:checked + .payment-card {
    border-color: #c4a747;
    background: rgba(196,167,71,0.1);
}
.payment-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px;
    border: 2px solid #e8dcca;
    border-radius: 12px;
    transition: all 0.2s;
}
.payment-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: white;
}
.payment-icon.bca { background: #0055a4; }
.payment-icon.mandiri { background: #002664; }
.payment-icon.bri { background: #0066b3; }
.payment-icon.cod { background: #27ae60; }
.payment-info { flex: 1; }
.payment-info strong { display: block; color: #2c1810; }
.payment-info small { font-size: 11px; color: #8b7355; }
.btn-checkout {
    background: #c4a747;
    color: #2c1810;
    border: none;
    width: 100%;
    padding: 14px;
    border-radius: 40px;
    font-weight: 600;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s;
}
.btn-checkout:hover {
    background: #8b7355;
    color: white;
}
.order-summary h3 {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    color: #2c1810;
    margin-bottom: 20px;
}
.product-summary {
    display: flex;
    gap: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e8dcca;
    margin-bottom: 15px;
}
.summary-image {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
}
.summary-image-placeholder {
    width: 80px;
    height: 80px;
    background: #e8dcca;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.summary-image-placeholder i { font-size: 30px; color: #c4a747; }
.summary-details { flex: 1; }
.summary-details h4 { font-size: 14px; color: #2c1810; margin-bottom: 4px; }
.summary-details p { font-size: 12px; color: #8b7355; }
.summary-price { color: #c4a747; font-weight: 600; margin-top: 4px; }
.summary-totals { margin-top: 15px; }
.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
    color: #8b7355;
}
.summary-row.total {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #e8dcca;
    font-weight: 700;
    color: #2c1810;
    font-size: 16px;
}
.summary-row.total span:last-child { color: #c4a747; }
.shipping-info {
    margin-top: 15px;
    padding: 10px;
    background: #fef3e2;
    border-radius: 10px;
    text-align: center;
    font-size: 12px;
    color: #92400e;
}
.shipping-info i { margin-right: 5px; }
@media (max-width: 992px) {
    .checkout-container { grid-template-columns: 1fr; }
}
</style>
@endsection
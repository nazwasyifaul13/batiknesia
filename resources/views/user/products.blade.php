@extends('layouts.user')

@section('title', 'Products')

@section('content')
@php
    $sliderProducts = \App\Models\Product::where('is_active', 1)->latest()->take(6)->get();
@endphp

<x-hero-section 
    title="Koleksi Batik" 
    subtitle="Nusantara" 
    :products="$sliderProducts" 
/>

<style>
    .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; margin-bottom: 40px; }
    .product-card {
        background: var(--bg-card);
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border);
        transition: all 0.3s;
        box-shadow: var(--shadow);
    }
    .product-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-hover); }
    .product-image { width: 100%; height: 220px; object-fit: cover; transition: transform 0.5s; }
    .product-card:hover .product-image { transform: scale(1.05); }
    .product-image-placeholder { height: 220px; background: var(--accent-glow); display: flex; align-items: center; justify-content: center; }
    .product-image-placeholder i { font-size: 60px; color: var(--accent); }
    .product-info { padding: 20px; }
    .product-title { font-size: 17px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px; }
    .product-price { font-size: 20px; font-weight: 700; color: var(--accent); margin: 10px 0; }
    .product-stock { font-size: 11px; color: var(--text-secondary); margin-bottom: 10px; }
    .qr-section { display: flex; align-items: center; gap: 12px; padding: 10px; background: var(--accent-glow); border-radius: 12px; margin: 12px 0; }
    .qr-code-img { width: 45px; height: 45px; cursor: pointer; border-radius: 8px; background: white; padding: 5px; }
    .btn-buy {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        border: none;
        border-radius: 40px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-buy:hover { transform: translateY(-2px); box-shadow: 0 8px 20px var(--accent-glow); }
    .pagination { display: flex; justify-content: center; margin-top: 30px; gap: 8px; }
    .pagination .page-item .page-link { background: var(--bg-card); border: 1px solid var(--border); color: var(--text-primary); border-radius: 12px; padding: 8px 14px; }
    .pagination .page-item.active .page-link { background: var(--accent); color: #2c1810; }
    .empty-state { text-align: center; padding: 60px; background: var(--bg-card); border-radius: 28px; border: 1px solid var(--border); }
    .empty-state i { font-size: 65px; color: var(--accent); margin-bottom: 20px; opacity: 0.5; }

    @media (max-width: 1200px) { .products-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; } }
    @media (max-width: 900px) { .products-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; } }
    @media (max-width: 600px) { .products-grid { grid-template-columns: 1fr; } }
</style>

<div class="products-grid">
    @forelse($products as $product)
    <div class="product-card">
        @if($product->image && file_exists(public_path($product->image)))
            <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
        @else
            <div class="product-image-placeholder"><i class="fas fa-tshirt"></i></div>
        @endif
        <div class="product-info">
            <div class="product-title">{{ $product->name }}</div>
            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
            <div class="product-stock"><i class="fas fa-box"></i> Stok: {{ $product->stock }} pcs</div>
            <div class="qr-section">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode(route('user.product.detail', $product->id)) }}" class="qr-code-img">
                <div class="qr-text"><i class="fas fa-qrcode"></i> Scan untuk info motif</div>
            </div>
            <button onclick="buyNow({{ $product->id }})" class="btn-buy"><i class="fas fa-shopping-cart"></i> Beli Sekarang</button>
        </div>
    </div>
    @empty
    <div class="empty-state"><i class="fas fa-box-open"></i><p>Belum ada produk yang tersedia</p></div>
    @endforelse
</div>

<div class="pagination">{{ $products->links() }}</div>

<script>
function buyNow(id) {
    Swal.fire({ title: 'Konfirmasi', text: 'Apakah Anda yakin ingin membeli produk ini?', icon: 'question', showCancelButton: true, confirmButtonColor: '#b8860b', confirmButtonText: 'Ya, Beli', cancelButtonText: 'Batal' })
        .then((result) => { if (result.isConfirmed) window.location.href = "/user/checkout?product_id=" + id; });
}
</script>
@endsection
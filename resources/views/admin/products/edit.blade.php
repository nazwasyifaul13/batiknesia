@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div style="margin-bottom: 20px;">
    <h1 style="font-family: 'Playfair Display', serif; font-size: 28px; color: #fff;">Edit Produk</h1>
    <p style="color: #c4a747;">Form untuk mengedit produk batik</p>
</div>

<div class="stat-card">
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Nama Produk</label>
            <input type="text" name="name" value="{{ $product->name }}" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#331515;">
        </div>
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Deskripsi</label>
            <textarea name="description" rows="3" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#331515;">{{ $product->description }}</textarea>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:12px;">
            <div>
                <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Harga (Rp)</label>
                <input type="number" name="price" value="{{ $product->price }}" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#331515;">
            </div>
            <div>
                <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Stok</label>
                <input type="number" name="stock" value="{{ $product->stock }}" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#331515;">
            </div>
        </div>
        @if($product->image)
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Gambar Saat Ini</label>
            <img src="{{ asset($product->image) }}" style="height:60px; border-radius:8px;">
        </div>
        @endif
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Ganti Gambar</label>
            <input type="file" name="image" accept="image/*" style="width:100%; padding:8px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#331515;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="checkbox" name="is_active" {{ $product->is_active ? 'checked' : '' }}> <span style="color:#fff; font-size:13px;">Aktifkan produk</span>
            </label>
        </div>
        <div style="margin-bottom:12px;">
    <label style="display:block; color:#c4a747; margin-bottom:5px;">Motif Batik (untuk QR Code)</label>
    <select name="motif_id" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#fff;">
        <option value="">Pilih Motif</option>
        @foreach($motifs as $motif)
        <option value="{{ $motif->id }}" {{ $product->motif_id == $motif->id ? 'selected' : '' }}>{{ $motif->name }}</option>
        @endforeach
    </select>
</div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn-vintage">Update</button>
            <a href="{{ route('admin.products.index') }}" style="background:rgba(196,167,71,0.2); color:#c4a747; padding:8px 20px; border-radius:30px; text-decoration:none; font-size:12px;">Batal</a>
        </div>
    </form>
</div>
@endsection
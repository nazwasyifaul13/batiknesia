@extends('layouts.admin')

@section('title', 'Tambah Motif Batik')

@section('content')
<div style="margin-bottom: 20px;">
    <h1 style="font-family: 'Playfair Display', serif; font-size: 28px; color: #fff;">Tambah Motif Batik</h1>
    <p style="color: #c4a747;">Form untuk menambah motif batik baru</p>
</div>

<div class="stat-card">
    <form method="POST" action="{{ route('admin.batik-patterns.store') }}" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Nama Motif</label>
            <input type="text" name="name" required style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#fff;">
        </div>
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Asal Daerah</label>
            <input type="text" name="origin" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#fff;">
        </div>
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Filosofi</label>
            <textarea name="philosophy" rows="3" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#fff;"></textarea>
        </div>
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Deskripsi</label>
            <textarea name="description" rows="3" style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#fff;"></textarea>
        </div>
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">Gambar Motif</label>
            <input type="file" name="image" accept="image/*" style="width:100%; padding:8px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#fff;">
        </div>
        <div style="margin-bottom: 12px;">
            <label style="display:block; color:#c4a747; margin-bottom:5px; font-size:13px;">URL Video (YouTube)</label>
            <input type="url" name="video_url" placeholder="https://youtube.com/..." style="width:100%; padding:10px; border-radius:10px; border:1px solid rgba(196,167,71,0.3); background:rgba(255,255,255,0.1); color:#fff;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                <input type="checkbox" name="is_active" checked> <span style="color:#fff; font-size:13px;">Aktifkan motif</span>
            </label>
        </div>
        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn-vintage">Simpan</button>
            <a href="{{ route('admin.batik-patterns.index') }}" style="background:rgba(196,167,71,0.2); color:#c4a747; padding:8px 20px; border-radius:30px; text-decoration:none; font-size:12px;">Batal</a>
        </div>
    </form>
</div>
@endsection
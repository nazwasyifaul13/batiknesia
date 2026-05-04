@extends('layouts.admin')

@section('title', 'Edit Motif Batik')

@section('content')
<style>
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        color: var(--text-muted);
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 500;
    }
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid var(--border);
        background: var(--bg-card);
        color: var(--text-primary);
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(196,167,71,0.1);
    }
    .current-image {
        margin: 10px 0;
        padding: 10px;
        background: var(--accent-light);
        border-radius: 12px;
        display: inline-block;
    }
    .current-image img {
        height: 80px;
        border-radius: 10px;
    }
    .btn-update {
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        color: white;
        padding: 12px 28px;
        border-radius: 40px;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }
    .btn-cancel {
        background: rgba(196,167,71,0.15);
        color: var(--accent);
        padding: 12px 28px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        display: inline-block;
    }
</style>

<div class="section-card" style="max-width: 800px; margin: 0 auto;">
    <div class="section-header">
        <h3><i class="fas fa-edit"></i> Edit Motif Batik</h3>
        <p>Perbarui informasi motif batik</p>
    </div>
    
    <form method="POST" action="{{ route('admin.batik-patterns.update', $pattern) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Nama Motif <span style="color: #ef4444;">*</span></label>
            <input type="text" name="name" value="{{ old('name', $pattern->name) }}" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Asal Daerah</label>
            <input type="text" name="origin" value="{{ old('origin', $pattern->origin) }}" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Filosofi</label>
            <textarea name="philosophy" rows="3" class="form-control">{{ old('philosophy', $pattern->philosophy) }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" rows="4" class="form-control">{{ old('description', $pattern->description) }}</textarea>
        </div>
        
        @if($pattern->image)
        <div class="form-group">
            <label>Gambar Saat Ini</label>
            <div class="current-image">
                <img src="{{ asset($pattern->image) }}" alt="{{ $pattern->name }}">
            </div>
        </div>
        @endif
        
        <div class="form-group">
            <label>Ganti Gambar</label>
            <input type="file" name="image" accept="image/*" class="form-control">
            <small style="color: var(--text-muted);">Format: JPG, PNG, JPEG. Max: 2MB</small>
        </div>
        
        <div class="form-group">
            <label>URL Video (YouTube) - Opsional</label>
            <input type="url" name="video_url" value="{{ old('video_url', $pattern->video_url) }}" placeholder="https://www.youtube.com/watch?v=..." class="form-control">
        </div>
        
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="is_active" value="1" {{ $pattern->is_active ? 'checked' : '' }}>
                <span>Aktifkan motif (ditampilkan di website)</span>
            </label>
        </div>
        
        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" class="btn-update">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.batik-patterns.index') }}" class="btn-cancel">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
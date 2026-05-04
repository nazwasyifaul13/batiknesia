@extends('layouts.admin')

@section('title', 'Edit Konten Edukasi')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 32px; color: #2c1810;">Edit Konten Edukasi</h1>
    <p style="color: #8b7355;">Edit artikel atau video tentang batik</p>
</div>

<div style="background: rgba(255, 252, 245, 0.95); border-radius: 24px; border: 1px solid rgba(196, 167, 71, 0.3); padding: 30px;">
    <form method="POST" action="{{ route('admin.education.update', $education) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; color: #2c1810; margin-bottom: 8px; font-weight: 600;">Judul *</label>
            <input type="text" name="title" value="{{ $education->title }}" required style="width: 100%; padding: 12px; border: 1px solid #e8dcca; border-radius: 12px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; color: #2c1810; margin-bottom: 8px; font-weight: 600;">Kategori *</label>
            <select name="category" required style="width: 100%; padding: 12px; border: 1px solid #e8dcca; border-radius: 12px;">
                <option value="article" {{ $education->category == 'article' ? 'selected' : '' }}>Artikel</option>
                <option value="video" {{ $education->category == 'video' ? 'selected' : '' }}>Video</option>
            </select>
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; color: #2c1810; margin-bottom: 8px; font-weight: 600;">Konten *</label>
            <textarea name="content" rows="8" required style="width: 100%; padding: 12px; border: 1px solid #e8dcca; border-radius: 12px;">{{ $education->content }}</textarea>
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; color: #2c1810; margin-bottom: 8px; font-weight: 600;">URL Video</label>
            <input type="url" name="video_url" value="{{ $education->video_url }}" style="width: 100%; padding: 12px; border: 1px solid #e8dcca; border-radius: 12px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                <input type="checkbox" name="is_published" {{ $education->is_published ? 'checked' : '' }}> 
                <span style="color: #2c1810;">Publikasikan</span>
            </label>
        </div>
        
        <div style="display: flex; gap: 15px;">
            <button type="submit" style="background: #c4a747; color: #2c1810; padding: 12px 30px; border: none; border-radius: 12px; font-weight: 600; cursor: pointer;">Update</button>
            <a href="{{ route('admin.education.index') }}" style="background: #e8dcca; color: #2c1810; padding: 12px 30px; border: none; border-radius: 12px; text-decoration: none;">Batal</a>
        </div>
    </form>
</div>
@endsection
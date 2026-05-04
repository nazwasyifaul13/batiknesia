@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<style>
    .profile-card { max-width: 550px; margin: 0 auto; text-align: center; }
    .avatar-container { position: relative; width: 130px; height: 130px; margin: 0 auto 25px; cursor: pointer; }
    .avatar-preview { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--accent); }
    .avatar-overlay { position: absolute; bottom: 5px; right: 5px; background: var(--accent); border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; }
    .avatar-overlay:hover { transform: scale(1.05); }
    .avatar-overlay i { color: #2c1810; font-size: 16px; }
    .info-row { display: flex; padding: 16px 0; border-bottom: 1px solid var(--border); }
    .info-label { width: 130px; font-weight: 600; color: var(--text-primary); text-align: left; }
    .info-value { flex: 1; color: var(--text-secondary); text-align: left; }
    .edit-input { width: 100%; padding: 10px 14px; border: 1px solid var(--border); border-radius: 12px; background: var(--bg-card); color: var(--text-primary); }
    .edit-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
    .btn-save { width: 100%; padding: 14px; background: linear-gradient(135deg, var(--accent), #8b7355); border: none; border-radius: 40px; color: #2c1810; font-weight: 600; cursor: pointer; margin-top: 25px; transition: all 0.3s; }
    .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px var(--accent-glow); color: white; }
</style>

<div class="page-header">
    <h1>Profil Saya</h1>
    <p>Kelola informasi akun Anda</p>
    <div class="decorative-line"></div>
</div>

<div class="profile-card card-premium">
    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="avatar-container" onclick="document.getElementById('avatarInput').click()">
            @if(Auth::user()->avatar && file_exists(public_path(Auth::user()->avatar)))
                <img src="{{ asset(Auth::user()->avatar) }}" class="avatar-preview" id="avatarPreview">
            @else
                <div class="avatar-preview" style="background: linear-gradient(145deg, #c4a747, #8b7355); display: flex; align-items: center; justify-content: center;"><i class="fas fa-user" style="font-size: 55px; color: #2c1810;"></i></div>
            @endif
            <div class="avatar-overlay"><i class="fas fa-camera"></i></div>
        </div>
        <input type="file" name="avatar" id="avatarInput" style="display: none;" accept="image/*" onchange="previewAvatar(this)">
        
        <div class="info-row"><div class="info-label">Nama Lengkap</div><div class="info-value"><input type="text" name="name" value="{{ Auth::user()->name }}" class="edit-input"></div></div>
        <div class="info-row"><div class="info-label">Email</div><div class="info-value">{{ Auth::user()->email }}</div></div>
        <div class="info-row"><div class="info-label">Bergabung</div><div class="info-value">{{ Auth::user()->created_at->translatedFormat('d F Y') }}</div></div>
        <div class="info-row"><div class="info-label">Role</div><div class="info-value">{{ ucfirst(Auth::user()->role) }}</div></div>
        
        <button type="submit" class="btn-save">Simpan Perubahan</button>
    </form>
</div>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) { document.getElementById('avatarPreview').src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
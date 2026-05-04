@extends('layouts.admin')

@section('title', 'Riwayat Try On')
@section('subtitle', 'Kelola riwayat virtual try on pengguna')

@section('content')
<style>
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .stat-mini {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 18px;
        border: 1px solid var(--border);
        text-align: center;
    }
    
    .stat-mini-value {
        font-size: 28px;
        font-weight: 700;
        color: #c4a747;
    }
    
    .stat-mini-label {
        font-size: 12px;
        color: var(--text-secondary);
        margin-top: 5px;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        text-align: left;
        padding: 14px 12px;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        border-bottom: 1px solid var(--border);
    }
    
    .data-table td {
        padding: 14px 12px;
        font-size: 13px;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    
    .tryon-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .image-placeholder {
        width: 50px;
        height: 50px;
        background: #e8dcca;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .recommendation-text {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: var(--text-secondary);
        font-size: 12px;
    }
    
    .user-name {
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .motif-name {
        color: #c4a747;
        font-weight: 500;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .action-buttons button {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .btn-delete {
        color: #dc2626;
    }
    
    .btn-delete:hover {
        color: #991b1b;
        transform: scale(1.1);
    }
    
    .btn-view {
        color: #c4a747;
    }
    
    .btn-view:hover {
        color: #8b7355;
        transform: scale(1.1);
    }
    
    .empty-state {
        text-align: center;
        padding: 50px;
        color: var(--text-secondary);
    }
    
    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
</style>

<div class="header-actions" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 24px;">📸 Riwayat Try On</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Riwayat virtual try on dari semua pengguna</p>
    </div>
</div>

<!-- Mini Stats -->
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $tryOnSessions->total() }}</div>
        <div class="stat-mini-label">Total Try On</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $tryOnSessions->where('selected_motif_id', '!=', null)->count() }}</div>
        <div class="stat-mini-label">Dengan Motif</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $tryOnSessions->where('generated_image', '!=', null)->count() }}</div>
        <div class="stat-mini-label">Dengan Hasil</div>
    </div>
</div>

<!-- Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengguna</th>
                    <th>Motif</th>
                    <th>Gambar Asli</th>
                    <th>Hasil Try On</th>
                    <th>Rekomendasi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tryOnSessions as $session)
                <tr>
                    <td>{{ $session->id }}</td>
                    <td>
                        <div class="user-name">{{ $session->user->name }}</div>
                        <div style="font-size: 11px; color: var(--text-secondary);">{{ $session->user->email }}</div>
                    </td>
                    <td>
                        @if($session->motif)
                            <span class="motif-name">{{ $session->motif->name }}</span>
                        @else
                            <span style="color: var(--text-secondary);">-</span>
                        @endif
                    </td>
                    <td>
                        @if($session->original_image)
                            <img src="{{ asset($session->original_image) }}" class="tryon-image" onclick="window.open(this.src)">
                        @else
                            <div class="image-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td>
                        @if($session->generated_image)
                            <img src="{{ asset($session->generated_image) }}" class="tryon-image" onclick="window.open(this.src)">
                        @else
                            <div class="image-placeholder"><i class="fas fa-spinner"></i></div>
                        @endif
                    </td>
                    <td>
                        <div class="recommendation-text" title="{{ $session->recommendation }}">
                            {{ Str::limit($session->recommendation, 50) }}
                        </div>
                    </td>
                    <td style="color: var(--text-secondary);">{{ $session->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <div class="action-buttons">
                            <button onclick="confirmDelete({{ $session->id }})" class="btn-delete" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="fas fa-camera" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        Belum ada riwayat try on
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    {{ $tryOnSessions->links() }}
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Riwayat?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#8b7355',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#fffcf5'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/tryon-history/' + id;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}', confirmButtonColor: '#c4a747' });
</script>
@endif
@endsection
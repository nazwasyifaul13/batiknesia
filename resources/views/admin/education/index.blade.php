@extends('layouts.admin')

@section('title', 'Edukasi Batik')
@section('subtitle', 'Kelola konten edukasi tentang batik')

@section('content')
<style>
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .btn-add {
        background: #c4a747;
        color: #2c1810;
        padding: 10px 24px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-add:hover {
        background: #8b7355;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Stats Row */
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
    
    /* Table */
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
    
    .education-image {
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
    
    .category-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 500;
    }
    
    .category-badge.article {
        background: #d1fae5;
        color: #065f46;
    }
    
    .category-badge.video {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 500;
    }
    
    .status-badge.published {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-badge.draft {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .action-buttons a, .action-buttons button {
        color: #c4a747;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .action-buttons a:hover, .action-buttons button:hover {
        color: #8b7355;
        transform: scale(1.1);
    }
    
    .video-link {
        color: #c4a747;
        text-decoration: none;
        font-size: 12px;
    }
    
    .video-link:hover {
        text-decoration: underline;
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

<div class="header-actions">
    <div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 24px;">📚 Edukasi Batik</h1>
        <p style="color: var(--text-secondary); margin-top: 5px;">Kelola artikel dan video edukasi tentang batik</p>
    </div>
    <a href="{{ route('admin.education.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Tambah Konten
    </a>
</div>

<!-- Mini Stats -->
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $educations->total() }}</div>
        <div class="stat-mini-label">Total Konten</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $educations->where('category', 'article')->count() }}</div>
        <div class="stat-mini-label">Artikel</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $educations->where('category', 'video')->count() }}</div>
        <div class="stat-mini-label">Video</div>
    </div>
</div>

<!-- Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Link</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($educations as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if($item->image)
                            <img src="{{ asset($item->image) }}" class="education-image">
                        @else
                            <div class="image-placeholder">
                                <i class="fas fa-{{ $item->category == 'video' ? 'video' : 'book' }}" style="color: #c4a747;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight: 500;">{{ Str::limit($item->title, 40) }}</td>
                    <td>
                        <span class="category-badge {{ $item->category }}">
                            <i class="fas fa-{{ $item->category == 'video' ? 'play' : 'file-alt' }}"></i>
                            {{ $item->category == 'article' ? 'Artikel' : 'Video' }}
                        </span>
                    </td>
                    <td>
                        @if($item->video_url)
                            <a href="{{ $item->video_url }}" target="_blank" class="video-link">
                                <i class="fab fa-youtube"></i> Tonton
                            </a>
                        @else
                            <span style="color: var(--text-secondary);">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $item->is_published ? 'published' : 'draft' }}">
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td style="color: var(--text-secondary);">{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.education.edit', $item) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $item->id }}, '{{ $item->title }}')" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="fas fa-graduation-cap" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        Belum ada konten edukasi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    {{ $educations->links() }}
</div>

<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Hapus Konten?',
        html: `Apakah Anda yakin ingin menghapus "<strong>${title}</strong>"?`,
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
            form.action = '/admin/education/' + id;
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
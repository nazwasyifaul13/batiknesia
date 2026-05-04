@extends('layouts.admin')

@section('title', 'Batik Patterns')
@section('subtitle', 'Manage traditional batik patterns')

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
        background: linear-gradient(135deg, #c4a747, #8b7355);
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(196,167,71,0.3);
    }
    
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .stat-mini {
        background: var(--bg-card);
        border-radius: 16px;
        padding: 16px;
        border: 1px solid var(--border);
        text-align: center;
    }
    
    .stat-mini-value {
        font-size: 24px;
        font-weight: 700;
        color: #c4a747;
    }
    
    .stat-mini-label {
        font-size: 11px;
        color: var(--text-secondary);
        margin-top: 4px;
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
    
    .pattern-image {
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
    
    .video-link {
        color: #c4a747;
        text-decoration: none;
        font-size: 12px;
    }
    
    .video-link:hover {
        text-decoration: underline;
    }
    
    .status-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 500;
    }
    
    .status-badge.active {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .action-buttons {
        display: flex;
        gap: 12px;
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
        <h1 style="font-family: 'Playfair Display', serif; font-size: 24px;">🎨 Batik Patterns</h1>
        <p style="color: var(--text-secondary); margin-top: 4px;">Manage traditional batik patterns</p>
    </div>
    <a href="{{ route('admin.batik-patterns.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Add Pattern
    </a>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $patterns->total() }}</div>
        <div class="stat-mini-label">Total Patterns</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $patterns->where('is_active', 1)->count() }}</div>
        <div class="stat-mini-label">Active</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $patterns->where('video_url', '!=', null)->count() }}</div>
        <div class="stat-mini-label">With Video</div>
    </div>
</div>

<!-- Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Origin</th>
                    <th>Video</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patterns as $pattern)
                <tr>
                    <td>{{ $pattern->id }}</td>
                    <td>
                        @if($pattern->image)
                            <img src="{{ asset($pattern->image) }}" class="pattern-image">
                        @else
                            <div class="image-placeholder">
                                <i class="fas fa-palette" style="color: #c4a747;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight: 500;">{{ $pattern->name }}</td>
                    <td style="color: var(--text-secondary);">{{ $pattern->origin ?? '-' }}</td>
                    <td>
                        @if($pattern->video_url)
                            <a href="{{ $pattern->video_url }}" target="_blank" class="video-link">
                                <i class="fab fa-youtube"></i> Watch
                            </a>
                        @else
                            <span style="color: var(--text-secondary);">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $pattern->is_active ? 'active' : 'inactive' }}">
                            {{ $pattern->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.batik-patterns.edit', $pattern) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $pattern->id }}, '{{ $pattern->name }}')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-palette" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        No batik patterns found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    {{ $patterns->links() }}
</div>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Delete Pattern?',
        html: `Are you sure you want to delete "<strong>${name}</strong>"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#8b7355',
        confirmButtonText: 'Yes, Delete!',
        cancelButtonText: 'Cancel',
        background: '#fffcf5'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/batik-patterns/' + id;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', confirmButtonColor: '#c4a747' });
</script>
@endif
@endsection
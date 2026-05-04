@extends('layouts.admin')

@section('title', 'Products')
@section('subtitle', 'Manage your batik products')

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
    
    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
    
    .product-image {
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
    
    .qr-code {
        width: 40px;
        height: 40px;
        cursor: pointer;
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
        <h1 style="font-family: 'Playfair Display', serif; font-size: 24px;">🛍️ Products</h1>
        <p style="color: var(--text-secondary); margin-top: 4px;">Manage your batik products inventory</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $products->total() }}</div>
        <div class="stat-mini-label">Total Products</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $products->where('is_active', 1)->count() }}</div>
        <div class="stat-mini-label">Active</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $products->where('is_active', 0)->count() }}</div>
        <div class="stat-mini-label">Inactive</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $products->sum('stock') }}</div>
        <div class="stat-mini-label">Total Stock</div>
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
                    <th>Price</th>
                    <th>Stock</th>
                    <th>QR Code</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="product-image">
                        @else
                            <div class="image-placeholder">
                                <i class="fas fa-tshirt" style="color: #c4a747;"></i>
                            </div>
                        @endif
                    </td>
                    <td style="font-weight: 500;">{{ $product->name }}</td>
                    <td style="color: #c4a747; font-weight: 600;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->qr_code)
                            <img src="{{ asset($product->qr_code) }}" class="qr-code" onclick="showQR('{{ asset($product->qr_code) }}', '{{ $product->name }}')">
                        @else
                            <span style="color: var(--text-secondary);">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge {{ $product->is_active ? 'active' : 'inactive' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.products.edit', $product) }}" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @if($product->qr_code)
                                <a href="{{ asset($product->qr_code) }}" download title="Download QR">
                                    <i class="fas fa-download"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-state">
                        <i class="fas fa-box-open" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        No products found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    {{ $products->links() }}
</div>

<!-- QR Modal -->
<div id="qrModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 20px; padding: 25px; max-width: 350px; width: 90%; text-align: center;">
        <h3 id="qrModalTitle" style="margin-bottom: 15px;"></h3>
        <img id="qrModalImage" src="" style="width: 200px; height: 200px; margin: 0 auto;">
        <button onclick="closeQRModal()" style="margin-top: 20px; background: #c4a747; color: #2c1810; border: none; padding: 8px 20px; border-radius: 30px; cursor: pointer;">Close</button>
    </div>
</div>

<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Delete Product?',
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
            form.action = '/admin/products/' + id;
            form.innerHTML = '@csrf @method("DELETE")';
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function showQR(url, name) {
    document.getElementById('qrModalTitle').innerText = name;
    document.getElementById('qrModalImage').src = url;
    document.getElementById('qrModal').style.display = 'flex';
}

function closeQRModal() {
    document.getElementById('qrModal').style.display = 'none';
}
</script>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', confirmButtonColor: '#c4a747' });
</script>
@endif
@endsection
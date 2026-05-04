@extends('layouts.admin')

@section('title', 'Orders')
@section('subtitle', 'Manage customer orders')

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
    
    .status {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 500;
    }
    
    .status.pending { background: #fef3c7; color: #92400e; }
    .status.processing { background: #dbeafe; color: #1e40af; }
    .status.shipped { background: #e0f2fe; color: #0891b2; }
    .status.delivered { background: #d1fae5; color: #065f46; }
    .status.cancelled { background: #fee2e2; color: #991b1b; }
    
    .action-buttons {
        display: flex;
        gap: 10px;
    }
    
    .action-buttons a {
        color: #c4a747;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .action-buttons a:hover {
        color: #8b7355;
    }
    
    .order-status-select {
        padding: 4px 8px;
        border-radius: 20px;
        border: 1px solid var(--border);
        background: var(--bg-card);
        color: var(--text-primary);
        font-size: 11px;
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
    
    .update-status-btn {
        background: none;
        border: none;
        color: #c4a747;
        cursor: pointer;
        margin-left: 5px;
    }
    
    .update-status-btn:hover {
        color: #8b7355;
    }
</style>

<div class="header-actions">
    <div>
        <h1 style="font-family: 'Playfair Display', serif; font-size: 24px;">📦 Orders</h1>
        <p style="color: var(--text-secondary); margin-top: 4px;">Manage customer orders</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $orders->total() }}</div>
        <div class="stat-mini-label">Total Orders</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $orders->where('status', 'pending')->count() }}</div>
        <div class="stat-mini-label">Pending</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $orders->where('status', 'processing')->count() }}</div>
        <div class="stat-mini-label">Processing</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $orders->where('status', 'delivered')->count() }}</div>
        <div class="stat-mini-label">Delivered</div>
    </div>
</div>

<!-- Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span style="font-weight: 500;">#{{ $order->order_number }}</span></td>
                    <td>{{ $order->user->name }}</td>
                    <td style="color: #c4a747; font-weight: 600;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" style="display: flex; align-items: center; gap: 5px;">
                            @csrf
                            @method('PUT')
                            <select name="status" class="order-status-select" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="update-status-btn" title="Update">
                                <i class="fas fa-save"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                        <span class="status {{ $order->payment_status }}">
                            {{ $order->payment_status == 'paid' ? 'Paid' : 'Unpaid' }}
                        </span>
                    </td>
                    <td style="color: var(--text-secondary);">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.orders.show', $order) }}" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-shopping-cart" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        No orders found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    {{ $orders->links() }}
</div>

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Success!', text: '{{ session('success') }}', confirmButtonColor: '#c4a747' });
</script>
@endif
@endsection
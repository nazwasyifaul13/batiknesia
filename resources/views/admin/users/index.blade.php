@extends('layouts.admin')

@section('title', 'Users')
@section('subtitle', 'Manage all registered users')

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
    
    .user-avatar {
        width: 40px;
        height: 40px;
        background: #c4a747;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .user-avatar i {
        color: #2c1810;
        font-size: 18px;
    }
    
    .role-badge {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 500;
    }
    
    .role-badge.admin {
        background: #fef3c7;
        color: #92400e;
    }
    
    .role-badge.user {
        background: #d1fae5;
        color: #065f46;
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
        <h1 style="font-family: 'Playfair Display', serif; font-size: 24px;">👥 Users</h1>
        <p style="color: var(--text-secondary); margin-top: 4px;">Manage all registered users</p>
    </div>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $users->total() }}</div>
        <div class="stat-mini-label">Total Users</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $users->where('role', 'admin')->count() }}</div>
        <div class="stat-mini-label">Admins</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $users->where('role', 'user')->count() }}</div>
        <div class="stat-mini-label">Customers</div>
    </div>
    <div class="stat-mini">
        <div class="stat-mini-value">{{ $users->where('is_active', 1)->count() }}</div>
        <div class="stat-mini-label">Active</div>
    </div>
</div>

<!-- Table -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                    </td>
                    <td style="font-weight: 500;">{{ $user->name }}</td>
                    <td style="color: var(--text-secondary);">{{ $user->email }}</td>
                    <td>
                        <span class="role-badge {{ $user->role }}">
                            <i class="fas fa-{{ $user->role == 'admin' ? 'crown' : 'user' }}"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td style="color: var(--text-secondary);">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="empty-state">
                        <i class="fas fa-users" style="font-size: 48px; color: #ccc; margin-bottom: 15px; display: block;"></i>
                        No users found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination">
    {{ $users->links() }}
</div>
@endsection
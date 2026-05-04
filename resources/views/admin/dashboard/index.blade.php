@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('subtitle', 'Selamat datang di panel admin Batiknesia')

@section('content')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid var(--border);
        transition: all 0.3s;
        box-shadow: var(--shadow);
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .stat-card h3 {
        font-size: 28px;
        font-weight: 800;
        color: var(--accent);
        margin-bottom: 5px;
    }
    
    .stat-card p {
        font-size: 13px;
        color: var(--text-secondary);
        font-weight: 500;
    }
    
    .stat-card i {
        font-size: 24px;
        color: var(--accent);
        margin-bottom: 10px;
        display: inline-block;
    }
    
    .chart-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
        margin-bottom: 30px;
    }
    
    .chart-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    
    .chart-card h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--border);
    }
    
    .chart-card canvas {
        max-height: 300px;
        width: 100%;
    }
    
    .table-card {
        background: var(--bg-card);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        margin-bottom: 30px;
    }
    
    .table-card h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-card h4 i {
        color: var(--accent);
        font-size: 18px;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table th {
        text-align: left;
        padding: 12px 8px;
        color: var(--text-secondary);
        font-size: 12px;
        font-weight: 600;
        border-bottom: 1px solid var(--border);
    }
    
    .data-table td {
        padding: 12px 8px;
        color: var(--text-primary);
        font-size: 13px;
        border-bottom: 1px solid var(--border);
    }
    
    .data-table tr:last-child td {
        border-bottom: none;
    }
    
    .badge-status {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-pending { background: #fef3c7; color: #92400e; }
    .badge-processing { background: #dbeafe; color: #1e40af; }
    .badge-shipped { background: #e0f2fe; color: #0891b2; }
    .badge-delivered { background: #d1fae5; color: #065f46; }
    .badge-cancelled { background: #fee2e2; color: #991b1b; }
    
    .badge-role {
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-admin { background: rgba(196,167,71,0.2); color: #c4a747; }
    .badge-user { background: rgba(76,175,80,0.2); color: #4caf50; }
    
    .btn-link {
        color: var(--accent);
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
    }
    
    .btn-link:hover {
        text-decoration: underline;
    }
    
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }
    
    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .chart-row { grid-template-columns: 1fr; }
        .grid-2 { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <i class="fas fa-money-bill-wave"></i>
        <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        <p>Total Pendapatan</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-shopping-cart"></i>
        <h3>{{ number_format($totalOrders) }}</h3>
        <p>Total Pesanan</p>
        <small>{{ $pendingOrders }} pending</small>
    </div>
    <div class="stat-card">
        <i class="fas fa-box"></i>
        <h3>{{ number_format($totalProducts) }}</h3>
        <p>Total Produk</p>
        <small>{{ $lowStockProducts }} stok menipis</small>
    </div>
    <div class="stat-card">
        <i class="fas fa-users"></i>
        <h3>{{ number_format($totalUsers) }}</h3>
        <p>Pengguna Aktif</p>
        <small>+{{ $newUsersThisMonth }} bulan ini</small>
    </div>
</div>

<!-- Charts Row -->
<div class="chart-row">
    <div class="chart-card">
        <h4><i class="fas fa-chart-line"></i> Trend Penjualan 6 Bulan</h4>
        <canvas id="salesChart"></canvas>
    </div>
    <div class="chart-card">
        <h4><i class="fas fa-chart-pie"></i> Status Pesanan</h4>
        <canvas id="orderStatusChart"></canvas>
    </div>
</div>

<!-- Top Products & Recent Orders -->
<div class="grid-2">
    <div class="table-card">
        <h4><i class="fas fa-star"></i> Produk Terlaris</h4>
        <table class="data-table">
            <thead>
                <tr><th>Produk</th><th>Terjual</th><th>Harga</th></tr>
            </thead>
            <tbody>
                @foreach($topProducts as $product)
                <tr>
                    <td>{{ Str::limit($product->name, 25) }}</td>
                    <td>{{ $product->total_sold ?? 0 }} pcs</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                </td>
                @endforeach
                @if($topProducts->count() == 0)
                <tr><td colspan="3" style="text-align: center;">Belum ada data</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    
    <div class="table-card">
        <h4><i class="fas fa-history"></i> Pesanan Terbaru</h4>
        <table class="data-table">
            <thead>
                <tr><th>No. Pesanan</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td>#{{ $order->order_number ?? $order->id }}</td>
                    <td>{{ $order->user->name ?? 'Guest' }}</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td><span class="badge-status badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn-link">Detail</a></td>
                </tr>
                @endforeach
                @if($recentOrders->count() == 0)
                <tr><td colspan="5" style="text-align: center;">Belum ada pesanan</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Users -->
<div class="table-card">
    <h4><i class="fas fa-users"></i> Pengguna Terbaru</h4>
    <table class="data-table">
        <thead>
            <tr><th>Nama</th><th>Email</th><th>Role</th><th>Bergabung</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @foreach($recentUsers as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge-role badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td><a href="{{ route('admin.users.show', $user) }}" class="btn-link">Detail</a></td>
            </tr>
            @endforeach
            @if($recentUsers->count() == 0)
            <tr><td colspan="5" style="text-align: center;">Belum ada pengguna</td></tr>
            @endif
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels ?? []) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($monthlySales ?? []) !!},
                borderColor: '#b8860b',
                backgroundColor: 'rgba(184, 134, 11, 0.1)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#b8860b',
                pointBorderColor: '#fff',
                pointHoverRadius: 6,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                },
                legend: { position: 'top' }
            },
            scales: {
                y: {
                    ticks: {
                        callback: function(val) {
                            return 'Rp ' + (val / 1000000).toFixed(1) + 'jt';
                        }
                    },
                    title: { display: true, text: 'Jutaan Rupiah' }
                }
            }
        }
    });
    
    // Order Status Chart
    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($orderStatusLabels ?? []) !!},
            datasets: [{
                data: {!! json_encode($orderStatusData ?? []) !!},
                backgroundColor: ['#fef3c7', '#dbeafe', '#e0f2fe', '#d1fae5', '#fee2e2'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection
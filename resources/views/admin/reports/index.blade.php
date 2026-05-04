@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 32px; color: #f7b291;">Laporan</h1>
    <p style="color: #8b7355;">Ringkasan data penjualan dan statistik toko</p>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; border-radius: 20px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="color: #8b7355; font-size: 13px;">Total Pendapatan</p>
        <p style="font-size: 28px; font-weight: 700; color: #5c4033;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    
    <div style="background: white; border-radius: 20px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="color: #8b7355; font-size: 13px;">Total Pesanan</p>
        <p style="font-size: 28px; font-weight: 700; color: #5c4033;">{{ $totalOrders }}</p>
        <p style="font-size: 12px; color: #c4a747;">Pending: {{ $pendingOrders }} | Selesai: {{ $completedOrders }}</p>
    </div>
    
    <div style="background: white; border-radius: 20px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="color: #8b7355; font-size: 13px;">Total Produk</p>
        <p style="font-size: 28px; font-weight: 700; color: #5c4033;">{{ $totalProducts }}</p>
        <p style="font-size: 12px; color: #27ae60;">Aktif: {{ $activeProducts }}</p>
    </div>
    
    <div style="background: white; border-radius: 20px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <p style="color: #8b7355; font-size: 13px;">Total Pengguna</p>
        <p style="font-size: 28px; font-weight: 700; color: #5c4033;">{{ $totalUsers }}</p>
        <p style="font-size: 12px; color: #27ae60;">Baru bulan ini: +{{ $newUsers }}</p>
    </div>
</div>

<!-- Monthly Sales -->
<div style="background: white; border-radius: 20px; padding: 25px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <h3 style="font-size: 20px; font-weight: 600; color: #5c4033; margin-bottom: 20px;">Penjualan Per Bulan</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e8dcca;">
                    <th style="padding: 12px; text-align: left; color: #8b7355;">Bulan</th>
                    <th style="padding: 12px; text-align: right; color: #8b7355;">Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlySales as $sale)
                <tr style="border-bottom: 1px solid #e8dcca;">
                    <td style="padding: 12px; color: #5c4033;">{{ $sale['month'] }}</td>
                    <td style="padding: 12px; text-align: right; color: #c4a747; font-weight: 600;">Rp {{ number_format($sale['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Top Products -->
<div style="background: white; border-radius: 20px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <h3 style="font-size: 20px; font-weight: 600; color: #5c4033; margin-bottom: 20px;">Produk Terlaris</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e8dcca;">
                    <th style="padding: 12px; text-align: left; color: #8b7355;">Produk</th>
                    <th style="padding: 12px; text-align: right; color: #8b7355;">Terjual</th>
                    <th style="padding: 12px; text-align: right; color: #8b7355;">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topProducts as $product)
                <tr style="border-bottom: 1px solid #e8dcca;">
                    <td style="padding: 12px; color: #5c4033;">{{ $product->name }}</td>
                    <td style="padding: 12px; text-align: right; color: #5c4033;">{{ $product->sold_count }} pcs</td>
                    <td style="padding: 12px; text-align: right; color: #c4a747;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Produk Batik')

@section('content')
<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 32px; color: #fff;">Produk Batik</h1>
        <p style="color: #a0a0b0; margin-top: 5px;">Kelola produk batik Anda</p>
    </div>
    <a href="{{ route('admin.products.create') }}" style="background: #c4a747; color: #1a1a2e; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s;">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
</div>

<div style="background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border-radius: 24px; border: 1px solid rgba(196, 167, 71, 0.2); overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.2);">
                <th style="padding: 18px 16px; text-align: left; color: #c4a747; font-weight: 600;">ID</th>
                <th style="padding: 18px 16px; text-align: left; color: #c4a747; font-weight: 600;">Nama Produk</th>
                <th style="padding: 18px 16px; text-align: left; color: #c4a747; font-weight: 600;">Harga</th>
                <th style="padding: 18px 16px; text-align: left; color: #c4a747; font-weight: 600;">Stok</th>
                <th style="padding: 18px 16px; text-align: left; color: #c4a747; font-weight: 600;">Status</th>
                <th style="padding: 18px 16px; text-align: left; color: #c4a747; font-weight: 600;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.1); transition: all 0.3s;">
                <td style="padding: 16px; color: #fff;">{{ $product->id }}</td>
                <td style="padding: 16px; color: #fff;">{{ $product->name }}</td>
                <td style="padding: 16px; color: #c4a747;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td style="padding: 16px; color: #fff;">{{ $product->stock }}</td>
                <td style="padding: 16px;">
                    <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; background: {{ $product->is_active ? 'rgba(76, 175, 80, 0.2)' : 'rgba(244, 67, 54, 0.2)' }}; color: {{ $product->is_active ? '#4caf50' : '#f44336' }};">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td style="padding: 16px;">
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('admin.products.edit', $product) }}" style="color: #c4a747; text-decoration: none;">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #f44336; cursor: pointer;" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding: 40px; text-align: center; color: #a0a0b0;">Belum ada produk</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top: 20px;">
    {{ $products->links() }}
</div>
@endsection
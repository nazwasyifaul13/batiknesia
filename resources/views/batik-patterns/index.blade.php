@extends('layouts.admin')

@section('title', 'Motif Batik')

@section('content')
<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
    <div>
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 32px; color: #fff;">Motif Batik</h1>
        <p style="color: #a0825a;">Kelola motif batik tradisional</p>
    </div>
    <a href="{{ route('admin.batik-patterns.create') }}" style="background: #c4a747; color: #2c1810; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 600;">
        <i class="fas fa-plus"></i> Tambah Motif
    </a>
</div>

<div class="stat-card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.2);">
                    <th style="padding: 15px; text-align: left; color: #c4a747;">ID</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Nama Motif</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Asal</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Status</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Aksi</th>
                 </tr>
            </thead>
            <tbody>
                @forelse($patterns as $pattern)
                <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.1);">
                    <td style="padding: 15px; color: #fff;">{{ $pattern->id }}</td>
                    <td style="padding: 15px; color: #fff;">{{ $pattern->name }}</td>
                    <td style="padding: 15px; color: #a0825a;">{{ $pattern->origin ?? '-' }}</td>
                    <td style="padding: 15px;">
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; background: {{ $pattern->is_active ? 'rgba(76, 175, 80, 0.2)' : 'rgba(244, 67, 54, 0.2)' }}; color: {{ $pattern->is_active ? '#4caf50' : '#f44336' }};">
                            {{ $pattern->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td style="padding: 15px;">
                        <div style="display: flex; gap: 10px;">
                            <a href="{{ route('admin.batik-patterns.edit', $pattern) }}" style="color: #c4a747;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.batik-patterns.destroy', $pattern) }}" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #f44336; cursor: pointer;" onclick="return confirm('Yakin hapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                 </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #a0825a;">Belum ada motif batik</td>
                 </tr>
                @endforelse
            </tbody>
         </table>
    </div>
    <div style="margin-top: 20px;">
        {{ $patterns->links() }}
    </div>
</div>
@endsection
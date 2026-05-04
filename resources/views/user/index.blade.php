@extends('layouts.admin')

@section('title', 'Pengguna')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 32px; color: #fff;">Pengguna</h1>
    <p style="color: #a0825a;">Kelola semua pengguna aplikasi</p>
</div>

<div class="stat-card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.2);">
                    <th style="padding: 15px; text-align: left; color: #c4a747;">ID</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Nama</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Email</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Role</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Bergabung</th>
                 </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.1);">
                    <td style="padding: 15px; color: #fff;">{{ $user->id }}</td>
                    <td style="padding: 15px; color: #fff;">{{ $user->name }}</td>
                    <td style="padding: 15px; color: #a0825a;">{{ $user->email }}</td>
                    <td style="padding: 15px;">
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; background: {{ $user->role == 'admin' ? 'rgba(196, 167, 71, 0.2)' : 'rgba(76, 175, 80, 0.2)' }}; color: {{ $user->role == 'admin' ? '#c4a747' : '#4caf50' }};">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td style="padding: 15px; color: #a0825a;">{{ $user->created_at->format('d/m/Y') }}</td>
                 </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #a0825a;">Belum ada pengguna</td>
                 </tr>
                @endforelse
            </tbody>
         </table>
    </div>
    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
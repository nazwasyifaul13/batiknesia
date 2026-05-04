@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 32px; color: #fff;">Pesanan</h1>
    <p style="color: #a0825a;">Kelola semua pesanan batik</p>
</div>

<div class="stat-card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.2);">
                    <th style="padding: 15px; text-align: left; color: #c4a747;">No. Order</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Pelanggan</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Total</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Status</th>
                    <th style="padding: 15px; text-align: left; color: #c4a747;">Tanggal</th>
                 </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr style="border-bottom: 1px solid rgba(196, 167, 71, 0.1);">
                    <td style="padding: 15px; color: #fff;">{{ $order->order_number }}</td>
                    <td style="padding: 15px; color: #fff;">{{ $order->user->name }}</td>
                    <td style="padding: 15px; color: #c4a747;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td style="padding: 15px;">
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; background: 
                            @if($order->status == 'pending') #fef3c7; color:#92400e;
                            @elseif($order->status == 'processing') #dbeafe; color:#1e40af;
                            @elseif($order->status == 'delivered') #d1fae5; color:#065f46;
                            @else #fee2e2; color:#991b1b; @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="padding: 15px; color: #a0825a;">{{ $order->created_at->format('d/m/Y') }}</td>
                 </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #a0825a;">Belum ada pesanan</td>
                 </tr>
                @endforelse
            </tbody>
         </table>
    </div>
    <div style="margin-top: 20px;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
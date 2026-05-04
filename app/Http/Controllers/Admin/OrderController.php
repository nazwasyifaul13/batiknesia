<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::with('user', 'items.product', 'payment')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order->update([
            'status' => $request->status,
            'shipped_at' => $request->status == 'shipped' ? now() : $order->shipped_at,
            'delivered_at' => $request->status == 'delivered' ? now() : null,
        ]);
        
        $statusText = [
            'pending' => 'Menunggu',
            'processing' => 'Dikemas',
            'shipped' => 'Dikirim',
            'delivered' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
        
        return redirect()->route('admin.orders.show', $order->id)->with('success', 'Status pesanan berhasil diubah menjadi ' . $statusText[$request->status]);
    }
}
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->whereIn('status', ['processing', 'shipped', 'pending'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.tracking', compact('orders'));
    }
    
    public function getLocation($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        
        return response()->json([
            'lat' => $order->current_lat ?? -6.200000,
            'lng' => $order->current_lng ?? 106.816666,
            'status' => $order->status
        ]);
    }
}
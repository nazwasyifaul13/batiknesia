<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.tracking', compact('orders'));
    }
    
    public function updateLocation(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->current_lat = $request->lat;
        $order->current_lng = $request->lng;
        $order->save();
        
        return response()->json(['success' => true]);
    }
}
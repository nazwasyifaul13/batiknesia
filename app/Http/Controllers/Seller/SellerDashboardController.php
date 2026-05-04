<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();
        
        $totalProducts = Product::where('seller_id', $sellerId)->count();
        $totalOrders = Order::where('seller_id', $sellerId)->count();
        $pendingOrders = Order::where('seller_id', $sellerId)->where('status', 'pending')->count();
        $totalRevenue = Order::where('seller_id', $sellerId)->where('status', 'delivered')->sum('total_amount');
        
        $recentOrders = Order::where('seller_id', $sellerId)->with('user')->latest()->limit(5)->get();
        $recentProducts = Product::where('seller_id', $sellerId)->latest()->limit(5)->get();
        
        return view('seller.dashboard', compact(
            'totalProducts', 'totalOrders', 'pendingOrders',
            'totalRevenue', 'recentOrders', 'recentProducts'
        ));
    }
    
    public function products()
    {
        $products = Product::where('seller_id', Auth::id())->latest()->paginate(12);
        return view('seller.products.index', compact('products'));
    }
    
    public function productCreate()
    {
        return view('seller.products.create');
    }
    
    public function productStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url' // video pembuatan produk
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }
        
        Product::create([
            'seller_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'video_url' => $request->video_url,
            'is_active' => 1
        ]);
        
        return redirect()->route('seller.products')->with('success', 'Produk berhasil ditambahkan');
    }
    
    public function productEdit($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);
        return view('seller.products.edit', compact('product'));
    }
    
    public function productUpdate(Request $request, $id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url'
        ]);
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }
        
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'video_url' => $request->video_url,
        ]);
        
        return redirect()->route('seller.products')->with('success', 'Produk berhasil diupdate');
    }
    
    public function productDelete($id)
    {
        $product = Product::where('seller_id', Auth::id())->findOrFail($id);
        $product->delete();
        
        return redirect()->route('seller.products')->with('success', 'Produk berhasil dihapus');
    }
    
    public function orders()
    {
        $orders = Order::where('seller_id', Auth::id())->with('user')->latest()->paginate(15);
        return view('seller.orders', compact('orders'));
    }
    
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::where('seller_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string'
        ]);
        
        $history = $order->tracking_history ?? [];
        $history[] = [
            'status' => $request->status,
            'time' => now()->toDateTimeString(),
            'note' => $request->note ?? ''
        ];
        
        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number ?? $order->tracking_number,
            'tracking_history' => $history
        ]);
        
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }
}
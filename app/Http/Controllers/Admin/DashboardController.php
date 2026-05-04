<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek apakah user adalah admin
        if (Auth::user()->role !== 'admin') {
            return redirect('/user/dashboard');
        }
        
        // Statistik
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount') ?? 0;
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();
        
        // Data untuk grafik penjualan per bulan (6 bulan terakhir)
        $monthlyLabels = [];
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('M Y');
            $sales = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'delivered')
                ->sum('total_amount') ?? 0;
            $monthlySales[] = $sales;
        }
        
        // Data untuk status pesanan
        $orderStatusLabels = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
        $orderStatusData = [
            Order::where('status', 'pending')->count(),
            Order::where('status', 'processing')->count(),
            Order::where('status', 'shipped')->count(),
            Order::where('status', 'delivered')->count(),
            Order::where('status', 'cancelled')->count()
        ];
        
        // Recent Orders
        $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->limit(10)->get();
        
        // Recent Users
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        
        // Top Products
        $topProducts = Product::select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard.index', compact(
            'totalRevenue', 'totalOrders', 'pendingOrders',
            'totalProducts', 'lowStockProducts', 'totalUsers', 'newUsersThisMonth',
            'monthlyLabels', 'monthlySales', 'orderStatusLabels', 'orderStatusData',
            'recentOrders', 'recentUsers', 'topProducts'
        ));
    }
}
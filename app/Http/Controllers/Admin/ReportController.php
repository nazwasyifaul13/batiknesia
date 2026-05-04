<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Total pendapatan
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount') ?? 0;
        
        // Total orders
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'delivered')->count();
        
        // Total products
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', 1)->count();
        
        // Total users
        $totalUsers = User::count();
        $newUsers = User::whereMonth('created_at', now()->month)->count();
        
        // Penjualan per bulan (6 bulan terakhir)
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $sales = Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'delivered')
                ->sum('total_amount') ?? 0;
            
            $monthlySales[] = [
                'month' => $month->format('M Y'),
                'total' => $sales
            ];
        }
        
        // Top products
        $topProducts = Product::select('products.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as sold_count'))
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderBy('sold_count', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.reports.index', compact(
            'totalRevenue', 'totalOrders', 'pendingOrders', 'completedOrders',
            'totalProducts', 'activeProducts', 'totalUsers', 'newUsers',
            'monthlySales', 'topProducts'
        ));
    }
}
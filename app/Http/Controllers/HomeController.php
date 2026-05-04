<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\BatikPattern;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', 1)->latest()->take(8)->get();
        $motifs = BatikPattern::where('is_active', 1)->take(4)->get();
        
        return view('landing', compact('products', 'motifs'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\BatikPattern;
use App\Models\Education;

class ProductQRController extends Controller
{
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        $motif = null;
        $education = null;
        
        if ($product->motif_id) {
            $motif = BatikPattern::find($product->motif_id);
            if ($motif) {
                // Cari edukasi berdasarkan nama motif
                $education = Education::where('title', 'LIKE', '%' . $motif->name . '%')
                    ->orWhere('content', 'LIKE', '%' . $motif->name . '%')
                    ->orWhere('excerpt', 'LIKE', '%' . $motif->name . '%')
                    ->first();
            }
        }
        
        // Jika tidak ada, ambil edukasi terbaru
        if(!$education) {
            $education = Education::where('is_published', 1)->latest()->first();
        }
        
        return view('product-qr-detail', compact('product', 'motif', 'education'));
    }
}
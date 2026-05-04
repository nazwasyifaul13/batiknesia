<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Education;

class QRScannerController extends Controller
{
    public function index()
    {
        return view('user.qr-scanner');
    }

    public function process(Request $request)
    {
        $qrCode = $request->code;
        
        $data = json_decode($qrCode, true);
        
        if ($data && isset($data['type']) && isset($data['id'])) {
            if ($data['type'] == 'product') {
                $product = Product::find($data['id']);
                if ($product) {
                    return response()->json([
                        'success' => true,
                        'title' => $product->name,
                        'url' => route('user.product.detail', $product->id)
                    ]);
                }
            } elseif ($data['type'] == 'education') {
                $education = Education::find($data['id']);
                if ($education) {
                    return response()->json([
                        'success' => true,
                        'title' => $education->title,
                        'url' => route('user.education.detail', $education->id)
                    ]);
                }
            }
        }
        
        $product = Product::find($qrCode);
        if ($product) {
            return response()->json([
                'success' => true,
                'title' => $product->name,
                'url' => route('user.product.detail', $product->id)
            ]);
        }
        
        if (filter_var($qrCode, FILTER_VALIDATE_URL)) {
            return response()->json([
                'success' => true,
                'title' => 'Video Edukasi Batik',
                'url' => $qrCode
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'QR Code tidak dikenali'
        ]);
    }
}
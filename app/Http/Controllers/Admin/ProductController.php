<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\BatikPattern;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $motifs = BatikPattern::where('is_active', 1)->get();
        return view('admin.products.create', compact('motifs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'motif_id' => 'nullable|exists:batik_patterns,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $filename);
            $imagePath = 'images/products/' . $filename;
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'image' => $imagePath,
            'motif_id' => $request->motif_id,
            'is_active' => $request->has('is_active'),
        ]);

        // Generate QR Code
        $this->generateQRCode($product);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $motifs = BatikPattern::where('is_active', 1)->get();
        return view('admin.products.edit', compact('product', 'motifs'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'motif_id' => 'nullable|exists:batik_patterns,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $filename);
            $imagePath = 'images/products/' . $filename;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'motif_id' => $request->motif_id,
            'is_active' => $request->has('is_active'),
        ]);

        // Regenerate QR Code
        $this->generateQRCode($product);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        if ($product->qr_code && file_exists(public_path($product->qr_code))) {
            unlink(public_path($product->qr_code));
        }
        $product->delete();
        
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }

    // METHOD GENERATE QR CODE - HANYA 1 KALI, TIDAK BOLEH DOUBLE
    private function generateQRCode($product)
    {
        // Buat folder jika belum ada
        if (!file_exists(public_path('images/qrcodes'))) {
            mkdir(public_path('images/qrcodes'), 0777, true);
        }
        
        // URL untuk scan QR Code
        $url = route('product.qr.detail', $product->slug);
        
        // Gunakan Google Charts API (gratis, tanpa install)
        $qrCodeUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($url) . "&choe=UTF-8";
        
        // Download dan simpan QR Code
        $qrContent = @file_get_contents($qrCodeUrl);
        
        if ($qrContent !== false) {
            $qrPath = 'images/qrcodes/qr_' . $product->id . '.png';
            file_put_contents(public_path($qrPath), $qrContent);
            $product->qr_code = $qrPath;
            $product->save();
        }
    }
}
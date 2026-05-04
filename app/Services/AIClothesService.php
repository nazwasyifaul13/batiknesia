<?php

namespace App\Services;

use App\Models\Product;
use App\Models\BatikPattern;

class AIClothesService
{
    public function generateChangeClothes($imagePath, $motifName, $modelType)
    {
        try {
            // Cari motif
            $motif = BatikPattern::where('name', 'LIKE', '%' . $motifName . '%')->first();
            
            // Cari produk berdasarkan motif
            $products = Product::where('motif_id', $motif ? $motif->id : null)
                ->where('is_active', 1)
                ->get();
            
            if($products->isEmpty()) {
                $products = Product::where('is_active', 1)->limit(3)->get();
            }
            
            // Gambar model baju berdasarkan tipe
            $modelImages = [
                'kemeja' => [
                    'url' => 'https://images.unsplash.com/photo-1594938378606-c8141b2e66c3?w=400',
                    'name' => 'Kemeja Batik Modern'
                ],
                'kebaya' => [
                    'url' => 'https://images.unsplash.com/photo-1609946420346-3d622c0a75e0?w=400',
                    'name' => 'Kebaya Batik Elegan'
                ],
                'blazer' => [
                    'url' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400',
                    'name' => 'Blazer Batik Premium'
                ],
                'setelan' => [
                    'url' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=400',
                    'name' => 'Setelan Batik Eksklusif'
                ]
            ];
            
            $selectedModel = $modelImages[$modelType] ?? $modelImages['kemeja'];
            
            // Buat rekomendasi produk
            $productList = "";
            foreach($products as $p) {
                $productList .= '
                <div style="background:#fef3e2; border-radius:12px; padding:12px; margin-bottom:10px; display:flex; align-items:center; gap:12px;">
                    ' . ($p->image ? '<img src="' . asset($p->image) . '" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">' : '<div style="width:60px; height:60px; background:#e8dcca; border-radius:8px; display:flex; align-items:center; justify-content:center;"><i class="fas fa-tshirt"></i></div>') . '
                    <div style="flex:1;">
                        <strong>' . $p->name . '</strong><br>
                        <span style="color:#c4a747;">Rp ' . number_format($p->price, 0, ',', '.') . '</span>
                    </div>
                    <a href="' . route('user.checkout', ['product_id' => $p->id, 'quantity' => 1]) . '" style="background:#c4a747; color:#2c1810; padding:6px 12px; border-radius:20px; text-decoration:none;">Beli</a>
                </div>';
            }
            
            // Simpan foto user
            $userImage = null;
            if(file_exists($imagePath)) {
                $filename = 'user_' . time() . '_' . rand(1000, 9999) . '.jpg';
                $destination = public_path('images/tryon/users/' . $filename);
                
                if(!file_exists(public_path('images/tryon/users'))) {
                    mkdir(public_path('images/tryon/users'), 0777, true);
                }
                
                copy($imagePath, $destination);
                $userImage = asset('images/tryon/users/' . $filename);
            }
            
            $description = '
            <div style="text-align:center;">
                <div style="margin-bottom:20px;">
                    <p style="font-size:14px; color:#2c1810;">📸 Foto Anda</p>
                    <img src="' . $userImage . '" style="width:100%; max-width:250px; border-radius:16px; margin:10px auto; border:2px solid #c4a747;">
                </div>
                
                <div style="margin-bottom:20px;">
                    <p style="font-size:14px; color:#2c1810;">✨ Model ' . strtoupper($modelType) . ' dengan motif ' . $motifName . ' ✨</p>
                    <img src="' . $selectedModel['url'] . '" style="width:100%; max-width:250px; border-radius:16px; margin:10px auto; border:2px solid #c4a747;">
                    <p style="margin-top:5px; font-size:12px; color:#8b7355;">' . $selectedModel['name'] . '</p>
                </div>
                
                <div style="background:#c4a74710; padding:15px; border-radius:12px; margin:15px 0;">
                    <p style="font-weight:bold;">💡 Rekomendasi AI</p>
                    <p>Motif <strong>' . $motifName . '</strong> sangat cocok untuk model <strong>' . strtoupper($modelType) . '</strong>!</p>
                    <p style="font-size:12px; margin-top:5px;">Model ini akan membuat penampilan Anda semakin elegan dan modern.</p>
                </div>
                
                <div style="margin-top:20px;">
                    <p style="font-weight:bold; margin-bottom:10px;">🛍️ Produk yang bisa Anda beli:</p>
                    ' . $productList . '
                </div>
            </div>';
            
            return [
                'success' => true,
                'description' => $description,
                'user_image' => $userImage,
                'model_image' => $selectedModel['url'],
                'model_name' => $selectedModel['name'],
                'message' => 'Try on berhasil!'
            ];
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }
    
    public function getModelRecommendations($motifId, $modelType)
    {
        $motif = BatikPattern::find($motifId);
        $motifName = $motif ? $motif->name : 'Batik';
        
        $products = Product::where('motif_id', $motifId)
            ->where('is_active', 1)
            ->get();
        
        if($products->isEmpty()) {
            $products = Product::where('is_active', 1)->inRandomOrder()->limit(4)->get();
        }
        
        $modelImages = [
            'kemeja' => 'https://images.unsplash.com/photo-1594938378606-c8141b2e66c3?w=300',
            'kebaya' => 'https://images.unsplash.com/photo-1609946420346-3d622c0a75e0?w=300',
            'blazer' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=300',
            'setelan' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=300'
        ];
        
        $recommendations = [];
        foreach($products as $product) {
            $recommendations[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image ? asset($product->image) : null,
                'model_type' => $modelType,
                'model_image' => $modelImages[$modelType] ?? $modelImages['kemeja'],
                'url' => route('user.checkout', ['product_id' => $product->id, 'quantity' => 1])
            ];
        }
        
        return [
            'success' => true,
            'motif_name' => $motifName,
            'recommendations' => $recommendations,
            'model_image' => $modelImages[$modelType] ?? $modelImages['kemeja']
        ];
    }
}
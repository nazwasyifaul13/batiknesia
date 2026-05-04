<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SegmindService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('SEGMIND_API_KEY');
    }

    /**
     * Generate gambar model baju batik berdasarkan motif dan model
     */
    public function generateClothesImage($motifName, $modelType)
    {
        try {
            // Prompt untuk generate gambar baju batik
            $prompt = "A professional fashion photography of an Indonesian Batik {$modelType} clothing with beautiful '{$motifName}' batik motif pattern. The fabric has intricate batik details, high quality, studio lighting, 4K, realistic.";

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api.segmind.com/v1/sdxl1.0-txt2img', [
                'prompt' => $prompt,
                'negative_prompt' => 'ugly, blurry, low quality, cartoon, anime, illustration',
                'steps' => 25,
                'width' => 768,
                'height' => 1024,
                'scheduler' => 'DPMSolverMultistep',
                'cfg_scale' => 7,
                'seed' => rand(1, 999999),
            ]);

            if ($response->successful()) {
                $imageData = $response->body();
                
                // Cek apakah response berisi gambar (base64 atau binary)
                $result = $response->json();
                if (isset($result['image'])) {
                    $imageData = base64_decode($result['image']);
                }

                $filename = 'segmind_' . time() . '_' . rand(1000, 9999) . '.png';
                $path = 'images/generated/' . $filename;

                if (!file_exists(public_path('images/generated'))) {
                    mkdir(public_path('images/generated'), 0777, true);
                }

                file_put_contents(public_path($path), $imageData);
                return asset($path);
            }

            Log::error('Segmind API Error: ' . $response->body());
            return $this->fallbackImage($modelType);

        } catch (\Exception $e) {
            Log::error('Segmind Exception: ' . $e->getMessage());
            return $this->fallbackImage($modelType);
        }
    }

    /**
     * Virtual Try-On dengan Segmind (jika ada model khusus)
     * Catatan: Segmind memiliki berbagai model, cek dokumentasi untuk virtual try-on spesifik
     */
    public function virtualTryOn($personImageUrl, $garmentImageUrl)
    {
        try {
            // Untuk virtual try-on, Segmind memiliki beberapa endpoint
            // Contoh menggunakan InstantID atau model virtual try-on lainnya
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post('https://api.segmind.com/v1/instantid', [
                'target_image' => $personImageUrl,
                'source_image' => $garmentImageUrl,
            ]);

            if ($response->successful()) {
                $imageData = $response->body();
                if (isset($result['image'])) {
                    $imageData = base64_decode($result['image']);
                }

                $filename = 'tryon_' . time() . '.png';
                $path = 'images/tryon/results/' . $filename;

                if (!file_exists(public_path('images/tryon/results'))) {
                    mkdir(public_path('images/tryon/results'), 0777, true);
                }

                file_put_contents(public_path($path), $imageData);
                return asset($path);
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Segmind TryOn Error: ' . $e->getMessage());
            return null;
        }
    }

    private function fallbackImage($modelType)
    {
        $images = [
            'kemeja' => 'https://images.unsplash.com/photo-1594938378606-c8141b2e66c3?w=400',
            'kebaya' => 'https://images.unsplash.com/photo-1609946420346-3d622c0a75e0?w=400',
            'blazer' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=400',
            'setelan' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=400'
        ];

        $imageUrl = $images[$modelType] ?? $images['kemeja'];
        $imageContent = file_get_contents($imageUrl);
        $filename = 'fallback_' . time() . '.jpg';
        $path = 'images/generated/' . $filename;
        file_put_contents(public_path($path), $imageContent);

        return asset($path);
    }
}
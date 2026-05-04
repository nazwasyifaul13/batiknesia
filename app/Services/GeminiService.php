<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_GEMINI_API_KEY');
    }

    public function chat($message)
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $this->apiKey);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Kamu adalah asisten fashion batik Indonesia yang ramah. Berikan rekomendasi motif batik sesuai pertanyaan user. Jawab singkat dan informatif.\n\nPertanyaan: " . $message]
                        ]
                    ]
                ]
            ]));
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode == 200) {
                $result = json_decode($response, true);
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    return $result['candidates'][0]['content']['parts'][0]['text'];
                }
            }
            
            return $this->manualFallback($message);
            
        } catch (\Exception $e) {
            Log::error('Gemini Chat Error: ' . $e->getMessage());
            return $this->manualFallback($message);
        }
    }
    
    public function generateClothesImage($motifName, $modelType)
    {
        try {
            $prompt = "Create a realistic fashion photography image of an Indonesian Batik " . $modelType . 
                      " clothing with '" . $motifName . "' batik motif pattern. Professional studio lighting, high quality, 4K, realistic fabric texture.";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp-image-generation:generateContent?key=' . $this->apiKey);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 1.0,
                    'candidateCount' => 1,
                ]
            ]));
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode == 200) {
                $result = json_decode($response, true);
                
                // Cek apakah ada gambar yang dihasilkan
                if (isset($result['candidates'][0]['content']['parts'][0]['inlineData']['data'])) {
                    $base64 = $result['candidates'][0]['content']['parts'][0]['inlineData']['data'];
                    $imageData = base64_decode($base64);
                    
                    $filename = 'gemini_' . time() . '_' . rand(1000, 9999) . '.png';
                    $path = 'images/generated/' . $filename;
                    
                    if (!file_exists(public_path('images/generated'))) {
                        mkdir(public_path('images/generated'), 0777, true);
                    }
                    
                    file_put_contents(public_path($path), $imageData);
                    return asset($path);
                }
            }
            
            // Jika generate gambar gagal, pakai fallback
            return $this->fallbackImage($modelType);
            
        } catch (\Exception $e) {
            Log::error('Gemini Image Error: ' . $e->getMessage());
            return $this->fallbackImage($modelType);
        }
    }
    
    private function manualFallback($message)
    {
        $msg = strtolower($message);
        
        $responses = [
            'halo' => "👋 Halo! Selamat datang di Batiknesia! Ada yang bisa saya bantu tentang batik?",
            'parang' => "🟤 Motif Parang dari Yogyakarta. Melambangkan kesinambungan dan kekuatan. Cocok untuk acara formal!",
            'kawung' => "🟢 Motif Kawung melambangkan kesucian. Cocok untuk kegiatan sehari-hari!",
            'kulit sawo' => "🎨 Untuk kulit sawo matang, rekomendasi: Motif Parang warna coklat keemasan!",
            'kulit putih' => "🎨 Untuk kulit putih, rekomendasi: Motif Mega Mendung warna biru!",
            'harga' => "💰 Harga batik: Batik Tulis Rp500.000-2.000.000, Batik Cap Rp200.000-500.000",
            'rekomendasi' => "🎯 Rekomendasi motif: Parang (formal), Kawung (sehari-hari), Mega Mendung (artistik)",
        ];
        
        foreach ($responses as $key => $response) {
            if (strpos($msg, $key) !== false) {
                return $response;
            }
        }
        
        return "🤖 Halo! Saya asisten AI Batiknesia. Coba tanyakan: 'motif parang', 'kulit sawo matang', atau 'rekomendasi batik'.";
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
        $imageContent = @file_get_contents($imageUrl);
        $filename = 'fallback_' . time() . '.jpg';
        $path = 'images/generated/' . $filename;
        
        if (!file_exists(public_path('images/generated'))) {
            mkdir(public_path('images/generated'), 0777, true);
        }
        
        file_put_contents(public_path($path), $imageContent);
        return asset($path);
    }
}
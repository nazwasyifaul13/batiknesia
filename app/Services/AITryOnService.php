<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AITryOnService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://openrouter.ai/api/v1/',
            'timeout' => 120,
        ]);
        $this->apiKey = env('OPEN_ROUTER_API_KEY');
    }

    public function generateTryOn($imagePath, $motifName)
    {
        try {
            // Baca gambar ke base64
            $imageData = base64_encode(file_get_contents($imagePath));
            
            $prompt = "Create a virtual try-on effect showing a person wearing batik clothing with the motif: " . $motifName . 
                      ". The batik should look realistic and natural on the person. Maintain the original pose and body shape. " .
                      "The result should be a realistic photo of someone wearing beautiful Indonesian batik.";
            
            $response = $this->client->post('chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'google/gemini-2.0-flash-exp:free',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => $prompt
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => 'data:image/jpeg;base64,' . $imageData
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'max_tokens' => 1000,
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            // Extract generated text/image description
            $generatedText = $result['choices'][0]['message']['content'] ?? 'Try on berhasil!';
            
            return [
                'success' => true,
                'description' => $generatedText,
                'recommendation' => $this->getRecommendation($motifName)
            ];
            
        } catch (\Exception $e) {
            Log::error('AI TryOn Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'recommendation' => $this->getFallbackRecommendation($motifName)
            ];
        }
    }
    
    private function getRecommendation($motifName)
    {
        $recommendations = [
            'parang' => 'Motif Parang sangat cocok untuk acara formal. Warna coklat dan emasnya memberikan kesan elegan dan mewah.',
            'kawung' => 'Motif Kawung cocok untuk kegiatan sehari-hari. Desainnya yang simpel namun bermakna sangat versatile.',
            'mega mendung' => 'Motif Mega Mendung sangat cocok untuk Anda yang menyukai seni. Gradasi warnanya yang indah sangat artistik.',
            'ceplok' => 'Motif Ceplok cocok untuk berbagai acara. Bentuk geometrisnya yang rapi memberikan kesan modern.',
        ];
        
        return $recommendations[strtolower($motifName)] ?? 'Motif ini sangat cocok dengan karakter Anda!';
    }
    
    private function getFallbackRecommendation($motifName)
    {
        return "✨ Rekomendasi: Motif " . ucfirst($motifName) . " sangat cocok untuk Anda! Motif ini memiliki filosofi yang mendalam dan akan membuat penampilan Anda lebih menarik.";
    }
}
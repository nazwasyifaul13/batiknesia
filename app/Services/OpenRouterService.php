<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://openrouter.ai/api/v1/',
            'timeout' => 60,
        ]);
        $this->apiKey = env('OPENROUTER_API_KEY');
    }

    public function chat($message)
    {
        try {
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
                            'content' => $message
                        ]
                    ],
                    'max_tokens' => 500,
                ]
            ]);
            
            $result = json_decode($response->getBody(), true);
            return $result['choices'][0]['message']['content'] ?? "Maaf, saya tidak bisa menjawab pertanyaan itu.";
            
        } catch (\Exception $e) {
            Log::error('OpenRouter Error: ' . $e->getMessage());
            return $this->getFallbackResponse($message);
        }
    }
    
    private function getFallbackResponse($message)
    {
        $message = strtolower($message);
        
        if(strpos($message, 'parang') !== false) {
            return "Motif Parang berasal dari Yogyakarta. Melambangkan kesinambungan dan kekuatan. Sangat cocok untuk acara formal.";
        }
        if(strpos($message, 'kawung') !== false) {
            return "Motif Kawung dari Yogyakarta. Melambangkan kesucian dan harapan. Cocok untuk kegiatan sehari-hari.";
        }
        if(strpos($message, 'mega mendung') !== false) {
            return "Motif Mega Mendung khas Cirebon dengan gradasi biru. Melambangkan kesabaran dan ketenangan.";
        }
        if(strpos($message, 'harga') !== false) {
            return "Harga batik: Batik Tulis Rp500.000-2.000.000, Batik Cap Rp200.000-500.000, Batik Printing Rp150.000-300.000.";
        }
        if(strpos($message, 'rekomendasi') !== false) {
            return "Rekomendasi motif: Parang (formal), Kawung (sehari-hari), Mega Mendung (artistik). Ada warna kulit tertentu?";
        }
        
        return "Halo! Saya asisten AI Batiknesia. Tanyakan tentang motif batik, harga, atau rekomendasi!";
    }
}
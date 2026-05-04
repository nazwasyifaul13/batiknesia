<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class GeminiChatService
{
    protected $apiKey;

    public function __construct()
    {
        // Ambil API key dari file .env Anda
        $this->apiKey = env('GOOGLE_GEMINI_API_KEY');
    }

    public function chat($message)
    {
        // Jika API key kosong, langsung ke fallback manual
        if (empty($this->apiKey)) {
            Log::error('Gemini API Key is empty');
            return $this->manualFallback($message);
        }

        // Gunakan model yang PALING STABIL dan GRATIS. 
        // Model 'gemini-1.5-flash' sudah teruji dan tidak mudah error 404.
        $model = 'gemini-1.5-flash';
        
        $prompt = "Kamu adalah asisten fashion batik Indonesia yang ramah. Jawab pertanyaan ini dengan singkat, jelas, dan informatif: " . $message;

        // Persiapkan data untuk dikirim ke Google
        $postData = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        // Gunakan cURL (cara paling stabil dan tidak perlu install library tambahan)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Timeout 30 detik

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Log untuk debugging (bisa dilihat di storage/logs/laravel.log)
        Log::info('Gemini API Call', [
            'url' => "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
            'http_code' => $httpCode,
            'response' => substr($response, 0, 500) // Log sebagian saja agar tidak penuh
        ]);

        // Jika request berhasil (kode 200)
        if ($httpCode === 200) {
            $result = json_decode($response, true);
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                // Sukses! Kembalikan jawaban dari AI
                return $result['candidates'][0]['content']['parts'][0]['text'];
            }
        }

        // Jika gagal, log errornya dan gunakan fallback manual
        if ($httpCode === 404) {
            Log::error("Gemini Error 404: Model '{$model}' not found or API Key invalid. Check your API Key.");
            return "Maaf, layanan AI sedang sibuk. Coba tanya lagi nanti ya. (Error: Koneksi AI terputus)";
        }
        
        if ($httpCode === 429) {
            Log::warning('Gemini API quota exhausted.');
            return "Maaf, kuota percakapan hari ini habis. Coba lagi besok ya!";
        }

        if (!empty($curlError)) {
            Log::error("Curl Error: " . $curlError);
            return "Maaf, terjadi masalah koneksi. Coba periksa internet Anda.";
        }

        // Fallback: Jawaban manual untuk pertanyaan umum
        return $this->manualFallback($message);
    }

    private function manualFallback($message)
    {
        $msg = strtolower($message);
        
        $responses = [
            'halo' => "👋 Halo! Ada yang bisa saya bantu tentang batik?",
            'parang' => "Motif Parang dari Yogyakarta, melambangkan kekuatan. Cocok untuk acara formal!",
            'kawung' => "Motif Kawung melambangkan kesucian. Cocok untuk kegiatan sehari-hari!",
            'kulit sawo' => "Untuk kulit sawo matang, motif Parang warna emas sangat cocok!",
            'rekomendasi' => "Rekomendasi motif: Parang (formal), Kawung (sehari-hari), Mega Mendung (artistik)",
        ];
        
        foreach ($responses as $key => $resp) {
            if (strpos($msg, $key) !== false) {
                return $resp;
            }
        }
        
        return "Halo! Saya asisten Batiknesia. Tanyakan: 'motif parang', 'kulit sawo matang', atau 'rekomendasi batik'.";
    }
}
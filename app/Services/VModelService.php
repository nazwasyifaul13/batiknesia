<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VModelService
{
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = env('VMODEL_API_TOKEN');
    }

    /**
     * Virtual Try-On menggunakan VModel API
     * @param string $personImagePath - Path foto user
     * @param string $garmentImageUrl - URL gambar motif batik
     * @return string|null - URL hasil try-on
     */
    public function virtualTryOn($personImageUrl, $garmentImageUrl)
    {
        try {
            // 1. Buat task baru
            $createResponse = Http::withToken($this->apiToken)
                ->timeout(30)
                ->post('https://api.vmodel.ai/api/tasks/v1/create', [
                    'version' => '537e83f7ed84751dc56aa80fb2391b07696c85a49967c72c64f002a0ca2bb224',
                    'input' => [
                        'target' => $personImageUrl,
                        'source' => $garmentImageUrl,
                        'disable_safety_checker' => false,
                    ],
                ]);

            if ($createResponse->failed()) {
                Log::error('VModel Create Task Error: ' . $createResponse->body());
                return null;
            }

            $taskId = $createResponse->json('result.task_id');
            Log::info('VModel Task Created: ' . $taskId);

            // 2. Polling: Cek status task sampai selesai (maks 30 detik)
            $maxAttempts = 15;
            for ($i = 0; $i < $maxAttempts; $i++) {
                sleep(2); // Tunggu 2 detik setiap cek

                $statusResponse = Http::withToken($this->apiToken)
                    ->get("https://api.vmodel.ai/api/tasks/v1/get/{$taskId}");

                if ($statusResponse->failed()) {
                    Log::error('VModel Get Task Error: ' . $statusResponse->body());
                    continue;
                }

                $status = $statusResponse->json('result.status');
                Log::info('VModel Task Status: ' . $status);

                if ($status === 'completed' || $status === 'succeeded') {
                    // Ambil URL hasil
                    $outputUrl = $statusResponse->json('result.output.0');
                    
                    if ($outputUrl) {
                        // Download dan simpan gambar hasil
                        $imageContent = file_get_contents($outputUrl);
                        $filename = 'tryon_' . time() . '_' . rand(1000, 9999) . '.png';
                        $path = 'images/tryon/results/' . $filename;

                        if (!file_exists(public_path('images/tryon/results'))) {
                            mkdir(public_path('images/tryon/results'), 0777, true);
                        }

                        file_put_contents(public_path($path), $imageContent);
                        return asset($path);
                    }
                }

                if ($status === 'failed') {
                    Log::error('VModel Task Failed: ' . $statusResponse->json('result.error'));
                    return null;
                }
            }

            Log::error('VModel Task Timeout for ID: ' . $taskId);
            return null;

        } catch (\Exception $e) {
            Log::error('VModel Exception: ' . $e->getMessage());
            return null;
        }
    }
}
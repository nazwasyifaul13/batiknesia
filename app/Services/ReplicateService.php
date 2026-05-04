<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class ReplicateService
{
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = env('REPLICATE_API_TOKEN');
    }

    public function generateModelImage($motifName, $modelType)
    {
        try {
            $prompt = "A beautiful Indonesian Batik " . $modelType . " with " . $motifName . " motif, high quality, professional fashion photography, 4K, realistic.";
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.replicate.com/v1/predictions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Token ' . $this->apiToken,
                'Content-Type: application/json',
            ]);
            
            $data = [
                'version' => '8beff3369e81422112d93b89ca01426147de542cd4684c244b673b105188fe5f',
                'input' => [
                    'prompt' => $prompt,
                    'width' => 512,
                    'height' => 768,
                    'num_outputs' => 1,
                ]
            ];
            
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if($httpCode == 201) {
                $result = json_decode($response, true);
                $predictionId = $result['id'];
                $imageUrl = $this->waitForResult($predictionId);
                
                if($imageUrl) {
                    $imageContent = file_get_contents($imageUrl);
                    $filename = 'model_' . time() . '.png';
                    $path = 'images/ai-generated/' . $filename;
                    file_put_contents(public_path($path), $imageContent);
                    return asset($path);
                }
            }
            
            return $this->getFallbackImage($modelType);
            
        } catch (\Exception $e) {
            return $this->getFallbackImage($modelType);
        }
    }
    
    private function waitForResult($predictionId)
    {
        for ($i = 0; $i < 20; $i++) {
            sleep(2);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.replicate.com/v1/predictions/' . $predictionId);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Token ' . $this->apiToken]);
            
            $response = curl_exec($ch);
            curl_close($ch);
            
            $result = json_decode($response, true);
            if($result['status'] === 'succeeded') {
                return $result['output'][0] ?? ($result['output'] ?? null);
            }
            if($result['status'] === 'failed') {
                return null;
            }
        }
        return null;
    }
    
    private function getFallbackImage($modelType)
    {
        $images = [
            'kemeja' => 'https://images.unsplash.com/photo-1594938378606-c8141b2e66c3?w=300',
            'kebaya' => 'https://images.unsplash.com/photo-1609946420346-3d622c0a75e0?w=300',
            'blazer' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=300',
            'setelan' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=300'
        ];
        return $images[$modelType] ?? $images['kemeja'];
    }
}
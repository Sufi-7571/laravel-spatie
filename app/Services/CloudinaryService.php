<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    protected $cloudName;
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->cloudName = env('CLOUDINARY_CLOUD_NAME');
        $this->apiKey = env('CLOUDINARY_API_KEY');
        $this->apiSecret = env('CLOUDINARY_API_SECRET');
    }

    /**
     * Upload an image to Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder
     * @return array
     */
    public function upload(UploadedFile $file, string $folder = 'products'): array
    {
        $timestamp = time();

        $filePath = $file->getPathname();

        if (!file_exists($filePath)) {
            $filePath = $file->store('temp');
            $filePath = storage_path('app/' . $filePath);
        }

        // Generate signature
        $params = [
            'folder' => $folder,
            'timestamp' => $timestamp,
        ];
        ksort($params);
        $signatureString = http_build_query($params) . $this->apiSecret;
        $signature = sha1($signatureString);

        // Prepare the upload URL
        $url = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/upload";

        // Use cURL for upload
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Create CURLFile object
        $cfile = new \CURLFile(
            $filePath,
            $file->getMimeType() ?? 'image/jpeg',
            $file->getClientOriginalName() ?? 'image.jpg'
        );

        $postFields = [
            'file' => $cfile,
            'api_key' => $this->apiKey,
            'timestamp' => $timestamp,
            'signature' => $signature,
            'folder' => $folder,
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Clean up temp file if we created one
        if (strpos($filePath, storage_path('app/temp')) !== false) {
            @unlink($filePath);
        }

        if ($error) {
            throw new \Exception("Cloudinary upload failed: " . $error);
        }

        $result = json_decode($response, true);

        if (isset($result['error'])) {
            throw new \Exception("Cloudinary error: " . $result['error']['message']);
        }

        if (!isset($result['public_id'])) {
            throw new \Exception("Cloudinary upload failed. Response: " . $response);
        }

        return [
            'public_id' => $result['public_id'],
            'url' => $result['secure_url'],
            'width' => $result['width'] ?? 0,
            'height' => $result['height'] ?? 0,
        ];
    }

    /**
     * Delete an image from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    public function delete(string $publicId): bool
    {
        try {
            $timestamp = time();

            // Generate signature
            $params = [
                'public_id' => $publicId,
                'timestamp' => $timestamp,
            ];
            ksort($params);
            $signatureString = http_build_query($params) . $this->apiSecret;
            $signature = sha1($signatureString);

            $url = "https://api.cloudinary.com/v1_1/{$this->cloudName}/image/destroy";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

            $postFields = [
                'public_id' => $publicId,
                'api_key' => $this->apiKey,
                'timestamp' => $timestamp,
                'signature' => $signature,
            ];

            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);
            return isset($result['result']) && $result['result'] === 'ok';
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get optimized URL with transformations
     *
     * @param string $publicId
     * @param int $width
     * @param int $height
     * @return string
     */
    public function getOptimizedUrl(string $publicId, int $width = 500, int $height = 500): string
    {
        return "https://res.cloudinary.com/{$this->cloudName}/image/upload/w_{$width},h_{$height},c_fill,q_auto,f_auto/{$publicId}";
    }

    /**
     * Get thumbnail URL
     *
     * @param string $publicId
     * @return string
     */
    public function getThumbnailUrl(string $publicId): string
    {
        return $this->getOptimizedUrl($publicId, 150, 150);
    }
}

<?php

namespace App\Service;

use Exception;

abstract class BaseApiService
{
    protected function request(string $url): array
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new Exception("Connection Error: " . $curlError);
        }

        if ($httpCode >= 400) {
            throw new Exception("API Error (Status $httpCode) for URL: $url");
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("JSON Parse Error");
        }

        return $data;
    }

    protected function extractIdFromUrl(string $url): string
    {
        return basename($url);
    }

    protected function enrichListWithLocalUrls(array $urlList): array
    {
        $appUrl = $_ENV['APP_URL'] ?? 'http://localhost:8000';

        return array_map(function ($externalUrl) use ($appUrl) {
            $id = $this->extractIdFromUrl($externalUrl);

            $resourceType = basename(dirname($externalUrl));
            return [
                'id'   => $id,
                'url'  => "{$appUrl}/api/{$resourceType}/{$id}"
            ];
        }, $urlList);
    }
}
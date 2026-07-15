<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PageSpeedService
{
    /**
     * Google API Key
     */
    protected string $apiKey;

    /**
     * Google API URL
     */
    protected string $baseUrl;

    /**
     * Strategy
     */
    protected string $strategy;

    /**
     * Timeout
     */
    protected int $timeout;

    public function __construct()
    {
        $this->apiKey = config('services.pagespeed.key');
        $this->baseUrl = config('services.pagespeed.url');
        $this->strategy = config('services.pagespeed.strategy', 'mobile');
        $this->timeout = config('services.pagespeed.timeout', 120);
    }

    /**
     * Analyze Website
     */
    public function analyze(string $url): array
    {
        /**
         * API Key
         */
        if (empty($this->apiKey)) {

            return [
                'success' => false,
                'message' => 'Google PageSpeed API Key belum dikonfigurasi.',
                'status' => 500,
                'data' => null,
            ];
        }

        /**
         * Validasi URL
         */
        if (!filter_var($url, FILTER_VALIDATE_URL)) {

            return [
                'success' => false,
                'message' => 'URL website tidak valid.',
                'status' => 422,
                'data' => null,
            ];
        }

        try {

            /**
             * Build Query
             */
            $query = http_build_query([
                'url'      => $url,
                'key'      => $this->apiKey,
                'strategy' => $this->strategy,
            ]);

            /**
             * Request seluruh kategori Lighthouse
             */
            $query .= '&category=performance';
            $query .= '&category=accessibility';
            $query .= '&category=best-practices';
            $query .= '&category=seo';

            /**
             * Request ke Google PageSpeed
             */
            $response = Http::timeout($this->timeout)
                ->retry(
                    config('evaluation.retry_attempts', 3),
                    config('evaluation.retry_delay', 1000)
                )
                ->acceptJson()
                ->get($this->baseUrl . '?' . $query);

            /**
             * Error HTTP
             */
            if (!$response->successful()) {

                Log::error('Google PageSpeed Error', [

                    'status' => $response->status(),
                    'body' => $response->body(),

                ]);

                return [

                    'success' => false,
                    'message' => 'Google API Error',
                    'status' => $response->status(),
                    'data' => $response->json(),

                ];
            }

            /**
             * Response JSON
             */
            $data = $response->json();

            /**
             * Lighthouse tidak ditemukan
             */
            if (!isset($data['lighthouseResult'])) {

                Log::error('Lighthouse Result Not Found', $data);

                return [

                    'success' => false,
                    'message' => 'Lighthouse Result tidak ditemukan.',
                    'status' => 500,
                    'data' => $data,

                ];
            }

            /**
             * Debug Categories
             */
            Log::info(
                'Lighthouse Categories',
                array_keys($data['lighthouseResult']['categories'])
            );

            /**
             * Debug Seluruh Category
             */
            Log::info(
                'Lighthouse Category Data',
                $data['lighthouseResult']['categories']
            );

            /**
             * Success
             */
            return [

                'success' => true,
                'message' => 'Success',
                'status' => 200,
                'data' => $data,

            ];

        } catch (\Throwable $e) {

            Log::error('PageSpeed Exception', [

                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),

            ]);

            return [

                'success' => false,
                'message' => $e->getMessage(),
                'status' => 500,
                'data' => null,

            ];
        }
    }
}
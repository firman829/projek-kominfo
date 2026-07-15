<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\Website;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvaluationService
{
    protected PageSpeedService $pageSpeed;

    public function __construct(PageSpeedService $pageSpeed)
    {
        $this->pageSpeed = $pageSpeed;
    }

    /**
     * Menjalankan evaluasi website menggunakan Google PageSpeed
     */
    public function evaluate(Website $website): Evaluation
    {
        $result = $this->pageSpeed->analyze($website->url);

        if (!$result['success']) {

            return Evaluation::create([

                'website_id' => $website->id,

                'performance' => null,
                'accessibility' => null,
                'best_practices' => null,
                'seo' => null,
                'pwa' => null,

                'first_contentful_paint' => null,
                'largest_contentful_paint' => null,
                'speed_index' => null,
                'interactive' => null,
                'time_to_interactive' => null,
                'total_blocking_time' => null,
                'max_potential_fid' => null,
                'cumulative_layout_shift' => null,

                'server_response_time' => null,

                'http_status' => $result['status'],

                'https' => str_starts_with($website->url, 'https://'),

                'ssl_valid' => str_starts_with($website->url, 'https://'),

                'page_title' => null,

                'cms' => null,

                'mobile_friendly' => false,

                'strategy' => config('services.pagespeed.strategy'),

                'lighthouse_version' => null,

                'status' => 'failed',

                'raw_result' => $result,

                'evaluated_at' => now(),

            ]);
        }

        $json = $result['data'];

        return DB::transaction(function () use ($website, $json) {

            return Evaluation::create([

                'website_id' => $website->id,

                /*
                |--------------------------------------------------------------------------
                | Lighthouse Scores
                |--------------------------------------------------------------------------
                */

                'performance' => $this->score($json, 'performance'),

                'accessibility' => $this->score($json, 'accessibility'),

                'best_practices' => $this->score($json, 'best-practices'),

                'seo' => $this->score($json, 'seo'),

                'pwa' => $this->score($json, 'pwa'),

                /*
                |--------------------------------------------------------------------------
                | Metrics
                |--------------------------------------------------------------------------
                */

                'first_contentful_paint' =>
                    $this->metric($json, 'first-contentful-paint'),

                'largest_contentful_paint' =>
                    $this->metric($json, 'largest-contentful-paint'),

                'speed_index' =>
                    $this->metric($json, 'speed-index'),

                'interactive' =>
                    $this->metric($json, 'interactive'),

                'time_to_interactive' =>
                    $this->metric($json, 'interactive'),

                'total_blocking_time' =>
                    $this->metricMs($json, 'total-blocking-time'),

                'max_potential_fid' =>
                    $this->metricMs($json, 'max-potential-fid'),

                'cumulative_layout_shift' =>
                    $this->metricRaw($json, 'cumulative-layout-shift'),

                /*
                |--------------------------------------------------------------------------
                | Server
                |--------------------------------------------------------------------------
                */

                'server_response_time' =>
                    $this->metricMs($json, 'server-response-time'),

                'http_status' => 200,

                /*
                |--------------------------------------------------------------------------
                | Security
                |--------------------------------------------------------------------------
                */

                'https' => str_starts_with($website->url, 'https://'),

                'ssl_valid' => str_starts_with($website->url, 'https://'),

                /*
                |--------------------------------------------------------------------------
                | Website
                |--------------------------------------------------------------------------
                */

                'page_title' =>
                    data_get(
                        $json,
                        'lighthouseResult.finalDisplayedUrl'
                    ),

                'cms' => null,

                'mobile_friendly' => true,

                /*
                |--------------------------------------------------------------------------
                | Lighthouse
                |--------------------------------------------------------------------------
                */

                'strategy' =>
                    data_get(
                        $json,
                        'configSettings.emulatedFormFactor',
                        'mobile'
                    ),

                'lighthouse_version' =>
                    data_get(
                        $json,
                        'lighthouseResult.lighthouseVersion'
                    ),

                /*
                |--------------------------------------------------------------------------
                | Status
                |--------------------------------------------------------------------------
                */

                'status' => 'success',

                'raw_result' => $json,

                'evaluated_at' => now(),
            ]);

        });

    }

    /**
     * Mengambil Score kategori Lighthouse
     */
    private function score(array $json, string $category): ?int
    {
        $score = data_get(
            $json,
            "lighthouseResult.categories.$category.score"
        );

        if ($score === null) {
            return null;
        }

        return (int) round($score * 100);
    }

    /**
     * Metric dalam detik
     */
    private function metric(array $json, string $audit): ?float
    {
        $value = data_get(
            $json,
            "lighthouseResult.audits.$audit.numericValue"
        );

        if ($value === null) {
            return null;
        }

        return round($value / 1000, 2);
    }

    /**
     * Metric dalam ms
     */
    private function metricMs(array $json, string $audit): ?float
    {
        $value = data_get(
            $json,
            "lighthouseResult.audits.$audit.numericValue"
        );

        if ($value === null) {
            return null;
        }

        return round($value, 2);
    }

    /**
     * Metric tanpa konversi
     */
    private function metricRaw(array $json, string $audit): ?float
    {
        $value = data_get(
            $json,
            "lighthouseResult.audits.$audit.numericValue"
        );

        if ($value === null) {
            return null;
        }

        return round($value, 3);
    }
}
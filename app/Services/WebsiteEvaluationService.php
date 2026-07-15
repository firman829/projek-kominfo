<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\EvaluationLog;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class WebsiteEvaluationService
{
    public function __construct(
        protected PageSpeedService $pageSpeedService
    ) {
    }

    /**
     * Evaluate Website
     */
    public function evaluate(Website $website): array
    {
        $result = $this->pageSpeedService->analyze($website->url);

        if (!$result['success']) {

            EvaluationLog::create([

                'website_id' => $website->id,

                'status' => 'failed',

                'http_status' => $result['status'],

                'message' => $result['message'],

                'response' => json_encode($result),

                'executed_at' => now()

            ]);

            return $result;
        }

        $json = $result['data'];

        $categories = Arr::get($json, 'lighthouseResult.categories', []);

        $audits = Arr::get($json, 'lighthouseResult.audits', []);

        $evaluation = Evaluation::create([

            'website_id' => $website->id,

            'performance' => $this->score($categories, 'performance'),

            'accessibility' => $this->score($categories, 'accessibility'),

            'best_practices' => $this->score($categories, 'best-practices'),

            'seo' => $this->score($categories, 'seo'),

            'https' => str_starts_with($website->url, 'https'),

            'ssl_valid' => str_starts_with($website->url, 'https'),

            'page_title' => Arr::get($json, 'lighthouseResult.finalDisplayedUrl'),

            'server_response_time' => Arr::get(
                $audits,
                'server-response-time.numericValue'
            ),

            'first_contentful_paint' => Arr::get(
                $audits,
                'first-contentful-paint.numericValue'
            ),

            'largest_contentful_paint' => Arr::get(
                $audits,
                'largest-contentful-paint.numericValue'
            ),

            'speed_index' => Arr::get(
                $audits,
                'speed-index.numericValue'
            ),

            'cumulative_layout_shift' => Arr::get(
                $audits,
                'cumulative-layout-shift.numericValue'
            ),

            'strategy' => config('services.pagespeed.strategy'),

            'status' => 'success',

            'raw_result' => $json,

            'evaluated_at' => Carbon::now()

        ]);

        $website->update([

            'last_checked_at' => now(),

            'last_success_at' => now(),

            'last_status' => 'success'

        ]);

        EvaluationLog::create([

            'website_id' => $website->id,

            'status' => 'success',

            'http_status' => 200,

            'message' => 'Evaluation completed successfully.',

            'response' => null,

            'executed_at' => now()

        ]);

        return [

            'success' => true,

            'message' => 'Website evaluated successfully.',

            'evaluation' => $evaluation

        ];
    }

    /**
     * Convert Lighthouse Score
     */
    private function score(array $categories, string $key): ?int
    {
        $score = Arr::get($categories, $key . '.score');

        if (is_null($score)) {
            return null;
        }

        return (int) round($score * 100);
    }
}
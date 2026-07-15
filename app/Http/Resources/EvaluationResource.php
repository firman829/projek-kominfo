<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'website_id' => $this->website_id,

            /*
            |--------------------------------------------------------------------------
            | Scores
            |--------------------------------------------------------------------------
            */

            'performance' => $this->performance,

            'accessibility' => $this->accessibility,

            'best_practices' => $this->best_practices,

            'seo' => $this->seo,

            'pwa' => $this->pwa,

            /*
            |--------------------------------------------------------------------------
            | Metrics
            |--------------------------------------------------------------------------
            */

            'first_contentful_paint' => $this->first_contentful_paint,

            'largest_contentful_paint' => $this->largest_contentful_paint,

            'speed_index' => $this->speed_index,

            'interactive' => $this->interactive,

            'time_to_interactive' => $this->time_to_interactive,

            'total_blocking_time' => $this->total_blocking_time,

            'max_potential_fid' => $this->max_potential_fid,

            'cumulative_layout_shift' => $this->cumulative_layout_shift,

            /*
            |--------------------------------------------------------------------------
            | Server
            |--------------------------------------------------------------------------
            */

            'server_response_time' => $this->server_response_time,

            'http_status' => $this->http_status,

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            'https' => $this->https,

            'ssl_valid' => $this->ssl_valid,

            /*
            |--------------------------------------------------------------------------
            | Website
            |--------------------------------------------------------------------------
            */

            'page_title' => $this->page_title,

            'cms' => $this->cms,

            'mobile_friendly' => $this->mobile_friendly,

            /*
            |--------------------------------------------------------------------------
            | Lighthouse
            |--------------------------------------------------------------------------
            */

            'strategy' => $this->strategy,

            'lighthouse_version' => $this->lighthouse_version,

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => $this->status,

            'evaluated_at' => $this->evaluated_at,

            'created_at' => $this->created_at,
        ];
    }
}
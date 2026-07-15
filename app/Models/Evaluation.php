<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * --------------------------------------------------------------------------
     * Table
     * --------------------------------------------------------------------------
     */
    protected $table = 'evaluations';

    /**
     * --------------------------------------------------------------------------
     * Mass Assignment
     * --------------------------------------------------------------------------
     */
    protected $fillable = [

        'website_id',

        /*
        |--------------------------------------------------------------------------
        | Lighthouse Scores
        |--------------------------------------------------------------------------
        */

        'performance',
        'accessibility',
        'best_practices',
        'seo',
        'pwa',

        /*
        |--------------------------------------------------------------------------
        | Core Web Vitals
        |--------------------------------------------------------------------------
        */

        'first_contentful_paint',
        'largest_contentful_paint',
        'speed_index',
        'interactive',
        'time_to_interactive',
        'total_blocking_time',
        'max_potential_fid',
        'cumulative_layout_shift',

        /*
        |--------------------------------------------------------------------------
        | Server
        |--------------------------------------------------------------------------
        */

        'server_response_time',
        'http_status',

        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        'https',
        'ssl_valid',

        /*
        |--------------------------------------------------------------------------
        | Website Information
        |--------------------------------------------------------------------------
        */

        'page_title',
        'cms',
        'mobile_friendly',

        /*
        |--------------------------------------------------------------------------
        | Lighthouse Information
        |--------------------------------------------------------------------------
        */

        'strategy',
        'lighthouse_version',

        /*
        |--------------------------------------------------------------------------
        | Evaluation
        |--------------------------------------------------------------------------
        */

        'status',
        'raw_result',
        'evaluated_at',
    ];

    /**
     * --------------------------------------------------------------------------
     * Attribute Casting
     * --------------------------------------------------------------------------
     */
    protected $casts = [

        'https' => 'boolean',

        'ssl_valid' => 'boolean',

        'mobile_friendly' => 'boolean',

        'raw_result' => 'array',

        'evaluated_at' => 'datetime',

    ];

    /**
     * --------------------------------------------------------------------------
     * Relationships
     * --------------------------------------------------------------------------
     */

    /**
     * Satu hasil evaluasi dimiliki oleh satu website.
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
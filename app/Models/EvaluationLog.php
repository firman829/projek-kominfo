<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EvaluationLog extends Model
{
    use HasFactory;

    /**
     * --------------------------------------------------------------------------
     * Table
     * --------------------------------------------------------------------------
     */
    protected $table = 'evaluation_logs';

    /**
     * --------------------------------------------------------------------------
     * Mass Assignment
     * --------------------------------------------------------------------------
     */
    protected $fillable = [
        'website_id',
        'status',
        'http_status',
        'message',
        'response',
        'execution_time',
        'executed_at',
    ];

    /**
     * --------------------------------------------------------------------------
     * Attribute Casting
     * --------------------------------------------------------------------------
     */
    protected $casts = [
        'executed_at' => 'datetime',
    ];

    /**
     * --------------------------------------------------------------------------
     * Relationships
     * --------------------------------------------------------------------------
     */

    /**
     * Log evaluasi dimiliki oleh satu website.
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
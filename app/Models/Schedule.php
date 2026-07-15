<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    /**
     * --------------------------------------------------------------------------
     * Table
     * --------------------------------------------------------------------------
     */
    protected $table = 'schedules';

    /**
     * --------------------------------------------------------------------------
     * Mass Assignment
     * --------------------------------------------------------------------------
     */
    protected $fillable = [
        'website_id',
        'frequency',
        'cron_expression',
        'next_run',
        'last_run',
        'is_active',
        'description',
    ];

    /**
     * --------------------------------------------------------------------------
     * Attribute Casting
     * --------------------------------------------------------------------------
     */
    protected $casts = [
        'next_run' => 'datetime',
        'last_run' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * --------------------------------------------------------------------------
     * Relationships
     * --------------------------------------------------------------------------
     */

    /**
     * Jadwal dimiliki oleh satu website.
     */
    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [

        'website_id',

        'start_time',
        'end_time',

        'interval_minutes',

        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',

        'is_active',

        'last_run_at',

    ];

    protected $casts = [

        'monday' => 'boolean',
        'tuesday' => 'boolean',
        'wednesday' => 'boolean',
        'thursday' => 'boolean',
        'friday' => 'boolean',
        'saturday' => 'boolean',
        'sunday' => 'boolean',

        'is_active' => 'boolean',

        'last_run_at' => 'datetime',

    ];

    /**
     * Relasi ke Website
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
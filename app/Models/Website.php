<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\EvaluationSchedule;

class Website extends Model
{
    use HasFactory;

    /**
     * --------------------------------------------------------------------------
     * Table
     * --------------------------------------------------------------------------
     */
    protected $table = 'websites';

    /**
     * --------------------------------------------------------------------------
     * Mass Assignment
     * --------------------------------------------------------------------------
     */
    protected $fillable = [
        'user_id',
        'name',
        'institution',
        'url',
        'domain',
        'province',
        'city',
        'status',
        'description',
        'is_active',
    ];

    /**
     * --------------------------------------------------------------------------
     * Attribute Casting
     * --------------------------------------------------------------------------
     */
    protected $casts = [];

    /**
     * --------------------------------------------------------------------------
     * Relationships
     * --------------------------------------------------------------------------
     */

    /**
     * Website dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu website memiliki banyak hasil evaluasi.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
    * Jadwal evaluasi website
     */
    public function schedule()
    {
        return $this->hasOne(EvaluationSchedule::class);
    }

    /**
     * Satu website memiliki banyak jadwal evaluasi.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Satu website memiliki banyak log evaluasi.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(EvaluationLog::class);
    }
}
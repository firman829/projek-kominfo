<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Primary Key
            |--------------------------------------------------------------------------
            */

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Relasi Website
            |--------------------------------------------------------------------------
            */

            $table->foreignId('website_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Lighthouse Scores
            |--------------------------------------------------------------------------
            */

            $table->integer('performance')->nullable();

            $table->integer('accessibility')->nullable();

            $table->integer('best_practices')->nullable();

            $table->integer('seo')->nullable();

            // Progressive Web App (opsional)
            $table->integer('pwa')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Core Web Vitals
            |--------------------------------------------------------------------------
            */

            // First Contentful Paint (detik)
            $table->float('first_contentful_paint')->nullable();

            // Largest Contentful Paint (detik)
            $table->float('largest_contentful_paint')->nullable();

            // Speed Index (detik)
            $table->float('speed_index')->nullable();

            // Time to Interactive (detik)
            $table->float('interactive')->nullable();

            $table->float('time_to_interactive')->nullable();

            // Total Blocking Time (ms)
            $table->float('total_blocking_time')->nullable();

            // Max Potential FID (ms)
            $table->float('max_potential_fid')->nullable();

            // Cumulative Layout Shift
            $table->float('cumulative_layout_shift')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Server Information
            |--------------------------------------------------------------------------
            */

            $table->float('server_response_time')->nullable();

            $table->integer('http_status')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            $table->boolean('https')->default(false);

            $table->boolean('ssl_valid')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Website Information
            |--------------------------------------------------------------------------
            */

            $table->string('page_title')->nullable();

            $table->string('cms')->nullable();

            $table->boolean('mobile_friendly')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Lighthouse Information
            |--------------------------------------------------------------------------
            */

            // mobile / desktop
            $table->string('strategy')->default('mobile');

            $table->string('lighthouse_version')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Evaluation Status
            |--------------------------------------------------------------------------
            */

            // success
            // failed
            // timeout
            // ssl_error
            $table->string('status')->default('success');

            /*
            |--------------------------------------------------------------------------
            | Raw JSON Result dari Google PageSpeed
            |--------------------------------------------------------------------------
            */

            $table->json('raw_result')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Waktu Evaluasi
            |--------------------------------------------------------------------------
            */

            $table->timestamp('evaluated_at');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Database Index
            |--------------------------------------------------------------------------
            */

            $table->index('website_id');
            $table->index('evaluated_at');
            $table->index('status');
            $table->index('strategy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
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
        Schema::create('evaluation_logs', function (Blueprint $table) {

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
            | Status Evaluasi
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'success',
                'failed',
                'timeout',
                'ssl_error',
                'dns_error',
                'server_error'
            ]);

            /*
            |--------------------------------------------------------------------------
            | HTTP Status
            |--------------------------------------------------------------------------
            */

            $table->integer('http_status')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Pesan Log
            |--------------------------------------------------------------------------
            */

            $table->text('message');

            /*
            |--------------------------------------------------------------------------
            | Response dari API / Exception
            |--------------------------------------------------------------------------
            */

            $table->longText('response')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Lama Eksekusi (ms)
            |--------------------------------------------------------------------------
            */

            $table->integer('execution_time')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Waktu Eksekusi
            |--------------------------------------------------------------------------
            */

            $table->timestamp('executed_at');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Database Index
            |--------------------------------------------------------------------------
            */

            $table->index('website_id');
            $table->index('status');
            $table->index('executed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_logs');
    }
};
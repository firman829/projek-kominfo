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
        Schema::create('schedules', function (Blueprint $table) {

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
            | Frekuensi Jadwal
            |--------------------------------------------------------------------------
            */

            $table->enum('frequency', [
                'hourly',
                'daily',
                'weekly',
                'monthly',
                'custom'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Cron Expression
            |--------------------------------------------------------------------------
            */

            $table->string('cron_expression')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Jadwal Berikutnya
            |--------------------------------------------------------------------------
            */

            $table->timestamp('next_run')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Jadwal Terakhir Berjalan
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_run')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Jadwal
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')->default(true);

            /*
            |--------------------------------------------------------------------------
            | Catatan
            |--------------------------------------------------------------------------
            */

            $table->text('description')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Database Index
            |--------------------------------------------------------------------------
            */

            $table->index('website_id');
            $table->index('next_run');
            $table->index('is_active');
            $table->index('frequency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
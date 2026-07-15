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
        Schema::create('evaluation_schedules', function (Blueprint $table) {

            $table->id();

            $table->foreignId('website_id')
                ->constrained()
                ->cascadeOnDelete();

            // Jam kerja
            $table->time('start_time')->default('08:00:00');
            $table->time('end_time')->default('16:00:00');

            // Interval evaluasi (menit)
            $table->unsignedInteger('interval_minutes')->default(60);

            // Hari kerja
            $table->boolean('monday')->default(true);
            $table->boolean('tuesday')->default(true);
            $table->boolean('wednesday')->default(true);
            $table->boolean('thursday')->default(true);
            $table->boolean('friday')->default(true);
            $table->boolean('saturday')->default(false);
            $table->boolean('sunday')->default(false);

            // Status
            $table->boolean('is_active')->default(true);

            // Waktu terakhir dijalankan
            $table->timestamp('last_run_at')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_schedules');
    }
};
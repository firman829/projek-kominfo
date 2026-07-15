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
        Schema::create('websites', function (Blueprint $table) {

            // Primary Key
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Informasi Website
            $table->string('name');
            $table->string('institution');
            $table->string('url')->unique();
            $table->string('domain')->unique();

            // Lokasi Instansi
            $table->string('province')->nullable();
            $table->string('city')->nullable();

            // Status Website
            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            // Status aktif pada sistem
            $table->boolean('is_active')->default(true);

            // Informasi evaluasi terakhir
            $table->timestamp('last_checked_at')->nullable();
            $table->timestamp('last_success_at')->nullable();

            // Contoh:
            // success
            // failed
            // timeout
            // ssl_error
            $table->string('last_status')->nullable();

            // Deskripsi Website
            $table->text('description')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Database Index
            |--------------------------------------------------------------------------
            */

            $table->index('status');
            $table->index('is_active');
            $table->index('domain');
            $table->index('institution');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
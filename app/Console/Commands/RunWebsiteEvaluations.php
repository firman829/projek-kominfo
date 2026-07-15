<?php

namespace App\Console\Commands;

use App\Jobs\EvaluationWebsiteJob;
use App\Models\EvaluationSchedule;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RunWebsiteEvaluations extends Command
{
    /**
     * Nama command
     */
    protected $signature = 'evaluation:run';

    /**
     * Deskripsi command
     */
    protected $description = 'Menjalankan evaluasi semua website yang aktif';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('===== Scheduler Masuk Evaluation Run =====');

        $this->info('====================================');
        $this->info(' Memulai Evaluasi Website ');
        $this->info('====================================');

        /*
        |--------------------------------------------------------------------------
        | Ambil Schedule Aktif
        |--------------------------------------------------------------------------
        */

        $schedule = EvaluationSchedule::where('is_active', true)->first();

        if (!$schedule) {

            $this->warn('Schedule belum tersedia.');

            return self::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | Cek Hari Kerja
        |--------------------------------------------------------------------------
        */

        $today = strtolower(Carbon::now()->englishDayOfWeek);

        $allowedToday = match ($today) {
            'monday' => $schedule->monday,
            'tuesday' => $schedule->tuesday,
            'wednesday' => $schedule->wednesday,
            'thursday' => $schedule->thursday,
            'friday' => $schedule->friday,
            'saturday' => $schedule->saturday,
            'sunday' => $schedule->sunday,
            default => false,
        };

        if (!$allowedToday) {

            $this->warn('Hari ini bukan jadwal evaluasi.');

            return self::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | Cek Jam Kerja
        |--------------------------------------------------------------------------
        */

        $now = Carbon::now()->format('H:i:s');

        if (
            $now < $schedule->start_time ||
            $now > $schedule->end_time
        ) {

            $this->warn('Di luar jam kerja.');

            return self::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | Cek Interval Evaluasi
        |--------------------------------------------------------------------------
        */

        if ($schedule->last_run_at) {

            $nextRun = $schedule->last_run_at
                ->copy()
                ->addMinutes($schedule->interval_minutes);

            if (now()->lt($nextRun)) {

                $this->warn('Belum waktunya evaluasi berikutnya.');

                return self::SUCCESS;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Website Aktif
        |--------------------------------------------------------------------------
        */

        $websites = Website::where('is_active', true)->get();

        if ($websites->isEmpty()) {

            $this->warn('Tidak ada website aktif.');

            return self::SUCCESS;
        }

        /*
        |--------------------------------------------------------------------------
        | Dispatch Queue
        |--------------------------------------------------------------------------
        */

        foreach ($websites as $website) {

            Log::info('Dispatch Website', [
                'id' => $website->id,
                'name' => $website->name,
            ]);

            EvaluationWebsiteJob::dispatch($website);

            $this->line(
                "Website {$website->name} dimasukkan ke Queue."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Last Run
        |--------------------------------------------------------------------------
        */

        $schedule->update([
            'last_run_at' => now(),
        ]);

        $this->newLine();

        $this->info(
            $websites->count() .
            ' website berhasil dimasukkan ke Queue.'
        );

        return self::SUCCESS;
    }
}
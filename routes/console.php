<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Default Command
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Website Evaluation Scheduler
|--------------------------------------------------------------------------
|
| Menjalankan command evaluation:run secara otomatis.
|
*/

Schedule::command('evaluation:run')
    ->everyMinute();
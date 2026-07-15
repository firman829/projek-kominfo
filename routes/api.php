<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WebsiteController;
use App\Http\Controllers\Api\EvaluationController;
use App\Http\Controllers\Api\EvaluationScheduleController;
/*
|--------------------------------------------------------------------------
| Public Authentication
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [AuthController::class, 'profile']);

    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Website Management
    |--------------------------------------------------------------------------
    */

    Route::get('/websites', [WebsiteController::class, 'index']);

    Route::post('/websites', [WebsiteController::class, 'store']);

    Route::get('/websites/{website}', [WebsiteController::class, 'show']);

    Route::put('/websites/{website}', [WebsiteController::class, 'update']);

    Route::delete('/websites/{website}', [WebsiteController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Evaluation
    |--------------------------------------------------------------------------
    */

    // Jalankan evaluasi
    Route::post(
        '/websites/{website}/evaluate',
        [EvaluationController::class, 'evaluate']
    );

    // ===========================
    // BARU
    // ===========================

    // Semua hasil evaluasi milik user
    Route::get(
        '/evaluations',
        [EvaluationController::class, 'index']
    );

    // Detail satu evaluasi
    Route::get(
        '/evaluations/{evaluation}',
        [EvaluationController::class, 'show']
    );

    // Riwayat evaluasi website
    Route::get(
        '/websites/{website}/evaluations',
        [EvaluationController::class, 'history']
    );

    // Evaluasi terbaru
    Route::get(
        '/websites/{website}/latest-evaluation',
        [EvaluationController::class, 'latest']
    );
    Route::apiResource(
        'schedules',
        EvaluationScheduleController::class
    );
    Route::delete(
        '/evaluations/{evaluation}',
        [EvaluationController::class, 'destroy']
    );
    
});
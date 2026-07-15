<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluationScheduleRequest;
use App\Http\Requests\UpdateEvaluationScheduleRequest;
use App\Http\Resources\EvaluationScheduleResource;
use App\Models\EvaluationSchedule;
use App\Services\ApiResponseService;

class EvaluationScheduleController extends Controller
{
    /**
     * Daftar seluruh jadwal
     */
    public function index()
    {
        $schedules = EvaluationSchedule::with('website')
            ->latest()
            ->paginate(10);

        return ApiResponseService::success(
            'Daftar jadwal evaluasi.',
            EvaluationScheduleResource::collection($schedules)
        );
    }

    /**
     * Simpan jadwal baru
     */
    public function store(StoreEvaluationScheduleRequest $request)
    {
        $schedule = EvaluationSchedule::create(
            $request->validated()
        );

        $schedule->load('website');

        return ApiResponseService::success(
            'Jadwal evaluasi berhasil dibuat.',
            new EvaluationScheduleResource($schedule),
            201
        );
    }

    /**
     * Detail jadwal
     */
    public function show(EvaluationSchedule $schedule)
    {
        $schedule->load('website');

        return ApiResponseService::success(
            'Detail jadwal evaluasi.',
            new EvaluationScheduleResource($schedule)
        );
    }

    /**
     * Update jadwal
     */
    public function update(
        UpdateEvaluationScheduleRequest $request,
        EvaluationSchedule $schedule
    ) {

        $schedule->update(
            $request->validated()
        );

        $schedule->load('website');

        return ApiResponseService::success(
            'Jadwal evaluasi berhasil diperbarui.',
            new EvaluationScheduleResource($schedule)
        );
    }

    /**
     * Hapus jadwal
     */
    public function destroy(EvaluationSchedule $schedule)
    {
        $schedule->delete();

        return ApiResponseService::success(
            'Jadwal evaluasi berhasil dihapus.'
        );
    }
}
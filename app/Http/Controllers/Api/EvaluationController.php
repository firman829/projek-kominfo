<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EvaluationResource;
use App\Models\Evaluation;
use App\Models\Website;
use App\Services\ApiResponseService;
use App\Services\EvaluationService;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    protected EvaluationService $evaluationService;

    public function __construct(EvaluationService $evaluationService)
    {
        $this->evaluationService = $evaluationService;
    }

    /**
     * Menjalankan evaluasi website.
     */
    public function evaluate(Request $request, Website $website)
    {
        $this->authorize('view', $website);

        try {

            $evaluation = $this->evaluationService->evaluate($website);

            return ApiResponseService::success(
                'Evaluasi website berhasil.',
                new EvaluationResource($evaluation)
            );

        } catch (\Throwable $e) {

            return ApiResponseService::error(
                'Evaluasi gagal.',
                $e->getMessage(),
                500
            );
        }
    }

    /**
     * Semua evaluasi user.
     */
    public function index(Request $request)
    {
        $evaluations = Evaluation::with('website')
            ->whereHas('website', function ($query) use ($request) {

                $query->where('user_id', $request->user()->id);

            })
            ->latest()
            ->paginate(10);

        return ApiResponseService::success(
            'Daftar evaluasi.',
            EvaluationResource::collection($evaluations)
        );
    }

    /**
     * Detail evaluasi.
     */
    public function show(Evaluation $evaluation)
    {
        $this->authorize('view', $evaluation->website);

        return ApiResponseService::success(
            'Detail evaluasi.',
            new EvaluationResource(
                $evaluation->load('website')
            )
        );
    }

    /**
     * Riwayat evaluasi website.
     */
    public function history(Website $website)
    {
        $this->authorize('view', $website);

        $history = $website
            ->evaluations()
            ->latest()
            ->paginate(10);

        return ApiResponseService::success(
            'Riwayat evaluasi.',
            EvaluationResource::collection($history)
        );
    }

    /**
     * Evaluasi terbaru.
     */
    public function latest(Website $website)
    {
        $this->authorize('view', $website);

        $evaluation = $website
            ->evaluations()
            ->latest()
            ->first();

        if (!$evaluation) {

            return ApiResponseService::error(
                'Belum ada evaluasi.',
                null,
                404
            );

        }

        return ApiResponseService::success(
            'Evaluasi terbaru.',
            new EvaluationResource($evaluation)
        );
    }
    /**
    * Hapus satu history evaluasi
    */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();

        return response()->json([

            'success' => true,

            'message' => 'History evaluasi berhasil dihapus.'

        ]);
    }
}
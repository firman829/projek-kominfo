<?php

namespace App\Jobs;

use App\Models\Website;
use App\Services\EvaluationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EvaluationWebsiteJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Website yang akan dievaluasi.
     */
    public Website $website;

    /**
     * Create a new job instance.
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Execute the job.
     */
    public function handle(EvaluationService $evaluationService): void
    {
        $evaluationService->evaluate($this->website);
    }
}
<?php

namespace App\Jobs;

use App\Services\RankingAverageService;
use App\Models\RankingWrestlerAverage;
use App\Models\VoteWrestler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateWrestlerAverage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $rankingId;
    public int $wrestlerId;

    /**
     * Create a new job instance.
     *
     * @param int $rankingId
     * @param int $wrestlerId
     */
    public function __construct(int $rankingId, int $wrestlerId)
    {
        $this->rankingId = $rankingId;
        $this->wrestlerId = $wrestlerId;
    }

    /**
     * Execute the job.
     */
    public function handle(RankingAverageService $rankingAverageService)
    {
        $rankingAverageService->updateAverage(
            VoteWrestler::class,
            RankingWrestlerAverage::class,
            'wrestler_id',
            $this->rankingId,
            $this->wrestlerId,
        );
    }
}

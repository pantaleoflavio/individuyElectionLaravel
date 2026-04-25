<?php

namespace App\Jobs;

use App\Models\RankingFederationAverage;
use App\Models\VoteFederation;
use App\Services\RankingAverageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFederationAverage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $rankingId;
    public int $federationId;

    public function __construct(int $rankingId, int $federationId)
    {
        $this->rankingId = $rankingId;
        $this->federationId = $federationId;
    }

    public function handle(RankingAverageService $rankingAverageService): void
    {
        $rankingAverageService->updateAverage(
            VoteFederation::class,
            RankingFederationAverage::class,
            'federation_id',
            $this->rankingId,
            $this->federationId,
        );
    }
}
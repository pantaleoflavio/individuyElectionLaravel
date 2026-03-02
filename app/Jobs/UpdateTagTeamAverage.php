<?php

namespace App\Jobs;

use App\Models\VoteTagTeam;
use App\Models\RankingTagTeamAverage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\RankingAverageService;

class UpdateTagTeamAverage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $rankingId;
    public int $tagTeamId;

    public function __construct(int $rankingId, int $tagTeamId)
    {
        $this->rankingId = $rankingId;
        $this->tagTeamId = $tagTeamId;
    }

    public function handle(RankingAverageService $rankingAverageService): void
    {
                $rankingAverageService->updateAverage(
            VoteTagTeam::class,
            RankingTagTeamAverage::class,
            'tag_team_id',
            $this->rankingId,
            $this->tagTeamId,
        );
    }
}

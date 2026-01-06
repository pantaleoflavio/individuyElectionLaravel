<?php

namespace App\Jobs;

use App\Models\VoteTagTeam;
use App\Models\RankingTagTeamAverage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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

    public function handle(): void
    {
        $query = VoteTagTeam::where('ranking_id', $this->rankingId)
            ->where('tag_team_id', $this->tagTeamId);

        $votesCount = $query->count();

        // nessun voto -> job safe
        if ($votesCount === 0) {
            return;
        }

        $votesSum = $query->sum('vote');

        RankingTagTeamAverage::updateOrCreate(
            [
                'ranking_id'  => $this->rankingId,
                'tag_team_id' => $this->tagTeamId,
            ],
            [
                'votes_count'  => $votesCount,
                'votes_sum'    => $votesSum,
                'average_vote' => round($votesSum / $votesCount, 2),
            ]
        );
    }
}

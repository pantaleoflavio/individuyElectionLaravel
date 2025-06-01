<?php

namespace App\Jobs;

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
    public float $newVoteValue;

    /**
     * Create a new job instance.
     *
     * @param  int    $rankingId
     * @param  int    $tagTeamId
     * @param  float  $newVoteValue
     */
    public function __construct(int $rankingId, int $tagTeamId, float $newVoteValue)
    {
        $this->rankingId    = $rankingId;
        $this->tagTeamId    = $tagTeamId;
        $this->newVoteValue = $newVoteValue;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Proviamo a recuperare la riga esistente in ranking_tag_team_averages
        $record = RankingTagTeamAverage::where('ranking_id', $this->rankingId)
            ->where('tag_team_id', $this->tagTeamId)
            ->first();

        if ($record) {
            $record->votes_count  += 1;
            $record->votes_sum    += $this->newVoteValue;
            $record->average_vote = round($record->votes_sum / $record->votes_count, 2);
            $record->save();
        } else {
            RankingTagTeamAverage::create([
                'ranking_id'   => $this->rankingId,
                'tag_team_id'  => $this->tagTeamId,
                'votes_count'  => 1,
                'votes_sum'    => $this->newVoteValue,
                'average_vote' => round($this->newVoteValue, 2),
            ]);
        }
    }
}

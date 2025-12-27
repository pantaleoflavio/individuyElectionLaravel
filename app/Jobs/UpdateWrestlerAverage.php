<?php

namespace App\Jobs;

use App\Models\VoteWrestler;
use App\Models\RankingWrestlerAverage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateWrestlerAverage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $rankingId;
    public int $wrestlerId;
    public float $newVoteValue;

    /**
     * Create a new job instance.
     *
     * @param  int    $rankingId
     * @param  int    $wrestlerId
     * @param  float  $newVoteValue
     */
    public function __construct(int $rankingId, int $wrestlerId, float $newVoteValue)
    {
        $this->rankingId = $rankingId;
        $this->wrestlerId = $wrestlerId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $query = VoteWrestler::where('ranking_id', $this->rankingId)
            ->where('wrestler_id', $this->wrestlerId);

        $votesCount = $query->count();

        //nessun voto
        if ($votesCount === 0) {
            return;
        }

        $votesSum = $query->sum('vote');

        RankingWrestlerAverage::updateOrCreate(
            [
                'ranking_id'  => $this->rankingId,
                'wrestler_id' => $this->wrestlerId,
            ],
            [
                'votes_count'  => $votesCount,
                'votes_sum'    => $votesSum,
                'average_vote' => round($votesSum / $votesCount, 2),
            ]
        );
    }
}

<?php

namespace App\Jobs;

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
        $this->rankingId    = $rankingId;
        $this->wrestlerId   = $wrestlerId;
        $this->newVoteValue = $newVoteValue;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $record = RankingWrestlerAverage::where('ranking_id', $this->rankingId)
            ->where('wrestler_id', $this->wrestlerId)
            ->first();

        if ($record) {
            $record->votes_count  += 1;
            $record->votes_sum    += $this->newVoteValue;
            $record->average_vote = round($record->votes_sum / $record->votes_count, 2);
            $record->save();
        } else {
            RankingWrestlerAverage::create([
                'ranking_id'   => $this->rankingId,
                'wrestler_id'  => $this->wrestlerId,
                'votes_count'  => 1,
                'votes_sum'    => $this->newVoteValue,
                'average_vote' => round($this->newVoteValue, 2),
            ]);
        }
    }
}

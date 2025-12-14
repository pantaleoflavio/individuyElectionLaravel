<?php

namespace App\Listeners;

use App\Events\VoteAdded;
use App\Models\VoteTagTeam;
use App\Models\AbstractVote;

use App\Models\VoteWrestler;
use App\Jobs\UpdateTagTeamAverage;
use App\Jobs\UpdateWrestlerAverage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UpdateRankingAverage
{
     use Dispatchable, SerializesModels;

    public AbstractVote $vote;

    public function __construct(AbstractVote $vote)
    {
        $this->vote = $vote;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\VoteAdded  $event
     * @return void
     */
    public function handle(VoteAdded $event): void
    {
        $vote = $event->vote; // AbstractVote

        if ($vote instanceof VoteWrestler) {
            UpdateWrestlerAverage::dispatch(
                $vote->ranking_id,
                $vote->wrestler_id,
                $vote->vote
            );
        } elseif ($vote instanceof VoteTagTeam) {
            UpdateTagTeamAverage::dispatch(
                $vote->ranking_id,
                $vote->tag_team_id,
                $vote->vote
            );
        }
    }
}

<?php


namespace App\Listeners;

use App\Events\VoteAdded;
use App\Jobs\UpdateTagTeamAverage;
use App\Jobs\UpdateWrestlerAverage;
use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;

class UpdateRankingAverage
{
    public function handle(VoteAdded $event): void
    {
        $vote = $event->vote;

        if ($vote instanceof VoteWrestler) {
            UpdateWrestlerAverage::dispatch($vote->ranking_id, $vote->wrestler_id);
            return;
        }

        if ($vote instanceof VoteTagTeam) {
            UpdateTagTeamAverage::dispatch($vote->ranking_id, $vote->tag_team_id);
        }
    }
}
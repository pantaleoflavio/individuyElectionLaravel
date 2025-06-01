<?php

namespace App\Listeners;

use App\Events\VoteAdded;
use App\Jobs\UpdateTagTeamAverage;
use App\Jobs\UpdateWrestlerAverage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateRankingAverage
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

/**
     * Handle the event.
     *
     * @param  \App\Events\VoteAdded  $event
     * @return void
     */
    public function handle(VoteAdded $event): void
    {
        // Se il voto è di tipo VoteWrestler, dispatchiamo il job specifico
        if ($event->vote instanceof \App\Models\VoteWrestler) {
            UpdateWrestlerAverage::dispatch(
                $event->vote->ranking_id,
                $event->vote->wrestler_id,
                $event->vote->vote
            );
        }
        // Altrimenti, è un voto su un tag team
        else {
            UpdateTagTeamAverage::dispatch(
                $event->vote->ranking_id,
                $event->vote->tag_team_id,
                $event->vote->vote
            );
        }
    }
}

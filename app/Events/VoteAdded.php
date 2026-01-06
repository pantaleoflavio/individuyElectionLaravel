<?php

namespace App\Events;

use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\AbstractVote;

class VoteAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
    * @var \App\Models\AbstractVote
    */
    public AbstractVote $vote;

    public function __construct(AbstractVote $vote)
    {
        $this->vote = $vote;
    }
}

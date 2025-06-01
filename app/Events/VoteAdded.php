<?php

namespace App\Events;

use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
    * @var \App\Models\VoteWrestler|\App\Models\VoteTagTeam
    */
    public VoteWrestler|VoteTagTeam $vote;

    public function __construct(VoteWrestler|VoteTagTeam $vote)
    {
        $this->vote = $vote;
    }
}

<?php

namespace App\Models;

use App\Models\AbstractVote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class VoteTagTeam extends AbstractVote
{
    use HasFactory;

    protected $table = 'votes_tag_team';

    protected $fillable = [
        'user_id',
        'tag_team_id',
        'ranking_id',
        'vote',
    ];

    public function tagTeam()
    {
        return $this->belongsTo(TagTeam::class);
    }

    public function participant(): BelongsTo
    {
        return $this->tagTeam();
    }
}

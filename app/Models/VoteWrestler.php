<?php

namespace App\Models;

use App\Models\AbstractVote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteWrestler extends AbstractVote
{
    use HasFactory;
    protected $table = 'votes_wrestler';

    protected $fillable = [
        'user_id',
        'wrestler_id',
        'ranking_id',
        'vote',
    ];

    public function wrestler()
    {
        return $this->belongsTo(Wrestler::class);
    }

        public function participant(): BelongsTo
    {
        return $this->wrestler();
    }
}

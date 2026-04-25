<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VoteFederation extends AbstractVote
{
    use HasFactory;

    protected $table = 'votes_federation';

    protected $fillable = [
        'user_id',
        'federation_id',
        'ranking_id',
        'vote',
    ];

    public function federation(): BelongsTo
    {
        return $this->belongsTo(Federation::class);
    }

    public function participant(): BelongsTo
    {
        return $this->federation();
    }
}

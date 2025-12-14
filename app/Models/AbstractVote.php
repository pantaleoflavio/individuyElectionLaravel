<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

abstract class AbstractVote extends Model
{
    protected $fillable = [
        'user_id',
        'ranking_id',
        'vote',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function ranking(): BelongsTo
    {
        return $this->belongsTo(Ranking::class);
    }

    abstract public function participant(): BelongsTo;
}

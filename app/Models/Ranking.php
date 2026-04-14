<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'status',
        'category_id',
        'federation_id',
        'country',
        'includes_inactive',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function federation(): BelongsTo
    {
        return $this->belongsTo(Federation::class);
    }

    public function votesWrestler(): HasMany
    {
        return $this->hasMany(VoteWrestler::class);
    }

    public function votesTagTeam(): HasMany
    {
        return $this->hasMany(VoteTagTeam::class);
    }

    public function wrestlerAverages(): HasMany
    {
        return $this->hasMany(RankingWrestlerAverage::class);
    }

    public function tagTeamAverages(): HasMany
    {
        return $this->hasMany(RankingTagTeamAverage::class);
    }
}

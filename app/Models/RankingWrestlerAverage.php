<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingWrestlerAverage extends Model
{
    use HasFactory;

        protected $fillable = [
        'ranking_id',
        'wrestler_id',
        'votes_count',
        'votes_sum',
        'average_vote',
    ];

    public function ranking()
    {
        return $this->belongsTo(Ranking::class);
    }

    public function wrestler()
    {
        return $this->belongsTo(Wrestler::class);
    }
}

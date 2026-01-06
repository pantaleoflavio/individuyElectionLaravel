<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingTagTeamAverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ranking_id',
        'tag_team_id',
        'votes_count',
        'votes_sum',
        'average_vote',
    ];

    public function ranking()
    {
        return $this->belongsTo(Ranking::class);
    }


    public function tagTeam()
    {
        return $this->belongsTo(TagTeam::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteTagTeam extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ranking()
    {
        return $this->belongsTo(Ranking::class);
    }
}

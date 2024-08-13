<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteWrestler extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ranking()
    {
        return $this->belongsTo(Ranking::class);
    }
}

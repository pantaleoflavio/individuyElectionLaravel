<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingCountry extends Model
{
    use HasFactory;

    protected $fillable = [
        'ranking_id',
        'country',
    ];

    public function ranking()
    {
        return $this->belongsTo(Ranking::class);
    }
}
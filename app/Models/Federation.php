<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Federation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function wrestler()
    {
        return $this->hasMany(Wrestler::class);
    }

    public function tag_team()
    {
        return $this->hasMany(TagTeam::class);
    }
}

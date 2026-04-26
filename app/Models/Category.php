<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the rankings for the category.
     */
    public function rankings()
    {
        return $this->hasMany(Ranking::class);
    }

    public function wrestlers()
    {
        return $this->belongsToMany(Wrestler::class, 'wrestler_category')->withTimestamps();
    }

    public function tagTeams()
    {
        return $this->belongsToMany(TagTeam::class, 'tag_team_category')->withTimestamps();
    }
}

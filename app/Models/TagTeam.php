<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'country',
        'category_id',
        'federation_id',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'tag_team_category')->withTimestamps();
    }

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }

    public function federations()
    {
        return $this->belongsToMany(Federation::class)->withTimestamps();
    }

    public function rankingAverages()
    {
        return $this->hasMany(RankingTagTeamAverage::class);
    }
}

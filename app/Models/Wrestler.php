<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wrestler extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
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
        return $this->belongsToMany(Category::class, 'wrestler_category')->withTimestamps();
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
        return $this->hasMany(RankingWrestlerAverage::class);
    }
}

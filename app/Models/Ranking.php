<?php

namespace App\Models;

use App\Models\RankingCountry;
use App\Models\RankingFederationAverage;
use App\Models\VoteFederation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'filter_type',
        'status',
        'category_id',
        'federation_id',
        'country',
        'includes_inactive',
    ];

    /**
     * Get the category that owns the ranking.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function federation()
    {
        return $this->belongsTo(Federation::class);
    }

    public function federations()
    {
        return $this->belongsToMany(Federation::class)->withTimestamps();
    }

    public function rankingCountries()
    {
        return $this->hasMany(RankingCountry::class);
    }

    /**
     * Get the votes for the wrestlers in this ranking.
     */
    public function votesWrestler()
    {
        return $this->hasMany(VoteWrestler::class);
    }

    /**
     * Get the votes for the tag teams in this ranking.
     */
    public function votesTagTeam()
    {
        return $this->hasMany(VoteTagTeam::class);
    }

    public function wrestlerAverages()
    {
        return $this->hasMany(RankingWrestlerAverage::class);
    }

    public function tagTeamAverages()
    {
        return $this->hasMany(RankingTagTeamAverage::class);
    }

    public function votesFederation()
    {
        return $this->hasMany(VoteFederation::class);
    }

    public function federationAverages()
    {
        return $this->hasMany(RankingFederationAverage::class);
    }
}

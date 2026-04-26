<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagTeam extends Model
{
    use HasFactory;

    protected ?int $legacyCategoryId = null;
    protected ?int $legacyFederationId = null;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'country',
        'category_id',
        'federation_id',
        'is_active',
    ];

    protected static function booted(): void
    {
        static::saved(function (self $tagTeam): void {
            if ($tagTeam->legacyCategoryId) {
                $tagTeam->categories()->syncWithoutDetaching([$tagTeam->legacyCategoryId]);
                $tagTeam->legacyCategoryId = null;
            }

            if ($tagTeam->legacyFederationId) {
                $tagTeam->federations()->syncWithoutDetaching([$tagTeam->legacyFederationId]);
                $tagTeam->legacyFederationId = null;
            }
        });
    }
    
    public function setCategoryIdAttribute($value): void
    {
        $this->legacyCategoryId = $value ? (int) $value : null;
    }

    public function setFederationIdAttribute($value): void
    {
        $this->legacyFederationId = $value ? (int) $value : null;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'tag_team_category')->withTimestamps();
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

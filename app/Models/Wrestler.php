<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wrestler extends Model
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
        static::saved(function (self $wrestler): void {
            if ($wrestler->legacyCategoryId) {
                $wrestler->categories()->syncWithoutDetaching([$wrestler->legacyCategoryId]);
                $wrestler->legacyCategoryId = null;
            }

            if ($wrestler->legacyFederationId) {
                $wrestler->federations()->syncWithoutDetaching([$wrestler->legacyFederationId]);
                $wrestler->legacyFederationId = null;
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
        return $this->belongsToMany(Category::class, 'wrestler_category')->withTimestamps();
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


    protected static function booted(): void
    {
        static::created(function (Wrestler $wrestler): void {
            if ($wrestler->category_id) {
                $wrestler->categories()->syncWithoutDetaching([$wrestler->category_id]);
            }

            if ($wrestler->federation_id) {
                $wrestler->federations()->syncWithoutDetaching([$wrestler->federation_id]);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function federation(): BelongsTo
    {
        return $this->belongsTo(Federation::class);
    }

    public function federations(): BelongsToMany
    {
        return $this->belongsToMany(Federation::class)->withTimestamps();
    }

    public function rankingAverages(): HasMany
    {
        return $this->hasMany(RankingWrestlerAverage::class);
    }
}

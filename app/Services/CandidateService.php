<?php

namespace App\Services;

use App\Models\Ranking;
use App\Models\Wrestler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CandidateService
{
    public function resolveRanking(?string $rankingId): ?Ranking
    {
        if (!$rankingId) {
            return null;
        }

        return Ranking::find($rankingId);
    }

    /**
     * @param class-string<Model> $modelClass
     */
    public function getCandidates(string $modelClass, Ranking $ranking): Collection
    {
        $query = $modelClass::query();

        if ($ranking->category_id) {
            if ($modelClass === Wrestler::class) {
                $query->whereHas('categories', fn ($q) => $q->whereKey($ranking->category_id));
            } else {
                $query->where('category_id', $ranking->category_id);
            }
        }

        if ($ranking->federation_id) {
            if ($modelClass === Wrestler::class) {
                $query->whereHas('federations', fn ($q) => $q->whereKey($ranking->federation_id));
            } else {
                $query->where('federation_id', $ranking->federation_id);
            }
        }

        if ($ranking->country) {
            $query->where('country', $ranking->country);
        }

        if (!$ranking->includes_inactive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }
}

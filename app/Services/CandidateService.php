<?php

namespace App\Services;

use App\Models\Ranking;
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
    public function getCandidates(string $modelClass, ?string $categoryId, mixed $includesInactive): Collection
    {
        $query = $modelClass::query();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        } else {
            $query->whereNull('category_id');
        }

        if (!$includesInactive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }
}
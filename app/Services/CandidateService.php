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

        return Ranking::with(['categories', 'federations', 'rankingCountries'])->find($rankingId);
    }

    /**
     * @param class-string<Model> $modelClass
     */
    public function getCandidates(string $modelClass, Ranking $ranking): Collection
    {
        $query = $modelClass::query();

        $categoryIds = $ranking->categories->pluck('id')->all();
        if (empty($categoryIds) && $ranking->category_id) {
            $categoryIds = [$ranking->category_id];
        }
       
        $federationIds = $ranking->federations->pluck('id')->all();
        if (empty($federationIds) && $ranking->federation_id) {
            $federationIds = [$ranking->federation_id];
        }

        $countries = $ranking->rankingCountries->pluck('country')->all();
        if (empty($countries) && $ranking->country) {
            $countries = array_values(array_filter(array_map('trim', explode(',', (string) $ranking->country))));
        }

        if (!empty($categoryIds)) {
            $query->where(function ($subQuery) use ($categoryIds) {
                $subQuery->whereIn('category_id', $categoryIds);

                if (method_exists($subQuery->getModel(), 'categories')) {
                    $subQuery->orWhereHas('categories', function ($categoriesQuery) use ($categoryIds) {
                        $categoriesQuery->whereIn('categories.id', $categoryIds);
                    });
                }
            });
        }

        if (!empty($federationIds)) {
            $query->where(function ($subQuery) use ($federationIds) {
                $subQuery->whereIn('federation_id', $federationIds);

                if (method_exists($subQuery->getModel(), 'federations')) {
                    $subQuery->orWhereHas('federations', function ($federationsQuery) use ($federationIds) {
                        $federationsQuery->whereIn('federations.id', $federationIds);
                    });
                }
            });
        }

        if (!empty($countries)) {
            $query->whereIn('country', $countries);
        }

        if (!$ranking->includes_inactive) {
            $query->where('is_active', true);
        }

        return $query->get();
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRankingRequest;
use App\Http\Requests\UpdateRankingRequest;
use App\Models\Category;
use App\Models\Federation;
use App\Models\Ranking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RankingManagementController extends Controller
{
    public function index()
    {
        $rankings = Ranking::with(['category', 'federation', 'categories', 'federations', 'rankingCountries'])->get();
        $categories = Category::all();
        $federations = Federation::all();

        return view('admin.ranking', compact('rankings', 'categories', 'federations'));
    }

    public function store(StoreRankingRequest $request)
    {
        $rankingAttributes = $request->validated();

        $categoryIds = $this->normalizeIds($rankingAttributes['category_ids'] ?? [], $rankingAttributes['category_id'] ?? null);
        $federationIds = $this->normalizeIds($rankingAttributes['federation_ids'] ?? [], $rankingAttributes['federation_id'] ?? null);
        $countries = $this->normalizeCountries($rankingAttributes['countries_text'] ?? null, $rankingAttributes['country'] ?? null);

        $rankingAttributes['category_id'] = $categoryIds[0] ?? null;
        $rankingAttributes['federation_id'] = $federationIds[0] ?? null;
        $rankingAttributes['country'] = empty($countries) ? null : implode(', ', $countries);
        $rankingAttributes['filter_type'] = $this->resolveFilterType($categoryIds, $federationIds, $countries);

        try {
            DB::transaction(function () use ($rankingAttributes, $categoryIds, $federationIds, $countries): void {
                $ranking = Ranking::create($rankingAttributes);

                $ranking->categories()->sync($categoryIds);
                $ranking->federations()->sync($federationIds);
                $ranking->rankingCountries()->delete();
                foreach ($countries as $country) {
                    $ranking->rankingCountries()->create(['country' => $country]);
                }
            });
        } catch (\Throwable $exception) {
            Log::error('Errore durante il salvataggio del Ranking.', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Impossibile salvare il Ranking.');
        }

        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiunto con successo.');
    }

    public function edit($id)
    {
        $ranking = Ranking::with(['categories', 'federations', 'rankingCountries'])->findOrFail($id);
        $categories = Category::all();

        $federations = Federation::all();

        return view('admin.edit-ranking', compact('ranking', 'categories', 'federations'));
    }

    public function update(UpdateRankingRequest $request, $id)
    {
        $ranking = Ranking::with(['categories', 'federations', 'rankingCountries'])->findOrFail($id);
        $validatedData = $request->validated();

        $categoryIds = $this->normalizeIds($validatedData['category_ids'] ?? [], $validatedData['category_id'] ?? null);
        $federationIds = $this->normalizeIds($validatedData['federation_ids'] ?? [], $validatedData['federation_id'] ?? null);
        $countries = $this->normalizeCountries($validatedData['countries_text'] ?? null, $validatedData['country'] ?? null);

        $validatedData['category_id'] = $categoryIds[0] ?? null;
        $validatedData['federation_id'] = $federationIds[0] ?? null;
        $validatedData['country'] = empty($countries) ? null : implode(', ', $countries);
        $validatedData['filter_type'] = $this->resolveFilterType($categoryIds, $federationIds, $countries);

        try {
            DB::transaction(function () use ($ranking, $validatedData, $categoryIds, $federationIds, $countries): void {
                $ranking->update($validatedData);
                $ranking->categories()->sync($categoryIds);
                $ranking->federations()->sync($federationIds);
                $ranking->rankingCountries()->delete();

                foreach ($countries as $country) {
                    $ranking->rankingCountries()->create(['country' => $country]);
                }
            });
        } catch (\Throwable $exception) {
            Log::error('Errore durante l\'aggiornamento del Ranking.', [
                'ranking_id' => $ranking->id,
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Impossibile aggiornare il Ranking.');
        }

        return redirect()->route('admin.ranking')->with('success', 'Ranking aggiornato con successo.');
    }

    public function destroy($id)
    {
        $ranking = Ranking::findOrFail($id);
        $ranking->delete();

        return redirect()->route('admin.ranking')->with('success', 'Ranking eliminato con successo');
    }

    /**
    * @param int[] $categoryIds
    * @param int[] $federationIds
    * @param string[] $countries
    */
    private function resolveFilterType(array $categoryIds, array $federationIds, array $countries): string
    {
        $activeFilters = (int) (!empty($categoryIds)) + (int) (!empty($federationIds)) + (int) (!empty($countries));

        if ($activeFilters === 0) {
            return 'none';
        }

        if ($activeFilters > 1) {
            return 'multiple';
        }

        if (!empty($categoryIds)) {
            return 'category';
        }

        if (!empty($federationIds)) {
            return 'federation';
        }

        return 'country';
    }

    /**
     * @param int[] $ids
     * @return int[]
     */
    private function normalizeIds(array $ids, ?int $singleId): array
    {
        $merged = $ids;
        if (!is_null($singleId)) {
            $merged[] = $singleId;
        }

        return array_values(array_unique(array_map('intval', array_filter($merged))));
    }

    /**
    * @return string[]
    */
    private function normalizeCountries(?string $countriesText, ?string $country): array
    {
        $fromText = $countriesText ? explode(',', $countriesText) : [];
        $legacy = $country ? explode(',', $country) : [];

        return array_values(array_unique(array_filter(array_map(
            static fn (string $value) => trim($value),
            array_merge($fromText, $legacy)
        ))));
    }
}

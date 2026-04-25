<?php

namespace App\Http\Controllers;

use App\Models\Federation;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\Wrestler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('query', ''));

        if ($query === '') {
            return view('search.index', [
                'query' => $query,
                'wrestlers' => collect(),
                'tagTeams' => collect(),
                'federations' => collect(),
                'rankings' => collect(),
            ]);
        }

        $wrestlers = $this->caseInsensitiveNameSearch(Wrestler::query(), $query)
            ->orderBy('name')
            ->limit(15)
            ->get();

        $tagTeams = $this->caseInsensitiveNameSearch(TagTeam::query(), $query)
            ->orderBy('name')
            ->limit(15)
            ->get();

        $federations = $this->caseInsensitiveNameSearch(Federation::query(), $query)
            ->orderBy('name')
            ->limit(15)
            ->get();

        $rankings = $this->caseInsensitiveNameSearch(Ranking::query(), $query)
            ->orderBy('name')
            ->limit(15)
            ->get();

        return view('search.index', compact('query', 'wrestlers', 'tagTeams', 'federations', 'rankings'));
    }

    private function caseInsensitiveNameSearch(Builder $builder, string $query): Builder
    {
        return $builder->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($query) . '%']);
    }
}

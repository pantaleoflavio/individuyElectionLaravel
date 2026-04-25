<?php

namespace App\Http\Controllers;

use App\Models\Federation;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\Wrestler;
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

        $wrestlers = Wrestler::query()
            ->where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(15)
            ->get();

        $tagTeams = TagTeam::query()
            ->where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(15)
            ->get();

        $federations = Federation::query()
            ->where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(15)
            ->get();

        $rankings = Ranking::query()
            ->where('name', 'like', "%{$query}%")
            ->orderBy('name')
            ->limit(15)
            ->get();

        return view('search.index', compact('query', 'wrestlers', 'tagTeams', 'federations', 'rankings'));
    }
}

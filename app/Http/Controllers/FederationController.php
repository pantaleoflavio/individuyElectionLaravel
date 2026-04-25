<?php

namespace App\Http\Controllers;

use App\Models\TagTeam;
use App\Models\Wrestler;
use App\Models\Federation;
use App\Services\CandidateService;
use Illuminate\Http\Request;

class FederationController extends Controller
{
    public function __construct(private readonly CandidateService $candidateService)
    {
    }

    public function index()
    {
        $federations = Federation::all();
        if ($federations->isEmpty()) {
            return redirect()->route('home')->with('error', 'Nessuna federazione disponibile.');
        }
        return view('federations.index', compact('federations'));
    }

    public function candidates(Request $request)
    {
        $rankingId = $request->query('ranking_id');

        $ranking = $this->candidateService->resolveRanking($rankingId);
        if (!$ranking) {
            return redirect()->back()->with('error', 'Ranking non disponibile per questa votazione.');
        }

        $federations = Federation::orderBy('name')->get();

        return view('votes.federation.candidates', [
            'federations' => $federations,
            'ranking' => $ranking,
        ]);
    }

    public function show($id)
    {
        $federation = Federation::findOrFail($id);

        $wrestlers = Wrestler::with(['federations', 'federation'])
            ->where(function ($query) use ($id) {
                $query->where('federation_id', $id)
                    ->orWhereHas('federations', function ($federationsQuery) use ($id) {
                        $federationsQuery->where('federations.id', $id);
                    });
            })
            ->distinct()
            ->get();

        $tagTeams = TagTeam::with(['federations', 'federation'])
            ->where(function ($query) use ($id) {
                $query->where('federation_id', $id)
                    ->orWhereHas('federations', function ($federationsQuery) use ($id) {
                        $federationsQuery->where('federations.id', $id);
                    });
            })
            ->distinct()
            ->get();

        return view('federations.show', compact('federation', 'wrestlers', 'tagTeams'));
    }
}

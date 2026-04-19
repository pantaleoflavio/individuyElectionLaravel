<?php

namespace App\Http\Controllers;

use App\Models\Wrestler;

use Illuminate\Http\Request;
use App\Services\CandidateService;

class WrestlerController extends Controller
{
    public function __construct(private readonly CandidateService $candidateService)
    {
    }

    public function show(Wrestler $wrestler)
    {
        $wrestler->load(['categories', 'federations', 'category', 'federation']);

        return view('wrestlers.show', [
            'wrestler' => $wrestler,
        ]);
    }

    public function candidates(Request $request)
    {
        $rankingId = $request->query('ranking_id');

        $ranking = $this->candidateService->resolveRanking($rankingId);
        if (!$ranking) {
            return redirect()->back()->with('error', 'Ranking non disponibile per questa votazione.');
        }
    
        $wrestlers = $this->candidateService->getCandidates(Wrestler::class, $ranking);
    
        return view('votes.wrestler.candidates', [
            'wrestlers' => $wrestlers,
            'ranking' => $ranking,
        ]);
    }
}

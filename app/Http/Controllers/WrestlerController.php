<?php

namespace App\Http\Controllers;

use App\Models\Wrestler;
use App\Services\CandidateService;
use Illuminate\Http\Request;

class WrestlerController extends Controller
{
    public function __construct(private readonly CandidateService $candidateService)
    {
    }

    public function candidates(Request $request)
    {
        $categoryId = $request->query('category_id');
        $includesInactive = $request->query('includes_inactive');
        $rankingId = $request->query('ranking_id');

        $ranking = $this->candidateService->resolveRanking($rankingId);
        if (!$ranking) {
            return redirect()->back()->with('error', 'Ranking non disponibile per questa votazione.');
        }
    
        $wrestlers = $this->candidateService->getCandidates(Wrestler::class, $categoryId, $includesInactive);
    
        return view('votes.wrestler.candidates', [
            'wrestlers' => $wrestlers,
            'ranking' => $ranking,
        ]);
    }
}

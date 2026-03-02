<?php

namespace App\Http\Controllers;

use App\Models\TagTeam;
use App\Services\CandidateService;
use Illuminate\Http\Request;

class TagTeamController extends Controller
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
    
        $tagTeams = $this->candidateService->getCandidates(TagTeam::class, $categoryId, $includesInactive);

        return view('votes.tag_team.candidates', [
            'tagTeams' => $tagTeams,
            'ranking' => $ranking,
        ]);
    }

    public function tag_team()
    {
        $tagTeams = TagTeam::with(['category', 'federation'])->get();
        
        return view('admin.tag_team', compact(
            'tagTeams',
        ));
    }
}

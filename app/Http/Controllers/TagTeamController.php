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

    public function show(TagTeam $tagTeam)
    {
        $tagTeam->load(['categories', 'federations', 'category', 'federation']);

        return view('tag_teams.show', [
            'tagTeam' => $tagTeam,
        ]);
    }
    
    public function candidates(Request $request)
    {
        $rankingId = $request->query('ranking_id');

        $ranking = $this->candidateService->resolveRanking($rankingId);
        if (!$ranking) {
            return redirect()->back()->with('error', 'Ranking non disponibile per questa votazione.');
        }
    
        $tagTeams = $this->candidateService->getCandidates(TagTeam::class, $ranking);

        return view('votes.tag_team.candidates', [
            'tagTeams' => $tagTeams,
            'ranking' => $ranking,
        ]);
    }
}

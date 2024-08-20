<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\TagTeam;
use Illuminate\Http\Request;

class TagTeamController extends Controller
{
    public function candidates(Request $request)
    {
        $categoryId = $request->query('category_id');
        $includesInactive = $request->query('includes_inactive');
        $rankingId = $request->query('ranking_id');

        $ranking = Ranking::find($rankingId);
        if (!$ranking) {
            return redirect()->back()->with('error', 'Ranking non disponibile per questa votazione.');
        }
    
        $query = TagTeam::query();
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        } else {
            $query->whereNull('category_id');
        }
    
        if (!$includesInactive) {
            $query->where('is_active', true);
        }
    
        $tagTeams = $query->get();
    
        $ranking = null;
        if ($rankingId) {
            $ranking = Ranking::find($rankingId);
        }
    
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

<?php

namespace App\Http\Controllers;

use App\Enums\RankingType;
use App\Models\Ranking;
use App\Models\RankingTagTeamAverage;
use App\Models\RankingWrestlerAverage;

class RankingController extends Controller
{
    public function index()
    {
        $rankings = Ranking::all();

        if ($rankings->isEmpty()) {
            return redirect()->route('home')->with('error', 'Nessuna classifica disponibile.');
        }
        return view('rankings.index', compact('rankings'));
    }

    public function ranking_list_wrestler()
    {
        $rankings = Ranking::where('type', RankingType::Wrestler->value)
            ->where('status', true) // Mostriamo solo quelli attivi
            ->get(['id', 'name', 'description', 'category_id', 'federation_id', 'country', 'includes_inactive']);
    
        if ($rankings->isEmpty()) {
            return redirect()->route('home')->with('error', 'Nessuna votazione disponibile per i wrestler.');
        }
    
        return view('votes.wrestler.ranking-list', ['rankings' => $rankings]);
    }

    public function ranking_list_tag_team()
    {
        $rankings = Ranking::where('type', RankingType::TagTeam->value)
            ->where('status', true) // Mostriamo solo quelli attivi
            ->get(['id', 'name', 'description', 'category_id', 'federation_id', 'country', 'includes_inactive']);
    
        if ($rankings->isEmpty()) {
            return redirect('/')->with('error', 'Nessuna votazione disponibile per i tag team.');
        }
    
        return view('votes.tag_team.ranking-list', ['rankings' => $rankings]);
    }
    
    public function show($rankingId)
    {
        $ranking = Ranking::findOrFail($rankingId);
    
        $participants = collect();

        if ($ranking->type === 'wrestler') {
            $participants = RankingWrestlerAverage::with(RankingType::Wrestler->value)
                ->where('ranking_id', $rankingId)
                ->orderByDesc('average_vote')
                ->get()
                ->map(function ($rwa) {
                    return (object) [
                        'participant'   => $rwa->wrestler,
                        'average_vote'  => $rwa->average_vote,
                        'votes_count'   => $rwa->votes_count,
                    ];
                });

        } elseif ($ranking->type === RankingType::TagTeam->value) {
            $participants = RankingTagTeamAverage::with('tagTeam')
                ->where('ranking_id', $rankingId)
                ->orderByDesc('average_vote')
                ->get()
                ->map(function ($rta) {
                    return (object) [
                        'participant'   => $rta->tagTeam,
                        'average_vote'  => $rta->average_vote,
                        'votes_count'   => $rta->votes_count,
                    ];
                });
        }

        return view('rankings.show', compact('ranking', 'participants'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\RankingType;
use App\Models\Category;
use App\Models\Ranking;
use App\Models\RankingTagTeamAverage;
use App\Models\RankingWrestlerAverage;
use App\Models\TagTeam;
use App\Models\Wrestler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        $rankings = Ranking::all();
        return view('rankings.index', compact('rankings'));
    }

    public function admin_index()
    {
        $rankings = Ranking::all();
        $categories = Category::all();
        return view('admin.ranking', compact('rankings', 'categories'));
    }

    public function ranking_list_wrestler()
    {
        $rankings = Ranking::where('type', RankingType::Wrestler->value)
            ->where('status', true) // Mostriamo solo quelli attivi
            ->get(['id', 'name', 'description', 'category_id', 'includes_inactive']);
    
        if ($rankings->isEmpty()) {
            return redirect()->route('home')->with('error', 'Le votazioni per i wrestler sono sospese.');
        }
    
        return view('votes.wrestler.ranking-list', ['rankings' => $rankings]);
    }

    public function ranking_list_tag_team()
    {
        $rankings = Ranking::where('type', RankingType::TagTeam->value)
            ->where('status', true) // Mostriamo solo quelli attivi
            ->get(['id', 'name', 'description', 'category_id', 'includes_inactive']);
    
        if ($rankings->isEmpty()) {
            return redirect('/')->with('error', 'Le votazioni per i tag team sono sospese.');
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

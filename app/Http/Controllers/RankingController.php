<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
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

    public function ranking_list_wrestler()
    {
        $rankings = Ranking::where('type', 'wrestler')->get(['id', 'name', 'description', 'category_id', 'includes_inactive']);

        return view('votes.wrestler.ranking-list', ['rankings' => $rankings]);
    }

    public function ranking_list_tag_team()
    {
        $rankings = Ranking::where('type', 'tag team')->get(['id', 'name', 'description', 'category_id', 'includes_inactive']);

        return view('votes.tag_team.ranking-list', ['rankings' => $rankings]);
    }

    public function show($rankingId)
    {
        // Recupera il ranking
        $ranking = Ranking::findOrFail($rankingId);
    
        $participants = collect(); // Inizializza una collection vuota
    
        if ($ranking->type == 'wrestler') {
            // Fetch dei voti e calcolo della media per i wrestler
            $results = DB::table('votes_wrestler')
                ->select('wrestler_id', DB::raw('AVG(vote) as average_vote'))
                ->where('ranking_id', $rankingId)
                ->groupBy('wrestler_id')
                ->orderBy('average_vote', 'desc')
                ->get();
    
            // Aggiungi i nomi dei wrestler
            $participants = $results->map(function ($result) {
                $result->participant = Wrestler::find($result->wrestler_id);
                return $result;
            });
    
        } elseif ($ranking->type == 'tag team') {
            // Fetch dei voti e calcolo della media per i tag team
            $results = DB::table('votes_tag_team')
                ->select('tag_team_id', DB::raw('AVG(vote) as average_vote'))
                ->where('ranking_id', $rankingId)
                ->groupBy('tag_team_id')
                ->orderBy('average_vote', 'desc')
                ->get();
    
            // Aggiungi i nomi dei tag team
            $participants = $results->map(function ($result) {
                $result->participant = TagTeam::find($result->tag_team_id);
                return $result;
            });
        }
    
        return view('rankings.show', compact('ranking', 'participants'));
    }
    



}

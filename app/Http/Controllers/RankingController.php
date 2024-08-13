<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        return view('votes.index');
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
}

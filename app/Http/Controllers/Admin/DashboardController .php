<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RankingType;
use App\Http\Controllers\Controller;
use App\Models\Federation;
use App\Models\Ranking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::user();
        $federationsWithCounts = Federation::withCount(['wrestler', 'tag_team'])->get();
        $wrestlerRankings = Ranking::where('type', RankingType::Wrestler->value)->withCount('votesWrestler')->get();
        $tagTeamRankings = Ranking::where('type', RankingType::TagTeam->value)->withCount('votesTagTeam')->get();
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'admin',
            'federationsWithCounts',
            'wrestlerRankings',
            'tagTeamRankings',
            'totalUsers'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Enums\RankingType;
use App\Models\Ranking;
use App\Models\RankingTagTeamAverage;
use App\Models\RankingWrestlerAverage;
use App\Models\RankingFederationAverage;

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
        $rankings = Ranking::where('status', true)
            ->get(['id', 'name', 'description', 'type', 'filter_type', 'category_id', 'federation_id', 'country', 'includes_inactive'])
            ->filter(fn (Ranking $ranking) => $this->isRankingType($ranking, RankingType::Wrestler))
            ->values();
    
        if ($rankings->isEmpty()) {
            return redirect()->route('home')->with('error', 'Nessuna votazione disponibile per i wrestler.');
        }
    
        return view('votes.wrestler.ranking-list', ['rankings' => $rankings]);
    }

    public function ranking_list_tag_team()
    {
        $rankings = Ranking::where('status', true)
            ->get(['id', 'name', 'description', 'type', 'filter_type', 'category_id', 'federation_id', 'country', 'includes_inactive'])
            ->filter(fn (Ranking $ranking) => $this->isRankingType($ranking, RankingType::TagTeam))
            ->values();
    
        if ($rankings->isEmpty()) {
            return redirect('/')->with('error', 'Nessuna votazione disponibile per i tag team.');
        }
    
        return view('votes.tag_team.ranking-list', ['rankings' => $rankings]);
    }

    public function ranking_list_federation()
    {
        $rankings = Ranking::where('status', true)
            ->get(['id', 'name', 'description', 'type', 'filter_type', 'category_id', 'federation_id', 'country', 'includes_inactive'])
            ->filter(fn (Ranking $ranking) => $this->isRankingType($ranking, RankingType::Federation))
            ->values();

        return view('votes.federation.ranking-list', ['rankings' => $rankings]);
    }
    
    public function show($rankingId)
    {
        $ranking = Ranking::findOrFail($rankingId);
    
        $participants = collect();

        if ($ranking->type === RankingType::Wrestler->value) {
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
        } elseif ($ranking->type === RankingType::Federation->value) {
            $participants = RankingFederationAverage::with('federation')
                ->where('ranking_id', $rankingId)
                ->orderByDesc('average_vote')
                ->get()
                ->map(function ($rfa) {
                    return (object) [
                        'participant'   => $rfa->federation,
                        'average_vote'  => $rfa->average_vote,
                        'votes_count'   => $rfa->votes_count,
                    ];
                });
        }

        return view('rankings.show', compact('ranking', 'participants'));
    }

    private function isRankingType(Ranking $ranking, RankingType $expectedType): bool
    {
        return $this->normalizeRankingType($ranking->type) === $this->normalizeRankingType($expectedType->value);
    }

    private function normalizeRankingType(?string $value): string
    {
        if (is_null($value)) {
            return '';
        }

        return str_replace(['_', '-', ' '], '', strtolower(trim($value)));
    }
}

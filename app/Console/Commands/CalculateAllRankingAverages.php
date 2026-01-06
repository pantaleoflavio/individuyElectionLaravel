<?php

namespace App\Console\Commands;

use App\Models\Ranking;
use App\Models\RankingTagTeamAverage;
use App\Models\RankingWrestlerAverage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateAllRankingAverages extends Command
{
    protected $signature = 'app:calculate-all-ranking-averages';
    protected $description = 'Rebuild vote averages for all rankings and repopulate averages tables.';

    public function handle(): int
    {
        $this->info('Starting full averages rebuild...');

        DB::transaction(function () {
            RankingWrestlerAverage::query()->delete();
            RankingTagTeamAverage::query()->delete();
        });

        // Wrestler rankings
        $wrestlerRankings = Ranking::where('type', 'wrestler')->get();

        foreach ($wrestlerRankings as $ranking) {
            $results = DB::table('votes_wrestler')
                ->select(
                    'wrestler_id',
                    DB::raw('COUNT(*) as votes_count'),
                    DB::raw('SUM(vote) as votes_sum'),
                    DB::raw('ROUND(AVG(vote), 2) as average_vote')
                )
                ->where('ranking_id', $ranking->id)
                ->groupBy('wrestler_id')
                ->get();

            if ($results->isEmpty()) {
                continue;
            }

            $payload = $results->map(fn ($row) => [
                'ranking_id'   => $ranking->id,
                'wrestler_id'  => $row->wrestler_id,
                'votes_count'  => (int) $row->votes_count,
                'votes_sum'    => (float) $row->votes_sum,
                'average_vote' => (float) $row->average_vote,
                'created_at'   => now(),
                'updated_at'   => now(),
            ])->all();

            RankingWrestlerAverage::insert($payload);

            $this->info("Wrestler ranking {$ranking->id}: inserted " . count($payload) . " rows");
        }

        // Tag team rankings
        $tagTeamRankings = Ranking::where('type', 'tag team')->get();

        foreach ($tagTeamRankings as $ranking) {
            $results = DB::table('votes_tag_team')
                ->select(
                    'tag_team_id',
                    DB::raw('COUNT(*) as votes_count'),
                    DB::raw('SUM(vote) as votes_sum'),
                    DB::raw('ROUND(AVG(vote), 2) as average_vote')
                )
                ->where('ranking_id', $ranking->id)
                ->groupBy('tag_team_id')
                ->get();

            if ($results->isEmpty()) {
                continue;
            }

            $payload = $results->map(fn ($row) => [
                'ranking_id'   => $ranking->id,
                'tag_team_id'  => $row->tag_team_id,
                'votes_count'  => (int) $row->votes_count,
                'votes_sum'    => (float) $row->votes_sum,
                'average_vote' => (float) $row->average_vote,
                'created_at'   => now(),
                'updated_at'   => now(),
            ])->all();

            RankingTagTeamAverage::insert($payload);

            $this->info("Tag team ranking {$ranking->id}: inserted " . count($payload) . " rows");
        }

        $this->info('Averages rebuild completed.');
        return 0;
    }
}
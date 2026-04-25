<?php

namespace App\Console\Commands;

use App\Enums\RankingType;
use App\Models\Ranking;
use App\Models\RankingTagTeamAverage;
use App\Models\RankingWrestlerAverage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\RankingFederationAverage;

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
            RankingFederationAverage::query()->delete();
        });

        // Wrestler rankings
        $wrestlerRankings = Ranking::where('type', RankingType::Wrestler->value)->get();

        foreach ($wrestlerRankings as $ranking) {
            $results = DB::table('votes_wrestler')
                ->select(
                    'wrestler_id',
                    DB::raw('COUNT(*) as votes_count'),
                    DB::raw('SUM(vote)::numeric(10,2) as votes_sum'),
                    DB::raw('ROUND(AVG(vote)::numeric, 2) as average_vote')
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
                'average_vote' => round((float) $row->average_vote, 2),
                'created_at'   => now(),
                'updated_at'   => now(),
            ])->all();

            RankingWrestlerAverage::insert($payload);

            $this->info("Wrestler ranking {$ranking->id}: inserted " . count($payload) . " rows");
        }

        // Tag team rankings
        $tagTeamRankings = Ranking::where('type', RankingType::TagTeam->value)->get();

        foreach ($tagTeamRankings as $ranking) {
            $results = DB::table('votes_tag_team')
                ->select(
                    'tag_team_id',
                    DB::raw('COUNT(*) as votes_count'),
                    DB::raw('SUM(vote)::numeric(10,2) as votes_sum'),
                    DB::raw('ROUND(AVG(vote)::numeric, 2) as average_vote')
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
                'average_vote' => round((float) $row->average_vote, 2),
                'created_at'   => now(),
                'updated_at'   => now(),
            ])->all();

            RankingTagTeamAverage::insert($payload);

            $this->info("Tag team ranking {$ranking->id}: inserted " . count($payload) . " rows");
        }

         // Federation rankings
        $federationRankings = Ranking::where('type', RankingType::Federation->value)->get();

        foreach ($federationRankings as $ranking) {
            $results = DB::table('votes_federation')
                ->select(
                    'federation_id',
                    DB::raw('COUNT(*) as votes_count'),
                    DB::raw('SUM(vote)::numeric(10,2) as votes_sum'),
                    DB::raw('ROUND(AVG(vote)::numeric, 2) as average_vote')
                )
                ->where('ranking_id', $ranking->id)
                ->groupBy('federation_id')
                ->get();

            if ($results->isEmpty()) {
                continue;
            }

            $payload = $results->map(fn ($row) => [
                'ranking_id'   => $ranking->id,
                'federation_id'  => $row->federation_id,
                'votes_count'  => (int) $row->votes_count,
                'votes_sum'    => (float) $row->votes_sum,
                'average_vote' => round((float) $row->average_vote, 2),
                'created_at'   => now(),
                'updated_at'   => now(),
            ])->all();

            RankingFederationAverage::insert($payload);

            $this->info("Federation ranking {$ranking->id}: inserted " . count($payload) . " rows");
        }

        $this->info('Averages rebuild completed.');
        return 0;
    }
}
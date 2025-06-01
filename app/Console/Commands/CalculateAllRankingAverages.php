<?php

namespace App\Console\Commands;

use App\Models\Ranking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\RankingTagTeamAverage;
use App\Models\RankingWrestlerAverage;

class CalculateAllRankingAverages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-all-ranking-averages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcola da zero le medie di voto per tutti i wrestler e i tag team in ogni ranking, e popola le tabelle ranking_wrestler_averages e ranking_tag_team_averages.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Inizio ricalcolo medie per tutti i ranking...');

        RankingWrestlerAverage::truncate();
        $this->info('Tabella ranking_wrestler_averages svuotata.');
        RankingTagTeamAverage::truncate();
        $this->info('Tabella ranking_tag_team_averages svuotata.');

        $wrestlerRankings = Ranking::where('type', 'wrestler')->get();
        foreach ($wrestlerRankings as $ranking) {
            $this->info("Calcolo medie per ranking (wrestler) ID={$ranking->id} (\"{$ranking->name}\")...");

            $results = DB::table('votes_wrestler')
                ->select('wrestler_id', DB::raw('COUNT(*) as votes_count'), DB::raw('SUM(vote) as votes_sum'), DB::raw('ROUND(AVG(vote), 2) as average_vote'))
                ->where('ranking_id', $ranking->id)
                ->groupBy('wrestler_id')
                ->get();

            foreach ($results as $row) {
                RankingWrestlerAverage::create([
                    'ranking_id'   => $ranking->id,
                    'wrestler_id'  => $row->wrestler_id,
                    'votes_count'  => $row->votes_count,
                    'votes_sum'    => $row->votes_sum,
                    'average_vote' => $row->average_vote,
                ]);
            }
            $this->info("  -> Inseriti {$results->count()} record per ranking {$ranking->id}.");
        }

        $tagTeamRankings = Ranking::where('type', 'tag team')->get();
        foreach ($tagTeamRankings as $ranking) {
            $this->info("Calcolo medie per ranking (tag team) ID={$ranking->id} (\"{$ranking->name}\")...");

            $results = DB::table('votes_tag_team')
                ->select('tag_team_id', DB::raw('COUNT(*) as votes_count'), DB::raw('SUM(vote) as votes_sum'), DB::raw('ROUND(AVG(vote), 2) as average_vote'))
                ->where('ranking_id', $ranking->id)
                ->groupBy('tag_team_id')
                ->get();

            foreach ($results as $row) {
                RankingTagTeamAverage::create([
                    'ranking_id'   => $ranking->id,
                    'tag_team_id'  => $row->tag_team_id,
                    'votes_count'  => $row->votes_count,
                    'votes_sum'    => $row->votes_sum,
                    'average_vote' => $row->average_vote,
                ]);
            }
            $this->info("  -> Inseriti {$results->count()} record per ranking {$ranking->id}.");
        }

        $this->info('Ricalcolo medie completato con successo.');
        return 0;
    }
}

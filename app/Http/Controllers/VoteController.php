<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;
use App\Models\Wrestler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function index()
    {
        return view('votes.index');
    }

    public function showWrestlerVoteForm(Wrestler $wrestler, Ranking $ranking)
    {
        return view('votes.wrestler.vote', [
            'wrestler' => $wrestler,
            'ranking' => $ranking,
            'voteOptions' => $this->generateVoteOptions(),
        ]);
    }

    public function showTagTeamVoteForm(TagTeam $tagTeam, Ranking $ranking)
    {
        return view('votes.tag_team.vote', [
            'tagTeam' => $tagTeam,
            'ranking' => $ranking,
            'voteOptions' => $this->generateVoteOptions(),
        ]);
    }

    private function generateVoteOptions()
    {
        $options = [];
        for ($i = 0; $i <= 10; $i += 0.5) {
            $options[] = $i;
        }
        return $options;
    }

    public function wrestlerVoteStore(Request $request)
    {
        $validated = $request->validate([
            'wrestler_id' => 'required|exists:wrestlers,id',
            'ranking_id' => 'required|exists:rankings,id',
            'vote' => 'required|numeric|min:0|max:10',
        ]);

        // Controlliamo che il wrestler appartenga al ranking
        $ranking = Ranking::find($validated['ranking_id']);

        if (!$ranking || $ranking->type !== 'wrestler') {
            return redirect()->back()->with('error', 'Questo ranking non accetta votazioni per wrestler.');
        }

        // Verifica se l'utente ha già votato per questo wrestler in questo ranking
        $existingVote = VoteWrestler::where('user_id', Auth::id())
            ->where('wrestler_id', $validated['wrestler_id'])
            ->where('ranking_id', $validated['ranking_id'])
            ->first();

        if ($existingVote) {
            return redirect()->back()->with('error', 'Hai già votato per questo wrestler in questo ranking.');
        }

        // Registra il voto
        VoteWrestler::create([
            'user_id' => Auth::id(),
            'wrestler_id' => $validated['wrestler_id'],
            'ranking_id' => $validated['ranking_id'],
            'vote' => $validated['vote'],
        ]);

        return redirect()->route('user.profile')->with('success', 'Il tuo voto è stato registrato con successo.');
    }

    public function tagTeamVoteStore(Request $request)
    {
        $validated = $request->validate([
            'tag_team_id' => 'required|exists:tag_teams,id',
            'ranking_id' => 'required|exists:rankings,id',
            'vote' => 'required|numeric|min:0|max:10',
        ]);
    
        // Controlliamo che il tag team appartenga al ranking
        $ranking = Ranking::find($validated['ranking_id']);
    
        if (!$ranking || $ranking->type !== 'tag team') {
            return redirect()->back()->with('error', 'Questo ranking non accetta votazioni per tag team.');
        }
    
        // Verifica se l'utente ha già votato per questo tag team in questo ranking
        $existingVote = VoteTagTeam::where('user_id', Auth::id())
            ->where('tag_team_id', $validated['tag_team_id'])
            ->where('ranking_id', $validated['ranking_id'])
            ->first();
    
        if ($existingVote) {
            return redirect()->back()->with('error', 'Hai già votato per questo tag team in questo ranking.');
        }
    
        // Registra il voto
        VoteTagTeam::create([
            'user_id' => Auth::id(),
            'tag_team_id' => $validated['tag_team_id'],
            'ranking_id' => $validated['ranking_id'],
            'vote' => $validated['vote'],
        ]);
    
        return redirect()->route('user.profile')->with('success', 'Il tuo voto è stato registrato con successo.');
    }
    
}

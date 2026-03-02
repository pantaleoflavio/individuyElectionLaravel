<?php

namespace App\Http\Controllers;

use App\Events\VoteAdded;
use App\Http\Requests\StoreTagTeamVoteRequest;
use App\Http\Requests\StoreWrestlerVoteRequest;
use App\Models\Ranking;
use App\Models\TagTeam;
use App\Models\Wrestler;
use App\Services\VoteService;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function __construct(private readonly VoteService $voteService)
    {
    }
    
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

    public function wrestlerVoteStore(StoreWrestlerVoteRequest $request)
    {
        $validated = $request->validated();
        $result = $this->voteService->createWrestlerVote((int) Auth::id(), $validated);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        $vote = $result['vote'];

        event(new VoteAdded($vote));

        return redirect()->route('user.profile')->with('success', 'Il tuo voto è stato registrato con successo.');
    }

    public function tagTeamVoteStore(StoreTagTeamVoteRequest $request)
    {
        $validated = $request->validated();
        $result = $this->voteService->createTagTeamVote((int) Auth::id(), $validated);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        $vote = $result['vote'];

        event(new VoteAdded($vote));
    
        return redirect()->route('user.profile')->with('success', 'Il tuo voto è stato registrato con successo.');
    }
}

<?php

namespace App\Services;

use App\Enums\RankingType;
use App\Models\Ranking;
use App\Models\VoteTagTeam;
use App\Models\VoteWrestler;

class VoteService
{
    public function createWrestlerVote(int $userId, array $validated): array
    {
        $ranking = Ranking::find($validated['ranking_id']);

        if (!$ranking || $ranking->type !== RankingType::Wrestler->value) {
            return ['error' => 'Questo ranking non accetta votazioni per wrestler.'];
        }

        $vote = VoteWrestler::updateOrCreate(
            [
                'user_id' => $userId,
                'wrestler_id' => $validated['wrestler_id'],
                'ranking_id' => $validated['ranking_id'],
            ],
            [
                'vote' => $validated['vote'],
            ]
        );

        return ['vote' => $vote];
    }

    public function createTagTeamVote(int $userId, array $validated): array
    {
        $ranking = Ranking::find($validated['ranking_id']);

        if (!$ranking || $ranking->type !== RankingType::TagTeam->value) {
            return ['error' => 'Questo ranking non accetta votazioni per tag team.'];
        }

        $vote = VoteTagTeam::updateOrCreate(
            [
                'user_id' => $userId,
                'tag_team_id' => $validated['tag_team_id'],
                'ranking_id' => $validated['ranking_id'],
            ],
            [
                'vote' => $validated['vote'],
            ]
        );

        return ['vote' => $vote];
    }
}
<?php

namespace App\Services;

class RankingAverageService
{
    /**
     * @param class-string $voteModel
     * @param class-string $averageModel
     */
    public function updateAverage(
        string $voteModel,
        string $averageModel,
        string $participantColumn,
        int $rankingId,
        int $participantId
    ): void {
        $query = $voteModel::where('ranking_id', $rankingId)
            ->where($participantColumn, $participantId);

        $votesCount = $query->count();

        if ($votesCount === 0) {
            return;
        }

        $votesSum = $query->sum('vote');

        $averageModel::updateOrCreate(
            [
                'ranking_id' => $rankingId,
                $participantColumn => $participantId,
            ],
            [
                'votes_count' => $votesCount,
                'votes_sum' => $votesSum,
                'average_vote' => round($votesSum / $votesCount, 2),
            ]
        );
    }
}
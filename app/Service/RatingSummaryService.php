<?php

namespace App\Service;

use App\Models\DataVoters;
use App\Models\RatingDailySummary;
use App\Models\RatingUser;
use Carbon\CarbonInterface;

class RatingSummaryService
{
    public function rebuildForBook(int $produkId): void
    {
        $lifetime = RatingUser::query()
            ->where('produk_buku_id', $produkId)
            ->selectRaw('
                COUNT(*) as total_votes,
                COALESCE(SUM(ratings), 0) as total_sum,
                COALESCE(AVG(ratings), 0) as avg_rating
            ')
            ->first();

        $last7 = $this->aggregateDailyWindow(
            $produkId,
            now()->subDays(6),
            now()
        );
        $prev7 = $this->aggregateDailyWindow(
            $produkId,
            now()->subDays(13),
            now()->subDays(7)
        );
        $last30 = $this->aggregateDailyWindow(
            $produkId,
            now()->subDays(29),
            now()
        );

        $trendDelta = $last7['avg'] - $prev7['avg'];
        $trendDirection = $trendDelta > 0.01
            ? 'up'
            : ($trendDelta < -0.01 ? 'down' : 'flat');
        $recentPopularity = $last30['avg'] * log($last30['votes'] + 1);

        DataVoters::updateOrCreate(
            ['produk_buku_id' => $produkId],
            [
                'total_voters' => (int) ($lifetime->total_votes ?? 0),
                'total_rating_sum' => (int) ($lifetime->total_sum ?? 0),
                'avg_rating' => round((float) ($lifetime->avg_rating ?? 0), 2),
                'avg_7_days' => round($last7['avg'], 2),
                'avg_prev_7_days' => round($prev7['avg'], 2),
                'avg_30_days' => round($last30['avg'], 2),
                'voters_30_days' => $last30['votes'],
                'recent_popularity_score' => round($recentPopularity, 2),
                'trend_7_days' => round($trendDelta, 2),
                'trend_direction' => $trendDirection,
            ]
        );
    }

    private function aggregateDailyWindow(int $produkId, CarbonInterface $start, CarbonInterface $end): array
    {
        $row = RatingDailySummary::query()
            ->where('produk_buku_id', $produkId)
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->selectRaw('
                COALESCE(SUM(total_votes), 0) as votes,
                COALESCE(SUM(total_sums), 0) as sums
            ')
            ->first();

        $votes = (int) ($row->votes ?? 0);
        $sums = (float) ($row->sums ?? 0);

        return [
            'votes' => $votes,
            'avg' => $votes > 0 ? ($sums / $votes) : 0.0,
        ];
    }
}

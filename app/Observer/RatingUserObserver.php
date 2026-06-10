<?php

namespace App\Observer;

use App\Jobs\RebuildRatingAggregatesJob;
use App\Models\RatingDailySummary;
use App\Models\RatingUser;

class RatingUserObserver
{
    private function dispatchRebuild(RatingUser $rating): void
    {
        $rating->loadMissing('produkBuku:id,penulis_buku_id');

        $authorId = (int) ($rating->produkBuku?->penulis_buku_id ?? 0);
        if ($authorId <= 0) {
            return;
        }

        RebuildRatingAggregatesJob::dispatch(
            (int) $rating->produk_buku_id,
            $authorId
        )->afterCommit();
    }

    public function created(RatingUser $rating): void
    {
        $summaryKey = [
            'produk_buku_id' => $rating->produk_buku_id,
            'date' => $rating->created_at->toDateString(),
        ];

        RatingDailySummary::query()->insertOrIgnore([
            ...$summaryKey,
            'total_votes' => 0,
            'total_sums' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        RatingDailySummary::query()
            ->where($summaryKey)
            ->increment('total_votes');

        RatingDailySummary::query()
            ->where($summaryKey)
            ->increment('total_sums', $rating->ratings);


        $this->dispatchRebuild($rating);
    }

    public function updated(RatingUser $rating): void
    {
        $oldRating = (int) $rating->getOriginal('ratings');
        $newRating = (int) $rating->ratings;
        $diff = $newRating - $oldRating;

        if ($diff !== 0) {
            $daily = RatingDailySummary::where([
                'produk_buku_id' => $rating->produk_buku_id,
                'date' => $rating->created_at->toDateString(),
            ])->first();

            if ($daily) {
                $daily->increment('total_sums', $diff);
            }
        }

        $this->dispatchRebuild($rating);
    }

    public function deleted(RatingUser $rating): void
    {
        $daily = RatingDailySummary::where([
            'produk_buku_id' => $rating->produk_buku_id,
            'date' => $rating->created_at->toDateString(),
        ])->first();

        if ($daily) {
            $daily->decrement('total_votes');
            $daily->decrement('total_sums', $rating->ratings);
        }

        $this->dispatchRebuild($rating);
    }
}

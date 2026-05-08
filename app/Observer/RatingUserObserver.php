<?php

namespace App\Observer;

use App\Models\RatingDailySummary;
use App\Models\RatingUser;
use App\Service\AuthorStatsService;
use App\Service\RatingSummaryService;

class RatingUserObserver
{
    public function __construct(
        private RatingSummaryService $ratingSummaryService,
        private AuthorStatsService $authorStatsService
    ) {}

    private function recalculate(RatingUser $rating)
    {
        $this->ratingSummaryService->rebuildForBook((int) $rating->produk_buku_id);

        $rating->load('produkBuku');
        $authorId = (int) $rating->produkBuku?->penulis_buku_id;
        if ($authorId > 0) {
            $this->authorStatsService->rebuildForAuthor($authorId);
        }
    }

    public function created(RatingUser $rating): void
    {
        $daily = RatingDailySummary::firstOrCreate(
            [
                'produk_buku_id' => $rating->produk_buku_id,
                'date' => $rating->created_at->toDateString(),
            ],
            [
                'total_votes' => 0,
                'total_sums' => 0,
            ]
        );

        $daily->increment('total_votes');
        $daily->increment('total_sums', $rating->ratings);

        $this->ratingSummaryService->rebuildForBook((int) $rating->produk_buku_id);

        $rating->load('produkBuku');
        $authorId = (int) $rating->produkBuku?->penulis_buku_id;
        if ($authorId > 0) {
            $this->authorStatsService->rebuildForAuthor($authorId);
        }
    }

    public function updated(RatingUser $rating) {
        $oldRating = $rating->getOriginal('ratings');
        $newRating = $rating->ratings;
        $diff = $newRating - $oldRating;

        $daily = RatingDailySummary::where([
            'produk_buku_id' => $rating->produk_buku_id,
            'date' => $rating->created_at->toDateString(),
        ])->first();

        if ($daily && $diff !== 0) {
            $daily->increment('total_sums', $diff);
        }

        $this->recalculate($rating);
    }

    public function deleted(RatingUser $rating) {
        $daily = RatingDailySummary::where([
            'produk_buku_id' => $rating->produk_buku_id,
            'date' => $rating->created_at->toDateString(),
        ])->first();

        if ($daily) {
            $daily->decrement('total_votes');
            $daily->decrement('total_sums', $rating->ratings);
        }

        $this->recalculate($rating);
    }
}

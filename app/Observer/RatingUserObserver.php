<?php

namespace App\Observer;

use App\Models\RatingDailySummary;
use App\Models\RatingUser;
use App\Service\AuthorStatsService;
use App\Service\RatingSummaryService;

class RatingUserObserver
{
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

        (new RatingSummaryService())->rebuildForBook((int) $rating->produk_buku_id);

        $authorId = (int) $rating->produkBuku()->value('penulis_buku_id');
        if ($authorId > 0) {
            (new AuthorStatsService())->rebuildForAuthor($authorId);
        }
    }
}

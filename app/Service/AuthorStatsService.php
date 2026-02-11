<?php

namespace App\Service;

use App\Models\AuthorStats;
use Illuminate\Support\Facades\DB;

class AuthorStatsService
{
    /**
     * Create a new class instance.
     */
    public function __construct() {}

    public function rebuildForAuthor(int $authorId)
    {
        $stats = DB::table('rating_users')
            ->join('produk_bukus', 'produk_bukus.id', '=', 'rating_users.produk_buku_id')
            ->where('produk_bukus.penulis_buku_id', $authorId);

        $voterGt5 = (clone $stats)->where('rating', '>', 5)->count();
        $avgRating = (clone $stats)->avg('rating') ?? 0;
        $totalVotes = (clone $stats)->count();

        // Total books by this author
        $totalBooks = DB::table('produk_bukus')
            ->where('penulis_buku_id', $authorId)
            ->count();

        // Avg rating last 30 days
        $rating30d = (clone $stats)
            ->where('rating_users.created_at', '>=', now()->subDays(30))
            ->avg('rating') ?? 0;

        // Avg rating previous 30 days (30-60 days ago)
        $ratingPrev30d = (clone $stats)
            ->whereBetween('rating_users.created_at', [now()->subDays(60), now()->subDays(30)])
            ->avg('rating');

        AuthorStats::updateOrCreate(
            ['penulis_buku_id' => $authorId],
            [
                'total_books' => $totalBooks,
                'voters_gt_5' => $voterGt5,
                'avg_rating' => round($avgRating, 2),
                'total_voters' => $totalVotes,
                'rating_30d' => round($rating30d, 2),
                'rating_prev_30d' => $ratingPrev30d ? round($ratingPrev30d, 2) : null,
                'popularity_score' => round($this->popularityScore($voterGt5, $avgRating), 2),
            ]
        );
    }

    private function popularityScore(int $voters, float $avg)
    {
        return ($voters * 0.7) + ($avg * 10 * 0.3);
    }
}

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

        // Untuk menghitung jumlah voters yang memberikan rating > 5
        $voterGt5 = (clone $stats)->where('ratings', '>', 5)->count();

        // Untuk menghitung AVG rating dan total votes
        $lifetime = (clone $stats)
            ->selectRaw('
            COUNT(*) as total_votes,
            AVG(ratings) as avg_rating
        ')
            ->first();

        $avgRating = $lifetime->avg_rating ?? 0;
        $totalVotes = $lifetime->total_votes ?? 0;

        // Total books by this author
        $totalBooks = DB::table('produk_bukus')
            ->where('penulis_buku_id', $authorId)
            ->count();

        // Avg rating last 30 days
        $last30d = (clone $stats)
            ->where('rating_users.created_at', '>=', now()->subDays(30))
            ->selectRaw('
            COUNT(*) as votes,
            AVG(ratings) as avg_rating
        ')
            ->first();
        $votes30d = $last30d->votes ?? 0;
        $rating30d = $last30d->avg_rating ?? 0;

        // Avg rating previous 30 days (30-60 days ago)
        $prev30d = (clone $stats)
            ->whereBetween('rating_users.created_at', [
                now()->subDays(60),
                now()->subDays(30),
            ])
            ->selectRaw('
                COUNT(*) as votes,
                AVG(ratings) as avg_rating
           ')
            ->first();
        $votesPrev30D = $prev30d->votes ?? 0;
        $ratingPrev30d = $prev30d->avg_rating ?? 0;

        $deltaAvg = $rating30d - $ratingPrev30d;
        $deltaVotes = $votes30d - $votesPrev30D;

        $trending_score = $ratingPrev30d > 0
            ? $deltaAvg * log($totalVotes + 1)
            : 0;

        AuthorStats::updateOrCreate(
            ['penulis_buku_id' => $authorId],
            [
                'total_books' => $totalBooks,
                'voters_gt_5' => $voterGt5,
                'avg_rating' => round($avgRating ?? 0, 2),
                'total_voters' => $totalVotes ?? 0,
                'rating_30d' => round($rating30d ?? 0, 2),
                'rating_prev_30d' => $ratingPrev30d !== null
                    ? round($ratingPrev30d, 2)
                    : null,
                'popularity_score' => round(
                    $this->popularityScore($voterGt5, $avgRating),
                    2
                ),
                'trending_score' => $trending_score !== null
                    ? round($trending_score, 2)
                    : null,
            ]
        );
    }

    private function popularityScore(int $voters, float $avg)
    {
        return ($voters * 0.7) + ($avg * 10 * 0.3);
    }
}

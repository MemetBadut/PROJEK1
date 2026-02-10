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

    public function rebuildForAuthor(int $authorId) {
        $stats = DB::table('rating_users')
        ->join('produk_bukus', 'produk_bukus.id', '=', 'rating_users.produk_buku_id')
        ->where('produk_bukus.penulis_buku_id', $authorId);

        $voterGt5 = (clone $stats)->where('rating', '>', 5);
        $avgRating = (clone $stats)->avg('rating');
        $totalVotes = (clone $stats)->count();

        AuthorStats::updateOrCreate([
            ['author_id' => $authorId],
            [
                'voters_gt_5' => $voterGt5,
                'avg_rating' => round($avgRating, 2),
                'total_voters' => $totalVotes,
                'popularity_score' => $this->popularityScore($voterGt5, $avgRating),
            ]
        ]);
    }

    private function popularityScore(int $voters, float $avg){
        return ($voters * 0.7) + ($avg * 10 * 0.3);
    }
}

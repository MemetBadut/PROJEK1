<?php

namespace App\Service;

use App\Models\AuthorStats;
use Illuminate\Support\Facades\DB;

class AuthorStatsService
{
    public function calculateM()
    {
        $authorCount = DB::table('penulis_bukus')->count();

        return (float) (
            DB::table('rating_daily_summary')
            ->join('produk_bukus', 'produk_bukus.id', '=', 'rating_daily_summary.produk_buku_id')
            ->groupBy('produk_bukus.penulis_buku_id')
            ->selectRaw('SUM(total_votes) as author_votes')
            ->orderBy('author_votes')
            ->skip((int) ($authorCount * 0.25))
            ->value('author_votes') ?? 30
        );
    }

    public function calculateGlobalAverage(){
        return (float) (
            DB::table('rating_daily_summary')
            ->selectRaw('SUM(total_sums) / NULLIF(SUM(total_votes), 0) as global_avg')
            ->value('global_avg') ?? 0.0
        );
    }

    public function rebuildForAuthor(int $authorId, ?float $m, ?float $globalAvg): void
    {
        $dailyStats = DB::table('rating_daily_summary')
            ->join('produk_bukus', 'produk_bukus.id', '=', 'rating_daily_summary.produk_buku_id')
            ->where('produk_bukus.penulis_buku_id', $authorId);

        $lifetime = (clone $dailyStats)
            ->selectRaw('
                COALESCE(SUM(total_votes), 0) as total_votes,
                COALESCE(SUM(total_sums), 0) as total_sums
            ')
            ->first();

        $last30d = (clone $dailyStats)
            ->whereBetween('rating_daily_summary.date', [
                now()->subDays(29)->toDateString(),
                now()->toDateString(),
            ])
            ->selectRaw('
                COALESCE(SUM(total_votes), 0) as votes,
                COALESCE(SUM(total_sums), 0) as sums
            ')
            ->first();

        $prev30d = (clone $dailyStats)
            ->whereBetween('rating_daily_summary.date', [
                now()->subDays(59)->toDateString(),
                now()->subDays(30)->toDateString(),
            ])
            ->selectRaw('
                COALESCE(SUM(total_votes), 0) as votes,
                COALESCE(SUM(total_sums), 0) as sums
            ')
            ->first();

        $totalVotes = (int) ($lifetime->total_votes ?? 0);
        $totalSums = (float) ($lifetime->total_sums ?? 0);

        $votes30d = (int) ($last30d->votes ?? 0);
        $sums30d = (float) ($last30d->sums ?? 0);

        $votesPrev30d = (int) ($prev30d->votes ?? 0);
        $sumsPrev30d = (float) ($prev30d->sums ?? 0);

        $avgRating = $totalVotes > 0 ? ($totalSums / $totalVotes) : 0.0;
        $rating30d = $votes30d > 0 ? ($sums30d / $votes30d) : 0.0;
        $ratingPrev30d = $votesPrev30d > 0 ? ($sumsPrev30d / $votesPrev30d) : 0.0;

        $deltaAvg = $rating30d - $ratingPrev30d;
        $weight = log($votes30d + 1);

        $trendingScore = $deltaAvg * $weight;
        $popularityScore = $rating30d * $weight;

        // IMDb logic
        $m = $m ?? $this->calculateM();
        $C = $globalAvg ?? $this->calculateGLobalAverage();
        $books = DB::table('data_voters')
            ->join('produk_bukus', 'produk_bukus.id', '=', 'data_voters.produk_buku_id')
            ->where('produk_bukus.penulis_buku_id', $authorId)
            ->select('data_voters.total_voters as v', 'data_voters.avg_rating as R')
            ->get();

        $totalBooks = $books->count();
        $weightedSum = 0;

        foreach ($books as $book) {
            $v = (int) $book->v;
            $R = (float) $book->R;

            // Jika $v == 0, formula ini akan menghasilkan $C (rata-rata global).
            // Jadi buku tanpa vote tidak menurunkan rating author menjadi 0.
            $WR = ($v / ($v + $m)) * $R + ($m / ($v + $m)) * $C;
            $weightedSum += $WR;
        }

        $authorWR = $totalBooks > 0 ? ($weightedSum / $totalBooks) : 0.0;

        $voterGt5 = DB::table('rating_users')
            ->join('produk_bukus', 'produk_bukus.id', '=', 'rating_users.produk_buku_id')
            ->where('produk_bukus.penulis_buku_id', $authorId)
            ->where('rating_users.ratings', '>', 5)
            ->count();


        AuthorStats::updateOrCreate(
            ['penulis_buku_id' => $authorId],
            [
                'total_books'  => $totalBooks,
                'voters_gt_5' => $voterGt5,
                'avg_rating' => round($avgRating, 2),
                'total_voters' => $totalVotes,
                'rating_30d' => round($rating30d, 2),
                'rating_prev_30d' => round($ratingPrev30d, 2),
                'popularity_score' => round($popularityScore, 2),
                'trending_score' => round($trendingScore, 2),
                'weighted_rating' => round($authorWR, 4),
            ]
        );
    }
}

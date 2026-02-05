<?php

namespace App\Service;

use App\Models\DataVoters;
use App\Models\RatingUser;
use Illuminate\Support\Facades\DB;

class RatingSummaryService
{
    /**
     * Create a new class instance.
     */
    public function submit(int $userId, int $produkId, int $rating){
        // INi untuk rule user vote 34 jam
        DB::transaction(function () use ($userId, $produkId, $rating) {
            $lastRating = RatingUser::where('user_id', $userId)
                ->latest('created_at')
                ->first();

            if ($lastRating && now()->diffInHours($lastRating->created_at) < 24) {
                throw new \Exception(
                    'Kamu harus menunggu 24 jam sebelum memberi rating lagi.'
                );
            }

            // Ini buat nyimpan rating baru
            RatingUser::create([
                'user_id' => $userId,
                'produk_buku_id' => $produkId,
                'rating' => $rating,
            ]);

            //
            $this->recalculate($produkId);
        });
    }

    private function recalculate(int $produkId){
        $query = RatingUser::where('produk_buku_id', $produkId);

        $avg = round($query->avg('rating'), 2);
        $totalRating = $query->count();
        $totalVoter = $query->distinct('user_id')->count('user_id');

        $avg7days = RatingUser::where('produk_buku_id', $produkId)
            ->where('created_at', '>=', now()->subDays(7))
            ->avg('rating');

        DataVoters::updateOrCreate(
            ['produk_buku_id' => $produkId],
            [
                'avg_rating' => $avg,
                'total_voters' => $totalVoter,
                'avg_7_days' => round($avg7days ?? 0, 2),
            ]
        );
    }
}

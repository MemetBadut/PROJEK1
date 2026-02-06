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
    public function submit(int $userId, int $produkId, int $rating)
    {
        // INi untuk rule user vote 34 jam
        DB::transaction(function () use ($userId, $produkId, $rating) {
            $lastRating = RatingUser::where('user_id', $userId)
                ->where('produk_buku_id', $produkId)
                ->latest('created_at')
                ->first();

            if ($lastRating && now()->diffInHours($lastRating->created_at) < 24) {
                throw new \RuntimeException(
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
            $this->incrementalUpdate($produkId, $rating);
        });
    }

    private function incrementalUpdate(int $produkId, int $rating)
    {
        DataVoters::updateOrCreate(
            ['produk_buku_id' => $produkId],
            [
                'total_voters' => DB::raw('total_voters + 1'),
                'total_rating_sum' => DB::raw("total_rating_sum + {$rating}"),
                'avg_rating' => DB::raw('(total_rating_sum)')
            ]
        );
    }
}

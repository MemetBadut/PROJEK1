<?php

namespace App\Service;

use App\Models\RatingUser;
use App\Models\ProdukBuku;

class VotingRules
{
    /**
     * Validate voting rules before creating a rating.
     *
     * @return array ['ok' => bool, 'message' => string|null]
     */
    public static function validate(int $userId, int $bookId, int $authorId): array
    {
        // 1. Validate book belongs to author
        $book = ProdukBuku::find($bookId);
        if (!$book || $book->penulis_buku_id != $authorId) {
            return [
                'ok' => false,
                'message' => 'Buku ini bukan milik author yang dipilih.',
            ];
        }

        // 2. Check duplicate: user already rated this book
        $alreadyRated = RatingUser::where('user_id', $userId)
            ->where('produk_buku_id', $bookId)
            ->exists();

        if ($alreadyRated) {
            return [
                'ok' => false,
                'message' => 'Kamu sudah pernah memberikan rating untuk buku ini.',
            ];
        }

        // 3. Check 24-hour cooldown: user rated ANY book in last 24 hours
        $lastRating = RatingUser::where('user_id', $userId)
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();

        if ($lastRating) {
            return [
                'ok' => false,
                'message' => 'Kamu harus menunggu 24 jam sebelum memberikan rating lagi.',
            ];
        }

        return ['ok' => true];
    }
}

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
        // 1. Validate selected book belongs to selected author.
        $book = ProdukBuku::query()->select('id', 'penulis_buku_id')->find($bookId);

        if (!$book || (int) $book->penulis_buku_id !== $authorId) {
            return [
                'ok' => false,
                'message' => 'Buku ini bukan milik author yang dipilih.',
            ];
        }

        // 2. Prevent duplicate vote for the same book.
        $alreadyRated = RatingUser::where('user_id', $userId)
            ->where('produk_buku_id', $bookId)
            ->exists();

        if ($alreadyRated) {
            return [
                'ok' => false,
                'message' => 'Kamu sudah pernah memberikan rating untuk buku ini.',
            ];
        }

        // 3. Global 24-hour cooldown per user (any book).
        $hasRecentRating = RatingUser::where('user_id', $userId)
            ->where('created_at', '>=', now()->subHours(24))
            ->exists();

        if ($hasRecentRating) {
            return [
                'ok' => false,
                'message' => 'Kamu harus menunggu 24 jam sebelum memberikan rating lagi.',
            ];
        }

        return [
            'ok' => true,
            'message' => null,
        ];
    }
}

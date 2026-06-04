<?php

namespace App\Service;

use App\Models\ProdukBuku;
use App\Models\RatingUser;
use App\Models\User;
use Carbon\Carbon;

class VotingRules
{
    /**
     * @return array{ok: bool, message: string|null}
     */
    public static function validate(
        int $userId,
        int $bookId,
        int $authorId,
        ?string $lastVoteAt = null
    ): array {
        // 1) Buku harus milik author yang dipilih + voting harus aktif.
        $book = ProdukBuku::query()
            ->select('id', 'penulis_buku_id', 'rating_enabled')
            ->find($bookId);

        if (! $book || (int) $book->penulis_buku_id !== $authorId) {
            return [
                'ok' => false,
                'message' => 'Buku ini bukan milik author yang dipilih.',
            ];
        }

        if (! (bool) $book->rating_enabled) {
            return [
                'ok' => false,
                'message' => 'Rating untuk buku ini sedang dinonaktifkan.',
            ];
        }

        // 2) Tidak boleh vote buku yang sama dua kali.
        $alreadyRated = RatingUser::query()
            ->where('user_id', $userId)
            ->where('produk_buku_id', $bookId)
            ->exists();

        if ($alreadyRated) {
            return [
                'ok' => false,
                'message' => 'Kamu sudah pernah memberikan rating untuk buku ini.',
            ];
        }

        // 3) Cooldown global 24 jam berbasis users.last_vote_at (anti bypass delete).
        $lastVoteAt = $lastVoteAt ?? User::query()->whereKey($userId)->value('last_vote_at');

        if ($lastVoteAt !== null) {
            $isInCooldown = Carbon::parse($lastVoteAt)
                ->greaterThan(now()->subHours(24));

            if ($isInCooldown) {
                return [
                    'ok' => false,
                    'message' => 'Kamu harus menunggu 24 jam sebelum memberikan rating lagi.',
                ];
            }
        }

        return [
            'ok' => true,
            'message' => null,
        ];
    }
}

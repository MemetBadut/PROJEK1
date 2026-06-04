<?php

namespace App\Service;

use App\Models\RatingUser;
use DomainException;
use Illuminate\Support\Facades\DB;

class VoteSubmissionService
{
    public function submit(int $userId, int $bookId, int $authorId, int $rating): RatingUser
    {
        return DB::transaction(function () use ($userId, $bookId, $authorId, $rating): RatingUser {
            // Lock row user supaya check cooldown + update timestamp race-safe.
            $lockedUser = DB::table('users')
                ->select('id', 'last_vote_at')
                ->where('id', $userId)
                ->lockForUpdate()
                ->first();

            if (! $lockedUser) {
                throw new DomainException('User tidak ditemukan.');
            }

            $check = VotingRules::validate(
                $userId,
                $bookId,
                $authorId,
                $lockedUser->last_vote_at
            );

            if (! ($check['ok'] ?? false)) {
                throw new DomainException($check['message'] ?? 'Voting gagal diproses.');
            }

            $created = RatingUser::create([
                'user_id' => $userId,
                'produk_buku_id' => $bookId,
                'ratings' => $rating,
            ]);

            DB::table('users')
                ->where('id', $userId)
                ->update([
                    'last_vote_at' => now(),
                    'updated_at' => now(),
                ]);

            return $created;
        });
    }
}

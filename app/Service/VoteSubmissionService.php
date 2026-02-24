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
            // Serialize writes per user to keep the 24-hour global rule race-safe.
            DB::table('users')->where('id', $userId)->lockForUpdate()->first();

            $check = VotingRules::validate($userId, $bookId, $authorId);

            if (!($check['ok'] ?? false)) {
                throw new DomainException($check['message'] ?? 'Voting gagal diproses.');
            }

            return RatingUser::create([
                'user_id' => $userId,
                'produk_buku_id' => $bookId,
                'ratings' => $rating,
            ]);
        });
    }
}

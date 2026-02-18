<?php

namespace App\Observer;

use App\Models\DataVoters;
use App\Models\RatingUser;
use App\Service\AuthorStatsService;
use Illuminate\Support\Facades\DB;

class RatingUserObserver
{
    public function created(RatingUser $rating){
        DataVoters::updateOrCreate(
            ['produk_buku_id' => $rating->produk_buku_id],
            [
                'total_voters' => DB::raw('total_voters + 1'),
                'total_rating_sum' => DB::raw("total_rating_sum + {$rating->ratings}"),
                'avg_rating' => DB::raw('(total_rating_sum / total_voters)')
            ]
        );

        $authorId = $rating->produkBuku->penulis_buku_id;
        (new AuthorStatsService())->rebuildForAuthor($authorId);
    }
}

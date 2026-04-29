<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataVoters extends Model
{
    protected $fillable = [
        'produk_buku_id',
        'total_voters',
        'avg_rating',
        'total_rating_sum',
        'avg_prev_7_days',
        'avg_30_days',
        'voters_30_days',
        'recent_popularity_score',
        'avg_7_days',
        'trend_7_days',
        'trend_direction',
    ];


    protected $table = 'data_voters';

    public function ratingBuku()
    {
        return $this->belongsTo(RatingUser::class, 'rating_user_id', 'id');
    }
}

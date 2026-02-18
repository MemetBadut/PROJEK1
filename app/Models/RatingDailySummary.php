<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingDailySummary extends Model
{
    protected $fillable = [
        'produk_buku_id',
        'date',
        'total_votes',
        'total_sums',
    ];

    protected $table = 'rating_daily_summary';
}

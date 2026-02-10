<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataVoters extends Model
{
    protected $fillable = [
        'produk_buku_id',
        'total_voters',
        'avg_rating',
        'avg_7_days'
    ];

    protected $table = 'data_voters';

    public function ratingBuku(){
        return $this->belongsTo(RatingUser::class, 'rating_user_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenulisBuku extends Model
{
    use HasFactory;
    protected $fillable = ['nama_penulis'];
    protected $table = 'penulis_bukus';

    public function getBestWorkAttribute()
    {
        return $this->produkBuku()
            ->withAvg('ratingUser', 'score')
            ->withCount('ratingUser')
            ->having('rating_user_count', '>', 0)
            ->orderByDesc('rating_user_avg_score')
            ->first();
    }

    public function getWorstWorkAttribute()
    {
        return $this->produkBuku()
            ->withAvg('ratingUser', 'score')
            ->withCount('ratingUser')
            ->having('rating_user_count', '>', 0)
            ->orderBy('rating_user_avg_score')
            ->first();
    }
}

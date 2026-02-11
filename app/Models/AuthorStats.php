<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorStats extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorStatsFactory> */
    use HasFactory;

    protected $fillable = [
        'penulis_buku_id',
        'total_books',
        'total_voters',
        'voters_gt_5',
        'avg_rating',
        'rating_30d',
        'rating_prev_30d',
        'popularity_score'
    ];

    protected $table = 'author_stats';

    public function author()
    {
        return $this->belongsTo(PenulisBuku::class, 'penulis_buku_id');
    }
}

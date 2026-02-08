<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBuku extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_buku',
        'penulis_bukus_id',
        'isbn',
        'publisher_id',
        'status_buku',
        'created_at',
        'updated_at'
    ];

    protected $table = 'produk_bukus';

    public function penulisBuku()
    {
        return $this->belongsTo(PenulisBuku::class, 'penulis_bukus_id', 'id');
    }

    public function kategoriBuku()
    {
        return $this->belongsToMany(KategoriBuku::class, 'buku_kategori_pivot', 'produk_buku_id', 'kategori_buku_id');
    }

    public function ratingUser()
    {
        return $this->hasMany(RatingUser::class, 'produk_buku_id', 'id');
    }

    public function publisherBuku()
    {
        return $this->belongsTo(PublisherBuku::class, '');
    }

    public function ratings()
    {
        return $this->hasMany(RatingUser::class, 'produk_buku_id');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_buku', 'like', "%{$keyword}%")
                ->orWhere('isbn', 'like', "%{$keyword}%")
                ->orWhere('publisher_id', 'like', "%{$keyword}%");
        });

        if(is_numeric($keyword)){
            return $query->orWhere('isbn', 'like', "%{$keyword}%");
        }
    }

    public function scopeFilterCategory($query, $status)
    {
        return match ($status) {
            'available' => $query->orderBy('tersedia'),
            'rented' => $query->orderBy('dipinjam'),
            'reserved' => $query->orderBy('dipesan'),
            default => $query
        };
    }

    public function scopeFilterYear($query, $year)
    {
        return match ($year) {
            'release' => $query->orderBy('created_at', 'desc'),
        };
    }

    public function scopeListBooks($query)
    {
        return $query->select('id', 'nama_buku', 'penulis_bukus_id', 'publisher_id', 'isbn')
            ->with([
                'kategoriBuku:id,kategori_buku',
                'penulisBuku:id,nama_penulis'
            ])
            ->withCount('ratings as total_voters')
            ->withAvg('ratings as avg_rating', 'rating');
    }

    public function scopeTotalRate($query, $vote)
    {
        return match ($vote) {
            'most' => $query->orderBy('total_voters', 'desc'),
            'least' => $query->orderBy('total_voters', 'asc'),
            default => $query
        };
    }

    public function scopeAlphabet($query, $alpha)
    {
        return match ($alpha) {
            'name_asc' => $query->orderBy('nama_buku', 'asc'),
            'name_desc' => $query->orderBy('nama_buku', 'desc'),
            default => $query
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenulisBuku extends Model
{
    use HasFactory;
    protected $fillable = ['nama_penulis'];
    protected $table = 'penulis_bukus';

    public function produkBuku()
    {
        return $this->hasMany(ProdukBuku::class, 'penulis_buku_id', 'id');
    }

    public function stats()
    {
        return $this->hasOne(AuthorStats::class, 'penulis_buku_id');
    }

    public function ratings()
    {
        return $this->hasManyThrough(
            RatingUser::class,
            ProdukBuku::class,
            'penulis_buku_id',
            'produk_buku_id'
        );
    }

    public function scopePopularity($query)
    {
        return $query
            ->join('produk_bukus', 'produk_bukus.penulis_buku_id', '=', 'penulis_bukus.id')
            ->join('rating_users', 'rating_users.produk_buku_id', '=', 'produk_bukus.id')
            ->select('penulis_bukus.*', DB::raw('COUNT(rating_users.id) as popularity'))
            ->groupBy('penulis_bukus.id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenulisBuku extends Model
{
    use HasFactory;
    protected $fillable = ['nama_penulis'];
    protected $table = 'penulis_bukus';

    public function produkBuku()
    {
        return $this->hasMany(ProdukBuku::class, 'penulis_bukus_id', 'id');
    }

    public function best_work()
    {
        return $this->hasOne(ProdukBuku::class)->ofMany('avg_rating', 'max');
    }

    public function worst_work()
    {
        return $this->hasOne(ProdukBuku::class)->ofMany('avg_rating', 'min');
    }

    public function ratings()
    {
        return $this->hasManyThrough(
            RatingUser::class,
            ProdukBuku::class,
            'penulis_bukus_id',
            'produk_buku_id'
        );
    }
}

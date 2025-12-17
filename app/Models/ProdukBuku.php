<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBuku extends Model
{
    use HasFactory;
    protected $fillable = ['nama_buku', 'penulis_buku_id', 'isbn', 'publisher', 'lokasi_toko', 'created_at'];

    public function penulisBuku()
    {
        return $this->belongsTo(PenulisBuku::class, 'penulis_buku_id', 'id');
    }

    public function kategoriBuku()
    {
        return $this->belongsToMany(KategoriBuku::class, 'buku_kategori_pivot', 'produk_bukus_id', 'kategori_bukus_id');
    }

    public function ratingUser(){
        return $this->hasMany(RatingUser::class, 'produk_bukus_id', 'id');
    }
}

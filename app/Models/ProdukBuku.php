<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBuku extends Model
{
    use HasFactory;
    protected $fillable = ['nama_buku', 'isbn', 'publisher', 'lokasi_toko', 'created_at'];

    public function kategoriBuku(){
        return $this->belongsToMany(KategoriBuku::class, 'buku_kategori_pivot', 'produk_bukus_id', 'kategori_bukus_id');
    }
}

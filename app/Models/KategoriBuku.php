<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;
    protected $fillable = ['kategori_buku'];

    public function kategoriBuku(){
        return $this->belongsToMany(ProdukBuku::class, 'buku_kategori_pivot', 'kategori_bukus_id', 'produk_bukus_id');
    }
}

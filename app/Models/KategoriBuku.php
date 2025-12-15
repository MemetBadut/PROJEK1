<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;
    protected $fillable = ['kategori_buku'];

    public function pategoriBuku(){
        return $this->belongsToMany(ProdukBuku::class, 'buku_kategori_pivot', 'produk_bukus_id', 'kategori_bukus_id');
    }
}

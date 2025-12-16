<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingUser extends Model
{
    protected $fillable = ['voters_id', 'produk_buku_id', 'score'];

    public function voter(){
        return $this->hasOne(DataVoters::class, 'voters_id', 'id');
    }

    public function produkBuku(){
        return $this->hasOne(ProdukBuku::class, 'produk_buku_id', 'id');
    }
}

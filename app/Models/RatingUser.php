<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingUser extends Model
{
    protected $fillable = ['voters_id', 'produk_buku_id', 'score'];

    public function voter(){
        return $this->belongsTo(DataVoters::class, 'voters_id', 'id');
    }

    public function produkBuku(){
        return $this->belongsTo(ProdukBuku::class, 'produk_buku_id', 'id');
    }
}

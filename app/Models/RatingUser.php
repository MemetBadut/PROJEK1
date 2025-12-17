<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingUser extends Model
{
    protected $fillable = ['data_voters_id', 'produk_bukus_id', 'score'];
    protected $table = 'rating_users';

    public function voter(){
        return $this->belongsTo(DataVoters::class, 'data_voters_id', 'id');
    }

    public function produkBuku(){
        return $this->belongsTo(ProdukBuku::class, 'produk_bukus_id', 'id');
    }
}

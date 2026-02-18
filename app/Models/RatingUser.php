<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingUser extends Model
{
    protected $fillable = [
        'user_id',
        'produk_buku_id',
        'ratings'
    ];
protected $table = 'rating_users';

    public function voter(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function produkBuku(){
        return $this->belongsTo(ProdukBuku::class, 'produk_buku_id', 'id');
    }

    protected static function booted(){
        static::observe(\App\Observer\RatingUserObserver::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenulisBuku extends Model
{
    use HasFactory;
    protected $fillable = ['nama_penulis'];
    protected $table = [' penulis_bukus'];

    public function produkBuku(){
        return $this->hasMany(ProdukBuku::class);
    }

}

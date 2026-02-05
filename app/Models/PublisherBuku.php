<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublisherBuku extends Model
{
    /** @use HasFactory<\Database\Factories\PublisherBukuFactory> */
    use HasFactory;

    protected $fillable = [
        'nama_publisher',
        'alamat_publisher',
        'kontak_publisher'
    ];

    protected $table = 'publisher';

    public function produkBuku(){
        return $this->hasMany(ProdukBuku::class);
    }

}

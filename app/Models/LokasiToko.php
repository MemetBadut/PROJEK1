<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiToko extends Model
{
    protected $table = 'lokasi_toko';

    protected $fillable = [
        'kode_toko',
        'nama_toko',
        'lokasi_toko',
        'kota',
        'status_aktif'
    ];

    #Relasi Many to Many
    public function produkBuku()
    {
        return $this->belongsToMany(ProdukBuku::class,
                'table_inventori_toko_buku',
                'lokasi_toko_id',
                'produk_buku_id'
            )->withPivot([
                'stok_total',
                'stok_tersedia',
                'kode_rak'
            ])->withTimestamps();
    }
}

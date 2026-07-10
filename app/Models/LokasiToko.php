<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiToko extends Model
{
    use HasFactory;

    protected $table = 'lokasi_toko';

    protected $fillable = [
        'kode_toko',
        'nama_toko',
        'alamat_toko',
        'kota',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
        ];
    }

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
                'stok_dipinjam',
                'stok_dipesan',
                'kode_rak'
            ])->withTimestamps();
    }
}

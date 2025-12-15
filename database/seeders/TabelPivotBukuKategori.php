<?php

namespace Database\Seeders;

use App\Models\KategoriBuku;
use App\Models\ProdukBuku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabelPivotBukuKategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kumpulan_buku = ProdukBuku::all();
        $kategori = KategoriBuku::pluck('id');

        foreach ($kumpulan_buku as $buku) {
            $buku->kategoriBuku()->sync(
                $kategori->random(5)->values()->toArray()
            );
        }
    }
}

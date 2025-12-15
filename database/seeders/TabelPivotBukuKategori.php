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
        $kategoriIds = KategoriBuku::pluck('id')->toArray();
        $bukuList = ProdukBuku::all();

        foreach($bukuList as $buku){
            if(count($kategoriIds) === 0){
                dd('Kategori Kosong');
            }

            $randomKategori = collect($kategoriIds)
            ->shuffle()
            ->take(5)
            ->toArray();

            $buku->kategoriBuku()->sync($randomKategori);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\ProdukBuku;
use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabelPivotBukuKategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriIds = KategoriBuku::pluck('id')->toArray();

        ProdukBuku::query()
            ->whereDoesntHave('kategoriBuku')
            ->select('id')
            ->chunkById(500, function ($bukuChunk) use ($kategoriIds) {
                $rows = [];

                foreach ($bukuChunk as $buku) {
                    $randomKategori = collect($kategoriIds)
                        ->shuffle()
                        ->take(5);


                    foreach ($randomKategori as $kategoriId) {
                        $rows[] = [
                            'produk_buku_id' => $buku->id,
                            'kategori_buku_id' => $kategoriId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                DB::table('buku_kategori_pivot')->insert($rows);
            });
    }
}

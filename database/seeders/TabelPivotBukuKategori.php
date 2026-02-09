<?php

namespace Database\Seeders;

use App\Models\ProdukBuku;
use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabelPivotBukuKategori extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriIds = KategoriBuku::pluck('id')->toArray();
        $bukuList = ProdukBuku::pluck('id');
        $relationToInsert = [];

        foreach ($bukuList as $bukuId) {
            $randomKategori = collect($kategoriIds)
                ->shuffle()
                ->take(5);

            foreach ($randomKategori as $kategoriId) {
                $relationToInsert[] = [
                    'produk_buku_id' => $bukuId,
                    'kategori_buku_id' => $kategoriId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        collect($relationToInsert)
            ->chunk(500)
            ->each(function ($chunk) {
                DB::table('buku_kategori_pivot')->insert($chunk->toArray());
            });
    }
}

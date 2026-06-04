<?php

namespace Database\Seeders;

use App\Models\ProdukBuku;
// use App\Models\PenulisBuku;
// use App\Models\PublisherBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabelBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog();

        $total = 10000;
        $batch = 2000;

        for ($i = 0; $i < $total; $i += $batch) {
            $rows = ProdukBuku::factory()
                ->count(min($batch, $total - $i))
                ->make()
                ->map(fn ($book) => $book->getAttributes())
                ->toArray();

            DB::table('produk_bukus')->insert($rows);
        }
    }
}

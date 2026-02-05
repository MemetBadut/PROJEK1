<?php

namespace Database\Seeders;

use App\Models\ProdukBuku;
use App\Models\PenulisBuku;
use App\Models\PublisherBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TabelBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog();

        $penulisIds   = PenulisBuku::pluck('id')->all();
        $publisherIds = PublisherBuku::pluck('id')->all();

        $total = 10000;
        $batch = 2000;

        for ($i = 0; $i < $total; $i += $batch) {
            $rows = ProdukBuku::factory()
                ->count(min($batch, $total - $i))
                ->state(fn() => [
                    'penulis_bukus_id' => fake()->randomElement($penulisIds),
                    'publisher_id'    => fake()->randomElement($publisherIds),
                ])
                ->make()
                ->map(fn($item) => array_merge(
                    $item->toArray(),
                    [
                        'created_at' => now()->format('Y-m-d H:i:s'),
                        'updated_at' => now()->format('Y-m-d H:i:s'),
                    ]
                ))
                ->toArray();

            DB::table('produk_bukus')->insert($rows);
        }
    }
}

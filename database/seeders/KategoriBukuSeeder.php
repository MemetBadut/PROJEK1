<?php

namespace Database\Seeders;

use App\Models\KategoriBuku;
// use Database\Factories\KategoriBukuFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = KategoriBuku::factory()->count(3000)->make()->map(fn($item) => array_merge(
            $item->toArray(),
            [
                'created_at' => now(),
                'updated_at' => now()
            ]
        ));


        collect($rows)->chunk(500)->each(function ($chunk) {
            DB::table('kategori_bukus')->insert($chunk->toArray());
        });
    }
}

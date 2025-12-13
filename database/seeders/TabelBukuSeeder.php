<?php

namespace Database\Seeders;

use App\Models\ProdukBuku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabelBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batch = 10;
        $total = 100;
        for ($i = 0; $i < $total / $batch; $i++) {
            ProdukBuku::factory()->count($batch)->create();
        }
    }
}

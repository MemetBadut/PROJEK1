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
        $batch = 500;
        $total = 10000;
        for ($i = 0; $i < $total / $batch; $i++) {
            ProdukBuku::factory()->count($batch)->create();
        }
    }
}

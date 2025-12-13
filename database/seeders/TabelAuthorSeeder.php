<?php

namespace Database\Seeders;

use App\Models\PenulisBuku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TabelAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenulisBuku::factory()->count(30)->create();
    }
}

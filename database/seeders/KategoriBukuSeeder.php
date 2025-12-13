<?php

namespace Database\Seeders;

use App\Models\KategoriBuku;
use Database\Factories\KategoriBukuFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KategoriBuku::factory()->count(20)->create();
    }
}

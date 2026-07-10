<?php

namespace Database\Seeders;

use App\Models\LokasiToko;
use Illuminate\Database\Seeder;

class LokasiTokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LokasiToko::factory()->count(10)->create();
    }
}

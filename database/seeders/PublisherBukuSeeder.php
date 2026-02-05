<?php

namespace Database\Seeders;

use App\Models\PublisherBuku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PublisherBuku::factory()->count(200)->create();
    }
}

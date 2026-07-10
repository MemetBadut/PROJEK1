<?php

namespace Database\Seeders;

use Database\Seeders\AuthorStatsSeeder;
use Database\Seeders\DummyVoterSeeder;
use Database\Seeders\KategoriBukuSeeder;
use Database\Seeders\LokasiTokoSeeder;
use Database\Seeders\PublisherBukuSeeder;
use Database\Seeders\RatingDailySummarySeeder;
use Database\Seeders\RatingSeeder;
use Database\Seeders\TabelPivotBukuKategori;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            KategoriBukuSeeder::class,
            TabelAuthorSeeder::class,
            PublisherBukuSeeder::class,
            TabelBukuSeeder::class,
            LokasiTokoSeeder::class,
            TablePivotLokasiToko::class,
            TabelPivotBukuKategori::class,
            RatingSeeder::class,
            RatingDailySummarySeeder::class,
            DummyVoterSeeder::class,
            AuthorStatsSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RatingSeeder;
use Database\Seeders\DummyVoterSeeder;
use Database\Seeders\AuthorStatsSeeder;
use Database\Seeders\KategoriBukuSeeder;
use Database\Seeders\PublisherBukuSeeder;
use Database\Seeders\TabelPivotBukuKategori;
use Database\Seeders\RatingDailySummarySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
            RatingSeeder::class,
            RatingDailySummarySeeder::class,
            DummyVoterSeeder::class,
            TabelPivotBukuKategori::class,
            AuthorStatsSeeder::class,
        ]);
    }
}

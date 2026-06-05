<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = new \App\Service\AuthorStatsService();
        $authorId = \App\Models\PenulisBuku::pluck("id");
        $m = $service->calculateM();
        $globalAvg = $service->calculateGlobalAverage();

        foreach ($authorId as $id) {
            $service->rebuildForAuthor($id, $m, $globalAvg);
        }

        $this->command->info("data author rebuilt untuk {$authorId->count()} author.");
    }
}

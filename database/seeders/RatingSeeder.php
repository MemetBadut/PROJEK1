<?php

namespace Database\Seeders;

use App\Models\DataVoters;
use App\Models\ProdukBuku;
use App\Models\RatingUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voterIds  = DataVoters::pluck('id')->toArray();
        $produkIds = ProdukBuku::pluck('id')->toArray();

        foreach (range(1, 500000) as $i) {
            RatingUser::create([
                'data_voters_id' => fake()->randomElement($voterIds),
                'produk_bukus_id' => fake()->randomElement($produkIds),
                'score' => fake()->numberBetween(1, 5),
            ]);
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\DataVoters;
use App\Models\ProdukBuku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RatingUser>
 */
class RatingUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'data_voters_id' => DataVoters::inRandomOrder()->value('id'),
            'produk_buku_id' => ProdukBuku::inRandomOrder()->value('id'),
            'score' => fake()->numberBetween(1, 10),
        ];
    }
}

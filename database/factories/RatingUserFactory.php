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
        $bukuId = ProdukBuku::query()->inRandomOrder()->value('id');
        $usersId = DataVoters::query()->inRandomOrder()->value('id');

        return [
            'user_id' => $usersId,
            'produk_buku_id' => $bukuId,
            'ratings' => fake()->numberBetween(1, 10),
        ];
    }
}

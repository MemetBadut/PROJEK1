<?php

namespace Database\Factories;

use App\Models\PenulisBuku;
use Illuminate\Database\Eloquent\Factories\Factory;

use function Symfony\Component\Clock\now;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProdukBuku>
 */
class ProdukBukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_buku' => fake()->sentence(),
            'penulis_buku_id' => PenulisBuku::pluck('id')->random(),
            'isbn' => fake()->isbn10(),
            'rating_buku' => fake()->randomFloat(1, 1, 10 ),
            'publisher' => fake('id_ID')->company(),
            'lokasi_toko' => fake('id_ID')->address(),
            'created_at' => fake()->dateTimeBetween('-3 years', 'now'),
            'updated_at' => now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\PenulisBuku;
use App\Models\PublisherBuku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


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
        static $penulisIds;
        static $publisherIds;
        $title = fake()->sentence(3);
        $sinopsis = fake()->sentence(3);
        $uniqueSuffix = fake()->unique()->numberBetween(100000, 999999);

        $penulisIds ??= PenulisBuku::pluck('id')->toArray();
        $publisherIds ??= PublisherBuku::pluck('id')->toArray();

        $createdAt = fake()->dateTimeBetween('-3 years', 'now');

        return [
            'nama_buku' => $title,
            'penulis_buku_id' => fake()->randomElement($penulisIds),
            'isbn' => fake()->isbn10(),
            'publisher_id' => fake()->randomElement($publisherIds),
            'rating_enabled' => true,
            'slug' => Str::slug($title . '-' . $uniqueSuffix),
            'sinopsis' => $sinopsis,
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
        ];
    }
}

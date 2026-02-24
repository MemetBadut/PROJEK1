<?php

namespace Database\Factories;

use App\Models\PenulisBuku;
use App\Models\PublisherBuku;
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
    static $penulisIds;
    static $publisherIds;
    $title = fake()->sentence(3);
    $sinopsis = fake()->sentence(3);

    $penulisIds ??= PenulisBuku::pluck('id')->toArray();
    $publisherIds ??= PublisherBuku::pluck('id')->toArray();

    $status = fake()->randomElement(
        array_merge(
            array_fill(0, 80, 'tersedia'),
            array_fill(0, 15, 'tersimpan'),
            array_fill(0, 5, 'dipinjam'),
        )
    );

    $createdAt = fake()->dateTimeBetween('-3 years', 'now');

    return [
        'nama_buku' => $title,
        'penulis_buku_id' => fake()->randomElement($penulisIds),
        'isbn' => fake()->isbn10(),
        'publisher_id' => fake()->randomElement($publisherIds),
        'status_buku' => $status,
        'rating_enabled' => $status === 'tersedia',
        'slug' => str($title)->slug(),
        'sinopsis' => $sinopsis,
        'created_at' => $createdAt,
        'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
    ];
}

}

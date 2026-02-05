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
        return [
            'nama_buku' => fake()->sentence(3),
            'penulis_bukus_id' => PenulisBuku::pluck('id')->random(),
            'publisher_id' => PublisherBuku::pluck('id')->random(),
            'isbn' => fake()->isbn10(),
            'created_at' => fake()
                ->dateTimeBetween(' -3 years', 'now')
                ->format('Y-m-d H:i:s'),

            'updated_at' => fake()
                ->dateTimeBetween('created_at', 'now')
                ->format('Y-m-d H:i:s'),
        ];
    }
}

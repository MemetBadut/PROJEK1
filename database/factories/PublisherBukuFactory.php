<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublisherBuku>
 */
class PublisherBukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_publisher' => fake('id_ID')->company(),
            'alamat_publisher' => fake('id_ID')->address(),
            'kontak_publisher' => fake('id_ID')->phoneNumber(),
        ];
    }
}

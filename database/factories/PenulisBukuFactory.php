<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenulisBuku>
 */
class PenulisBukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'nama_penulis' => fake('id_ID')->name('male'),
            'voters' => fake()->randomNumber(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}

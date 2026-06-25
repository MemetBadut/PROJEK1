<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LokasiToko>
 */
class LokasiTokoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lokasiToko = [
            'Gramedia',
            'BukaBuku',
            'Periplus',
            'Mizanstore',
            'OpenTrolley'
        ];

        return [
            'kode_toko' => $this->faker->unique()->bothify('Toko-###'),
            'nama_toko' => $this->faker->randomElement($lokasiToko),
            'alamat_toko' => $this->faker->address(),
            'kota' => $this->faker->city(),
            'status_aktif' => $this->faker->boolean(80) // 80% chance of being active
        ];
    }
}

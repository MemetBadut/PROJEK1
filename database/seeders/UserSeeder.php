<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'bagindaadmin@gmail.com'],
            [
                'name' => 'Baginda Admin Kakanda',
                'role' => 'admin',
                'password' => 'adminmin',
            ]
        );

        User::factory()->count(1000)->create([
            'role' => 'user',
        ]);
    }
}

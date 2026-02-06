<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(1)->create([
            'name' => 'Baginda Admin Kakanda',
            'email' => 'bagindaadmin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('adminmin'),
        ]);

        User::factory()->count(1000)->create([
            'role' => 'user',
        ]);
    }
}

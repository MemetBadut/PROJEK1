<?php

namespace Database\Seeders;

use App\Models\DataVoters;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummyVoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 500000; $i++) {
            DataVoters::create([
                'voter_palsu' => Str::uuid(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\DataVoters;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DummyVoterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $totalVoters = 500000;
        $chunkSize = 50000;

        for ($i = 0; $i < $totalVoters; $i++) {
            // DataVoters::create([
            //     'voter_palsu' => Str::uuid(),
            // ]);
            $data[] = [
                'voter_palsu' => Str::uuid(),
            ];

            if ($i % $chunkSize === 0) {
                DB::table('data_voters')->insert($data);
                $data = []; // Kosongkan lagi array-nya biar hemat RAM
            }
        }
    }
}

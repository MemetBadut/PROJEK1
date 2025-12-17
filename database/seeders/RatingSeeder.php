<?php

namespace Database\Seeders;

use App\Models\ProdukBuku;
use App\Models\RatingUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkIds = ProdukBuku::pluck('id')->toArray();
        $totalVoters = 500000;

        for($i = 0; $i < 500000; $i++) {
            $voterId = rand(1, $totalVoters);

            RatingUser::create([
                'voters_id'  => $voterId,
                'produk_buku_id' => $produkIds[array_rand($produkIds)],
                'score' => rand(1, 10),
                'created_at' => Carbon::now()->subDays(rand(0, 60)),
            ]);
        }
    }
}

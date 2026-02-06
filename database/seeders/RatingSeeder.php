<?php

namespace Database\Seeders;

use App\Models\User;
use RuntimeException;
use App\Models\ProdukBuku;
use App\Models\RatingUser;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $totalSize = 500000;
        $batchSize = 5000;

        $userId = User::pluck('id')->toArray();
        $produkBukuId = ProdukBuku::pluck('id')->toArray();
        $fake = fake();
        $now = now();
        $ratings = [];

        for ($i = 0; $i < $totalSize; $i++) {
            $ratings[] = [
                'user_id' => $userId[array_rand($userId)],
                'produk_buku_id' => $produkBukuId[array_rand($produkBukuId)],
                'rating' => rand(2, 10),
                'created_at' => $fake->dateTimeBetween('-6 months'),
                'updated_at' => $now,
            ];

            if (($i + 1) % $batchSize === 0) {
                RatingUser::upsert(
                    $ratings,
                    ['user_id', 'produk_buku_id'],
                    ['rating', 'updated_at']
                );
                $ratings = [];
            }
        }

        if (!empty($ratings)) {
            RatingUser::upsert(
                $ratings,
                ['user_id', 'produk_buku_id'],
                ['rating', 'updated_at']
            );
        }
    }
}

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
    public function run(){
        $user = User::pluck('id')->all();
        $buku = ProdukBuku::pluck('id')->all();

        foreach(range(1, 500_000) as $i){
            RatingUser::create([
                'user_id' => fake()->randomElement($user),
                'produk_buku_id' => fake()->randomElement($buku),
                'rating' => rand(1, 5),
                'created_at' =>now()->subDays(rand(0, 60)),
                'updated_at' => now(),
            ]);
        }
    }
}

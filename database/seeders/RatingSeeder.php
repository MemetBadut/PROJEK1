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
        $service = app(\App\Service\RatingSummaryService::class);

        $users = User::pluck('id');
        $books = ProdukBuku::pluck('id');

        foreach ($users as $userId) {
            $randomBooks = $books->random(rand(3, 10));

            foreach ($randomBooks as $bookId) {
                try {
                    $service->submit(
                        $userId,
                        $bookId,
                        rand(1, 5)
                    );
                } catch (\Exception $e) {
                    continue;
                }
            }
        }
    }
}

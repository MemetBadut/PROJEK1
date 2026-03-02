<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RatingDailySummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("
        INSERT INTO rating_daily_summary (produk_buku_id, date, total_votes, total_sums,
            created_at, updated_at)
            SELECT
                produk_buku_id,
                DATE(created_at) as date,
                COUNT(*)            as total_votes,
                SUM(ratings)        as total_sums,
                NOW(),
                NOW()
            FROM rating_users
            GROUP BY produk_buku_id, DATE(created_at)
            ON DUPLICATE KEY UPDATE
                total_votes = VALUES(total_votes),
                total_sums = VALUES(total_sums)
                ");

        $count = DB::table('rating_daily_summary')->count();
        $this->command->info("rating_daily_summary rebuilt: {$count} baris");
    }
}

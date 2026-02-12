<?php

namespace Database\Seeders;

use App\Models\DataVoters;
use App\Models\RatingUser;
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
        RatingUser::query()
            ->selectRaw('produk_buku_id, COUNT(*) as total_voters, AVG(ratings) as average_rating')
            ->groupBy('produk_buku_id')
            ->orderBy('produk_buku_id')
            ->chunk(500, function ($rows) {
                $data = [];
                foreach ($rows as $row) {
                    $data[] = [
                        'produk_buku_id' => $row->produk_buku_id,
                        'total_voters' => $row->total_voters,
                        'avg_rating' => round($row->average_rating, 2),
                    ];
                }
                DB::table('data_voters')->upsert($data, ['produk_buku_id'], ['total_voters', 'avg_rating']);
            });
    }
}

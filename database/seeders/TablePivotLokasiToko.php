<?php

namespace Database\Seeders;

use App\Models\LokasiToko;
use App\Models\ProdukBuku;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TablePivotLokasiToko extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lokasiIds = LokasiToko::pluck('id')->toArray();

        if ($lokasiIds === []) {
            throw new RuntimeException('Lokasi toko harus di-seed sebelum inventory.');
        }

        ProdukBuku::query()->select('id')->chunkById(500, function ($books) use ($lokasiIds) {
            $rows = [];

            foreach ($books as $book) {
                $selectedStores = collect($lokasiIds)->shuffle()->take(rand(1, 3));

                foreach ($selectedStores as $lokasiId) {
                    $stokTotal = rand(0, 20);
                    $stokTersedia = rand(0, $stokTotal);
                    $sisa = $stokTotal - $stokTersedia;
                    $stokDipinjam = rand(0, $sisa);
                    $stokDipesan = $sisa - $stokDipinjam;

                    $rows[] = [
                        'produk_buku_id' => $book->id,
                        'lokasi_toko_id' => $lokasiId,
                        'stok_total' => $stokTotal,
                        'stok_tersedia' => $stokTersedia,
                        'stok_dipinjam' => $stokDipinjam,
                        'stok_dipesan' => $stokDipesan,
                        'kode_rak' => 'R-' . rand(1, 50),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            DB::table('table_inventori_toko_buku')->upsert(
                $rows,
                ['produk_buku_id', 'lokasi_toko_id'],
                [
                    'stok_total',
                    'stok_tersedia',
                    'stok_dipinjam',
                    'stok_dipesan',
                    'kode_rak',
                    'updated_at',
                ]
            );
        });

        $this->command->info('Inventory buku-toko berhasil dibuat.');
    }
}

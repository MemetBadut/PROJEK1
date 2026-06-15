<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE produk_bukus
            MODIFY status_buku
            ENUM('tersedia', 'tersimpan', 'dipinjam', 'dipesan')
            NOT NULL DEFAULT 'tersedia'
        ");

        DB::table('produk_bukus')
            ->where('status_buku', 'tersimpan')
            ->update(['status_buku' => 'dipesan']);

        DB::statement(
            "
            ALTER TABLE produk_bukus
            MODIFY status_buku
            ENUM('tersedia', 'dipinjam', 'dipesan')
            NOT NULL DEFAULT 'tersedia'"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE produk_bukus
            MODIFY status_buku
            ENUM('tersedia', 'tersimpan', 'dipinjam', 'dipesan')
            NOT NULL DEFAULT 'tersedia'
        ");

        DB::table('produk_bukus')
            ->where('status_buku', 'dipesan')
            ->update(['status_buku' => 'tersimpan']);

        DB::statement("
            ALTER TABLE produk_bukus
            MODIFY status_buku
            ENUM('tersedia', 'tersimpan', 'dipinjam')
            NOT NULL DEFAULT 'tersedia'
        ");
    }
};

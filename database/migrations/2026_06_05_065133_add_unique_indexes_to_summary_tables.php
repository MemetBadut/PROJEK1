<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_voters', function (Blueprint $table) {
            $table->unique('produk_buku_id', 'data_voters_produk_buku_id_unique');
        });

        Schema::table('author_stats', function (Blueprint $table) {
            $table->unique('penulis_buku_id', 'author_stats_author_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_voters', function (Blueprint $table) {
            $table->dropUnique('data_voters_produk_buku_id_unique');
        });

        Schema::table('author_stats', function (Blueprint $table) {
            $table->dropUnique('author_stats_author_id_unique');
        });
    }
};

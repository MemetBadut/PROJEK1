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
        Schema::table('produk_bukus', function (Blueprint $table) {
            $table->unique('isbn', 'produk_bukus_isbn_unique');
            $table->unique('slug', 'produk_bukus_slug_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk_bukus', function (Blueprint $table) {
            $table->dropUnique('produk_bukus_isbn_unique');
            $table->dropUnique('produk_bukus_slug_unique');
        });
    }
};

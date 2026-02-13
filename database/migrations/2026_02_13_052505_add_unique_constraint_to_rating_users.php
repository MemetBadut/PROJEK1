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
        Schema::table('rating_users', function (Blueprint $table) {
            $table->unique(['user_id', 'produk_buku_id'], 'rating_users_user_book_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rating_users', function (Blueprint $table) {
            $table->dropUnique('rating_users_user_book_unique');
        });
    }
};

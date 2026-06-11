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
        Schema::table('author_stats', function (Blueprint $table) {
            $table->foreign('penulis_buku_id')
                ->references('id')
                ->on('penulis_bukus')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('author_stats', function (Blueprint $table) {
            $table->dropForeign(['penulis_buku_id']);
        });
    }
};

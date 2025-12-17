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
        Schema::create('data_voters', function (Blueprint $table) {
            $table->id();
            $table->string('voter_palsu');
            $table->enum('type', ['real', 'dummy'])->default('dummy'); // tipe voter
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_voters');
    }
};

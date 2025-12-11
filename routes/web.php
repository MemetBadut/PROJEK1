<?php

use App\Http\Controllers\AuthorBukuController;
use App\Http\Controllers\InputRatingController;
use App\Http\Controllers\ProdukBukuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('data_produk', ProdukBukuController::class);
Route::resource('voting_author', AuthorBukuController::class);
Route::resource('input_rating', InputRatingController::class);

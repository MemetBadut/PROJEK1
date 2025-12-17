<?php

namespace App\Http\Controllers;

use App\Models\PenulisBuku;
use Illuminate\Http\Request;

class AuthorRangkingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_author = PenulisBuku::query()
            ->with([
                'produkBuku' => function ($q) {
                    $q->withAvg('ratingUser as avg_rating', 'score');
                }
            ])
            ->withAvg('produkBuku.ratingUser as avg_rating', 'score')
            ->get()
            ->map(function ($author) {
                $author->best_work = $author->produkBuku->whereNotNull('avg_rating')->sortByDesc('avg_rating')->first();
                $author->worst_work = $author->produkBuku->whereNotNull('avg_rating')->sortBy('avg_rating')->first();
                return $author;
            });


    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

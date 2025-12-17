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
        $data_authors = PenulisBuku::with([
            'produkBuku' => function ($q) {
                $q->withAvg('ratingUser', 'score')
                    ->withCount('ratingUser');
            }
        ])
            ->get()
            ->map(function ($author) {

                $author->best_work = $author->produkBuku
                    ->whereNotNull('rating_user_avg_score')
                    ->sortByDesc('rating_user_avg_score')
                    ->first();

                $author->worst_work = $author->produkBuku
                    ->whereNotNull('rating_user_avg_score')
                    ->sortBy('rating_user_avg_score')
                    ->first();

                $author->total_voters = $author->produkBuku
                    ->sum('rating_user_count');

                return $author;
            });
        return view('famous_author.index', compact('data_authors'));
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

<?php

namespace App\Http\Controllers;

use App\Models\PenulisBuku;
use Illuminate\Http\Request;

class AuthorBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_authors = PenulisBuku::with([
            'produkBuku' => function ($q) {
                $q->withAvg('ratingUser', 'score');
            }
        ])->paginate(100);

        // hitung manual karena ini REPORT, bukan kolom DB
        $data_authors->getCollection()->transform(function ($author) {
            $author->best_work = $author->produkBuku
                ->sortByDesc('rating_user_avg_score')
                ->first();

            $author->worst_work = $author->produkBuku
                ->sortBy('rating_user_avg_score')
                ->first();

            $author->avg_rating = $author->produkBuku
                ->avg('rating_user_avg_score');
            return $author;
        });

        return view('famous_author.index', compact('data_authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
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
        $data_author = PenulisBuku::with([
            'produk_bukus' => function ($q) {
                $q->select('id', 'penulis_bukus_id', 'nama_buku');
            }
        ])->findOrFail($id);



        return view('famous_author.show', compact('data_author'));
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

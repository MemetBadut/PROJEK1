<?php

namespace App\Http\Controllers;

use App\Models\PenulisBuku;
use App\Models\ProdukBuku;
use Illuminate\Http\Request;

class AuthorBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_authors = PenulisBuku::query()
            ->join('author_stats', 'author_stats.penulis_buku_id', '=', 'penulis_bukus.id')
            ->orderBy('author_stats.popularity_score', 'desc')
            ->select('penulis_bukus.*', 'author_stats.popularity_score', 'author_stats.total_voters')
            ->paginate(10);

        $data_authors->getCollection()->transform(function ($author) {
            $author->best_book = ProdukBuku::where('penulis_buku_id', $author->id)
                ->withAvg('ratings as avg_rating', 'ratings')
                ->having('avg_rating', '>', 0)
                ->orderByDesc('avg_rating')
                ->first();

            $author->worst_book = ProdukBuku::where('penulis_buku_id', $author->id)
                ->withAvg('ratings as avg_rating', 'ratings')
                ->having('avg_rating', '>', 0)
                ->orderBy('avg_rating', 'asc')
                ->first();

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
                $q->select('id', 'penulis_buku_id', 'nama_buku');
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

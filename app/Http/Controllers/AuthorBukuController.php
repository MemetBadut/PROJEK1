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
            ->leftJoin('author_stats', 'author_stats.penulis_buku_id', '=', 'penulis_bukus.id')
            ->selectRaw('penulis_bukus.*, COALESCE(author_stats.popularity_score,0) as popularity_score, COALESCE(author_stats.total_voters,0) as total_voters')
            ->orderByDesc('author_stats.weighted_rating')
            ->paginate(10);

        $authorIds = $data_authors->pluck('id');

        $bestBooks = ProdukBuku::whereIn('penulis_buku_id', $authorIds)
            ->withAvg('ratings as avg_rating', 'ratings')
            ->having('avg_rating', '>', 0)
            ->orderByDesc('avg_rating')
            ->get()
            ->groupBy('penulis_buku_id')
            ->map(fn($books) => $books->first());

        $worstBooks = ProdukBuku::whereIn('penulis_buku_id', $authorIds)
            ->withAvg('ratings as avg_rating', 'ratings')
            ->having('avg_rating', '>', 0)
            ->orderBy('avg_rating', 'asc')
            ->get()
            ->groupBy('penulis_buku_id')
            ->map(fn($books) => $books->first());

        $data_authors->getCollection()->transform(function ($author) use ($bestBooks, $worstBooks) {
            $author->best_book = $bestBooks->get($author->id);
            $author->worst_book = $worstBooks->get($author->id);

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
            'produkBuku' => function ($q) {
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

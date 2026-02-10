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
        $data_authors = PenulisBuku::query()
            ->withCount([
                'produkBuku as popularity' => function ($q) {
                    $q->whereHas('ratings', function ($r) {
                        $r->where('rating', '>', 5);
                    });
                }
            ])
            ->orderBy('popularity')
            ->paginate(10);

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

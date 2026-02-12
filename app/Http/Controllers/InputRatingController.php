<?php

namespace App\Http\Controllers;

use App\Models\PenulisBuku;
use App\Models\ProdukBuku;
use Illuminate\Http\Request;

class InputRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($authorId)
    {
        $rateProduk = ProdukBuku::where('penulis_buku_id', $authorId)
            ->select('id', 'nama_buku')
            ->orderBy('nama_buku')
            ->get();

        return view('input_rating.index', compact('rateProduk'));
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
        return redirect()->route('home')->with('success', 'Rating berhasil terkirim');
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

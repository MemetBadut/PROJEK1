<?php

namespace App\Http\Controllers;

use App\Models\ProdukBuku;
use Illuminate\Http\Request;

class ProdukBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_buku = ProdukBuku::all();

        $data_buku = ProdukBuku::with(['penulisBuku'])->get();

        $data_buku = ProdukBuku::with(['kategoriBuku'])
            ->orderBy('nama_buku', 'asc')
            ->paginate(5);

        return view('data_buku.index', compact('data_buku'));
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

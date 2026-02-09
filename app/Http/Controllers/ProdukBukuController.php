<?php

namespace App\Http\Controllers;

use App\Models\ProdukBuku;
use App\Models\RatingUser;
use Illuminate\Http\Request;

class ProdukBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data_buku = ProdukBuku::listBooks()
        ->when($request->filled('sorting'), function ($q) use ($request){
            match($request->sorting){
                'most', 'least' => $q->totalRate($request->sorting),
                'name_asc', 'name_desc' => $q->alphabet($request->sorting),
                default => $q
            };
        })
        ->when($request->filled('search'), function ($q) use ($request){
            $q->search($request->search);
        })
        ->paginate(20)
        ->withQueryString();
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
    public function show(ProdukBuku $buku)
    {
        $buku = ProdukBuku::listBooks()
        ->whereKey($buku->id)
        ->firstOrFail();

        return view('data_buku.show', compact('buku'));
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

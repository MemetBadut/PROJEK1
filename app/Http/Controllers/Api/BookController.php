<?php

namespace App\Http\Controllers\Api;

use App\Models\ProdukBuku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $books = ProdukBuku::with(['penulisBuku', 'kategoriBuku', 'publisherBuku'])
            ->when($request->filled('sorting'), function ($q) use ($request) {
                match ($request->sorting) {
                    'most', 'least' => $q->totalRate($request->sorting),
                    'name_asc', 'name_desc' => $q->alphabet($request->sorting),
                    default => $q
                };
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->search($request->search);
            })
            ->paginate(20)
            ->withQueryString();

        return BookResource::collection($books);
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

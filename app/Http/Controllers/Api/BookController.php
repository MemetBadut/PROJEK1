<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookIndexRequest;
use App\Http\Resources\BookResource;
use App\Models\ProdukBuku;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BookIndexRequest $request)
    {
        $validated = $request->validated();

        $books = ProdukBuku::listBooks()
            ->when(isset($validated['sorting']), function ($q)  use ($validated) {
                return in_array($validated['sorting'], ['most', 'least'], true)
                ? $q->totalRate($validated['sorting'])
                : $q->alphabet($validated['sorting']);
            })
            ->when(isset($validated['search']), fn ($q) => $q->search($validated['search']))
            ->when(isset($validated['status']), fn($q) => $q->status($validated['status']))
            ->paginate($validated['per_page'] ?? 20)
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

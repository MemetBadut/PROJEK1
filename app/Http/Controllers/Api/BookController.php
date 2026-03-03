<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\ProdukBuku;

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
    public function store(BookStoreRequest $request)
    {
        $validated = $request->validated();

        $book = ProdukBuku::create($validated);

        return new BookResource(($book));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = ProdukBuku::findOrFail($id);

        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(BookUpdateRequest $request, string $id)  // ← ganti Request
    {
        $book = ProdukBuku::findOrFail($id);
        $book->update($request->validated());
        return new BookResource($book);
    }

    public function destroy(string $id)
    {
        $book = ProdukBuku::findOrFail($id);
        $book->delete();
        return response()->json(['message' => 'Buku berhasil dihapus.'], 200);
    }
}

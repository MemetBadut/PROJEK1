<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\ProdukBuku;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
                return match($validated['sorting']){
                    'most', 'least' => $q->totalRate(($validated['sorting'])),
                    'name_asc', 'name_desc' => $q->alphabet($validated['sorting']),
                    default => $q
                };
            })
            ->when(isset($validated['search']), fn($q) => $q->search($validated['search']))
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
        try {
            $book = ProdukBuku::with(['penulisBuku', 'publisherBuku', 'kategoriBuku'])
                ->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data buku tidak ditemukan'], 404);
        }


        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(BookUpdateRequest $request, string $id)  // ← ganti Request
    {
        try {
            $book = ProdukBuku::findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'message' => 'Data buku tidak ada, tidak bisa update!',
                ],
                404
            );
        }

        $book->update($request->validated());
        $book->load(['penulisBuku', 'publisherBuku']);

        return new BookResource($book);
    }

    public function destroy(string $id)
    {
        try {
            $book = ProdukBuku::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'message' => 'Data buku tidak ditemukan'
                ],
                404
            );
        }

        $book->delete();

        return response()->json(['message' => 'Buku berhasil dihapus.'], 200);
    }
}

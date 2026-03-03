<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorIndexRequest;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\PenulisBuku;

class AuthorController extends Controller
{
    public function index(AuthorIndexRequest $request)
    {
        $authors = PenulisBuku::with(['produkBuku', 'stats'])
            ->when($request->filled('nama_penulis'),
 fn($q) =>
                $q->where('nama_penulis', 'like', '%' . $request->nama_penulis . '%')
            )
            ->paginate($request->per_page ?? 10);

        return AuthorResource::collection($authors);
    }

    public function store(AuthorStoreRequest $request)
    {
        $author = PenulisBuku::create($request->validated());

        return new AuthorResource($author);
    }

    public function show(string $id)
    {
        $author = PenulisBuku::with(['produkBuku', 'stats'])
            ->findOrFail($id);

        return new AuthorResource($author);
    }

    public function update(AuthorUpdateRequest $request, string $id)
    {
        $author = PenulisBuku::findOrFail($id);
        $author->update($request->validated());

        return new AuthorResource($author);
    }

    public function destroy(string $id)
    {
        $author = PenulisBuku::findOrFail($id);
        $author->delete();

        return response()->json(['message' => 'Author berhasil dihapus.']);
    }
}

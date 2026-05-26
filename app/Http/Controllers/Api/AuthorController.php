<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorIndexRequest;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\PenulisBuku;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorController extends Controller
{
    public function index(AuthorIndexRequest $request)
    {
        $authors = PenulisBuku::with(['produkBuku', 'stats'])
            ->when(
                $request->filled('nama_penulis'),
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
        try {
            $author = PenulisBuku::with(['produkBuku', 'stats'])->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'message' => 'Author tidak ditemukan',
                ],
                404
            );
        }


        return new AuthorResource($author);
    }

    public function update(AuthorUpdateRequest $request, string $id)
    {
        try {
            $author = PenulisBuku::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return  response()->json(
                [
                    'message' => 'Author tidak ditemukan',
                ],
                404
            );
        }

        $author->update($request->validated());
        $author->load(['produkBuku', 'stats']);

        return new AuthorResource($author);
    }

    public function destroy(string $id)
    {
        try {
            $author = PenulisBuku::findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'message' => 'Author tidak ditemukan.'
                ],
                404
            );
        }

        $author->delete();

        return response()->json(['message' => 'Author berhasil dihapus.'], 200);
    }
}

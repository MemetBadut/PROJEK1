<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRatingRequest;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use App\Http\Requests\DeleteRatingRequest;
use App\Http\Resources\RatingResource;
use App\Models\RatingUser;
use App\Service\VoteSubmissionService;
use Illuminate\Database\QueryException;
use DomainException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RatingController extends Controller
{
    public function index(IndexRatingRequest $request)
    {
        $ratings = RatingUser::with(['voter', 'produkBuku'])
            ->when(
                $request->filled('year'),
                fn($q) =>
                $q->whereYear('created_at', $request->year)
            )
            ->paginate(10);

        return RatingResource::collection($ratings);
    }

    public function store(StoreRatingRequest $request, VoteSubmissionService $voteSubmissionService)
    {
        $validated = $request->validated();

        try {
            $rating = $voteSubmissionService->submit(
                (int) $request->user()->id,
                (int) $validated['produk_buku_id'],
                (int) $validated['author_id'],
                (int) $validated['ratings'],
            );
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['message' => 'Kamu sudah pernah memberikan rating untuk buku ini.'], 422);
            }
            throw $e;
        }

        return new RatingResource($rating->load(['voter', 'produkBuku']));
    }

    public function show(string $id)
    {
        try {
            $rating = RatingUser::with(['voter', 'produkBuku'])
                ->findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(
                [

                    'message' => 'Data rating tidak ditemukan.'
                ]
            );
        }


        return new RatingResource($rating);
    }

    public function update(UpdateRatingRequest $request, string $id)
    {
        $rating = RatingUser::findOrFail($id);

        // Cek produk_buku_id harus sesuai dengan rating yang mau diupdate
        if ((int) $request->produk_buku_id !== (int) $rating->produk_buku_id) {
            return response()->json([
                'message' => 'produk_buku_id tidak sesuai dengan rating ini.'
            ], 422);
        }

        if ((int) $rating->user_id !== (int) $request->user()->id) {
            return response()->json(['message' => 'Kamu tidak bisa mengubah rating milik orang lain.'], 403);
        }


        $rating->update(['ratings' => $request->ratings]);

        return new RatingResource($rating->load(['voter', 'produkBuku']));
    }

    public function destroy(DeleteRatingRequest $request, string $id)
    {
        try {
            $rating = RatingUser::findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json(
                [
                    'message' => 'Data rating tidak ditemukan.'
                ],
                404
            );
        }

        if ((int) $rating->user_id !== (int) $request->user()->id) {
            return response()->json(['message' => 'Kamu tidak bisa menghapus rating milik orang lain.'], 403);
        }

        $rating->delete();

        return response()->json(['message' => 'Rating berhasil dihapus.']);
    }
}

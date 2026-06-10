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
use Illuminate\Database\UniqueConstraintViolationException;

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

    /**
     * Store a newly created resource in storage.
     */
    private function isUniqueConstraintViolation(QueryException $e): bool
    {
        $sqlState = (string) ($e->errorInfo[0] ?? $e->getCode());
        $driverCode = (string) ($e->errorInfo[1] ?? '');
        $message = strtolower($e->getMessage());

        return in_array($sqlState, ['23000', '23505'], true)
            || in_array($driverCode, ['1062', '19', '2067'], true)
            || str_contains($message, 'unique')
            || str_contains($message, 'duplicate');
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
            return back()->withErrors(['voting' => $e->getMessage()])->withInput();
        } catch (UniqueConstraintViolationException $e) {
            return back()->withErrors([
                'voting' => 'Kamu sudah pernah memberikan rating untuk buku ini.',
            ])->withInput();
        } catch (QueryException $e) {
            // fallback untuk variasi driver/versi
            if ($this->isUniqueConstraintViolation($e)) {
                return back()->withErrors([
                    'voting' => 'Kamu sudah pernah memberikan rating untuk buku ini.',
                ])->withInput();
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
                ],
                404
            );
        }


        return new RatingResource($rating);
    }

    public function update(UpdateRatingRequest $request, string $id)
    {
        try {
            $rating = RatingUser::findOrFail($id);
        } catch (ModelNotFoundException) {
            return response()->json([
                'message' => 'Data rating tidak ditemukan.',
            ], 404);
        }

        $validated = $request->validated();

        if ((int) $rating->user_id !== (int) $request->user()->id) {
            return response()->json([
                'message' => 'Kamu tidak bisa mengubah rating milik orang lain.',
            ], 403);
        }

        if (
            array_key_exists('produk_buku_id', $validated)
            && (int) $validated['produk_buku_id'] !== (int) $rating->produk_buku_id
        ) {
            return response()->json([
                'message' => 'produk_buku_id tidak sesuai dengan rating ini.',
            ], 422);
        }

        $rating->update([
            'ratings' => $validated['ratings'],
        ]);


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

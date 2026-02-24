<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\RatingUser;
use App\Service\VoteSubmissionService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use DomainException;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratings = RatingUser::with(['voter', 'produkBuku'])
            ->paginate(10);

        return RatingResource::collection($ratings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, VoteSubmissionService $voteSubmissionService)
    {
        $validated = $request->validate([
            'author_id' => ['required', 'exists:penulis_bukus,id'],
            'produk_buku_id' => ['required', 'exists:produk_bukus,id'],
            'ratings' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

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
        $rating = RatingUser::findOrFail($id);

        $validated = $request->validate([
            'ratings' => 'required|sometimes|integer|min:1|max:10',
        ]);

        $rating->update($validated);

        return new RatingResource($rating->load(['voter', 'produkBuku']));
    }

    /**
     * Remove the specified resource from storage.
     */    public function destroy(string $id)
    {
        //
    }
}

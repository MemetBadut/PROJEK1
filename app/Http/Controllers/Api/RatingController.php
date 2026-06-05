<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\RatingUser;
use App\Service\VoteSubmissionService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use DomainException;
use Illuminate\Database\UniqueConstraintViolationException;

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
            'ratings' => 'required|integer|min:1|max:10',
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

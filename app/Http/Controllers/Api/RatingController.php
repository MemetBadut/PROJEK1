<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RatingResource;
use App\Models\RatingUser;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'produk_buku_id' => 'required|exists:produk_buku,id',
            'ratings' => 'required|numeric|min:1|max:10',
        ]);

        $rating = RatingUser::create($validated);

        return new RatingResource($rating);
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

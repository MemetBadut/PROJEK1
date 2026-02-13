<?php

namespace App\Http\Controllers;

use App\Models\ProdukBuku;
use App\Models\RatingUser;
use App\Models\PenulisBuku;
use App\Service\VotingRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InputRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = PenulisBuku::orderBy('nama_penulis')->get();

        return view('input_rating.index', compact('authors'));
    }

    public function booksByAuthor(PenulisBuku $author)
    {
        return $author->produkBuku()
            ->select('id', 'nama_buku')
            ->orderBy('nama_buku')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'author_id' => ['required', 'exists:penulis_bukus,id'],
            'produk_buku_id' => ['required', 'exists:produk_bukus,id'],
            'ratings' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $userId = Auth::id();

        // Validate voting rules
        $check = VotingRules::validate(
            $userId,
            $validated['produk_buku_id'],
            $validated['author_id']
        );

        if (!$check['ok']) {
            return back()->withErrors(['voting' => $check['message']])->withInput();
        }

        // Use DB transaction for concurrency safety
        try {
            DB::transaction(function () use ($validated, $userId) {
                RatingUser::create([
                    'produk_buku_id' => $validated['produk_buku_id'],
                    'user_id' => $userId,
                    'ratings' => $validated['ratings'],
                ]);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // Catch unique constraint violation (concurrent duplicate)
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors(['voting' => 'Kamu sudah pernah memberikan rating untuk buku ini.'])->withInput();
            }
            throw $e;
        }

        return redirect()->route('home')->with('success', 'Rating berhasil terkirim!');
    }
}

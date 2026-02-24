<?php

namespace App\Http\Controllers;

use App\Models\ProdukBuku;
use App\Models\PenulisBuku;
use App\Service\VoteSubmissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use DomainException;

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
    public function store(Request $request, VoteSubmissionService $voteSubmissionService)
    {
        $validated = $request->validate([
            'author_id' => ['required', 'exists:penulis_bukus,id'],
            'produk_buku_id' => ['required', 'exists:produk_bukus,id'],
            'ratings' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $userId = (int) Auth::id();

        try {
            $voteSubmissionService->submit(
                $userId,
                (int) $validated['produk_buku_id'],
                (int) $validated['author_id'],
                (int) $validated['ratings'],
            );
        } catch (DomainException $e) {
            return back()->withErrors(['voting' => $e->getMessage()])->withInput();
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors(['voting' => 'Kamu sudah pernah memberikan rating untuk buku ini.'])->withInput();
            }
            throw $e;
        }

        return redirect()->route('home')->with('success', 'Rating berhasil terkirim!');
    }
}

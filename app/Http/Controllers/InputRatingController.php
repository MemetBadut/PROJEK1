<?php

namespace App\Http\Controllers;

use App\Models\PenulisBuku;
use App\Service\VoteSubmissionService;
use DomainException;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InputRatingController extends Controller
{
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

        return redirect()->route('home')->with('success', 'Rating berhasil terkirim!');
    }

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
}

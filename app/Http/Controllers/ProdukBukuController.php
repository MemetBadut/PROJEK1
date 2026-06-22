<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookIndexRequest;
use App\Models\LokasiToko;
use App\Models\ProdukBuku;
use Illuminate\Http\Request;

class ProdukBukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BookIndexRequest $request)
    {
        $filters = $request->validated();
        $storeId = isset($filters['lokasi_toko_id'])
            ? (int) $filters['lokasi_toko_id']
            : null;

        $data_buku = ProdukBuku::listBooks()
            ->when($storeId, fn ($query, $id) => $query->filterStore($id))
            ->when($filters['status'] ?? null, fn ($query, $status) => $query
                ->filterAvailability($status, $storeId))
            ->when($filters['sorting'] ?? null, function ($query, $sorting) {
                return match ($sorting) {
                    'most', 'least' => $query->totalRate($sorting),
                    'rating_desc', 'rating_asc' => $query->averageRate($sorting),
                    'name_asc', 'name_desc' => $query->alphabet($sorting),
                    default => $query,
                };
            })
            ->when($filters['search'] ?? null, fn ($query, $search) => $query->search($search))
            ->paginate($filters['per_page'] ?? 5)
            ->withQueryString();

        $lokasiToko = LokasiToko::query()
            ->where('status_aktif', true)
            ->orderBy('nama_toko')
            ->get(['id', 'kode_toko', 'nama_toko', 'kota']);

        return view('data_buku.index', compact('data_buku', 'lokasiToko', 'storeId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProdukBuku $buku)
    {
        $buku = ProdukBuku::with(['penulisBuku', 'publisherBuku', 'kategoriBuku'])
            ->whereKey($buku->id)
            ->firstOrFail();

        return view('data_buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

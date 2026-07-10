<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBuku extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_buku',
        'penulis_buku_id',
        'isbn',
        'publisher_id',
        'status_buku',
        'slug',
        'sinopsis',
        'rating_enabled',
        'created_at',
        'updated_at'
    ];

    protected $table = 'produk_bukus';

    #relasi Author
    public function penulisBuku()
    {
        return $this->belongsTo(PenulisBuku::class, 'penulis_buku_id', 'id');
    }

    #relasi Kategori
    public function kategoriBuku()
    {
        return $this->belongsToMany(KategoriBuku::class, 'buku_kategori_pivot', 'produk_buku_id', 'kategori_buku_id');
    }

    #relasi Toko
    public function lokasiToko()
    {
        return $this->belongsToMany(LokasiToko::class,
            'table_inventori_toko_buku',
            'produk_buku_id',
            'lokasi_toko_id'
        )->withPivot([
            'stok_total',
            'stok_tersedia',
            'stok_dipinjam',
            'stok_dipesan',
            'kode_rak'
        ])->withTimestamps();
    }

    #relasi ratingUser
    public function ratingUser()
    {
        return $this->hasMany(RatingUser::class, 'produk_buku_id', 'id');
    }


    #relasi publisher
    public function publisherBuku()
    {
        return $this->belongsTo(PublisherBuku::class, 'publisher_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(RatingUser::class, 'produk_buku_id');
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('nama_buku', 'like', "%{$keyword}%")
                ->orWhere('isbn', 'like', "%{$keyword}%")
                ->orWhereHas('penulisBuku', function ($qq) use ($keyword) {
                    $qq->where('nama_penulis', 'like', "%{$keyword}%");
                })
                ->orWhereHas('publisherBuku', function ($qq) use ($keyword) {
                    $qq->where('nama_publisher', 'like', "%{$keyword}%");
                });
        });
    }

    public function scopeFilterStore($query, int $storeId)
    {
        return $query->whereHas('lokasiToko', function ($storeQuery) use ($storeId) {
            $storeQuery->where('lokasi_toko.id', $storeId);
        });
    }

    public function scopeFilterAvailability($query, string $status, ?int $storeId = null)
    {
        $atStore = function ($storeQuery) use ($storeId) {
            $storeQuery->when($storeId, function ($query, $id) {
                $query->where('lokasi_toko.id', $id);
            });
        };

        return match ($status) {
            'available' => $query->whereHas('lokasiToko', function ($storeQuery) use ($atStore) {
                $atStore($storeQuery);
                $storeQuery->where('table_inventori_toko_buku.stok_tersedia', '>', 0);
            }),

            'rented' => $query
                ->whereDoesntHave('lokasiToko', function ($storeQuery) use ($atStore) {
                    $atStore($storeQuery);
                    $storeQuery->where('table_inventori_toko_buku.stok_tersedia', '>', 0);
                })
                ->whereHas('lokasiToko', function ($storeQuery) use ($atStore) {
                    $atStore($storeQuery);
                    $storeQuery->where('table_inventori_toko_buku.stok_dipinjam', '>', 0);
                }),

            'reserved' => $query
                ->whereDoesntHave('lokasiToko', function ($storeQuery) use ($atStore) {
                    $atStore($storeQuery);
                    $storeQuery->where(function ($inventoryQuery) {
                        $inventoryQuery
                            ->where('table_inventori_toko_buku.stok_tersedia', '>', 0)
                            ->orWhere('table_inventori_toko_buku.stok_dipinjam', '>', 0);
                    });
                })
                ->whereHas('lokasiToko', function ($storeQuery) use ($atStore) {
                    $atStore($storeQuery);
                    $storeQuery->where('table_inventori_toko_buku.stok_dipesan', '>', 0);
                }),

            default => $query,
        };
    }

    public function availabilityStatus(?int $storeId = null): string
    {
        $stores = $this->lokasiToko;

        if ($storeId !== null) {
            $stores = $stores->where('id', $storeId);
        }

        if ($stores->sum(fn ($store) => (int) $store->pivot->stok_tersedia) > 0) {
            return 'available';
        }

        if ($stores->sum(fn ($store) => (int) $store->pivot->stok_dipinjam) > 0) {
            return 'rented';
        }

        if ($stores->sum(fn ($store) => (int) $store->pivot->stok_dipesan) > 0) {
            return 'reserved';
        }

        return 'unavailable';
    }

    public function scopeFilterYear($query, $year)
    {
        return match ($year) {
            'release' => $query->whereYear('created_at', $year),
        };
    }

    public function scopeListBooks($query)
    {
        return $query->select([
            'produk_bukus.id',
            'produk_bukus.nama_buku',
            'produk_bukus.penulis_buku_id',
            'produk_bukus.publisher_id',
            'produk_bukus.status_buku',
            'produk_bukus.slug',
            'produk_bukus.isbn',
            'data_voters.total_voters',
            'data_voters.avg_rating',
            'data_voters.avg_7_days',
            'data_voters.trend_7_days',
            'data_voters.trend_direction',
            'data_voters.recent_popularity_score',
        ])
            ->leftJoin('data_voters', 'data_voters.produk_buku_id', '=', 'produk_bukus.id')
            ->with([
                'kategoriBuku:id,kategori_buku',
                'penulisBuku:id,nama_penulis',
                'publisherBuku:id,nama_publisher',
                'lokasiToko:id,kode_toko,nama_toko,kota',
            ]);
    }

    public function scopeTotalRate($query, $vote)
    {
        return match ($vote) {
            'most' => $query->orderBy('total_voters', 'desc'),
            'least' => $query->orderBy('total_voters', 'asc'),
            default => $query
        };
    }

    public function scopeAverageRate($query, $sorting)
    {
        return match ($sorting) {
            'rating_desc' => $query
                ->orderByRaw('data_voters.avg_rating IS NULL')
                ->orderByDesc('data_voters.avg_rating')
                ->orderByDesc('data_voters.total_voters')
                ->orderBy('produk_bukus.id'),
            'rating_asc' => $query
                ->orderByRaw('data_voters.avg_rating IS NULL')
                ->orderBy('data_voters.avg_rating')
                ->orderByDesc('data_voters.total_voters')
                ->orderBy('produk_bukus.id'),
            default => $query,
        };
    }

    public function scopeAlphabet($query, $alpha)
    {
        return match ($alpha) {
            'name_asc' => $query->orderBy('nama_buku', 'asc'),
            'name_desc' => $query->orderBy('nama_buku', 'desc'),
            default => $query
        };
    }
}

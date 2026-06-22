<x-app>
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Buku John Doe</h1>
            <p class="mt-1 text-sm text-gray-600">
                Status buku dihitung dari stok pada cabang toko, bukan dari kolom status global.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url()->current() }}" method="GET"
            class="mb-6 grid gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-sm md:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <label for="search" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Pencarian
                </label>
                <input id="search" type="search" name="search" value="{{ request('search') }}"
                    placeholder="Judul, penulis, ISBN, publisher..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
            </div>

            <div>
                <label for="lokasi_toko_id" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Cabang toko
                </label>
                <select id="lokasi_toko_id" name="lokasi_toko_id"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Semua cabang</option>
                    @foreach ($lokasiToko as $toko)
                        <option value="{{ $toko->id }}" @selected((string) request('lokasi_toko_id') === (string) $toko->id)>
                            {{ $toko->nama_toko }} - {{ $toko->kota }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Status stok
                </label>
                <select id="status" name="status"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Semua status</option>
                    <option value="available" @selected(request('status') === 'available')>Available</option>
                    <option value="rented" @selected(request('status') === 'rented')>Rented</option>
                    <option value="reserved" @selected(request('status') === 'reserved')>Reserved</option>
                </select>
            </div>

            <div>
                <label for="sorting" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Urutkan
                </label>
                <select id="sorting" name="sorting"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Default</option>
                    <option value="name_asc" @selected(request('sorting') === 'name_asc')>Judul A-Z</option>
                    <option value="name_desc" @selected(request('sorting') === 'name_desc')>Judul Z-A</option>
                    <option value="rating_desc" @selected(request('sorting') === 'rating_desc')>Rating tertinggi</option>
                    <option value="rating_asc" @selected(request('sorting') === 'rating_asc')>Rating terendah</option>
                </select>
            </div>

            <div class="flex items-end gap-2 lg:col-span-5">
                <button type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">
                    Terapkan filter
                </button>
                <a href="{{ url()->current() }}"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Buku</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Rating</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-500">Inventory per cabang</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($data_buku as $buku)
                            @php
                                $stores = $storeId
                                    ? $buku->lokasiToko->where('id', $storeId)
                                    : $buku->lokasiToko;
                                $status = $buku->availabilityStatus($storeId);
                                $statusLabel = match ($status) {
                                    'available' => 'Available',
                                    'rented' => 'Rented',
                                    'reserved' => 'Reserved',
                                    default => 'Unavailable',
                                };
                            @endphp
                            <tr class="align-top hover:bg-gray-50">
                                <td class="px-4 py-4">
                                    <a href="{{ route('detail_book', $buku->slug) }}"
                                        class="font-semibold text-gray-900 hover:text-blue-600">
                                        {{ $buku->nama_buku }}
                                    </a>
                                    <div class="mt-1 text-sm text-gray-600">
                                        {{ $buku->penulisBuku?->nama_penulis ?? '-' }}
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">ISBN {{ $buku->isbn }}</div>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    {{ $buku->kategoriBuku->pluck('kategori_buku')->implode(', ') ?: '-' }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700">
                                    <div class="font-semibold">{{ number_format((float) ($buku->avg_rating ?? 0), 1) }}/10</div>
                                    <div class="text-xs text-gray-500">{{ (int) $buku->total_voters }} voter</div>
                                </td>
                                <td class="px-4 py-4">
                                    <span @class([
                                        'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold',
                                        'bg-green-100 text-green-700' => $status === 'available',
                                        'bg-amber-100 text-amber-700' => $status === 'rented',
                                        'bg-blue-100 text-blue-700' => $status === 'reserved',
                                        'bg-gray-100 text-gray-600' => $status === 'unavailable',
                                    ])>
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="space-y-2">
                                        @forelse ($stores as $toko)
                                            <div class="rounded-lg border border-gray-200 p-2 text-xs text-gray-700">
                                                <div class="font-semibold text-gray-900">
                                                    {{ $toko->nama_toko }} - {{ $toko->kota }}
                                                </div>
                                                <div class="mt-1 flex flex-wrap gap-x-3 gap-y-1">
                                                    <span>Total: {{ $toko->pivot->stok_total }}</span>
                                                    <span class="text-green-700">Tersedia: {{ $toko->pivot->stok_tersedia }}</span>
                                                    <span class="text-amber-700">Dipinjam: {{ $toko->pivot->stok_dipinjam }}</span>
                                                    <span class="text-blue-700">Dipesan: {{ $toko->pivot->stok_dipesan }}</span>
                                                    <span>Rak: {{ $toko->pivot->kode_rak ?? '-' }}</span>
                                                </div>
                                            </div>
                                        @empty
                                            <span class="text-xs text-gray-400">Belum memiliki inventory toko.</span>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
                                    Tidak ada buku yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $data_buku->links() }}
        </div>
    </div>
</x-app>

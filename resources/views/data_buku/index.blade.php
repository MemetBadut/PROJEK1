<x-app>

    <div class="ml-2.5 text-center mt-5">
        <h2 class="font-bold text-xl">Tabel Buku</h2>
        <p class="">Daftar Buku Johndoe</p>
        <br><br>
    </div>

    <div class="overflow-x-auto ">
        <div class="max-w-6xl mx-auto">
            <table class="w-full">
                <form action="{{ route('home') }}" method="GET" class="flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <select name="sorting" id="sorting" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="name_asc" {{ request('sorting') == 'name_asc' ? 'selected' : '' }}>A-Z
                            </option>
                            <option value="name_desc" {{ request('sorting') == 'name_desc' ? 'selected' : '' }}>Z-A
                            </option>
                            <option value="most" {{ request('sorting') == 'most' ? 'selected' : '' }}>Rating Tertinggi
                            </option>
                            <option value="least" {{ request('sorting') == 'least' ? 'selected' : '' }}>Rating Terendah
                            </option>
                            <option value="available" {{ request('sorting') == 'available' ? 'selected' : '' }}>Tersedia
                            </option>
                            <option value="reserved" {{ request('sorting') == 'reserved' ? 'selected' : '' }}>Dipinjam
                            </option>
                            <option value="rented" {{ request('sorting') == 'rented' ? 'selected' : '' }}>Tersimpan
                            </option>
                        </select>

                        <input type="text" placeholder="Cari buku/penulis/ISBN..." name="search"
                            value="{{ request('search') }}" onchange="this.form.submit()">

                    </div>
                </form>

                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-center ">Judul Buku</th>
                        <th class="px-6 py-4 text-center">Nama Penulis</th>
                        <th class="px-6 py-4 text-center">Kategori Buku</th>
                        <th class="px-6 py-4 text-center">ISBN</th>
                        <th class="px-6 py-4 text-center">Rating Buku</th>
                        <th class="px-6 py-4 text-center">Voters</th>
                        <th class="px-6 py-4 text-center">Status Buku</th>
                        <th class="px-6 py-4 "></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_buku as $buku)
                        <tr>
                            <td class="px-6 py-4 text-justify">{{ $buku->nama_buku }}</td>
                            <td class="px-6 py-4 text-justify">
                                {{ $buku->penulisBuku->nama_penulis }}
                            </td>
                            <td class="px-6 py-4 text-justify">
                                {{ $buku->kategoriBuku->isNotEmpty() ? $buku->kategoriBuku->pluck('kategori_buku')->implode(', ') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-justify">{{ $buku->isbn }}</td>
                            <td class="px-6 py-4 text-justify">{{ number_format($buku->avg_rating, 1, '.', ) }}/10</td>
                            <td class="px-6 py-4 text-justify">{{ $buku->total_voters }}</td>
                            <td class="px-6 py-4 text-justify hover:underline">
                                @if ($buku->status_buku === 'tersedia')
                                    <a href="{{ route('detail_book', $buku->slug) }}">{{ $buku->status_buku }}</a>
                                @else
                                    {{ $buku->status_buku }}
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- footer --}}
        <div>
            {{ $data_buku->links() }}
        </div>
    </div>

</x-app>

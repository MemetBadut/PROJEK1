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
                            <option value="">Semua Status</option>
                            <option value="name_asc" {{ request('sorting') == 'name_asc' ? 'selected' : '' }}>A-Z
                            </option>
                            <option value="name_desc" {{ request('sorting') == 'name_desc' ? 'selected' : '' }}>Z-A
                            </option>
                            <option value="most" {{ request('sorting') == 'most' ? 'selected' : '' }}>Rating Tertinggi
                            </option>
                            <option value="least" {{ request('sorting') == 'least' ? 'selected' : '' }}>Rating Terendah
                            </option>
                            <option value="status" {{ request('sorting') == 'status' ? 'selected' : '' }}>Status
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
                            <td class="px-6 py-4 text-justify">{{ $buku->avg_rating }}/10</td>
                            <td class="px-6 py-4 text-justify">{{ $buku->total_voters }}</td>
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

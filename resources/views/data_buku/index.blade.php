<x-app>

    <div class="ml-2.5 text-center mt-5">
        <h2 class="font-bold text-xl">Tabel Buku</h2>
        <p class="">Daftar Buku Johndoe</p>
        <br><br>
    </div>

    <div class="overflow-x-auto ">
        <div class="max-w-6xl mx-auto">
            <table class="w-full">
                <select name="" id="">

                </select>
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-center">Tgl.</th>
                        <th class="px-6 py-4 text-center ">Judul Buku</th>
                        <th class="px-6 py-4 text-center">Nama Penulis</th>
                        <th class="px-6 py-4 text-center">Kategori Buku</th>
                        <th class="px-6 py-4 text-center">ISBN</th>
                        <th class="px-6 py-4 text-center">Rating Buku</th>
                        <th class="px-6 py-4 text-center">Lokasi Toko </th>
                        <th class="px-6 py-4 text-center">Status Buku</th>
                        <th class="px-6 py-4 "></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_buku as $buku)
                        <tr>
                            <td class="px-6 py-4 text-center">{{ $buku->created_at }}</td>
                            <td class="px-6 py-4 text-justify">{{ $buku->nama_buku }}</td>
                            <td class="px-6 py-4 text-justify"></td>
                            <td class="px-6 py-4 text-justify"></td>
                            <td class="px-6 py-4 text-justify">{{ $buku->isbn }}</td>
                            <td class="px-6 py-4 text-center">{{ $buku->rating_buku }}/10</td>
                            <td class="px-6 py-4 text-center">{{ $buku->lokasi_toko }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</x-app>

{{-- resources/views/data_buku/show.blade.php --}}
<x-app>
    <x-slot:header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Buku
        </h2>
    </x-slot:header>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-4">
                <h1 class="text-2xl font-bold">{{ $buku->nama_buku }}</h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Penulis</p>
                        <p class="font-medium">{{ $buku->penulisBuku->nama_penulis ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Publisher</p>
                        <p class="font-medium">{{ $buku->publisherBuku->nama_publisher ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">ISBN</p>
                        <p class="font-medium">{{ $buku->isbn ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Publish</p>
                        <p class="font-medium">{{ $buku->tanggal_publish7 ?? '-' }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-gray-500 text-sm mb-1">Sinopsis</p>
                    <p class="text-gray-800">{{ $buku->sinopsis ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-gray-500 text-sm mb-1">Kategori</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse ($buku->kategoriBuku as $kat)
                            <span class="px-2 py-1 text-xs bg-gray-100 rounded">
                                {{ $kat->kategori_buku }}
                            </span>
                        @empty
                            <span class="text-gray-500">-</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>

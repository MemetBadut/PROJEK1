<x-app>
    <div class="ml-2.5 text-center">
        <h2 class="font-bold text-2xl">Vote Author</h2>
        <p class="">Vote author favorite kamu 🤩</p>
        <br>
    </div>

    <div class="overflow-x-auto ">
        <div class="max-w-6xl mx-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-center">Nama Penulis</th>
                        <th class="px-6 py-4 text-center">Total Ratings</th>
                        <th class="px-6 py-4 text-center">Best Book</th>
                        <th class="px-6 py-4 text-center">Worst Book</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_authors as $author)
                        <tr>
                            <td class="px-6 py-4">{{ $author->nama_penulis }}</td>
                            <td class="px-6 py-4 text-center">{{ $author->total_voters ?? 0 }}</td>
                            <td class="px-6 py-4">
                                @if ($author->best_book)
                                    {{ $author->best_book->nama_buku }}
                                    <span class="text-green-600 text-xs">(⭐
                                        {{ number_format($author->best_book->avg_rating, 1) }})</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if ($author->worst_book)
                                    {{ $author->worst_book->nama_buku }}
                                    <span class="text-red-500 text-xs">(⭐
                                        {{ number_format($author->worst_book->avg_rating, 1) }})</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="submit" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                        height="24" fill="currentColor">
                                        <path
                                            d="M12.001 4.52853C14.35 2.42 17.98 2.49 20.2426 4.75736C22.5053 7.02472 22.583 10.637 20.4786 12.993L11.9999 21.485L3.52138 12.993C1.41705 10.637 1.49571 7.01901 3.75736 4.75736C6.02157 2.49315 9.64519 2.41687 12.001 4.52853ZM18.827 6.1701C17.3279 4.66794 14.9076 4.60701 13.337 6.01687L12.0019 7.21524L10.6661 6.01781C9.09098 4.60597 6.67506 4.66808 5.17157 6.17157C3.68183 7.66131 3.60704 10.0473 4.97993 11.6232L11.9999 18.6543L19.0201 11.6232C20.3935 10.0467 20.319 7.66525 18.827 6.1701Z">
                                        </path>
                                    </svg>
                                    <span>Vote</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div>
            {{ $data_authors->links() }}
        </div>
    </div>

</x-app>

<x-app>

    <div class="min-h-screen bg-linear-to-br from-indigo-50 via-white to-purple-50 py-12 px-4">
        <div class="max-w-2xl mx-auto">

            <!-- Header Section -->
            <div class="text-center mb-12">
                <div class="inline-block mb-4">
                    <span class="text-6xl">📚</span>
                </div>
                <h2 class="font-bold text-4xl text-gray-800 mb-3">Input Rating Buku</h2>
                <p class="text-gray-600 text-lg">Beri Rating pada Buku yang kamu Baca ⭐</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <form action="" class="space-y-6">

                    <!-- Nama Buku -->
                    <div class="space-y-2">
                        <label for="nama_buku" class="block text-sm font-semibold text-gray-700 mb-2">
                            📖 Pilih Nama Buku
                        </label>
                        <select name="nama_buku" id="nama_buku"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all duration-200 bg-gray-50 hover:bg-white cursor-pointer">
                            <option value="" disabled selected>Pilih buku...</option>
                            <option value="buku1">Nama Buku 1</option>
                            <option value="buku2">Nama Buku 2</option>
                        </select>
                    </div>

                    <!-- Rating -->
                    <div class="space-y-2">
                        <label for="rating" class="block text-sm font-semibold text-gray-700 mb-2">
                            ⭐ Berikan Rating
                        </label>
                        <select name="rating" id="rating"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 outline-none transition-all duration-200 bg-gray-50 hover:bg-white cursor-pointer">
                            <option value="" disabled selected>Pilih rating...</option>
                            <option value="5">⭐⭐⭐⭐⭐ (5 - Sangat Bagus)</option>
                            <option value="4">⭐⭐⭐⭐ (4 - Bagus)</option>
                            <option value="3">⭐⭐⭐ (3 - Cukup)</option>
                            <option value="2">⭐⭐ (2 - Kurang)</option>
                            <option value="1">⭐ (1 - Tidak Bagus)</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-linear-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Kirim Rating 🚀
                    </button>

                </form>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-8">
                <p class="text-gray-500 text-sm">Rating kamu membantu pembaca lain menemukan buku terbaik! 💫</p>
            </div>

        </div>
    </div>

</x-app>

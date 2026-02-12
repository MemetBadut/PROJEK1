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

                    {{-- Nama Author --}}
                    <div class="space-y-2">
                        <select id="author_id" name="author_id" class="form-control">
                            <option value="">-- Select Author --</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">
                                    {{ $author->nama_penulis }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama Buku -->
                    <div class="space-y-2">
                        <label for="nama_buku" class="block text-sm font-semibold text-gray-700 mb-2">
                            📖 Pilih Nama Buku
                        </label>
                        <select id="produk_buku_id" name="produk_buku_id" class="form-control" disabled>
                            <option value="">-- Select Book --</option>
                        </select>
                    </div>

                    <!-- Rating -->
                    <select name="ratings" class="form-control">
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>

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

    <script>
        document.getElementById('author_id').addEventListener('change', function() {
            const authorId = this.value;
            const bookDropdown = document.getElementById('produk_buku_id');

            bookDropdown.innerHTML = '<option value="">Loading...</option>';
            bookDropdown.disabled = true;

            if (!authorId) {
                bookDropdown.innerHTML = '<option value="">-- Select Book --</option>';
                return;
            }

            fetch(`/authors/${authorId}/books`)
                .then(response => response.json())
                .then(data => {
                    let options = '<option value="">-- Select Book --</option>';

                    data.forEach(book => {
                        options += `<option value="${book.id}">${book.nama_buku}</option>`;
                    });

                    bookDropdown.innerHTML = options;
                    bookDropdown.disabled = false;
                })
                .catch(() => {
                    bookDropdown.innerHTML = '<option value="">Error loading books</option>';
                });
        });
    </script>


</x-app>

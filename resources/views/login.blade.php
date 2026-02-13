<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <input type="email" name="email" placeholder="Email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Login
            </button>
        </form>

        <div class="mt-4">
            <a href="{{ route('home') }}"
                class="block w-full text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                Masuk sebagai Guest
            </a>
        </div>
    </div>
</div>

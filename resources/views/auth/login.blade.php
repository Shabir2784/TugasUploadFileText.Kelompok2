<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EventRent</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen font-sans">

    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-md border-t-4 border-[#27498c]">
        <h2 class="text-2xl font-bold text-[#1a2b58] mb-6 text-center">Login</h2>

        @if (session('success'))
            <div class="bg-orange-50 p-4 rounded-md mb-6 border border-orange-100 text-center">
                <span
                    class="text-orange-700 font-bold text-xs bg-orange-200 px-3 py-1 rounded-full uppercase tracking-wide">Menunggu
                    Verifikasi KTP</span>
                <p class="text-gray-700 text-sm mt-3">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-md p-2.5 focus:outline-none focus:border-[#27498c] focus:ring-1 focus:ring-[#27498c] transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-md p-2.5 focus:outline-none focus:border-[#27498c] focus:ring-1 focus:ring-[#27498c] transition">
            </div>

            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div class="flex items-center justify-between mt-2">
                <a href="{{ route('password.request') }}"
                    class="text-[#27498c] text-sm font-medium hover:underline">Lupa Password?</a>
            </div>

            <button type="submit"
                class="w-full bg-[#27498c] hover:bg-blue-800 text-white font-bold py-2.5 px-4 rounded-md transition shadow-sm">
                Login
            </button>
        </form>

        <!-- Tambahan Opsi Registrasi -->
        <div class="mt-6 pt-4 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-600">Belum punya akun?</p>
            <a href="{{ route('register') }}" class="inline-block mt-1 text-[#27498c] font-bold hover:underline">Daftar
                Sekarang</a>
        </div>
    </div>

</body>

</html>

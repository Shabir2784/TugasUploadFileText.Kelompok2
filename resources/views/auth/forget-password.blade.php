<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - EventRent</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Lupa Kata Sandi?</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Masukkan alamat email Anda yang terdaftar dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
        </p>

        <!-- Menampilkan pesan sukses pengiriman link email -->
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 border p-2">
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition">
                Kirim Tautan Reset
            </button>
        </form>

        <div class="mt-4 text-center text-sm text-gray-600">
            Ingat kata sandi Anda? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Kembali ke
                Login</a>
        </div>
    </div>

</body>

</html>

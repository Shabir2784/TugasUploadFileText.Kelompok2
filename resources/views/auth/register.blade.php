<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - EventRent</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white min-h-screen flex font-sans">

    <!-- Sisi Kiri: Panel Biru -->
    <div class="hidden md:flex w-1/3 bg-[#27498c] text-white p-16 flex-col justify-center">
        <h1 class="text-4xl font-bold mb-8">Daftar & Mulai Menyewa</h1>
        <ul class="space-y-4 text-lg">
            <li class="flex items-center"><span class="mr-3">•</span> Verifikasi KTP satu kali</li>
            <li class="flex items-center"><span class="mr-3">•</span> Cek stok per tanggal</li>
            <li class="flex items-center"><span class="mr-3">•</span> Pantau status pesanan</li>
        </ul>
    </div>

    <!-- Sisi Kanan: Form Registrasi -->
    <div class="w-full md:w-1/2 p-8 md:p-16 flex flex-col justify-center overflow-y-auto">
        <h2 class="text-2xl font-bold text-[#1a2b58] mb-6">Registrasi</h2>

        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Nama lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Nomor telepon</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('phone')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Konfirmasi password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>

            <!-- Area Upload KTP -->
            <div class="mt-6">
                <label
                    class="block w-full border-2 border-gray-300 border-dashed rounded-md p-6 text-center cursor-pointer bg-gray-50 hover:bg-gray-100">
                    <span class="text-gray-500 text-sm">Unggah foto KTP - Maks. 2 MB, format JPG/PNG</span>
                    <input type="file" name="ktp_path" accept=".jpg,.jpeg,.png" required class="hidden">
                </label>
                <p class="text-xs text-gray-500 mt-2">KTP diverifikasi manual oleh Admin.</p>
                @error('ktp_path')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center gap-4 mt-6">
                <button type="submit"
                    class="bg-[#27498c] hover:bg-blue-800 text-white font-semibold py-2 px-8 rounded-md transition">
                    Daftar
                </button>
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline text-sm">
                    Sudah punya akun? Login
                </a>
            </div>
        </form>
    </div>

</body>

</html>

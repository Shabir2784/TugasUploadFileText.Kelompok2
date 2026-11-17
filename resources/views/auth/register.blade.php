@extends('layouts.app')

@section('title', 'Registrasi - EventRent')

@section('content')
    <div class="flex-grow flex flex-col md:flex-row bg-white">
        <!-- Sisi Kiri: Panel Biru Navy Sesuai Mockup -->
        <div class="hidden md:flex md:w-5/12 lg:w-1/3 bg-[#1E3A8A] text-white p-12 lg:p-16 flex-col justify-center">
            <h1 class="text-3xl lg:text-4xl font-black mb-8 leading-tight">
                Daftar &amp; Mulai Menyewa
            </h1>
            <ul class="space-y-4 text-base lg:text-lg text-blue-100">
                <li class="flex items-center">
                    <span class="mr-3 text-[#F59E0B] font-bold">•</span> Verifikasi KTP satu kali
                </li>
                <li class="flex items-center">
                    <span class="mr-3 text-[#F59E0B] font-bold">•</span> Cek stok per tanggal
                </li>
                <li class="flex items-center">
                    <span class="mr-3 text-[#F59E0B] font-bold">•</span> Pantau status pesanan
                </li>
            </ul>
        </div>

        <!-- Sisi Kanan: Form Registrasi -->
        <div class="w-full md:w-7/12 lg:w-2/3 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            <div class="w-full max-w-lg mx-auto">
                <h2 class="text-2xl sm:text-3xl font-black text-[#1E3A8A] mb-6">Registrasi</h2>

                <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-800 mb-1">Nama lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                        @error('name')
                            <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-800 mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                        @error('email')
                            <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-800 mb-1">Nomor telepon</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                        @error('phone')
                            <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-800 mb-1">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                        @error('password')
                            <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-800 mb-1">Konfirmasi password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                    </div>

                    <!-- Area Upload KTP -->
                    <div class="pt-2">
                        <label for="ktp_input"
                            class="block w-full border-2 border-slate-300 border-dashed rounded-xl p-6 text-center cursor-pointer bg-slate-50 hover:bg-slate-100 transition">
                            <span id="ktp_filename" class="text-slate-500 text-sm">
                                Unggah foto KTP · Maks. 2 MB, format JPG/PNG
                            </span>
                            <input id="ktp_input" type="file" name="ktp_path" accept=".jpg,.jpeg,.png" required class="hidden">
                        </label>
                        <p class="text-xs text-slate-500 mt-2">KTP diverifikasi manual oleh Admin.</p>
                        @error('ktp_path')
                            <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-3">
                        <button type="submit"
                            class="bg-[#1E3A8A] hover:bg-blue-900 text-white font-bold py-2.5 px-8 rounded-xl transition shadow-sm">
                            Daftar
                        </button>
                        <a href="{{ route('login') }}" class="text-[#1E3A8A] font-semibold hover:underline text-sm">
                            Sudah punya akun? Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('ktp_input')?.addEventListener('change', function (e) {
            const label = document.getElementById('ktp_filename');
            if (e.target.files.length > 0) {
                label.textContent = 'File dipilih: ' + e.target.files[0].name;
                label.classList.remove('text-slate-500');
                label.classList.add('text-[#1E3A8A]', 'font-semibold');
            }
        });
    </script>
@endpush
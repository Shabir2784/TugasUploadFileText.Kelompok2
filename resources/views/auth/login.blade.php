@extends('layouts.app')

@section('title', 'Login - EventRent')

@section('content')
    <div class="flex-grow flex items-center justify-center px-4 py-12 bg-slate-50">
        <div class="w-full max-w-sm bg-white p-8 rounded-2xl shadow-md border border-slate-200/80 border-t-4 border-t-[#1E3A8A]">
            <h2 class="text-2xl font-black text-[#1E3A8A] mb-6 text-center">Login</h2>

            @if (session('success'))
                <div class="bg-amber-50 p-4 rounded-xl mb-6 border border-amber-200 text-center">
                    <span class="text-amber-800 font-bold text-xs bg-amber-200/80 px-3 py-1 rounded-full uppercase tracking-wide">
                        Menunggu Verifikasi KTP
                    </span>
                    <p class="text-slate-700 text-sm mt-3">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-800 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-800 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full border border-slate-300 rounded-xl p-2.5 text-sm focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                </div>

                @error('email')
                    <p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>
                @enderror

                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('password.request') }}"
                        class="text-[#1E3A8A] text-sm font-semibold hover:underline">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-[#1E3A8A] hover:bg-blue-900 text-white font-bold py-2.5 px-4 rounded-xl transition shadow-sm">
                    Login
                </button>
            </form>

            <!-- Opsi Registrasi -->
            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <p class="text-sm text-slate-600">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="inline-block mt-1 text-[#1E3A8A] font-bold hover:underline">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
@endsection
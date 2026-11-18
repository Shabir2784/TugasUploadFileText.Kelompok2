<header class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#1E3A8A] to-blue-600 flex items-center justify-center text-white font-extrabold shadow-md group-hover:scale-105 transition">
                    ER
                </div>
                <span class="text-2xl font-black bg-gradient-to-r from-[#1E3A8A] to-blue-700 bg-clip-text text-transparent tracking-tight">
                    EventRent
                </span>
            </a>

            {{-- Navigasi Desktop --}}
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold">
                <a href="{{ url('/') }}"
                    class="{{ request()->is('/') ? 'text-[#1E3A8A] border-b-2 border-[#1E3A8A] pb-1' : 'text-slate-600 hover:text-[#1E3A8A] transition' }}">
                    Beranda
                </a>
                <a href="{{ url('/katalog') }}"
                    class="{{ request()->is('katalog*') ? 'text-[#1E3A8A] border-b-2 border-[#1E3A8A] pb-1' : 'text-slate-600 hover:text-[#1E3A8A] transition' }}">
                    Katalog
                </a>
                <a href="{{ url('/#layanan') }}" class="text-slate-600 hover:text-[#1E3A8A] transition">Layanan</a>
                <a href="{{ url('/#cara-menyewa') }}" class="text-slate-600 hover:text-[#1E3A8A] transition">Cara Sewa</a>
                {{-- <a href="{{ url('/#kontak') }}" class="text-slate-600 hover:text-[#1E3A8A] transition">Kontak & Lokasi</a> --}}

                <a href="{{ url('/kontak') }}"
                class="{{ request()->is('kontak*') ? 'text-[#1E3A8A] border-b-2 border-[#1E3A8A] pb-1' : 'text-slate-600 hover:text-[#1E3A8A] transition' }}">
                Kontak & Lokasi
            </a>
                <a href="{{ url('/keranjang') }}"
                    class="flex items-center space-x-2 {{ request()->is('keranjang*') ? 'bg-amber-100 text-[#1E3A8A]' : 'text-slate-700 bg-slate-100 hover:bg-amber-100 hover:text-[#1E3A8A]' }} px-3.5 py-2 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>Keranjang</span>
                    <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-[#F59E0B] rounded-full shadow-sm">
                        {{ count(session('cart', [])) }}
                    </span>
                </a>
            </nav>

            {{-- Aksi Autentikasi --}}
            <div class="flex items-center space-x-3">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ url('/admin/dashboard') }}"
                            class="px-5 py-2.5 text-sm font-bold text-white bg-[#1E3A8A] rounded-xl shadow-md hover:bg-blue-900 transition transform hover:-translate-y-0.5">
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ url('/riwayat') }}"
                            class="text-sm font-semibold {{ request()->is('riwayat*') ? 'text-[#1E3A8A] underline' : 'text-slate-700 hover:text-[#1E3A8A]' }} hidden sm:inline transition">
                            Riwayat
                        </a>
                        <form action="{{ url('/logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 text-sm font-semibold text-rose-600 border border-rose-200 rounded-xl hover:bg-rose-50 transition">
                                Logout
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ url('/login') }}"
                        class="px-5 py-2.5 text-sm font-bold text-[#1E3A8A] bg-blue-50 border border-blue-200 rounded-xl hover:bg-[#1E3A8A] hover:text-white transition shadow-sm">
                        Masuk / Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
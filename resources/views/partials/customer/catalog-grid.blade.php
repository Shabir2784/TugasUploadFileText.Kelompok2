@if ($items->count() > 0)
    {{-- Grid Produk 3 Kolom Sesuai Mockup --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($items as $barang)
            <div class="bg-white rounded-2xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-xl hover:border-blue-300 transition-all duration-300 group">
                <div>
                    {{-- Foto Produk --}}
                    <div class="h-44 bg-slate-100 w-full overflow-hidden flex items-center justify-center relative">
                        @if ($barang->gambar)
                            <img src="{{ asset('storage/' . $barang->gambar) }}"
                                alt="{{ $barang->nama }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <span class="text-xs font-medium text-slate-400">Foto produk</span>
                        @endif
                    </div>

                    {{-- Info Produk --}}
                    <div class="p-5 pb-3">
                        <h3 class="text-base font-extrabold text-slate-900 line-clamp-1">
                            {{ $barang->nama }}
                        </h3>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">
                            {{ $barang->kategori->nama ?? 'Perlengkapan' }}
                        </p>
                        <p class="text-base font-black text-[#1E3A8A] mt-2.5">
                            Rp {{ number_format($barang->harga_per_hari, 0, ',', '.') }}<span class="text-xs font-semibold text-slate-600">/hari</span>
                        </p>
                    </div>
                </div>

                {{-- 2 Tombol Aksi Sesuai Mockup: Lihat Detail & + Pesanan --}}
                <div class="px-5 pb-5 pt-2 grid grid-cols-2 gap-2.5">
                    <a href="{{ url('/katalog/' . $barang->id) }}"
                        class="text-center py-2 px-3 text-xs font-bold text-[#1E3A8A] bg-white border border-[#1E3A8A] rounded-xl hover:bg-blue-50 transition">
                        Lihat Detail
                    </a>
                    <a href="{{ url('/katalog/' . $barang->id . '#form-sewa') }}"
                        class="text-center py-2 px-3 text-xs font-extrabold text-slate-900 bg-[#F59E0B] hover:bg-amber-400 rounded-xl shadow-sm transition">
                        + Pesanan
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Paginasi Kustom Sesuai Mockup (< 1 2 3 >) --}}
    @if ($items->hasPages())
        <div class="mt-10 flex justify-center">
            <nav aria-label="Navigasi Halaman Katalog" class="inline-flex items-center space-x-2">
                {{-- Tombol Previous (<) --}}
                @if ($items->onFirstPage())
                    <span class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed text-sm font-bold">
                        &lt;
                    </span>
                @else
                    <a href="{{ $items->previousPageUrl() }}" data-page-link
                        class="w-10 h-10 flex items-center justify-center rounded-xl border border-[#1E3A8A]/30 text-[#1E3A8A] bg-white hover:bg-blue-50 transition text-sm font-bold">
                        &lt;
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                    @if ($page == $items->currentPage())
                        <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-[#1E3A8A] text-white font-extrabold text-sm shadow-sm">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" data-page-link
                            class="w-10 h-10 flex items-center justify-center rounded-xl border border-[#1E3A8A]/30 text-[#1E3A8A] bg-white hover:bg-blue-50 transition text-sm font-bold">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Tombol Next (>) --}}
                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}" data-page-link
                        class="w-10 h-10 flex items-center justify-center rounded-xl border border-[#1E3A8A]/30 text-[#1E3A8A] bg-white hover:bg-blue-50 transition text-sm font-bold">
                        &gt;
                    </a>
                @else
                    <span class="w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 text-slate-300 cursor-not-allowed text-sm font-bold">
                        &gt;
                    </span>
                @endif
            </nav>
        </div>
    @endif
@else
    {{-- Empty State Sesuai Mockup & UC-05/UC-06 --}}
    <div class="bg-white border border-slate-200/90 rounded-2xl p-12 text-center flex flex-col items-center justify-center shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
        </div>

        @if ($totalAllItems === 0)
            <h3 class="text-base font-extrabold text-slate-900">Katalog masih kosong</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm">
                Belum ada perlengkapan acara yang tersedia saat ini. Silakan periksa kembali beberapa saat lagi.
            </p>
        @else
            <h3 class="text-base font-extrabold text-slate-900">Barang tidak ditemukan</h3>
            <p class="text-xs text-slate-500 mt-1 max-w-sm">
                Tidak ada perlengkapan yang cocok dengan kata kunci atau filter kategori yang Anda pilih.
            </p>
        @endif
    </div>
@endif
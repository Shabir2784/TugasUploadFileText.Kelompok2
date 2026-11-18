<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-2xl hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1.5">
    <div>
        <div class="h-48 bg-slate-100 w-full overflow-hidden flex items-center justify-center relative group">
            @if ($barang->gambar)
                <img src="{{ asset('storage/' . $barang->gambar) }}"
                    alt="{{ $barang->nama }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
                <span class="text-xs font-medium text-slate-400">Foto produk</span>
            @endif
            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
                Stok: {{ $barang->stok }}
            </span>
        </div>

        <div class="p-6">
            <span class="inline-block text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md mb-2">
                {{ $barang->kategori->nama ?? 'Perlengkapan' }}
            </span>
            <h4 class="text-base font-bold text-slate-900 line-clamp-1">{{ $barang->nama }}</h4>
            <p class="text-lg font-black text-[#1E3A8A] mt-2">
                Rp {{ number_format($barang->harga_per_hari, 0, ',', '.') }}
                <span class="text-xs font-normal text-slate-500">/ hari</span>
            </p>
        </div>
    </div>

    <div class="px-6 pb-6">
        <a href="{{ url('/katalog/' . $barang->id) }}"
            class="block w-full text-center py-2.5 px-4 text-sm font-bold text-[#1E3A8A] bg-blue-50 border border-blue-200 rounded-xl hover:bg-[#1E3A8A] hover:text-white transition shadow-sm">
            Lihat Detail & Sewa
        </a>
    </div>
</div>
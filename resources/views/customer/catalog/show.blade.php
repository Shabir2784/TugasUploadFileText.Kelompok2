@extends('layouts.app')

@section('title', $item->nama . ' - Detail Produk EventRent')

@section('content')
    <section class="py-8 lg:py-12 bg-slate-50 flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Breadcrumb Navigasi --}}
            <nav class="flex items-center space-x-2 text-xs font-semibold text-slate-500">
                <a href="{{ url('/') }}" class="hover:text-[#1E3A8A]">Beranda</a>
                <span>/</span>
                <a href="{{ route('catalog.index') }}" class="hover:text-[#1E3A8A]">Katalog</a>
                <span>/</span>
                <span class="text-[#1E3A8A]">{{ $item->nama }}</span>
            </nav>

            {{-- Banner Peringatan Login & Verifikasi KTP Sesuai Mockup & Bab V SDD --}}
            @guest
                <div class="bg-amber-50 border border-amber-200/90 rounded-2xl px-5 py-3.5 flex flex-wrap items-center justify-between gap-3">
                    <p class="text-sm text-slate-800">
                        Login dan verifikasi KTP diperlukan untuk memesan.
                        <a href="{{ route('login') }}" class="font-bold text-[#1E3A8A] hover:underline ml-1">
                            Login / Registrasi
                        </a>
                    </p>
                </div>
            @else
                @if (auth()->user()->peran === 'pelanggan' && auth()->user()->status_verifikasi !== 'terverifikasi')
                    <div class="bg-amber-50 border border-amber-200/90 rounded-2xl px-5 py-3.5 flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm text-slate-800">
                            Akun Anda berstatus <strong class="uppercase">{{ auth()->user()->status_verifikasi }}</strong>. Verifikasi KTP diperlukan sebelum mengajukan pesanan.
                            <a href="{{ url('/status-verifikasi') }}" class="font-bold text-[#1E3A8A] hover:underline ml-1">
                                Lihat Status Verifikasi
                            </a>
                        </p>
                    </div>
                @endif
            @endguest

            {{-- Flash Message Sukses / Error --}}
            @if (session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-3.5 rounded-2xl text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- GRID UTAMA 2 KOLOM SESUAI MOCKUP --}}
            <div class="bg-white rounded-3xl border border-slate-200/90 p-6 sm:p-8 lg:p-10 shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

                    {{-- KOLOM KIRI: Galeri Foto Produk (6 Kolom) --}}
                    <div class="lg:col-span-6">
                        <div class="w-full h-80 sm:h-96 lg:h-[430px] bg-slate-100 rounded-2xl overflow-hidden border border-slate-200/70 flex items-center justify-center">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                    alt="{{ $item->nama }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-slate-400 p-6">
                                    <svg class="w-14 h-14 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm font-medium">Galeri foto produk</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Detail & Box Formulir Sewa (6 Kolom) --}}
                    <div class="lg:col-span-6 space-y-5">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-black text-[#1E3A8A] tracking-tight">
                                {{ $item->nama }}
                            </h1>
                            <p class="text-sm font-semibold text-slate-500 mt-1">
                                {{ $item->kategori->nama ?? 'Perlengkapan Acara' }}
                            </p>
                        </div>

                        <p class="text-2xl font-black text-[#1E3A8A]">
                            Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}<span class="text-sm font-semibold text-slate-600">/hari</span>
                        </p>

                        <p class="text-sm text-slate-600 leading-relaxed">
                            {{ $item->deskripsi ?: 'Perlengkapan acara berkualitas tinggi dan terawat, siap mendukung kelancaran kebutuhan acara Anda.' }}
                        </p>

                        {{-- KOTAK FORMULIR SEWA & CEK STOK (#form-sewa) --}}
                        <div id="form-sewa" class="rounded-2xl border border-slate-200 p-5 sm:p-6 bg-slate-50/50 space-y-4">
                            <form id="add-to-cart-form" action="{{ url('/keranjang/tambah') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">

                                {{-- Input Tanggal Sewa (Mulai - Selesai) --}}
                                <div>
                                    <label class="block text-xs font-extrabold text-slate-800 mb-1.5">
                                        Tanggal sewa
                                    </label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <span class="block text-[11px] font-medium text-slate-500 mb-1">Tanggal mulai</span>
                                            <input type="date" id="start_date" name="start_date"
                                                value="{{ old('start_date', $defaultStart) }}"
                                                min="{{ now()->toDateString() }}"
                                                required
                                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A]">
                                        </div>
                                        <div>
                                            <span class="block text-[11px] font-medium text-slate-500 mb-1">Tanggal selesai</span>
                                            <input type="date" id="end_date" name="end_date"
                                                value="{{ old('end_date', $defaultEnd) }}"
                                                min="{{ old('start_date', $defaultStart) }}"
                                                required
                                                class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A]">
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-600 mt-2">
                                        Durasi: <strong id="duration-text">{{ $initialCheck['total_days'] }}</strong> hari
                                    </p>
                                </div>

                                {{-- Input Jumlah Unit --}}
                                <div>
                                    <label for="quantity" class="block text-xs font-extrabold text-slate-800 mb-1.5">
                                        Jumlah
                                    </label>
                                    <input type="number" id="quantity" name="quantity"
                                        value="{{ old('quantity', 1) }}"
                                        min="1"
                                        max="{{ max(1, $item->stok) }}"
                                        required
                                        class="w-full bg-white border border-slate-300 rounded-xl px-3.5 py-2 text-sm text-slate-800 focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A]">
                                </div>

                                {{-- PILL STATUS STOK (3 Variasi sesuai Mockup Bab IV) --}}
                                <div class="pt-1">
                                    {{-- 1. Pill Tersedia (Hijau) --}}
                                    <span id="badge-available"
                                        class="{{ $initialCheck['status'] === 'available' ? 'inline-flex' : 'hidden' }} items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        Tersedia: <span id="available-stock-count" class="mx-1">{{ $initialCheck['available_stock'] }}</span> unit
                                    </span>

                                    {{-- 2. Pill Stok Habis (Merah) --}}
                                    <div id="badge-out-of-stock"
                                        class="{{ $initialCheck['status'] === 'out_of_stock' ? 'block' : 'hidden' }} space-y-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800">
                                            Stok habis
                                        </span>
                                        <p class="text-xs text-slate-500">Formulir terkunci.</p>
                                    </div>

                                    {{-- 3. Pill Konflik Pesanan (Kuning) --}}
                                    <span id="badge-conflict"
                                        class="{{ $initialCheck['status'] === 'conflict' ? 'inline-flex' : 'hidden' }} items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                                        Barang sedang ditinjau pesanan lain
                                    </span>
                                </div>

                                {{-- Estimasi Total Biaya --}}
                                <p class="text-base font-extrabold text-slate-900">
                                    Estimasi total: <span id="estimated-total">{{ 'Rp ' . number_format($initialCheck['estimated_total'], 0, ',', '.') }}</span>
                                </p>

                                {{-- VARIASI TOMBOL AKSI 1 & 2 (Tersedia vs Stok Habis) --}}
                                <div id="action-normal"
                                    class="{{ $initialCheck['status'] !== 'conflict' ? 'grid' : 'hidden' }} grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                    <button type="submit" id="btn-add-cart"
                                        {{ $initialCheck['status'] === 'out_of_stock' ? 'disabled' : '' }}
                                        class="w-full py-2.5 px-4 rounded-xl text-sm font-extrabold transition
                                        {{ $initialCheck['status'] === 'out_of_stock'
                                            ? 'bg-white border border-slate-300 text-slate-400 cursor-not-allowed'
                                            : 'bg-[#F59E0B] hover:bg-amber-400 text-slate-900 shadow-sm' }}">
                                        Tambah ke Pesanan
                                    </button>
                                    <a href="{{ url('/keranjang') }}"
                                        class="w-full text-center py-2.5 px-4 rounded-xl text-sm font-bold text-[#1E3A8A] bg-white border border-[#1E3A8A] hover:bg-blue-50 transition">
                                        Lihat Keranjang
                                    </a>
                                </div>
                            </form>

                            {{-- VARIASI TOMBOL AKSI 3: KONFLIK PESANAN / ANTREAN (UC-11) --}}
                            <div id="action-conflict"
                                class="{{ $initialCheck['status'] === 'conflict' ? 'grid' : 'hidden' }} grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                <form action="{{ url('/antrean') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="start_date" id="queue_start_date" value="{{ $defaultStart }}">
                                    <input type="hidden" name="end_date" id="queue_end_date" value="{{ $defaultEnd }}">
                                    <input type="hidden" name="quantity" id="queue_quantity" value="1">
                                    <button type="submit"
                                        class="w-full py-2.5 px-4 rounded-xl text-sm font-bold text-white bg-[#1E3A8A] hover:bg-blue-900 transition shadow-sm">
                                        Masuk Antrean
                                    </button>
                                </form>

                                <a href="{{ route('catalog.index') }}"
                                    class="w-full text-center py-2.5 px-4 rounded-xl text-sm font-bold text-[#1E3A8A] bg-white border border-[#1E3A8A] hover:bg-blue-50 transition">
                                    Cari Barang Lain
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');
            const qtyInput = document.getElementById('quantity');

            const durationText = document.getElementById('duration-text');
            const estimatedTotal = document.getElementById('estimated-total');

            const badgeAvailable = document.getElementById('badge-available');
            const availableStockCount = document.getElementById('available-stock-count');
            const badgeOutOfStock = document.getElementById('badge-out-of-stock');
            const badgeConflict = document.getElementById('badge-conflict');

            const actionNormal = document.getElementById('action-normal');
            const btnAddCart = document.getElementById('btn-add-cart');
            const actionConflict = document.getElementById('action-conflict');

            const queueStart = document.getElementById('queue_start_date');
            const queueEnd = document.getElementById('queue_end_date');
            const queueQty = document.getElementById('queue_quantity');

            const checkStockUrl = "{{ route('catalog.check-stock', $item->id) }}";
            let debounceTimer;

            function syncQueueInputs() {
                if (queueStart) queueStart.value = startInput.value;
                if (queueEnd) queueEnd.value = endInput.value;
                if (queueQty) queueQty.value = qtyInput.value;
            }

            async function refreshAvailability() {
                // Pastikan tanggal selesai tidak lebih awal dari tanggal mulai
                if (endInput.value < startInput.value) {
                    endInput.value = startInput.value;
                }
                endInput.min = startInput.value;
                syncQueueInputs();

                const params = new URLSearchParams({
                    start_date: startInput.value,
                    end_date: endInput.value,
                    quantity: qtyInput.value || 1
                });

                try {
                    const response = await fetch(`${checkStockUrl}?${params.toString()}`, {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (!response.ok) return;
                    const data = await response.json();

                    durationText.textContent = data.total_days;
                    estimatedTotal.textContent = data.estimated_total_text;

                    // Reset semua tampilan status
                    badgeAvailable.classList.add('hidden');
                    badgeAvailable.classList.remove('inline-flex');
                    badgeOutOfStock.classList.add('hidden');
                    badgeConflict.classList.add('hidden');
                    badgeConflict.classList.remove('inline-flex');

                    if (data.status === 'available') {
                        badgeAvailable.classList.remove('hidden');
                        badgeAvailable.classList.add('inline-flex');
                        availableStockCount.textContent = data.available_stock;

                        actionNormal.classList.remove('hidden');
                        actionNormal.classList.add('grid');
                        actionConflict.classList.add('hidden');
                        actionConflict.classList.remove('grid');

                        btnAddCart.disabled = false;
                        btnAddCart.className = 'w-full py-2.5 px-4 rounded-xl text-sm font-extrabold transition bg-[#F59E0B] hover:bg-amber-400 text-slate-900 shadow-sm';
                    } else if (data.status === 'conflict') {
                        badgeConflict.classList.remove('hidden');
                        badgeConflict.classList.add('inline-flex');

                        actionNormal.classList.add('hidden');
                        actionNormal.classList.remove('grid');
                        actionConflict.classList.remove('hidden');
                        actionConflict.classList.add('grid');
                    } else {
                        badgeOutOfStock.classList.remove('hidden');

                        actionNormal.classList.remove('hidden');
                        actionNormal.classList.add('grid');
                        actionConflict.classList.add('hidden');
                        actionConflict.classList.remove('grid');

                        btnAddCart.disabled = true;
                        btnAddCart.className = 'w-full py-2.5 px-4 rounded-xl text-sm font-extrabold transition bg-white border border-slate-300 text-slate-400 cursor-not-allowed';
                    }
                } catch (error) {
                    console.error('Gagal memeriksa stok:', error);
                }
            }

            startInput.addEventListener('change', refreshAvailability);
            endInput.addEventListener('change', refreshAvailability);
            qtyInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(refreshAvailability, 250);
            });
        });
    </script>
@endpush


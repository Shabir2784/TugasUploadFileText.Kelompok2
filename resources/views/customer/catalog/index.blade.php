@extends('layouts.app')

@section('title', 'Katalog Perlengkapan - EventRent')

@section('content')
    <section class="py-10 lg:py-14 bg-slate-50 flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Judul Halaman Sesuai Mockup --}}
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-black text-[#1E3A8A] tracking-tight">
                    Katalog Perlengkapan
                </h1>
                <p class="text-sm text-slate-500 mt-1.5">
                    Pilih perlengkapan acara dan periksa ketersediaan stok sesuai tanggal acara Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- SIDEBAR FILTER KIRI (3 Kolom) --}}
                <aside class="lg:col-span-3 bg-white rounded-2xl border border-slate-200/90 p-6 shadow-sm sticky top-24">
                    <form id="catalog-filter-form" action="{{ route('catalog.index') }}" method="GET" class="space-y-6">
                        {{-- Pencarian Kata Kunci --}}
                        <div>
                            <label for="search-input" class="block text-sm font-extrabold text-slate-900 mb-2">
                                Cari barang
                            </label>
                            <div class="relative">
                                <input id="search-input" type="text" name="q" value="{{ $search ?? '' }}"
                                    placeholder="Ketik nama barang"
                                    autocomplete="off"
                                    class="w-full border border-slate-300 rounded-xl pl-3.5 pr-9 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#1E3A8A] focus:ring-1 focus:ring-[#1E3A8A] transition">
                                <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        {{-- Filter Kategori (4 Kategori Tetap SDD) --}}
                        <div>
                            <p class="text-sm font-extrabold text-slate-900 mb-3">Kategori</p>
                            @php
                                $daftarKategori = $categories->isNotEmpty()
                                    ? $categories->pluck('nama')->toArray()
                                    : ['Kursi', 'Meja', 'Tenda', 'Sound System'];
                            @endphp

                            <div class="space-y-2.5">
                                @foreach ($daftarKategori as $namaKategori)
                                    <label class="flex items-center space-x-2.5 cursor-pointer group">
                                        <input type="checkbox" name="kategori[]" value="{{ $namaKategori }}"
                                            {{ in_array($namaKategori, $selectedCategories ?? []) ? 'checked' : '' }}
                                            class="category-checkbox w-4 h-4 rounded border-slate-300 text-[#1E3A8A] focus:ring-[#1E3A8A] cursor-pointer">
                                        <span class="text-sm text-slate-700 group-hover:text-[#1E3A8A] transition">
                                            {{ $namaKategori }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Tombol Reset Filter Sesuai Mockup --}}
                        <div class="pt-1">
                            <button type="button" id="reset-filter-btn"
                                class="w-full py-2.5 px-4 text-sm font-bold text-[#1E3A8A] bg-white border border-[#1E3A8A] rounded-xl hover:bg-blue-50 transition">
                                Reset Filter
                            </button>
                        </div>
                    </form>
                </aside>

                {{-- AREA UTAMA KANAN: GRID KATALOG & PAGINASI (9 Kolom) --}}
                <div class="lg:col-span-9 relative">
                    {{-- Indikator Loading Halus Saat Filtering AJAX --}}
                    <div id="catalog-loading"
                        class="hidden absolute inset-0 bg-slate-50/70 backdrop-blur-[1px] z-10 rounded-2xl flex items-start justify-center pt-20">
                        <div class="inline-flex items-center space-x-2.5 bg-white px-4 py-2.5 rounded-xl shadow-md border border-slate-200 text-xs font-bold text-[#1E3A8A]">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Memuat perlengkapan...</span>
                        </div>
                    </div>

                    <div id="catalog-results">
                        @include('partials.customer.catalog-grid')
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('catalog-filter-form');
            const searchInput = document.getElementById('search-input');
            const checkboxes = document.querySelectorAll('.category-checkbox');
            const resetBtn = document.getElementById('reset-filter-btn');
            const resultsContainer = document.getElementById('catalog-results');
            const loadingOverlay = document.getElementById('catalog-loading');

            let debounceTimer;

            async function fetchCatalog(url) {
                loadingOverlay.classList.remove('hidden');

                try {
                    const response = await fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    });

                    if (response.ok) {
                        const html = await response.text();
                        resultsContainer.innerHTML = html;
                        window.history.replaceState({}, '', url);
                    }
                } catch (error) {
                    console.error('Gagal memuat katalog:', error);
                } finally {
                    loadingOverlay.classList.add('hidden');
                }
            }

            function buildFilterUrl() {
                const formData = new FormData(form);
                const params = new URLSearchParams();

                for (const [key, value] of formData.entries()) {
                    if (value.trim() !== '') {
                        params.append(key, value);
                    }
                }

                const queryString = params.toString();
                return queryString ? `${form.action}?${queryString}` : form.action;
            }

            // Pencarian real-time dengan debounce 350ms (UC-06)
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    fetchCatalog(buildFilterUrl());
                }, 350);
            });

            // Cegah reload penuh saat pengguna menekan Enter di kolom pencarian
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                fetchCatalog(buildFilterUrl());
            });

            // Filter langsung saat checkbox kategori dicentang/dihapus
            checkboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    fetchCatalog(buildFilterUrl());
                });
            });

            // Tombol Reset Filter (UC-06)
            resetBtn.addEventListener('click', function () {
                searchInput.value = '';
                checkboxes.forEach(cb => cb.checked = false);
                fetchCatalog(form.action);
            });

            // Paginasi tanpa reload halaman
            resultsContainer.addEventListener('click', function (e) {
                const link = e.target.closest('a[data-page-link]');
                if (link) {
                    e.preventDefault();
                    fetchCatalog(link.href);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });
        });
    </script>
@endpush
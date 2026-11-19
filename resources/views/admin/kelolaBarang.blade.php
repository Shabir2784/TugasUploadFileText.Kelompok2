@extends('layouts.admin')

@section('title', 'Kelola Barang')

@section('content')

@php
    $daftarBarang = $barangs ?? collect();
    $daftarKategori = $kategoris ?? collect();

    $totalBarang = $daftarBarang->count();
    $totalStok = $daftarBarang->sum('stok');
    $totalKategori = $daftarKategori->count();
@endphp

<div x-data="{
    pencarian: '',
    kategoriPilihan: 'semua',
    filterStok: 'semua'
}" class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Kelola Barang
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola inventaris barang, kategori, stok, dan harga sewa EventRent.
            </p>
        </div>

        @if(Route::has('admin.barang.create'))
            <a href="{{ route('admin.barang.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2">

                <svg class="size-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 5v14m-7-7h14"/>
                </svg>

                Tambah Barang
            </a>
        @endif
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

        {{-- Total Barang --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Jenis Barang
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($totalBarang, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400">
                        Barang terdaftar dalam inventaris
                    </p>
                </div>

                <div class="flex size-12 items-center justify-center rounded-xl bg-slate-100 text-blue-900">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m-8-14v10l8 4m0-10v10"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Stok --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Stok Barang
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($totalStok, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400">
                        Jumlah seluruh unit barang
                    </p>
                </div>

                <div class="flex size-12 items-center justify-center rounded-xl bg-slate-100 text-blue-900">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 7.5L12 3l8 4.5M4 7.5V17l8 4 8-4V7.5M12 11.5v9.5M8 5.2l8 4.5"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Kategori --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Kategori
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($totalKategori, 0, ',', '.') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-400">
                        Kategori barang tersedia
                    </p>
                </div>

                <div class="flex size-12 items-center justify-center rounded-xl bg-slate-100 text-blue-900">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL INVENTARIS --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Header tabel --}}
        <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
            <div class="flex flex-col gap-1">
                <h2 class="text-lg font-semibold text-slate-900">
                    Daftar Inventaris
                </h2>
                <p class="text-sm text-slate-500">
                    Informasi seluruh barang yang tersedia untuk disewakan.
                </p>
            </div>

            {{-- Pencarian & Filter --}}
            <div class="mt-5 flex flex-col gap-3 lg:flex-row">

                {{-- Search --}}
                <div class="relative flex-1">
                    <svg class="pointer-events-none absolute left-3 top-1/2 size-5 -translate-y-1/2 text-slate-400"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 21-4.3-4.3M19 10.5a8.5 8.5 0 1 1-17 0 8.5 8.5 0 0 1 17 0Z"/>
                    </svg>

                    <input type="text"
                           x-model="pencarian"
                           placeholder="Cari nama barang..."
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-10 pr-4 text-sm text-slate-700 placeholder:text-slate-400 transition focus:border-blue-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-900/10">
                </div>

                {{-- Filter kategori --}}
                <div class="w-full lg:w-56">
                    <select x-model="kategoriPilihan"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition focus:border-blue-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-900/10">

                        <option value="semua">Semua Kategori</option>

                        @foreach($daftarKategori as $kategori)
                            <option value="{{ $kategori->id }}">
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter stok --}}
                <div class="w-full lg:w-48">
                    <select x-model="filterStok"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 transition focus:border-blue-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-900/10">

                        <option value="semua">Semua Stok</option>
                        <option value="tersedia">Stok Tersedia</option>
                        <option value="habis">Stok Habis</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Isi tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left">
                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200">
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Barang
                        </th>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Kategori
                        </th>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Stok
                        </th>
                        <th class="px-5 py-4 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Harga Sewa / Hari
                        </th>
                        <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($daftarBarang as $barang)

                        <tr x-data="{
                                nama: @js(strtolower($barang->nama)),
                                kategori: @js((string) $barang->kategori_id),
                                stok: {{ (int) $barang->stok }}
                            }"
                            x-show="nama.includes(pencarian.toLowerCase())
                                && (kategoriPilihan === 'semua' || kategori === kategoriPilihan)
                                && (filterStok === 'semua' || (filterStok === 'tersedia' && stok > 0) || (filterStok === 'habis' && stok <= 0))"
                            class="transition hover:bg-slate-50/80">

                            {{-- Barang --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-14 shrink-0 overflow-hidden rounded-xl border border-slate-200 bg-slate-100">
                                        @if($barang->gambar)
                                            <img src="{{ asset('storage/' . $barang->gambar) }}"
                                                 alt="{{ $barang->nama }}"
                                                 class="size-full object-cover"
                                                 loading="lazy">
                                        @else
                                            <div class="flex size-full items-center justify-center text-slate-400">
                                                <svg class="size-6" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M4 5h16v14H4zM8 9h.01M20 15l-5-5-7 7"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-800">
                                            {{ $barang->nama }}
                                        </p>
                                        <p class="mt-0.5 max-w-xs truncate text-xs text-slate-400">
                                            {{ $barang->deskripsi ?: 'Tidak ada deskripsi' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-medium text-slate-600">
                                    {{ $barang->kategori->nama ?? 'Tidak berkategori' }}
                                </span>
                            </td>

                            {{-- Stok --}}
                            <td class="px-5 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-sm font-semibold text-slate-800">
                                        {{ number_format($barang->stok, 0, ',', '.') }} unit
                                    </span>

                                    @if($barang->stok > 0)
                                        <span class="text-xs text-slate-500">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="text-xs font-medium text-slate-500">
                                            Stok habis
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Harga --}}
                            <td class="px-5 py-4">
                                <p class="text-sm font-semibold text-slate-800">
                                    Rp{{ number_format($barang->harga_per_hari, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-slate-400">
                                    per unit / hari
                                </p>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    @if(Route::has('admin.barang.edit'))
                                        <a href="{{ route('admin.barang.edit', $barang->id) }}"
                                           class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-medium text-slate-600 transition hover:border-blue-900 hover:bg-slate-50 hover:text-blue-900"
                                           title="Edit barang">

                                            <svg class="size-4" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m16.5 4.5 3 3M4 20l4.5-1 11-11a2.1 2.1 0 0 0-3-3l-11 11L4 20Z"/>
                                            </svg>

                                            Edit
                                        </a>
                                    @endif

                                    @if(Route::has('admin.barang.destroy'))
                                        <form action="{{ route('admin.barang.destroy', $barang->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Apakah kamu yakin ingin menghapus barang ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-medium text-slate-600 transition hover:border-slate-400 hover:bg-slate-100"
                                                    title="Hapus barang">

                                                <svg class="size-4" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>
                                                </svg>

                                                Hapus
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                    <svg class="size-8" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M4 7.5L12 3l8 4.5M4 7.5V17l8 4 8-4V7.5M12 11.5v9.5"/>
                                    </svg>
                                </div>

                                <h3 class="mt-4 text-sm font-semibold text-slate-800">
                                    Belum ada barang
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Barang inventaris belum ditambahkan ke dalam sistem.
                                </p>

                                @if(Route::has('admin.barang.create'))
                                    <a href="{{ route('admin.barang.create') }}"
                                       class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800">
                                        Tambah Barang Pertama
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse

                    {{-- Pesan jika filter tidak menemukan hasil --}}
                    @if($totalBarang > 0)
                        <tr x-show="!$el.parentElement.querySelector('tr[x-data]:not([style*=&quot;display: none&quot;])')"
                            class="hidden">
                            <td colspan="5"></td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

        {{-- Footer tabel --}}
        @if($totalBarang > 0)
            <div class="flex flex-col gap-2 border-t border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500">
                    Total <span class="font-semibold text-slate-700">{{ $totalBarang }}</span>
                    jenis barang terdaftar.
                </p>
                <p class="text-xs text-slate-400">
                    Data inventaris EventRent
                </p>
            </div>
        @endif
    </div>
</div>

@endsection
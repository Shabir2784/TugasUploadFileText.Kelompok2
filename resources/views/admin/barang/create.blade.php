
@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route('admin.barang.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-blue-900">
            <svg class="size-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m15 18-6-6 6-6"/>
            </svg>
            Kembali ke Kelola Barang
        </a>

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-slate-900">
            Tambah Barang
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Masukkan informasi barang yang akan ditambahkan ke inventaris EventRent.
        </p>
    </div>

    {{-- Form --}}
    <form action="{{ route('admin.barang.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        @csrf

        {{-- Informasi barang --}}
        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Informasi Barang
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Lengkapi informasi dasar barang.
            </p>
        </div>

        <div class="space-y-5 p-6">

            {{-- Nama barang --}}
            <div>
                <label for="nama" class="mb-2 block text-sm font-medium text-slate-700">
                    Nama Barang <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       id="nama"
                       name="nama"
                       value="{{ old('nama') }}"
                       placeholder="Contoh: Tenda Kerucut"
                       required
                       class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10">

                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori_id" class="mb-2 block text-sm font-medium text-slate-700">
                    Kategori Barang <span class="text-red-500">*</span>
                </label>

                <select id="kategori_id"
                        name="kategori_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10">

                    <option value="">Pilih kategori barang</option>

                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>

                @error('kategori_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="mb-2 block text-sm font-medium text-slate-700">
                    Deskripsi Barang
                </label>

                <textarea id="deskripsi"
                          name="deskripsi"
                          rows="4"
                          placeholder="Tuliskan deskripsi atau keterangan barang..."
                          class="w-full resize-y rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition placeholder:text-slate-400 focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10">{{ old('deskripsi') }}</textarea>

                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stok dan harga --}}
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div>
                    <label for="stok" class="mb-2 block text-sm font-medium text-slate-700">
                        Jumlah Stok <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <input type="number"
                               id="stok"
                               name="stok"
                               value="{{ old('stok') }}"
                               min="0"
                               placeholder="Contoh: 20"
                               required
                               class="w-full rounded-xl border border-slate-200 px-4 py-3 pr-14 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10">

                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400">
                            Unit
                        </span>
                    </div>

                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_per_hari" class="mb-2 block text-sm font-medium text-slate-700">
                        Harga Sewa per Hari <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                            Rp
                        </span>

                        <input type="number"
                               id="harga_per_hari"
                               name="harga_per_hari"
                               value="{{ old('harga_per_hari') }}"
                               min="0"
                               step="0.01"
                               placeholder="Contoh: 150000"
                               required
                               class="w-full rounded-xl border border-slate-200 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-900/10">
                    </div>

                    @error('harga_per_hari')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Foto barang --}}
        <div class="border-t border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-900">
                Foto Barang
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Tambahkan foto untuk memudahkan pelanggan mengenali barang.
            </p>

            <div class="mt-4">
                <label for="gambar" class="mb-2 block text-sm font-medium text-slate-700">
                    Unggah Gambar
                </label>

                <input type="file"
                       id="gambar"
                       name="gambar"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="block w-full cursor-pointer rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-900 file:px-4 file:py-3 file:font-medium file:text-white hover:file:bg-blue-800">

                <p class="mt-2 text-xs text-slate-400">
                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </p>

                @error('gambar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex flex-col-reverse justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row">

            <a href="{{ route('admin.barang.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                Batal
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2">

                <svg class="size-4" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 13l4 4L19 7"/>
                </svg>

                Simpan Barang
            </button>
        </div>

    </form>
</div>
@endsection

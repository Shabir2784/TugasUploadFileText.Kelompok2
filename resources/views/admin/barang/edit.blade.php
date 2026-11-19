
@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Edit Barang
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Perbarui informasi barang yang tersedia untuk disewakan.
            </p>
        </div>

        <a href="{{ route('admin.barang.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
            <span>&larr;</span>
            Kembali
        </a>
    </div>

    {{-- Form --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h2 class="text-base font-semibold text-slate-800">
                Informasi Barang
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Silakan periksa dan ubah data barang sesuai kebutuhan.
            </p>
        </div>

        <form action="{{ route('admin.barang.update', $barang) }}"
              method="POST"
              enctype="multipart/form-data"
              class="p-6 space-y-6">

            @csrf
            @method('PUT')

            {{-- Nama Barang --}}
            <div>
                <label for="nama" class="mb-2 block text-sm font-medium text-slate-700">
                    Nama Barang <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       id="nama"
                       name="nama"
                       value="{{ old('nama', $barang->nama) }}"
                       placeholder="Masukkan nama barang"
                       required
                       class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">

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
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">

                    <option value="">Pilih kategori barang</option>

                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
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
                          placeholder="Masukkan deskripsi barang"
                          class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('deskripsi', $barang->deskripsi) }}</textarea>

                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stok dan Harga --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                <div>
                    <label for="stok" class="mb-2 block text-sm font-medium text-slate-700">
                        Stok Barang <span class="text-red-500">*</span>
                    </label>

                    <input type="number"
                           id="stok"
                           name="stok"
                           value="{{ old('stok', $barang->stok) }}"
                           min="0"
                           required
                           class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">

                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga_per_hari" class="mb-2 block text-sm font-medium text-slate-700">
                        Harga Sewa per Hari (Rp) <span class="text-red-500">*</span>
                    </label>

                    <input type="number"
                           id="harga_per_hari"
                           name="harga_per_hari"
                           value="{{ old('harga_per_hari', $barang->harga_per_hari) }}"
                           min="0"
                           step="0.01"
                           required
                           class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-100">

                    @error('harga_per_hari')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Gambar Saat Ini --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Gambar Saat Ini
                </label>

                @if ($barang->gambar)
                    <div class="inline-block rounded-lg border border-slate-200 bg-slate-50 p-2">
                        <img src="{{ asset('storage/' . $barang->gambar) }}"
                             alt="{{ $barang->nama }}"
                             class="h-40 w-48 rounded-md object-cover"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                        <p class="hidden p-4 text-sm text-red-600">
                            Gambar tidak dapat ditampilkan.
                        </p>
                    </div>
                @else
                    <div class="flex h-40 w-48 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 text-sm text-slate-400">
                        Belum ada gambar
                    </div>
                @endif
            </div>

            {{-- Ganti Gambar --}}
            <div>
                <label for="gambar" class="mb-2 block text-sm font-medium text-slate-700">
                    Ganti Gambar Barang
                </label>

                <input type="file"
                       id="gambar"
                       name="gambar"
                       accept=".jpg,.jpeg,.png,.webp"
                       class="block w-full rounded-lg border border-slate-300 text-sm text-slate-600 file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-3 file:font-medium file:text-slate-700 hover:file:bg-slate-200">

                <p class="mt-2 text-xs text-slate-500">
                    Kosongkan jika tidak ingin mengganti gambar. Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                </p>

                @error('gambar')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('admin.barang.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-blue-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-800 transition">
                    Simpan Perubahan
                </button>

            </div>

        </form>
    </div>
</div>
@endsection

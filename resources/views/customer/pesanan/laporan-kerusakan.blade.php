@extends('layouts.app')

@section('title', 'Form Laporan Kerusakan ' . $pemesanan->kode_pemesanan . ' - EventRent')

@section('content')
@php
    $singleDetail = $pemesanan->detailPemesanans->first();
    $singleBarang = $singleDetail?->barang;
    $singleNamaBarang = $singleBarang?->nama ?? $singleBarang?->nama_barang ?? ($singleDetail ? 'Barang #' . $singleDetail->barang_id : '-');
@endphp

<style>
    @keyframes erFormFadeUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .er-form-animate {
        animation: erFormFadeUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
</style>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6 er-form-animate">
    <div>
        <a href="{{ route('pesanan.show', $pemesanan) }}"
            class="inline-flex items-center gap-2 text-sm sm:text-base font-bold text-[#1E3A8A] hover:text-[#0F172A] transition">
            <span>&larr;</span>
            <span>Kembali ke Detail Pesanan</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl bg-rose-50 border border-rose-300 px-5 py-4 text-sm sm:text-base text-rose-900 shadow-xs">
            <p class="font-bold mb-1">Periksa kembali inputan form:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-md overflow-hidden">
        <div class="relative px-6 sm:px-8 py-6 bg-gradient-to-r from-[#0F172A] via-[#1E3A8A] to-[#0F172A] text-white border-b-4 border-[#F59E0B] overflow-hidden">
            <div class="pointer-events-none -right-10 -top-10 h-36 w-36 rounded-full bg-[#F59E0B]/15 blur-2xl absolute"></div>
            <div class="relative">
                <p class="text-xs font-extrabold uppercase tracking-widest text-[#F59E0B]">
                    Pesanan {{ $pemesanan->kode_pemesanan }}
                </p>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-1">
                    Form Laporan Kerusakan
                </h1>
                <p class="text-sm sm:text-base text-slate-200 mt-1.5">
                    Barang disewa: <strong class="text-white">{{ $singleNamaBarang }}</strong>
                    @if ($singleDetail)
                        ({{ $singleDetail->jumlah }} unit)
                    @endif
                </p>
            </div>
        </div>

        <form action="{{ route('pesanan.laporan-kerusakan', $pemesanan) }}" method="POST" enctype="multipart/form-data"
            class="p-6 sm:p-8 space-y-6">
            @csrf

            @if ($singleDetail)
                <input type="hidden" name="detail_pemesanan_id" value="{{ $singleDetail->id }}">
            @endif

            <div>
                <label for="keterangan" class="block text-base font-bold text-slate-900 mb-2">
                    Keterangan Kerusakan
                </label>
                <textarea id="keterangan" name="keterangan" rows="5" required
                    placeholder="Jelaskan secara detail bagian barang yang rusak atau bermasalah..."
                    class="w-full bg-white border border-slate-300 rounded-xl px-4 py-3 text-base text-slate-900 transition focus:outline-none focus:border-[#1E3A8A] focus:ring-2 focus:ring-[#1E3A8A]/20">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-sm font-semibold text-rose-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-base font-bold text-slate-900 mb-2">
                    Foto Bukti Kerusakan (Opsional)
                </label>
                <label for="foto_kerusakan"
                    class="group flex flex-col items-center justify-center w-full min-h-36 bg-slate-50 hover:bg-amber-50/60 border-2 border-dashed border-slate-300 hover:border-[#F59E0B] rounded-2xl cursor-pointer transition p-4 text-center">
                    <span id="foto-label-text" class="text-base font-bold text-slate-700 group-hover:text-slate-950 transition">
                        Unggah foto · Maks. 5 MB
                    </span>
                    <span class="text-sm text-slate-500 mt-1">
                        Klik untuk memilih file gambar (JPG, PNG, WEBP)
                    </span>
                    <img id="foto-preview-img" src="" alt="Preview Bukti Kerusakan"
                        class="hidden mt-3 max-h-44 w-auto rounded-xl border border-slate-200 object-contain shadow-xs">
                    <input id="foto_kerusakan" name="foto" type="file" accept="image/*" class="hidden">
                </label>
                @error('foto')
                    <p class="text-sm font-semibold text-rose-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2 flex flex-wrap items-center gap-3">
                <button type="submit"
                    class="px-6 py-3 rounded-xl text-base font-extrabold text-slate-950 bg-[#F59E0B] hover:bg-amber-400 active:scale-[0.98] transition shadow-sm cursor-pointer">
                    Kirim Laporan
                </button>

                <a href="{{ route('pesanan.show', $pemesanan) }}"
                    class="px-5 py-3 rounded-xl text-base font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('foto_kerusakan');
        const labelText = document.getElementById('foto-label-text');
        const previewImg = document.getElementById('foto-preview-img');

        if (fileInput && labelText) {
            fileInput.addEventListener('change', function () {
                if (this.files && this.files.length > 0) {
                    const file = this.files[0];
                    labelText.textContent = 'File dipilih: ' + file.name;

                    if (previewImg && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                            previewImg.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                } else {
                    labelText.textContent = 'Unggah foto · Maks. 5 MB';
                    if (previewImg) {
                        previewImg.src = '';
                        previewImg.classList.add('hidden');
                    }
                }
            });
        }
    });
</script>
@endsection
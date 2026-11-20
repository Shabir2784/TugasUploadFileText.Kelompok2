@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $pemesanan->kode_pemesanan . ' - EventRent')

@section('content')
@php
    $statusMap = [
        'menunggu' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-amber-100 text-amber-950 border-amber-300', 'step' => 1],
        'disetujui' => ['label' => 'Disetujui', 'class' => 'bg-sky-100 text-sky-950 border-sky-300', 'step' => 2],
        'aktif' => ['label' => 'Sedang Disewa', 'class' => 'bg-blue-100 text-blue-950 border-blue-300', 'step' => 3],
        'selesai' => ['label' => 'Selesai', 'class' => 'bg-emerald-100 text-emerald-950 border-emerald-300', 'step' => 4],
        'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-rose-100 text-rose-950 border-rose-300', 'step' => 0],
    ];
    $statusInfo = $statusMap[$pemesanan->status] ?? [
        'label' => ucfirst($pemesanan->status ?? 'Menunggu'),
        'class' => 'bg-slate-100 text-slate-900 border-slate-300',
        'step' => 1,
    ];
    $currentStep = $statusInfo['step'];

    $tanggalMulai = \Carbon\Carbon::parse($pemesanan->tanggal_mulai)->translatedFormat('d M Y');
    $tanggalSelesai = \Carbon\Carbon::parse($pemesanan->tanggal_selesai)->translatedFormat('d M Y');

    $singleDetail = $pemesanan->detailPemesanans->first();
    $singleBarang = $singleDetail?->barang;
    $singleNamaBarang = $singleBarang?->nama ?? $singleBarang?->nama_barang ?? ($singleDetail ? 'Barang #' . $singleDetail->barang_id : '-');

    $rawImg = $singleBarang?->foto ?? $singleBarang?->gambar ?? $singleBarang?->image ?? $singleBarang?->thumbnail ?? null;
    if ($rawImg && \Illuminate\Support\Str::startsWith($rawImg, ['http://', 'https://'])) {
        $imgUrl = $rawImg;
    } elseif ($rawImg) {
        $cleanPath = ltrim($rawImg, '/');
        $imgUrl = \Illuminate\Support\Str::startsWith($cleanPath, 'storage/')
            ? asset($cleanPath)
            : asset('storage/' . $cleanPath);
    } else {
        $imgUrl = null;
    }

    $steps = [
        1 => 'Menunggu Konfirmasi',
        2 => 'Disetujui',
        3 => 'Sedang Disewa',
        4 => 'Selesai',
    ];
@endphp

<style>
    @keyframes erFadeUp {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes erModalIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(8px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .er-animate-card {
        animation: erFadeUp 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .er-animate-item {
        animation: erFadeUp 0.65s cubic-bezier(0.22, 1, 0.36, 1) 0.12s both;
    }

    .er-modal-box {
        animation: erModalIn 0.25s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    .er-hover-lift {
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }

    .er-hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px -10px rgba(15, 23, 42, 0.14);
    }
</style>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
    @if (session('success'))
        <div class="er-animate-card flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-300 px-5 py-4 text-base font-bold text-emerald-950 shadow-sm">
            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-white text-sm shrink-0">
                ✓
            </span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="er-animate-card bg-white rounded-3xl border border-slate-200/90 shadow-md overflow-hidden">
        <div class="relative px-6 sm:px-8 py-7 bg-gradient-to-br from-[#0F172A] via-[#1E3A8A] to-[#0F172A] text-white border-b-4 border-[#F59E0B] overflow-hidden">
            <div class="pointer-events-none -right-12 -top-12 h-44 w-44 rounded-full bg-[#F59E0B]/15 blur-2xl absolute"></div>
            <div class="pointer-events-none -left-10 -bottom-16 h-40 w-40 rounded-full bg-sky-400/10 blur-2xl absolute"></div>

            <div class="relative flex flex-wrap items-center justify-between gap-4">
                <div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-[#F59E0B] text-slate-950 shadow-xs">
                        <span class="h-2 w-2 rounded-full bg-slate-950 animate-ping"></span>
                        Detail Pesanan
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-2.5">
                        {{ $pemesanan->kode_pemesanan }}
                    </h1>
                </div>

                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-extrabold border shadow-xs {{ $statusInfo['class'] }}">
                    <span class="h-2.5 w-2.5 rounded-full bg-current opacity-80"></span>
                    {{ $statusInfo['label'] }}
                </span>
            </div>

            @if ($pemesanan->status !== 'dibatalkan')
                <div class="relative mt-7 pt-5 border-t border-white/15">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach ($steps as $stepNum => $stepLabel)
                            @php
                                $isDone = $currentStep > $stepNum;
                                $isCurrent = $currentStep === $stepNum;
                            @endphp
                            <div class="flex items-center gap-2.5 rounded-xl px-3 py-2 {{ $isCurrent ? 'bg-white/15 ring-1 ring-[#F59E0B]' : ($isDone ? 'bg-white/10' : 'bg-white/5 opacity-60') }}">
                                <span class="h-6 w-6 rounded-full text-xs font-extrabold flex items-center justify-center shrink-0 {{ $isCurrent ? 'bg-[#F59E0B] text-slate-950' : ($isDone ? 'bg-emerald-400 text-slate-950' : 'bg-white/20 text-white') }}">
                                    {{ $isDone ? '✓' : $stepNum }}
                                </span>
                                <span class="text-xs sm:text-sm font-bold truncate">
                                    {{ $stepLabel }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="p-6 sm:p-8 space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="er-hover-lift p-4 rounded-2xl bg-slate-50 border border-slate-200/90">
                    <p class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Penyewa</p>
                    <p class="text-base font-extrabold text-slate-900 mt-1.5">
                        {{ $pemesanan->user->name ?? auth()->user()->name ?? 'Pelanggan' }}
                    </p>
                    <p class="text-sm text-slate-600 mt-0.5 truncate">
                        {{ $pemesanan->user->email ?? auth()->user()->email ?? '-' }}
                    </p>
                </div>

                <div class="er-hover-lift p-4 rounded-2xl bg-slate-50 border border-slate-200/90">
                    <p class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Tanggal Sewa</p>
                    <p class="text-base font-extrabold text-slate-900 mt-1.5">
                        {{ $tanggalMulai }}
                    </p>
                    <p class="text-sm text-slate-600 mt-0.5">
                        s.d. {{ $tanggalSelesai }}
                    </p>
                </div>

                <div class="er-hover-lift p-4 rounded-2xl bg-slate-50 border border-slate-200/90">
                    <p class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Durasi Sewa</p>
                    <p class="text-base font-extrabold text-[#1E3A8A] mt-1.5">
                        {{ $pemesanan->total_hari }} Hari
                    </p>
                    <p class="text-sm text-slate-600 mt-0.5">
                        {{ $singleDetail?->jumlah ?? 1 }} Unit Disewa
                    </p>
                </div>

                <div class="er-hover-lift p-4 rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100/70 border border-amber-300/80 flex flex-col justify-center">
                    <p class="text-xs font-extrabold uppercase tracking-wider text-amber-900">Total Tagihan</p>
                    <p class="text-xl sm:text-2xl font-black text-[#0F172A] mt-1">
                        Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="er-animate-item space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900">
                        Barang yang Dipesan
                    </h2>
                    @if ($imgUrl)
                        <span class="text-xs sm:text-sm font-semibold text-slate-500">
                            Klik foto untuk memperbesar
                        </span>
                    @endif
                </div>

                @if ($singleDetail)
                    <div class="er-hover-lift p-5 rounded-2xl border border-slate-200 bg-gradient-to-r from-slate-50/80 via-white to-amber-50/30 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                        <div class="flex items-center gap-5">
                            <button type="button"
                                @if ($imgUrl) onclick="openBarangModal('{{ $imgUrl }}', '{{ addslashes($singleNamaBarang) }}')" @endif
                                class="group relative w-28 h-28 rounded-2xl bg-white border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center shadow-xs {{ $imgUrl ? 'cursor-zoom-in' : 'cursor-default' }}">
                                @if ($imgUrl)
                                    <img src="{{ $imgUrl }}" alt="{{ $singleNamaBarang }}"
                                        class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <span class="hidden text-xs font-semibold text-slate-400 px-2 text-center">
                                        No Photo
                                    </span>
                                    <span class="absolute inset-x-0 bottom-0 bg-slate-950/65 text-white text-[11px] font-bold py-1 opacity-0 group-hover:opacity-100 transition-opacity text-center">
                                        Perbesar
                                    </span>
                                @else
                                    <span class="text-xs font-semibold text-slate-400 px-2 text-center">
                                        No Photo
                                    </span>
                                @endif
                            </button>

                            <div class="space-y-2">
                                <h3 class="text-lg sm:text-xl font-extrabold text-slate-900">
                                    {{ $singleNamaBarang }}
                                </h3>
                                <div class="flex flex-wrap items-center gap-2.5 text-sm text-slate-700">
                                    <span class="px-3 py-1 rounded-lg bg-[#1E3A8A]/10 border border-[#1E3A8A]/20 font-extrabold text-[#1E3A8A]">
                                        {{ $singleDetail->jumlah }} Unit
                                    </span>
                                    <span>
                                        Harga Sewa: <strong class="text-slate-900">Rp {{ number_format($singleDetail->harga_per_hari, 0, ',', '.') }}</strong> / hari
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="sm:text-right pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-200 shrink-0">
                            <span class="block text-xs font-extrabold uppercase tracking-wider text-slate-500">Subtotal</span>
                            <span class="text-xl sm:text-2xl font-black text-[#1E3A8A] mt-0.5 block">
                                Rp {{ number_format($singleDetail->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50 text-center text-base text-slate-500">
                        Tidak ada barang pada pesanan ini.
                    </div>
                @endif
            </div>

            <div class="pt-6 border-t border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900">Konfirmasi Pengembalian Barang</h3>
                    <p class="text-sm text-slate-600 mt-0.5">
                        Konfirmasi barang dalam kondisi baik atau buka halaman form pelaporan kerusakan.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <form action="{{ route('pesanan.kondisi-baik', $pemesanan) }}" method="POST"
                        onsubmit="return confirm('Konfirmasi bahwa seluruh barang sudah diterima dan dalam kondisi baik?');">
                        @csrf
                        <button type="submit"
                            class="px-5 py-3 rounded-xl text-sm sm:text-base font-extrabold text-white bg-[#1E3A8A] hover:bg-[#172554] active:scale-[0.98] transition shadow-sm cursor-pointer">
                            Barang Kondisi Baik
                        </button>
                    </form>

                    <a href="{{ route('pesanan.laporan-kerusakan.create', $pemesanan) }}"
                        class="px-5 py-3 rounded-xl text-sm sm:text-base font-extrabold text-slate-950 bg-[#F59E0B] hover:bg-amber-400 active:scale-[0.98] transition shadow-sm">
                        Laporkan Kerusakan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="barangImageModal"
    onclick="closeBarangModal()"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/75 backdrop-blur-xs p-4">
    <div onclick="event.stopPropagation()"
        class="er-modal-box bg-white rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl border border-slate-200">
        <div class="px-5 py-4 bg-[#0F172A] text-white flex items-center justify-between">
            <h3 id="modalBarangTitle" class="text-base sm:text-lg font-extrabold truncate">Pratinjau Barang</h3>
            <button type="button" onclick="closeBarangModal()"
                class="h-8 w-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-sm font-bold cursor-pointer">
                ✕
            </button>
        </div>
        <div class="p-5 bg-slate-100 flex items-center justify-center max-h-[75vh]">
            <img id="modalBarangImg" src="" alt="" class="max-h-[68vh] w-auto rounded-2xl object-contain shadow-sm">
        </div>
    </div>
</div>

<script>
    function openBarangModal(src, title) {
        const modal = document.getElementById('barangImageModal');
        const img = document.getElementById('modalBarangImg');
        const caption = document.getElementById('modalBarangTitle');
        if (!modal || !img) return;
        img.src = src;
        img.alt = title || 'Barang';
        if (caption) caption.textContent = title || 'Pratinjau Barang';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeBarangModal() {
        const modal = document.getElementById('barangImageModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeBarangModal();
        }
    });
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Pemesanan Masuk')

@section('content')
<div class="space-y-6">

    {{-- Header Halaman --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Pemesanan Masuk
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola dan pantau pemesanan barang dari pelanggan.
            </p>
        </div>

        <div class="flex items-center gap-2 text-sm text-slate-500">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </span>
            <span>Data Pemesanan</span>
        </div>
    </div>

    {{-- Informasi --}}
    <div class="rounded-xl border border-blue-100 bg-blue-50 p-4">
        <div class="flex gap-3">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 shrink-0 text-blue-900"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />
            </svg>
            <div>
                <p class="text-sm font-semibold text-blue-900">
                    Informasi Pemesanan
                </p>
                <p class="mt-1 text-sm text-blue-800">
                    Halaman ini menampilkan daftar pemesanan pelanggan,
                    termasuk informasi barang, tanggal penyewaan,
                    jumlah hari, total harga, dan status pemesanan.
                </p>
            </div>
        </div>
    </div>

    {{-- Filter Status --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <form action="{{ route('admin.pesanan.index') }}"
              method="GET"
              class="flex flex-col gap-4 sm:flex-row sm:items-end">

            <div class="flex-1">
                <label for="status"
                       class="mb-2 block text-sm font-semibold text-slate-700">
                    Filter Status Pemesanan
                </label>

                <select name="status"
                        id="status"
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-900 focus:ring-2 focus:ring-blue-100">
                    <option value="">Semua Status</option>
                    <option value="menunggu" @selected(request('status') === 'menunggu')>
                        Menunggu
                    </option>
                    <option value="disetujui" @selected(request('status') === 'disetujui')>
                        Disetujui
                    </option>
                    <option value="ditolak" @selected(request('status') === 'ditolak')>
                        Ditolak
                    </option>
                    <option value="berlangsung" @selected(request('status') === 'berlangsung')>
                        Berlangsung
                    </option>
                    <option value="selesai" @selected(request('status') === 'selesai')>
                        Selesai
                    </option>
                    <option value="dibatalkan" @selected(request('status') === 'dibatalkan')>
                        Dibatalkan
                    </option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2l-7 8v6l-4 2v-8L3 6V4z" />
                    </svg>
                    Terapkan
                </button>

                <a href="{{ route('admin.pesanan.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel Pemesanan --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-2 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800">
                    Daftar Pemesanan
                </h2>
                <p class="mt-1 text-xs text-slate-500">
                    Data pemesanan yang tercatat dalam sistem.
                </p>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-900">
                {{ $pemesanans->total() }} Pemesanan
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1050px] text-left">
                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Kode Pemesanan</th>
                        <th class="px-5 py-4">Pelanggan</th>
                        <th class="px-5 py-4">Tanggal Penyewaan</th>
                        <th class="px-5 py-4">Durasi</th>
                        <th class="px-5 py-4">Total Harga</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-center">Detail</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($pemesanans as $index => $pemesanan)

                        @php
                            $statusTampilan = [
                                'menunggu' => [
                                    'label' => 'Menunggu',
                                    'class' => 'bg-amber-50 text-amber-700 ring-amber-200',
                                ],
                                'disetujui' => [
                                    'label' => 'Disetujui',
                                    'class' => 'bg-blue-50 text-blue-700 ring-blue-200',
                                ],
                                'ditolak' => [
                                    'label' => 'Ditolak',
                                    'class' => 'bg-red-50 text-red-700 ring-red-200',
                                ],
                                'berlangsung' => [
                                    'label' => 'Berlangsung',
                                    'class' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
                                ],
                                'selesai' => [
                                    'label' => 'Selesai',
                                    'class' => 'bg-green-50 text-green-700 ring-green-200',
                                ],
                                'dibatalkan' => [
                                    'label' => 'Dibatalkan',
                                    'class' => 'bg-slate-100 text-slate-600 ring-slate-200',
                                ],
                            ];

                            $status = $statusTampilan[$pemesanan->status] ?? [
                                'label' => ucfirst($pemesanan->status),
                                'class' => 'bg-slate-100 text-slate-600 ring-slate-200',
                            ];
                        @endphp

                        <tr class="transition hover:bg-slate-50">
                            <td class="px-5 py-4 text-sm text-slate-500">
                                {{ $pemesanans->firstItem() + $index }}
                            </td>

                            <td class="px-5 py-4">
                                <span class="text-sm font-bold text-blue-900">
                                    {{ $pemesanan->kode_pemesanan }}
                                </span>
                                <p class="mt-1 text-xs text-slate-400">
                                    {{ $pemesanan->created_at?->format('d/m/Y H:i') }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $pemesanan->user?->nama ?? 'Pelanggan tidak tersedia' }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $pemesanan->user?->email ?? '-' }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <p class="text-sm font-medium text-slate-700">
                                    {{ $pemesanan->tanggal_mulai?->format('d/m/Y') }}
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    s.d. {{ $pemesanan->tanggal_selesai?->format('d/m/Y') }}
                                </p>
                            </td>

                            <td class="px-5 py-4">
                                <span class="text-sm font-semibold text-slate-700">
                                    {{ $pemesanan->total_hari }} Hari
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <span class="text-sm font-bold text-slate-800">
                                    Rp {{ number_format((float) $pemesanan->total_harga, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                <button type="button"
                                        @click="$dispatch('buka-detail-pemesanan', { id: {{ $pemesanan->id }} })"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-blue-900 hover:bg-blue-50 hover:text-blue-900">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat
                                </button>
                            </td>
                        </tr>

                        {{-- Detail Pemesanan --}}
                        <tr
                            x-data="{ terbuka: false }"
                            x-on:buka-detail-pemesanan.window="if ($event.detail.id === {{ $pemesanan->id }}) terbuka = !terbuka"
                            x-show="terbuka"
                            x-cloak
                        >
                            <td colspan="8" class="bg-slate-50 px-5 py-5">

                                <div class="rounded-xl border border-slate-200 bg-white p-5">

                                    <div class="mb-4 flex items-center justify-between">
                                        <h3 class="text-sm font-bold text-slate-800">
                                            Detail Barang Pesanan
                                        </h3>

                                        <button type="button"
                                                @click="terbuka = false"
                                                class="text-sm font-medium text-slate-500 hover:text-red-600">
                                            Tutup
                                        </button>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="w-full min-w-[550px] text-left">
                                            <thead>
                                                <tr class="border-b border-slate-200 text-xs font-semibold uppercase text-slate-500">
                                                    <th class="py-3 pr-4">Nama Barang</th>
                                                    <th class="px-4 py-3">Jumlah</th>
                                                    <th class="px-4 py-3">Harga / Hari</th>
                                                    <th class="px-4 py-3">Subtotal</th>
                                                </tr>
                                            </thead>

                                            <tbody class="divide-y divide-slate-100">
                                                @forelse ($pemesanan->detailPemesanans as $detail)
                                                    <tr>
                                                        <td class="py-3 pr-4 text-sm font-medium text-slate-700">
                                                            {{ $detail->barang?->nama ?? 'Barang tidak tersedia' }}
                                                        </td>

                                                        <td class="px-4 py-3 text-sm text-slate-600">
                                                            {{ $detail->jumlah }}
                                                        </td>

                                                        <td class="px-4 py-3 text-sm text-slate-600">
                                                            Rp {{ number_format((float) $detail->harga_per_hari, 0, ',', '.') }}
                                                        </td>

                                                        <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                                                            Rp {{ number_format((float) $detail->subtotal, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="py-5 text-center text-sm text-slate-500">
                                                            Belum ada detail barang pada pemesanan ini.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if ($pemesanan->status === 'ditolak' && $pemesanan->alasan_penolakan)
                                        <div class="mt-4 rounded-lg border border-red-100 bg-red-50 p-4">
                                            <p class="text-xs font-bold uppercase text-red-700">
                                                Alasan Penolakan
                                            </p>
                                            <p class="mt-1 text-sm text-red-700">
                                                {{ $pemesanan->alasan_penolakan }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="mt-5 flex justify-end border-t border-slate-100 pt-4">
                                        <div class="text-right">
                                            <p class="text-xs text-slate-500">
                                                Total Pembayaran Pemesanan
                                            </p>
                                            <p class="mt-1 text-lg font-bold text-blue-900">
                                                Rp {{ number_format((float) $pemesanan->total_harga, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-16 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-7 w-7 text-slate-400"
                                         fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>

                                <h3 class="mt-4 text-sm font-bold text-slate-800">
                                    Belum Ada Data Pemesanan
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    @if (request('status'))
                                        Tidak ditemukan pemesanan dengan status tersebut.
                                    @else
                                        Data pemesanan pelanggan akan ditampilkan di sini.
                                    @endif
                                </p>

                                @if (request('status'))
                                    <a href="{{ route('admin.pesanan.index') }}"
                                       class="mt-4 inline-flex text-sm font-semibold text-blue-900 hover:underline">
                                        Tampilkan Semua Pemesanan
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($pemesanans->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $pemesanans->links() }}
            </div>
        @endif

    </div>

</div>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard')

@php
    // ---- Data dummy: ganti dengan data dari DashboardController (compact / with) ----
    $stats = $stats ?? [
        ['label' => 'Pesanan baru',            'value' => 12,  'note' => '4 masuk hari ini',      'route' => 'admin.pesanan.index'],
        ['label' => 'KTP menunggu verifikasi', 'value' => 7,   'note' => 'Terlama 2 hari lalu',   'route' => 'admin.ktp.index'],
        ['label' => 'Barang disewa',           'value' => 186, 'note' => 'Dari 9 pesanan aktif',  'route' => 'admin.barang.index'],
        ['label' => 'Laporan kerusakan',       'value' => 3,   'note' => '1 perlu tindak lanjut', 'route' => 'admin.kerusakan.index'],
    ];

    $tren = $tren ?? [
        ['label' => 'Mei', 'value' => 34], ['label' => 'Jun', 'value' => 52], ['label' => 'Jul', 'value' => 41],
        ['label' => 'Agu', 'value' => 68], ['label' => 'Sep', 'value' => 47], ['label' => 'Okt', 'value' => 74],
        ['label' => 'Nov', 'value' => 58],
    ];
    $trenMax = max(array_column($tren, 'value'));

    $jadwalSewa = $jadwalSewa ?? [
        now()->copy()->addDays(-5)->toDateString() => [['klien' => 'Gathering PT Sinar Abadi', 'barang' => 'Sound System 2000W']],
        now()->copy()->addDays(1)->toDateString()  => [['klien' => 'Pernikahan Rina & Dimas',  'barang' => 'Tenda Roder 5x10m, 200 Kursi Futura']],
        now()->copy()->addDays(3)->toDateString()  => [['klien' => 'Seminar PT Nusa Karya',    'barang' => 'Sound System 2000W, 80 Kursi Futura']],
        now()->copy()->addDays(4)->toDateString()  => [['klien' => 'Arisan Keluarga Hartono',  'barang' => '10 Meja Prasmanan']],
        now()->copy()->addDays(8)->toDateString()  => [
            ['klien' => 'Wisuda SMAN 3',     'barang' => 'Tenda Roder 5x10m x2, Sound System 2000W'],
            ['klien' => 'Syukuran Bu Wulan', 'barang' => '50 Kursi Futura, 5 Meja Prasmanan'],
        ],
        now()->copy()->addDays(15)->toDateString() => [['klien' => 'Bazar Kampus UNIKA', 'barang' => '12 Tenda Roder 5x10m']],
    ];

    $inventaris = $inventaris ?? [
        ['barang' => 'Kursi Futura',        'kategori' => 'Kursi',        'stok' => 240, 'status' => 'Tersedia'],
        ['barang' => 'Meja Prasmanan',      'kategori' => 'Meja',         'stok' => 6,   'status' => 'Menipis'],
        ['barang' => 'Tenda Roder 5x10m',   'kategori' => 'Tenda',        'stok' => 0,   'status' => 'Habis'],
        ['barang' => 'Sound System 2000W',  'kategori' => 'Sound System', 'stok' => 8,   'status' => 'Tersedia'],
        ['barang' => 'Kursi Chiavari Emas', 'kategori' => 'Kursi',        'stok' => 120, 'status' => 'Tersedia'],
    ];
@endphp

@section('content')
    {{-- Header + filter Periode --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <h1 class="text-2xl font-bold text-blue-900">Dashboard</h1>

        <form method="GET" action="{{ url()->current() }}" class="relative w-full sm:w-72"
              x-data="{
                  open: false,
                  start: '{{ request('start') }}',
                  end: '{{ request('end') }}',
                  show(s) { return new Date(s + 'T00:00:00').toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) },
                  iso(d) { return d.toLocaleDateString('sv-SE') },
                  preset(days) { const e = new Date(), s = new Date(); s.setDate(e.getDate() - days + 1); this.start = this.iso(s); this.end = this.iso(e) },
                  thisMonth() { const n = new Date(); this.start = this.iso(new Date(n.getFullYear(), n.getMonth(), 1)); this.end = this.iso(n) },
                  get text() { return this.start && this.end ? this.show(this.start) + ' – ' + this.show(this.end) : '' },
                  get valid() { return this.start && this.end && this.start <= this.end }
              }"
              @click.outside="open = false" @keydown.escape="open = false">
            <label for="periode" class="mb-1 block text-xs font-semibold text-slate-900">Periode</label>
            <input type="hidden" name="start" :value="start">
            <input type="hidden" name="end" :value="end">
            <button type="button" id="periode" @click="open = !open" :aria-expanded="open.toString()"
                    class="flex w-full items-center justify-between rounded-lg border border-slate-300 bg-white px-3 py-2 text-left text-sm transition duration-150 hover:border-slate-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900">
                <span :class="text ? 'text-slate-900 tabular-nums' : 'text-slate-400'" x-text="text || 'Pilih rentang tanggal'"></span>
                <svg class="size-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/>
                </svg>
            </button>

            <div x-show="open" x-cloak
                 x-transition:enter="transition duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="absolute right-0 z-10 mt-2 w-full rounded-lg border border-slate-200 bg-white p-4 shadow-lg sm:w-80">
                <div class="flex flex-wrap gap-2">
                    <button type="button" @click="preset(7)"  class="rounded-md border border-slate-200 px-2.5 py-1 text-xs font-medium text-slate-700 transition duration-150 hover:bg-slate-50">7 hari terakhir</button>
                    <button type="button" @click="preset(30)" class="rounded-md border border-slate-200 px-2.5 py-1 text-xs font-medium text-slate-700 transition duration-150 hover:bg-slate-50">30 hari terakhir</button>
                    <button type="button" @click="thisMonth()" class="rounded-md border border-slate-200 px-2.5 py-1 text-xs font-medium text-slate-700 transition duration-150 hover:bg-slate-50">Bulan ini</button>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-3">
                    <div>
                        <label for="tgl-mulai" class="mb-1 block text-xs text-slate-500">Dari</label>
                        <input id="tgl-mulai" type="date" x-model="start" class="w-full rounded-md border border-slate-300 px-2 py-1.5 text-sm tabular-nums focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900">
                    </div>
                    <div>
                        <label for="tgl-akhir" class="mb-1 block text-xs text-slate-500">Sampai</label>
                        <input id="tgl-akhir" type="date" x-model="end" :min="start" class="w-full rounded-md border border-slate-300 px-2 py-1.5 text-sm tabular-nums focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900">
                    </div>
                </div>
                <p x-show="start && end && !valid" x-cloak class="mt-2 text-xs text-rose-700">Tanggal akhir harus sama atau setelah tanggal mulai.</p>
                <div class="mt-4 flex items-center justify-between">
                    <a href="{{ url()->current() }}" class="text-xs font-medium text-slate-500 hover:text-slate-900">Atur ulang</a>
                    <button type="submit" :disabled="!valid"
                            class="rounded-lg bg-blue-900 px-3.5 py-1.5 text-sm font-semibold text-white transition duration-150 hover:bg-blue-800 disabled:cursor-not-allowed disabled:opacity-40">
                        Terapkan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Baris 1: KPI --}}
    <section class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan">
        @foreach ($stats as $stat)
            <a href="{{ Route::has($stat['route']) ? route($stat['route']) : '#' }}"
               class="rounded-xl border border-slate-200/80 bg-white p-5 transition duration-150 hover:border-slate-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900">
                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-bold tracking-tight text-blue-900 tabular-nums">{{ number_format($stat['value'], 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $stat['note'] }}</p>
            </a>
        @endforeach
    </section>

    {{-- Baris 2: Tren + Kalender (7:5) --}}
    <section class="mt-4 grid grid-cols-1 gap-4 lg:grid-cols-12">
        <div class="rounded-xl border border-slate-200/80 bg-white p-5 lg:col-span-7">
            <div class="flex items-baseline justify-between gap-2">
                <h2 class="text-sm font-bold text-slate-900">Tren Penyewaan</h2>
                <p class="text-xs text-slate-500">Jumlah pesanan per bulan, 2026</p>
            </div>

            <div class="mt-6 flex h-52 gap-3 border-b border-slate-200">
                @foreach ($tren as $bar)
                    <div class="group flex h-full flex-1 flex-col justify-end">
                        <span class="mb-1 text-center text-xs font-medium text-slate-600 tabular-nums">{{ $bar['value'] }}</span>
                        <div class="w-full rounded-t-md bg-blue-900 transition duration-150 group-hover:bg-blue-800"
                             style="height: {{ round($bar['value'] / $trenMax * 85) }}%"
                             title="{{ $bar['label'] }}: {{ $bar['value'] }} pesanan"></div>
                    </div>
                @endforeach
            </div>
            <div class="mt-2 flex gap-3">
                @foreach ($tren as $bar)
                    <span class="flex-1 text-center text-xs text-slate-500">{{ $bar['label'] }}</span>
                @endforeach
            </div>
        </div>

        <div class="rounded-xl border border-slate-200/80 bg-white p-5 lg:col-span-5"
             x-data="{
                 year: {{ now()->year }}, month: {{ now()->month - 1 }}, selected: null,
                 today: '{{ now()->toDateString() }}',
                 events: @js($jadwalSewa),
                 names: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
                 get label() { return this.names[this.month] + ' ' + this.year },
                 get cells() {
                     const offset = (new Date(this.year, this.month, 1).getDay() + 6) % 7;
                     const total = new Date(this.year, this.month + 1, 0).getDate();
                     return [...Array(offset).fill(null), ...Array.from({ length: total }, (_, i) => i + 1)];
                 },
                 key(d) { return this.year + '-' + String(this.month + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0') },
                 has(d) { return !!this.events[this.key(d)] },
                 prev() { this.month === 0 ? (this.month = 11, this.year--) : this.month--; this.selected = null },
                 next() { this.month === 11 ? (this.month = 0, this.year++) : this.month++; this.selected = null },
                 pick(d) { this.selected = this.selected === d ? null : d }
             }">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-900">Jadwal Sewa</h2>
                <div class="flex items-center gap-1">
                    <button type="button" @click="prev()" class="rounded-md p-1.5 text-slate-500 transition duration-150 hover:bg-slate-100 hover:text-slate-900" aria-label="Bulan sebelumnya">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <span class="min-w-28 text-center text-sm font-medium text-slate-900 tabular-nums" x-text="label" aria-live="polite"></span>
                    <button type="button" @click="next()" class="rounded-md p-1.5 text-slate-500 transition duration-150 hover:bg-slate-100 hover:text-slate-900" aria-label="Bulan berikutnya">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-7 gap-y-1 text-center text-xs text-slate-500">
                @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $hari)
                    <span class="pb-1 font-medium">{{ $hari }}</span>
                @endforeach

                <template x-for="(d, i) in cells" :key="i">
                    <div class="flex justify-center">
                        <template x-if="d">
                            <button type="button" @click="pick(d)"
                                    :aria-label="d + ' ' + label + (has(d) ? ', ada jadwal sewa' : '')"
                                    :class="[
                                        selected === d ? 'bg-blue-900 text-white' : 'text-slate-700 hover:bg-slate-100',
                                        key(d) === today && selected !== d ? 'ring-1 ring-blue-900 font-semibold' : ''
                                    ]"
                                    class="relative flex size-9 items-center justify-center rounded-lg text-sm tabular-nums transition duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-900">
                                <span x-text="d"></span>
                                <span x-show="has(d)" class="absolute bottom-1 size-1 rounded-full bg-amber-500"></span>
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            <div class="mt-4 border-t border-slate-200 pt-3 text-sm" aria-live="polite">
                <template x-if="selected && has(selected)">
                    <ul class="space-y-2">
                        <template x-for="e in events[key(selected)]" :key="e.klien">
                            <li>
                                <p class="font-medium text-slate-900" x-text="e.klien"></p>
                                <p class="text-xs text-slate-500" x-text="e.barang"></p>
                            </li>
                        </template>
                    </ul>
                </template>
                <p x-show="selected && !has(selected)" x-cloak class="text-xs text-slate-500">Tidak ada jadwal sewa pada tanggal ini.</p>
                <p x-show="!selected" class="flex items-center gap-2 text-xs text-slate-500">
                    <span class="size-1.5 shrink-0 rounded-full bg-amber-500"></span> Tanggal bertitik punya jadwal sewa. Pilih tanggal untuk melihat detail.
                </p>
            </div>
        </div>
    </section>

    {{-- Baris 3: Status Inventaris --}}
    <section class="mt-4 rounded-xl border border-slate-200/80 bg-white p-5">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-bold text-slate-900">Status Inventaris</h2>
            <a href="{{ Route::has('admin.barang.index') ? route('admin.barang.index') : '#' }}" class="text-xs font-medium text-blue-900 hover:underline">Kelola barang</a>
        </div>

        <div class="-mx-5 mt-3 overflow-x-auto px-5">
            <table class="w-full min-w-[32rem] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-900">
                        <th scope="col" class="py-2.5 pr-4 font-semibold">Barang</th>
                        <th scope="col" class="py-2.5 pr-4 font-semibold">Kategori</th>
                        <th scope="col" class="py-2.5 pr-4 text-right font-semibold">Stok</th>
                        <th scope="col" class="py-2.5 pl-8 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($inventaris as $item)
                        <tr class="transition duration-150 hover:bg-slate-50">
                            <td class="py-3 pr-4 font-medium text-slate-900">{{ $item['barang'] }}</td>
                            <td class="py-3 pr-4 text-slate-600">{{ $item['kategori'] }}</td>
                            <td class="py-3 pr-4 text-right text-slate-900 tabular-nums">{{ number_format($item['stok'], 0, ',', '.') }}</td>
                            <td class="py-3 pl-8">@include('partials.shared.status-badge', ['status' => $item['status']])</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-sm text-slate-500">Belum ada barang. Tambahkan barang di menu Kelola Barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
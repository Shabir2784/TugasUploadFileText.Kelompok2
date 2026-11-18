@php
    $menu = [
        ['label' => 'Dashboard',         'route' => 'admin.dashboard',        'match' => 'admin.dashboard'],
        ['label' => 'Verifikasi KTP',    'route' => 'admin.ktp.index',        'match' => 'admin.ktp.*'],
        ['label' => 'Pemesanan Masuk',   'route' => 'admin.pesanan.index',    'match' => 'admin.pesanan.*'],
        ['label' => 'Kelola Barang',     'route' => 'admin.barang.index',     'match' => 'admin.barang.*'],
        ['label' => 'Laporan Kerusakan', 'route' => 'admin.kerusakan.index',  'match' => 'admin.kerusakan.*'],
    ];
@endphp

{{-- Overlay mobile --}}
<div x-show="sidebarOpen" x-cloak
     x-transition:enter="transition-opacity duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"
     @click="sidebarOpen = false" aria-hidden="true"></div>

<aside class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-blue-900 transition-transform duration-150"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       aria-label="Navigasi admin">

    <div class="flex h-16 items-center justify-between px-5 lg:h-20">
        <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" class="text-lg font-bold text-white">EventRent Admin</a>
        <button type="button" class="rounded-lg p-1.5 text-blue-200 transition duration-150 hover:bg-blue-800 hover:text-white lg:hidden"
                @click="sidebarOpen = false" aria-label="Tutup menu">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-2">
        @foreach ($menu as $item)
            @php $active = request()->routeIs($item['match']); @endphp
            <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
               @if ($active) aria-current="page" @endif
               class="block rounded-lg px-3 py-2.5 text-sm transition duration-150 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400
                      {{ $active ? 'bg-amber-500 font-semibold text-slate-900' : 'font-medium text-blue-100 hover:bg-blue-800 hover:text-white' }}">
                {{ $item['label'] }}
            </a>
        @endforeach

        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
            @csrf
            <button type="submit"
                    class="block w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-blue-100 transition duration-150 hover:bg-blue-800 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400">
                Logout
            </button>
        </form>
    </nav>
</aside>
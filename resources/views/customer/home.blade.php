@extends('layouts.app')

@section('title', 'EventRent - Sewa Perlengkapan Acara Terpercaya')

@push('styles')
    <style>
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>
@endpush

@section('content')
    <!-- 1. HERO SECTION -->
    <section class="relative bg-gradient-to-b from-white via-blue-50/40 to-slate-50 py-16 lg:py-24 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-60 -left-40 w-96 h-96 bg-amber-400/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6 space-y-6">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                        <span>Platform Rental Peralatan Acara #1 di Majene</span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-[#1E3A8A] leading-tight tracking-tight">
                        Wujudkan Acara Sempurna Tanpa Repot
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                        Penyewaan kursi, meja, tenda, dan sound system berkualitas tinggi dengan pengecekan stok
                        real-time. Solusi terpadu untuk pernikahan, seminar, hingga hajatan kampus.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ url('/katalog') }}"
                            class="px-7 py-3.5 text-base font-bold text-white bg-[#1E3A8A] rounded-xl shadow-lg shadow-blue-900/20 hover:bg-blue-900 transition transform hover:-translate-y-0.5">
                            Jelajahi Katalog
                        </a>
                        <a href="#cara-menyewa"
                            class="px-7 py-3.5 text-base font-bold text-[#1E3A8A] bg-white border-2 border-[#1E3A8A]/20 rounded-xl hover:border-[#1E3A8A] hover:bg-blue-50/50 transition shadow-sm">
                            Pelajari Cara Sewa
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-6 relative">
                    <div class="relative w-full h-80 sm:h-96 lg:h-[420px] rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-slate-200 group">
                        <img src="{{ asset('images/hero-event.jpeg') }}"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            alt="Set Perlengkapan Acara EventRent"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        <div class="hidden w-full h-full flex-col items-center justify-center text-slate-400 p-6 text-center">
                            <svg class="w-16 h-16 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium">Foto Set Acara</span>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -left-6 bg-white/90 backdrop-blur-md p-5 rounded-2xl shadow-xl border border-slate-100 hidden sm:flex items-center space-x-4 animate-float">
                        <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-xl shadow-md">
                            ⚡
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold uppercase">Status Stok</p>
                            <p class="text-sm font-extrabold text-slate-900">Real-Time Terintegrasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. LAYANAN KAMI -->
    <section id="layanan" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <h2 class="text-xs font-bold uppercase tracking-widest text-[#F59E0B] mb-2">Fasilitas Unggulan</h2>
                <h3 class="text-3xl sm:text-4xl font-black text-[#1E3A8A]">Kategori Layanan Kami</h3>
                <p class="text-slate-600 mt-2 text-sm sm:text-base">Pilihan perlengkapan lengkap siap sedia untuk
                    menyukseskan berbagai skala acara Anda.</p>
            </div>

            @php
                $layanan = [
                    [
                        'nama' => 'Kursi',
                        'deskripsi' => 'Kursi futura, lipat, & sarung kursi elegan',
                        'ikon' => 'M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12v7a1 1 0 001 1h2m10-8v7a1 1 0 01-1 1h-2',
                    ],
                    [
                        'nama' => 'Meja',
                        'deskripsi' => 'Meja bundar, prasmanan, & meja tamu eksklusif',
                        'ikon' => 'M3 10h18M4 10v8m16-8v8M2 10h20',
                    ],
                    [
                        'nama' => 'Tenda',
                        'deskripsi' => 'Tenda roder, kerucut, & dekorasi mewah',
                        'ikon' => 'M3 20l9-14 9 14H3zm9-14v14',
                    ],
                    [
                        'nama' => 'Sound System',
                        'deskripsi' => 'Speaker aktif berkualitas tinggi & mikrofon jernih',
                        'ikon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z',
                    ],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($layanan as $item)
                    <a href="{{ url('/katalog?kategori=' . urlencode($item['nama'])) }}"
                        class="bg-slate-50/80 rounded-2xl p-8 border border-slate-200/80 shadow-sm hover:shadow-xl hover:border-[#1E3A8A] hover:bg-white transition-all duration-300 transform hover:-translate-y-1.5 group text-center flex flex-col items-center">
                        <div class="w-16 h-16 bg-blue-100/60 rounded-2xl mb-5 flex items-center justify-center group-hover:bg-[#1E3A8A] group-hover:text-white text-[#1E3A8A] transition-all duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $item['ikon'] }}" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 group-hover:text-[#1E3A8A] transition">{{ $item['nama'] }}</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">{{ $item['deskripsi'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3. CARA MENYEWA -->
    <section id="cara-menyewa" class="py-20 bg-gradient-to-b from-slate-50 via-blue-50/20 to-slate-50 border-y border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <h2 class="text-xs font-bold uppercase tracking-widest text-[#F59E0B] mb-2">Prosedur Mudah</h2>
                <h3 class="text-3xl sm:text-4xl font-black text-[#1E3A8A]">5 Langkah Cara Menyewa</h3>
                <p class="text-slate-600 mt-2 text-sm sm:text-base">Proses pemesanan transparan dan cepat langsung
                    dari perangkat Anda.</p>
            </div>

            @php
                $langkahSewa = [
                    ['no' => 1, 'judul' => 'Cari Barang', 'ket' => 'Telusuri katalog kursi, meja, tenda, atau sound system sesuai kebutuhan.'],
                    ['no' => 2, 'judul' => 'Cek Stok', 'ket' => 'Pilih tanggal acara untuk verifikasi ketersediaan stok real-time.'],
                    ['no' => 3, 'judul' => 'Daftar & KTP', 'ket' => 'Buat akun dan unggah foto KTP untuk validasi identitas peminjam.'],
                    ['no' => 4, 'judul' => 'Ajukan Pesanan', 'ket' => 'Masukkan ke keranjang belanja dan kirimkan pengajuan sewa.'],
                    ['no' => 5, 'judul' => 'Gunakan & Selesai', 'ket' => 'Terima perlengkapan di lokasi acara dan kembalikan tepat waktu.'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                @foreach ($langkahSewa as $step)
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-6 text-center flex flex-col items-center shadow-md hover:shadow-xl hover:border-amber-400 transition-all duration-300 group">
                        <span class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-[#F59E0B] text-white font-black text-base flex items-center justify-center mb-4 shadow-md group-hover:scale-110 transition duration-300">
                            0{{ $step['no'] }}
                        </span>
                        <h4 class="text-base font-bold text-slate-900 mb-2 group-hover:text-[#1E3A8A] transition">{{ $step['judul'] }}</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $step['ket'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. PRODUK PILIHAN -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <h2 class="text-xs font-bold uppercase tracking-widest text-[#F59E0B] mb-2">Katalog Unggulan</h2>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#1E3A8A]">Produk Pilihan</h3>
                </div>
                <a href="{{ url('/katalog') }}"
                    class="mt-4 md:mt-0 text-sm font-bold text-[#1E3A8A] hover:text-blue-700 inline-flex items-center space-x-1 group">
                    <span>Lihat Semua Katalog</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($produkPilihan as $barang)
                    @include('partials.customer.product-card', ['barang' => $barang])
                @empty
                    <div class="col-span-full bg-slate-50 border border-slate-200 rounded-2xl p-12 text-center text-slate-500 shadow-sm">
                        <p class="font-semibold text-base">Belum ada produk yang ditambahkan ke katalog.</p>
                        <p class="text-xs text-slate-400 mt-1">Silakan tambahkan data produk melalui panel admin atau seeder.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. TENTANG KAMI -->
    <section class="py-20 bg-slate-50 border-t border-slate-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <div class="lg:col-span-6">
                    <div class="w-full h-72 sm:h-80 bg-slate-200 rounded-3xl overflow-hidden flex items-center justify-center border-4 border-white shadow-xl group">
                        <img src="{{ asset('images/tentang-kami.jpeg') }}"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            alt="Tim dan Gudang EventRent"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="hidden w-full h-full flex-col items-center justify-center text-slate-400 p-6 text-center">
                            <svg class="w-12 h-12 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="text-sm font-medium">Foto Tim / Gudang</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 space-y-5">
                    <h2 class="text-xs font-bold uppercase tracking-widest text-[#F59E0B]">Mengenal Lebih Dekat</h2>
                    <h3 class="text-3xl sm:text-4xl font-black text-[#1E3A8A]">Tentang EventRent</h3>
                    <p class="text-slate-600 leading-relaxed text-base">
                        <strong>EventRent</strong> adalah platform penyewaan perlengkapan acara berbasis web modern
                        yang dirancang untuk mengatasi masalah kerumitan logistik acara—mulai dari hajatan keluarga,
                        pernikahan, seminar kampus, hingga acara komunitas skala besar.
                    </p>
                    <p class="text-slate-600 leading-relaxed text-base">
                        Didukung sistem manajemen inventaris yang akurat dan transparan, kami berkomitmen memberikan
                        layanan terbaik yang menjamin ketersediaan barang tepat waktu tanpa risiko bentrok jadwal.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
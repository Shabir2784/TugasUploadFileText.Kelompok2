@extends('layouts.app')

@section('title', 'Kontak & Lokasi - EventRent')

@section('content')
    <section class="py-14 lg:py-20 bg-gradient-to-b from-white via-blue-50/30 to-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

                {{-- KOLOM KIRI: Informasi Kontak, Jam Operasional & Tombol Petunjuk Arah --}}
                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <span class="inline-block text-xs font-bold uppercase tracking-widest text-[#F59E0B] mb-2">
                            Informasi Usaha
                        </span>
                        <h1 class="text-3xl sm:text-4xl font-black text-[#1E3A8A] tracking-tight">
                            Kontak & Lokasi
                        </h1>
                        <p class="text-sm text-slate-500 mt-2">
                            Hubungi kami untuk konsultasi kebutuhan perlengkapan acara atau kunjungi langsung gudang operasional kami.
                        </p>
                    </div>

                    {{-- Detail Alamat, Telepon & Email --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-5">
                        <div class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1E3A8A] flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Lengkap</p>
                                <p class="text-sm font-semibold text-slate-800 leading-relaxed mt-0.5">
                                    {{ $profil['alamat'] ?? 'Jl. Prof. Dr. Baharuddin Lopa, S.H., Talumung, Kec. Banggae Timur, Kabupaten Majene, Sulawesi Barat 91412' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1E3A8A] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Telepon / WhatsApp</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">
                                    {{ $profil['telepon'] ?? '+62 812-3456-7890' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3.5">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#1E3A8A] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Email Resmi</p>
                                <p class="text-sm font-semibold text-slate-800 mt-0.5">
                                    {{ $profil['email'] ?? 'info@eventrent.id' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Jam Operasional --}}
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                        <div class="flex items-center space-x-2.5 mb-3">
                            <svg class="w-5 h-5 text-[#F59E0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h2 class="text-base font-extrabold text-slate-900">Jam Operasional</h2>
                        </div>
                        <div class="space-y-1.5 text-sm text-slate-600">
                            <div class="flex justify-between">
                                <span>Senin – Sabtu</span>
                                <span class="font-bold text-slate-800">{{ $profil['jam_buka'] ?? '08.00 – 17.00 WITA' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Minggu / Hari Libur</span>
                                <span class="font-medium text-slate-500">Pengiriman & Pengambilan Terjadwal</span>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Petunjuk Arah (Sesuai Mockup & UC-04) --}}
                    <div class="pt-1 space-y-2.5">
                        <a href="{{ $profil['maps_url'] ?? 'https://maps.google.com/?q=Universitas+Sulawesi+Barat' }}"
                            target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center space-x-2.5 px-7 py-3.5 text-sm font-extrabold text-slate-900 bg-[#F59E0B] hover:bg-amber-400 rounded-xl shadow-md shadow-amber-500/20 transition transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <span>Petunjuk Arah</span>
                        </a>
                        <p class="text-xs text-slate-500">
                            Membuka Google Maps. Jika peta gagal dimuat, alamat lengkap tetap ditampilkan sebagai teks statis.
                        </p>
                    </div>
                </div>

                {{-- KOLOM KANAN: Peta Lokasi (dengan Fallback Teks Statis UC-04) --}}
                <div class="lg:col-span-7">
                    <div class="relative w-full h-[380px] sm:h-[460px] bg-slate-200 rounded-3xl overflow-hidden border-4 border-white shadow-xl">
                        {{-- Iframe Google Maps --}}
                        <iframe id="gmaps-frame"
                            src="{{ $profil['maps_embed'] ?? 'https://www.google.com/maps?q=Universitas+Sulawesi+Barat,+Majene&output=embed' }}"
                            class="w-full h-full border-0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Lokasi EventRent">
                        </iframe>

                        {{-- Fallback Statis jika koneksi terputus / Maps gagal dimuat (UC-04) --}}
                        <div id="gmaps-fallback"
                            class="hidden absolute inset-0 bg-slate-100 flex-col items-center justify-center p-8 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-[#1E3A8A] flex items-center justify-center mb-4">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">
                                Peta Tidak Dapat Dimuat
                            </p>
                            <h3 class="text-lg font-extrabold text-[#1E3A8A] mb-2">Lokasi Gudang & Kantor EventRent</h3>
                            <p class="text-sm text-slate-600 max-w-md leading-relaxed">
                                {{ $profil['alamat'] ?? 'Jl. Prof. Dr. Baharuddin Lopa, S.H., Talumung, Kec. Banggae Timur, Kabupaten Majene, Sulawesi Barat 91412' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const iframe = document.getElementById('gmaps-frame');
            const fallback = document.getElementById('gmaps-fallback');

            function showFallback() {
                if (iframe) iframe.classList.add('hidden');
                if (fallback) {
                    fallback.classList.remove('hidden');
                    fallback.classList.add('flex');
                }
            }

            if (!navigator.onLine) {
                showFallback();
            }

            window.addEventListener('offline', showFallback);
            if (iframe) {
                iframe.addEventListener('error', showFallback);
            }
        });
    </script>
@endpush
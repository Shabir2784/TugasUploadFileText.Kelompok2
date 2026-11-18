<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Autentikasi - EventRent')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="@yield('body-class', 'bg-gray-50 flex flex-col items-center justify-center min-h-screen px-4 py-8') font-sans antialiased">

    @unlessView('hide-brand-header')
    @endunlessView

    @hasSection('hide-brand-header')
    @else
        {{-- Logo Kembali ke Beranda (untuk halaman card terpusat seperti Login) --}}
        <a href="{{ url('/') }}" class="flex items-center space-x-2.5 mb-6 group">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#1E3A8A] to-blue-600 flex items-center justify-center text-white font-extrabold shadow-md group-hover:scale-105 transition">
                ER
            </div>
            <span class="text-xl font-black bg-gradient-to-r from-[#1E3A8A] to-blue-700 bg-clip-text text-transparent tracking-tight">
                EventRent
            </span>
        </a>
    @endif

    {{-- Konten Utama --}}
    @yield('content')

    @stack('scripts')
</body>

</html>
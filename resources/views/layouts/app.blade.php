<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EventRent - Sewa Perlengkapan Acara Terpercaya')</title>

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

<body class="bg-slate-50 text-slate-800 antialiased flex flex-col min-h-screen selection:bg-amber-400 selection:text-slate-900 overflow-x-hidden">

    {{-- Navbar Pelanggan & Publik --}}
    @include('partials.customer.navbar')

    {{-- Konten Utama Halaman --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer Publik --}}
    @include('partials.customer.footer')

    @stack('scripts')
</body>

</html>
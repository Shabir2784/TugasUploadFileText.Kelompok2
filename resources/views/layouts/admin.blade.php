<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · EventRent Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Pastikan Alpine.js sudah di-import di resources/js/app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="h-full bg-slate-50 font-['Poppins',ui-sans-serif,system-ui,sans-serif] text-slate-700 antialiased"
      x-data="{ sidebarOpen: false }"
      @keydown.escape.window="sidebarOpen = false">

    @include('partials.admin.sidebar')

    <div class="lg:pl-64">
        {{-- Top bar khusus mobile --}}
        <header class="sticky top-0 z-20 flex h-14 items-center gap-3 border-b border-slate-200/80 bg-white px-4 lg:hidden">
            <button type="button"
                    class="-ml-1 rounded-lg p-2 text-blue-900 transition duration-150 hover:bg-slate-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500"
                    @click="sidebarOpen = true"
                    aria-label="Buka menu navigasi"
                    :aria-expanded="sidebarOpen.toString()">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <span class="text-base font-bold text-blue-900">EventRent Admin</span>
        </header>

        <main class="mx-auto min-h-screen max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            @include('partials.shared.flash-messages')
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
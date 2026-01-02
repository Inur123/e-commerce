<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Super Admin - Martku' }}</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100 overflow-hidden" x-data="{ sidebarOpen: false }">

    {{-- Overlay Mobile --}}
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/40 z-40 lg:hidden" x-cloak></div>

    <div class="h-screen flex bg-gray-100">

        {{-- SIDEBAR --}}
        <x-superadmin.sidebar />

        {{-- MAIN WRAPPER --}}
        <div class="flex-1 flex flex-col h-screen lg:pl-72">

            {{-- HEADER --}}
            <x-superadmin.header />

            {{-- ✅ SCROLL AREA (ONLY THIS SCROLLS) --}}
            <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                {{ $slot }}
            </main>

            {{-- FOOTER --}}
            <x-superadmin.footer />

        </div>
    </div>

    @livewireScripts
</body>

</html>

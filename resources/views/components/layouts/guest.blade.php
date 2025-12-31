<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Auth' }} - Mini eCommerce</title>


    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">

    @vite('resources/css/app.css', 'resources/js/app.js')
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="min-h-screen grid lg:grid-cols-2">

        {{-- LEFT / BRAND --}}
        <div class="relative hidden lg:flex items-center justify-center p-12 overflow-hidden">
            {{-- Background gradient sesuai logo --}}
            <div class="absolute inset-0 bg-gradient-to-br from-orange-100 via-white to-blue-100"></div>

            {{-- Ornamen blur --}}
            <div class="absolute -top-28 -left-28 h-80 w-80 rounded-full bg-orange-300/40 blur-3xl"></div>
            <div class="absolute -bottom-28 -right-28 h-80 w-80 rounded-full bg-blue-300/40 blur-3xl"></div>

            {{-- Content --}}
            <div class="relative max-w-md text-center">
                <img src="{{ asset('images/logo.webp') }}" alt="Mini eCommerce"
                    class="mx-auto w-56 drop-shadow-lg rounded-2xl">

                <h1 class="mt-8 text-4xl font-extrabold tracking-tight text-slate-900">
                    Mini eCommerce
                </h1>
                <p class="mt-3 text-slate-600">
                    Belanja cepat, jualan mudah, semua rapi.
                </p>

                <div class="mt-10 grid gap-3 text-sm text-slate-700">
                    <div class="rounded-2xl bg-white/70 shadow p-4 flex items-center gap-3">
                        <span class="text-orange-500 text-lg">🛒</span> Produk & Checkout mudah
                    </div>
                    <div class="rounded-2xl bg-white/70 shadow p-4 flex items-center gap-3">
                        <span class="text-blue-600 text-lg">📦</span> Tracking order realtime
                    </div>
                    <div class="rounded-2xl bg-white/70 shadow p-4 flex items-center gap-3">
                        <span class="text-emerald-600 text-lg">💳</span> Pembayaran aman
                    </div>
                </div>

                <p class="mt-12 text-xs text-slate-500">
                    © {{ date('Y') }} Mini eCommerce. All rights reserved.
                </p>
            </div>
        </div>

        {{-- RIGHT / SLOT --}}
        <div class="flex items-center justify-center px-5 py-10">
            <div class="w-full max-w-md">

                {{-- Mobile logo --}}
                <div class="lg:hidden mb-8 text-center">
                    <img src="{{ asset('images/logo.webp') }}" class="mx-auto w-32 drop-shadow-md rounded-xl"
                        alt="Mini eCommerce">
                    <h2 class="mt-3 text-xl font-bold text-slate-900">Mini eCommerce</h2>
                    <p class="text-sm text-slate-500">Belanja cepat, jualan mudah.</p>
                </div>

                {{ $slot }}
            </div>
        </div>

    </div>

    @livewireScripts
</body>

</html>

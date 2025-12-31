<!-- TOP PROMO BANNER -->
<div class="bg-orange-500 text-white py-2 px-4 text-center text-sm font-medium">
    🎉 Gratis ongkos kirim minimal pembelian!
    <span class="float-right hidden sm:inline">Lihat Selengkapnya • Download App • Jual Sekarang</span>
</div>

<header class="bg-white border-b border-gray-200 sticky top-0 z-50"
    x-data="{ open: false }">

    {{-- WRAPPER HEADER CONTENT --}}
    <div class="relative">
        <div class="max-w-7xl mx-auto px-4 py-4">

            <!-- ROW 1 -->
            <div class="flex items-center justify-between gap-4 flex-wrap">

                <!-- LOGO -->
                <div class="flex items-center gap-2 text-xl font-bold">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center text-white font-bold">M</div>
                    <span class="text-gray-800">Martku</span>
                </div>

                <!-- SEARCH BAR (DESKTOP) -->
                <div class="flex-1 max-w-md hidden md:flex items-center bg-gray-100 rounded-full px-4 py-2">
                    <input type="text" placeholder="Cari produk, kategori, atau brand..."
                        class="bg-transparent flex-1 outline-none text-sm">
                    <button class="text-orange-500"><i class="fas fa-search"></i></button>
                </div>

                <!-- RIGHT MENU -->
                <div class="flex items-center gap-4">

                    <!-- ICONS -->
                    <button class="text-gray-600 text-lg"><i class="fas fa-bell"></i></button>
                    <button class="text-gray-600 text-lg"><i class="fas fa-heart"></i></button>

                    <button class="relative text-gray-600 text-lg">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            0
                        </span>
                    </button>

                    <!-- LOGIN REGISTER (DESKTOP ONLY) -->
                    <div class="hidden md:flex border-l border-gray-300 pl-4 gap-2">
                        <a href="{{ route('login') }}" wire:navigate class="text-gray-600 font-medium text-sm px-4 py-2">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" wire:navigate
                            class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Daftar
                        </a>
                    </div>

                    <!-- HAMBURGER (MOBILE ONLY) -->
                    <button class="md:hidden text-gray-600 text-2xl" @click="open = !open">
                        <i class="fas" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                    </button>
                </div>
            </div>

            <!-- SEARCH BAR MOBILE -->
            <div class="flex md:hidden items-center bg-gray-100 rounded-full px-4 py-2 mt-3">
                <input type="text" placeholder="Cari produk..." class="bg-transparent flex-1 outline-none text-sm">
                <button class="text-orange-500"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <!-- DROPDOWN MOBILE NEMPEL (ABSOLUTE, TIDAK NGESER) -->
        <div
            x-show="open"
            x-transition
            x-cloak
            class="md:hidden absolute left-0 right-0 top-full bg-white border-t border-gray-200 shadow-lg z-50">

            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex gap-3">
                    <a href="{{ route('login') }}" wire:navigate @click="open=false"
                        class="flex-1 h-11 inline-flex items-center justify-center rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" wire:navigate @click="open=false"
                        class="flex-1 h-11 inline-flex items-center justify-center rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-semibold text-sm transition">
                        Daftar
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- NAVIGATION -->
    <nav class="border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 flex overflow-x-auto gap-8 py-3 text-sm text-gray-600">
            <a href="#" class="whitespace-nowrap font-medium text-gray-800">Semua Kategori</a>
            <a href="#" class="whitespace-nowrap hover:text-orange-500">Elektronik</a>
            <a href="#" class="whitespace-nowrap hover:text-orange-500">Fashion Pria</a>
            <a href="#" class="whitespace-nowrap hover:text-orange-500">Fashion Wanita</a>
            <a href="#" class="whitespace-nowrap hover:text-orange-500">Kecantikan</a>
            <a href="#" class="whitespace-nowrap hover:text-orange-500">Rumah & Dapur</a>
            <a href="#" class="whitespace-nowrap hover:text-orange-500">Hobi</a>
            <a href="#" class="whitespace-nowrap hover:text-orange-500">Makanan</a>
        </div>
    </nav>

</header>

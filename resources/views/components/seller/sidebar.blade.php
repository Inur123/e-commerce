<aside
    class="fixed top-0 left-0 h-screen w-72 bg-white border-r border-gray-200 z-50
           transform transition-transform duration-300 flex flex-col"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" x-cloak>

    {{-- ✅ TOP --}}
    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 shrink-0">
        <div class="flex items-center gap-3 font-bold text-lg text-gray-800">
            <img src="{{ asset('images/logo.webp') }}" alt="Martku Logo" class="w-15 h-15 rounded-lg object-cover">

            <span class="font-bold text-sm sm:text-base lg:text-lg text-gray-800 truncate">
                Mini E-Commerce
            </span>
        </div>

        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-800">
            <i class="fas fa-xmark text-xl"></i>
        </button>
    </div>

    {{-- ✅ MENU --}}
    <nav
        class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-sm font-medium scroll-smooth
                [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

        <a href="{{ route('seller.dashboard') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition
   {{ request()->routeIs('seller.dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-home w-5 text-center"></i>
            Dashboard
        </a>

        {{-- Produk --}}
        <a href="{{ route('seller.products') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition
   {{ request()->routeIs('seller.products') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-100' }}">
            <i class="fas fa-box w-5 text-center"></i>
            Produk
        </a>

        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-600 hover:bg-gray-100 transition">
            <i class="fas fa-receipt w-5 text-center"></i>
            Transaksi
        </a>
    </nav>

    {{-- ✅ BOTTOM --}}
    <div class="px-6 py-4 shrink-0">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200"></div>
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Seller' }}</p>
                    <p class="text-xs text-gray-500">Seller</p>
                </div>
            </div>

            <livewire:auth.logout />
        </div>
    </div>
</aside>

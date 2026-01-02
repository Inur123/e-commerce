<header class="sticky top-0 z-30 bg-white border-b border-gray-200 h-16 flex items-center">
    <div class="flex items-center justify-between w-full px-6 lg:px-8 gap-4">

        {{-- Mobile Toggle --}}
        <button @click="sidebarOpen = true" class="lg:hidden text-gray-600 text-2xl">
            <i class="fas fa-bars"></i>
        </button>

        {{-- Right --}}
        <div class="flex items-center gap-4 ml-auto">

            {{-- Notifications --}}
            <button class="relative text-gray-600 hover:text-orange-500">
                <i class="fas fa-bell text-lg"></i>
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                    3
                </span>
            </button>

            {{-- Profile --}}
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gray-200"></div>
                <div class="hidden sm:block leading-tight">
                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-500">Super Admin</p>
                </div>
            </div>

        </div>
    </div>
</header>

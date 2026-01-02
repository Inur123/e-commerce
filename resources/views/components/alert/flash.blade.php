<div class="fixed top-6 right-6 z-[9999] space-y-3 w-full max-w-sm">

    {{-- ✅ SUCCESS --}}
    @if (session()->has('success'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 2000)"
            x-cloak

            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-10"
            x-transition:enter-end="translate-x-0"

            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-10"

            class="p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm flex items-start gap-3 shadow-lg"
        >
            <i class="fas fa-check-circle mt-0.5 text-lg"></i>

            <div class="flex-1">
                <p class="font-semibold">Berhasil</p>
                <p class="text-xs mt-1">{{ session('success') }}</p>
            </div>

            <button @click="show = false" class="text-green-800 hover:text-green-900">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    @endif


    {{-- ❌ ERROR --}}
    @if (session()->has('error'))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 5000)"
            x-cloak

            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-10"
            x-transition:enter-end="translate-x-0"

            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-10"

            class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-start gap-3 shadow-lg"
        >
            <i class="fas fa-exclamation-triangle mt-0.5 text-lg"></i>

            <div class="flex-1">
                <p class="font-semibold">Gagal</p>
                <p class="text-xs mt-1">{{ session('error') }}</p>
            </div>

            <button @click="show = false" class="text-red-800 hover:text-red-900">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    @endif


    {{-- ⚠️ VALIDATION --}}
    @if ($errors->any())
        <div
            x-data="{ show: true }"
            x-show="show"
            x-cloak

            x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="translate-x-10"
            x-transition:enter-end="translate-x-0"

            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-10"

            class="p-4 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm shadow-lg"
        >
            <div class="flex items-start justify-between gap-3">
                <p class="font-semibold flex items-center gap-2">
                    <i class="fas fa-triangle-exclamation"></i> Periksa kembali input kamu:
                </p>

                <button @click="show = false" class="text-yellow-800 hover:text-yellow-900">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <ul class="list-disc pl-5 mt-2 space-y-1 text-xs sm:text-sm">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

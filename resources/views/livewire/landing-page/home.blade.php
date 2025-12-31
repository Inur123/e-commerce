<div>
{{-- PROMO CAROUSEL --}}
<section class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        <!-- Fashion Week Banner -->
        <div class="lg:col-span-2 gradient-fashion rounded-3xl p-8 text-white relative overflow-hidden h-64 flex flex-col justify-between">
            <div>
                <h2 class="text-4xl font-bold mb-2">Fashion Week</h2>
                <p class="text-sm opacity-90">Koleksi Terbaru Diskon 50%</p>
            </div>
            <button class="bg-white bg-opacity-30 text-white px-6 py-2 rounded-full w-fit text-sm font-medium hover:bg-opacity-40 transition">
                Lihat Koleksi
            </button>
            <img src="/placeholder.svg?height=200&width=200" alt="Fashion" class="absolute -right-10 -bottom-10 w-40 h-40 opacity-30">
            <div class="flex gap-2 mt-4">
                <div class="w-3 h-3 bg-white rounded-full"></div>
                <div class="w-3 h-3 bg-white bg-opacity-50 rounded-full"></div>
                <div class="w-3 h-1 bg-white bg-opacity-50 rounded-full"></div>
            </div>
        </div>

        <!-- Right Banners -->
        <div class="flex flex-col gap-4">
            <div class="gradient-orange rounded-3xl p-6 text-white relative overflow-hidden h-28 flex flex-col justify-center">
                <span class="text-xs opacity-90 mb-1">🔥 Diskon Besar</span>
                <h3 class="text-xl font-bold">Garansi Sale</h3>
                <p class="text-xs opacity-90">Diskon s.d 60%</p>
            </div>

            <div class="gradient-blue rounded-3xl p-6 text-white relative overflow-hidden h-28 flex flex-col justify-center">
                <span class="text-xs opacity-90 mb-1">🎮 Gaming</span>
                <h3 class="text-xl font-bold">Gaming Gear</h3>
                <p class="text-xs opacity-90">Harga hingga Jutaan</p>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="max-w-7xl mx-auto px-4 py-8">
    <h3 class="text-2xl font-bold mb-6">Kategori</h3>

    <div class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-10 gap-4">

        @php
            $categories = [
                ['icon'=>'fa-laptop','bg'=>'bg-blue-100','color'=>'text-blue-500','name'=>'Elektronik'],
                ['icon'=>'fa-shopping-bag','bg'=>'bg-pink-100','color'=>'text-pink-500','name'=>'Fashion Pria'],
                ['icon'=>'fa-dress','bg'=>'bg-red-100','color'=>'text-red-500','name'=>'Fashion Wanita'],
                ['icon'=>'fa-home','bg'=>'bg-yellow-100','color'=>'text-yellow-500','name'=>'Rumah Tangga'],
                ['icon'=>'fa-dumbbell','bg'=>'bg-green-100','color'=>'text-green-500','name'=>'Olahraga'],
                ['icon'=>'fa-utensils','bg'=>'bg-orange-100','color'=>'text-orange-500','name'=>'Makanan'],
                ['icon'=>'fa-gamepad','bg'=>'bg-purple-100','color'=>'text-purple-500','name'=>'Gaming'],
                ['icon'=>'fa-child','bg'=>'bg-red-100','color'=>'text-red-500','name'=>'Ibu & Anak'],
                ['icon'=>'fa-laptop','bg'=>'bg-indigo-100','color'=>'text-indigo-500','name'=>'Komputer'],
                ['icon'=>'fa-heart','bg'=>'bg-red-100','color'=>'text-red-500','name'=>'Kesehatan'],
            ];
        @endphp

        @foreach($categories as $cat)
        <div class="text-center group cursor-pointer">
            <div class="{{ $cat['bg'] }} w-16 h-16 mx-auto rounded-lg flex items-center justify-center mb-2 group-hover:opacity-80 transition">
                <i class="fas {{ $cat['icon'] }} text-2xl {{ $cat['color'] }}"></i>
            </div>
            <p class="text-xs font-medium text-gray-700">{{ $cat['name'] }}</p>
        </div>
        @endforeach

    </div>
</section>

{{-- FEATURES --}}
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-orange-500 text-white rounded-2xl p-6 flex items-center gap-4">
            <div class="text-3xl"><i class="fas fa-ticket"></i></div>
            <div>
                <p class="text-sm opacity-90">Voucher</p>
                <h4 class="font-bold">Cashback Rp 50K</h4>
            </div>
        </div>

        <div class="bg-teal-500 text-white rounded-2xl p-6 flex items-center gap-4">
            <div class="text-3xl"><i class="fas fa-truck"></i></div>
            <div>
                <p class="text-sm opacity-90">Gratis</p>
                <h4 class="font-bold">Ongkir Rp100rb</h4>
            </div>
        </div>

        <div class="bg-indigo-600 text-white rounded-2xl p-6 flex items-center gap-4">
            <div class="text-3xl"><i class="fas fa-shield-alt"></i></div>
            <div>
                <p class="text-sm opacity-90">100%</p>
                <h4 class="font-bold">Original Garansi</h4>
            </div>
        </div>

        <div class="bg-pink-600 text-white rounded-2xl p-6 flex items-center gap-4">
            <div class="text-3xl"><i class="fas fa-star"></i></div>
            <div>
                <p class="text-sm opacity-90">Hadiah</p>
                <h4 class="font-bold">Spesial Untukmu</h4>
            </div>
        </div>
    </div>
</section>

{{-- FLASH SALE --}}
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-red-500 text-white rounded-3xl p-6 flex items-center justify-between gap-4 flex-wrap">
        <div class="flex items-center gap-3">
            <div class="text-3xl"><i class="fas fa-bolt"></i></div>
            <div>
                <h3 class="text-xl font-bold">Flash Sale</h3>
                <p class="text-sm opacity-90">Berakhir dalam</p>
            </div>
        </div>

        <div class="flex gap-2 text-center">
            <div class="bg-white bg-opacity-20 rounded px-3 py-2 min-w-12">
                <p class="font-bold text-lg">05</p>
                <p class="text-xs">Jam</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded px-3 py-2 min-w-12">
                <p class="font-bold text-lg">32</p>
                <p class="text-xs">Menit</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded px-3 py-2 min-w-12">
                <p class="font-bold text-lg">07</p>
                <p class="text-xs">Detik</p>
            </div>
        </div>

        <button class="bg-white text-red-500 px-6 py-2 rounded-full font-bold text-sm">
            Lihat Semua
        </button>
    </div>
</section>

{{-- FLASH SALE PRODUCTS CAROUSEL --}}
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="relative">
        <div class="carousel-scroll flex gap-4 overflow-x-auto pb-4 snap-x snap-mandatory"
            x-ref="flashCarousel"
            @touchstart="startX = $event.touches[0].clientX"
            @touchmove="handleTouchMove">

            <template x-for="i in 5" :key="i">
                <div class="carousel-item flex-shrink-0 w-full sm:w-80">
                    <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 hover:shadow-lg transition">
                        <div class="relative bg-gray-200 h-64">
                            <img src="{{ asset('images/logo.webp') }}"
                                alt="Product" class="w-full h-full object-cover">

                            <span class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">-40%</span>

                            <button class="absolute top-3 right-3 bg-white rounded-full w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>

                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 text-sm mb-1">Premium Tech Product</h4>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-yellow-400 text-xs"><i class="fas fa-star"></i></span>
                                <span class="text-xs text-gray-600">4.8 • Terjual 1.2K</span>
                            </div>
                            <p class="text-red-500 font-bold text-lg mb-2">Rp 199.000</p>
                            <p class="text-gray-400 text-xs line-through mb-3">Rp 399.000</p>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Controls -->
        <button @click="scrollCarousel('left', 'flashCarousel')"
            class="absolute left-0 top-1/3 -translate-y-1/2 -translate-x-4 bg-white rounded-full w-10 h-10 shadow-lg flex items-center justify-center text-gray-800 hover:bg-gray-100 hidden md:flex z-10">
            <i class="fas fa-chevron-left"></i>
        </button>

        <button @click="scrollCarousel('right', 'flashCarousel')"
            class="absolute right-0 top-1/3 -translate-y-1/2 translate-x-4 bg-white rounded-full w-10 h-10 shadow-lg flex items-center justify-center text-gray-800 hover:bg-gray-100 hidden md:flex z-10">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</section>

{{-- RECOMMENDATIONS --}}
<section class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold">Rekomendasi Untukmu</h3>
        <a href="#" class="text-orange-500 text-sm font-medium hover:underline">Lihat Semua</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <template x-for="i in 10" :key="i">
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 hover:shadow-lg transition">
                <div class="relative bg-gray-200 h-48">
                    <img src="{{ asset('images/logo.webp') }}"
                        alt="Product" class="w-full h-full object-cover">

                    <span x-show="i % 2 === 0"
                        class="absolute top-3 left-3 bg-red-500 text-white px-2 py-1 rounded text-xs font-bold">-50%</span>

                    <button class="absolute top-3 right-3 bg-white rounded-full w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>

                <div class="p-3">
                    <h4 class="font-bold text-gray-800 text-xs mb-1 line-clamp-2">Premium Product Item</h4>
                    <div class="flex items-center gap-1 mb-2">
                        <span class="text-yellow-400 text-xs"><i class="fas fa-star"></i></span>
                        <span class="text-xs text-gray-600">4.9 • Terjual 2.4K</span>
                    </div>
                    <p class="text-red-500 font-bold text-sm mb-1">Rp 189.000</p>
                    <p class="text-gray-400 text-xs line-through mb-2">Rp 399.000</p>
                </div>
            </div>
        </template>
    </div>
</section>

{{-- LOAD MORE --}}
<section class="max-w-7xl mx-auto px-4 py-8 text-center">
    <button class="border-2 border-orange-500 text-orange-500 px-12 py-3 rounded-full font-bold hover:bg-orange-50 transition">
        Lihat Lebih Banyak
    </button>
</section>

</div>

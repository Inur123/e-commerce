<div class="w-full space-y-6 sm:space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">
            Dashboard Seller
        </h1>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">
            Ringkasan performa toko dan aktivitas terbaru
        </p>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Total Produk --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Total Produk</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                        {{ $productStats['total'] }}
                    </p>
                    <p class="text-[11px] text-gray-400 mt-1">Semua produk kamu</p>
                </div>
                <span
                    class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-box"></i>
                </span>
            </div>
        </div>

        {{-- Total Pesanan --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Total Pesanan</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                        {{ $orderStats['total'] }}
                    </p>
                    <p class="text-[11px] text-gray-400 mt-1">Order yang mengandung produk kamu</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-receipt"></i>
                </span>
            </div>
        </div>

        {{-- Pendapatan --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Pendapatan</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-600 mt-1">
                        Rp{{ number_format($income) }}
                    </p>
                    <p class="text-[11px] text-gray-400 mt-1">Paid / Shipped / Completed</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-money-bill-wave"></i>
                </span>
            </div>
        </div>

        {{-- Stok Habis --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Stok Habis</p>
                    <p class="text-2xl sm:text-3xl font-bold text-red-600 mt-1">
                        {{ $productStats['out_of_stock'] }}
                    </p>
                    <p class="text-[11px] text-gray-400 mt-1">Produk stock = 0</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-triangle-exclamation"></i>
                </span>
            </div>
        </div>

    </div>

    {{-- STATUS PESANAN SUMMARY --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl shadow p-4">
            <p class="text-xs text-gray-500">Pending Payment</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $orderStats['pending_payment'] }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <p class="text-xs text-gray-500">Paid</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $orderStats['paid'] }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <p class="text-xs text-gray-500">Shipped</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $orderStats['shipped'] }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-4">
            <p class="text-xs text-gray-500">Completed</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $orderStats['completed'] }}</p>
        </div>

    </div>

    {{-- GRID SECTION --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- RECENT ORDERS --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800">Pesanan Terbaru</h3>
                <a href="{{ route('seller.orders') }}" class="text-xs text-orange-600 font-medium hover:underline">
                    Lihat semua
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($recentOrders as $o)
                    <div class="p-4 flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $o->order_code }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Buyer: {{ $o->buyer->name ?? '-' }} • {{ $o->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        <div class="text-right space-y-2">
                            <p class="text-sm font-bold text-gray-800">
                                Rp{{ number_format($o->total_amount) }}
                            </p>

                            <span
                                class="px-3 py-1 rounded-full text-[11px] font-medium
                                {{ $o->status === 'paid'
                                    ? 'bg-green-50 text-green-700'
                                    : ($o->status === 'pending_payment'
                                        ? 'bg-gray-100 text-gray-700'
                                        : ($o->status === 'shipped'
                                            ? 'bg-yellow-50 text-yellow-700'
                                            : 'bg-blue-50 text-blue-700')) }}">
                                {{ strtoupper(str_replace('_', ' ', $o->status)) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <i class="fas fa-receipt text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada pesanan terbaru</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- PRODUK STOK HABIS --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800">Produk Stok Habis</h3>
                <a href="{{ route('seller.products') }}" class="text-xs text-orange-600 font-medium hover:underline">
                    Kelola produk
                </a>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($outOfStockProducts as $p)
                    <div class="p-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <img src="{{ $p->thumbnail ? asset('storage/' . $p->thumbnail) : 'https://via.placeholder.com/60' }}"
                                class="w-12 h-12 rounded-xl object-cover border shrink-0">

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">
                                    {{ $p->name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Harga: Rp{{ number_format($p->price) }}
                                </p>
                            </div>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                            Stock 0
                        </span>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <i class="fas fa-check-circle text-3xl mb-2 text-green-500"></i>
                        <p class="text-sm">Tidak ada produk stok habis 🎉</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

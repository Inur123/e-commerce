<div class="w-full space-y-4 sm:space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Pesanan</h1>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">Kelola pesanan yang masuk (khusus produk kamu)</p>
    </div>

    {{-- FLASH --}}
    <div class="space-y-3">
        @if (session()->has('success'))
            <div class="p-3 sm:p-4 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-3 sm:p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            </div>
        @endif
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">

        {{-- Total --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Total Pesanan</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Mengikuti filter saat ini</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-receipt"></i>
                </span>
            </div>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Pending Payment</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['pending_payment'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Status: pending_payment</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-hourglass-half"></i>
                </span>
            </div>
            <div class="mt-4">
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    @php
                        $percentPending = $stats['total'] > 0 ? round(($stats['pending_payment'] / $stats['total']) * 100) : 0;
                    @endphp
                    <div class="h-full bg-yellow-500" style="width: {{ $percentPending }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $percentPending }}% dari total</p>
            </div>
        </div>

        {{-- Paid --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Paid</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['paid'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Status: paid</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-circle-check"></i>
                </span>
            </div>
            <div class="mt-4">
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    @php
                        $percentPaid = $stats['total'] > 0 ? round(($stats['paid'] / $stats['total']) * 100) : 0;
                    @endphp
                    <div class="h-full bg-green-500" style="width: {{ $percentPaid }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $percentPaid }}% dari total</p>
            </div>
        </div>

        {{-- Shipped --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Shipped</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['shipped'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Status: shipped</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-truck-fast"></i>
                </span>
            </div>
            <div class="mt-4">
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    @php
                        $percentShip = $stats['total'] > 0 ? round(($stats['shipped'] / $stats['total']) * 100) : 0;
                    @endphp
                    <div class="h-full bg-blue-500" style="width: {{ $percentShip }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $percentShip }}% dari total</p>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 items-end">
            <div class="col-span-2 lg:col-span-2">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Cari Order</label>
                <input type="text" wire:model.live.debounce.500ms="search"
                    placeholder="Kode order..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl
                           focus:outline-none focus-visible:outline-none
                           focus:ring-2 focus:ring-orange-500 focus:ring-offset-0
                           focus:border-transparent text-sm">
            </div>

            <div class="col-span-1 lg:col-span-1">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm
                           focus:outline-none focus-visible:outline-none">
                    <option value="">Semua</option>
                    <option value="pending_payment">Pending Payment</option>
                    <option value="paid">Paid</option>
                    <option value="shipped">Shipped</option>
                    <option value="completed">Completed</option>
                    <option value="canceled">Canceled</option>
                    <option value="expired">Expired</option>
                </select>
            </div>

            <div class="col-span-2 lg:col-span-1">
                <button type="button" wire:click="$refresh"
                    class="w-full bg-orange-500 text-white px-4 py-2.5 rounded-xl hover:bg-orange-600 transition text-sm font-medium cursor-pointer">
                    <i class="fas fa-rotate mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    {{-- LIST (MOBILE) --}}
    <div class="md:hidden bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Daftar Pesanan</h3>
            <span class="text-[10px] px-2 py-1 bg-orange-50 text-orange-700 rounded-full">
                <i class="fas fa-receipt mr-1"></i>Orders
            </span>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($orders as $o)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">
                                {{ $o->order_code }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $o->created_at->format('d M Y H:i') }}
                                • Total: Rp{{ number_format($o->total_amount) }}
                            </p>

                            <div class="mt-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $o->status === 'paid' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $o->status === 'pending_payment' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                    {{ $o->status === 'shipped' ? 'bg-blue-50 text-blue-700' : '' }}
                                    {{ in_array($o->status, ['canceled','expired']) ? 'bg-red-50 text-red-700' : '' }}
                                    {{ $o->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_',' ', $o->status)) }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-lg shrink-0">
                            <button type="button" wire:click="detail('{{ $o->id }}')"
                                class="text-blue-600 hover:text-blue-800 transition cursor-pointer" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-10 text-center text-gray-500">
                    <i class="fas fa-receipt text-4xl mb-3 block"></i>
                    <p class="text-base">Belum ada pesanan</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- TABLE (DESKTOP) --}}
    <div class="hidden md:block bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between gap-3">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">Daftar Pesanan</h3>
            <span class="text-xs px-2 py-1 bg-orange-50 text-orange-700 rounded-full whitespace-nowrap">
                <i class="fas fa-store mr-1"></i>Seller Area
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Order Code</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Buyer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $o)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                                {{ $o->order_code }}
                                <div class="text-[11px] text-gray-400 mt-1">{{ $o->created_at->format('d M Y H:i') }}</div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $o->buyer->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                Rp{{ number_format($o->total_amount) }}
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $o->status === 'paid' ? 'bg-green-50 text-green-700' : '' }}
                                    {{ $o->status === 'pending_payment' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                    {{ $o->status === 'shipped' ? 'bg-blue-50 text-blue-700' : '' }}
                                    {{ in_array($o->status, ['canceled','expired']) ? 'bg-red-50 text-red-700' : '' }}
                                    {{ $o->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                                ">
                                    {{ ucfirst(str_replace('_',' ', $o->status)) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <button type="button" wire:click="detail('{{ $o->id }}')"
                                    class="text-blue-600 hover:text-blue-800 transition-transform hover:scale-110 cursor-pointer"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-receipt text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada pesanan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION (SAMA STYLE PRODUK) --}}
    @if ($orders->hasPages())
        <div class="bg-white rounded-2xl shadow p-3 sm:p-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="text-xs sm:text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $orders->firstItem() }}</span>
                    sampai <span class="font-medium">{{ $orders->lastItem() }}</span>
                    dari <span class="font-medium">{{ $orders->total() }}</span> hasil
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    {{-- Prev --}}
                    @if ($orders->onFirstPage())
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <button type="button" wire:click="previousPage"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    @endif

                    @php
                        $current = $orders->currentPage();
                        $last = $orders->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);

                        if ($end - $start < 4) {
                            if ($start == 1) $end = min($last, $start + 4);
                            elseif ($end == $last) $start = max(1, $end - 4);
                        }
                    @endphp

                    {{-- first + dots --}}
                    @if ($start > 1)
                        <button type="button" wire:click="gotoPage(1)"
                            class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            1
                        </button>
                        @if ($start > 2)
                            <span class="px-3 py-2 text-sm text-gray-400">...</span>
                        @endif
                    @endif

                    {{-- window --}}
                    @for ($pg = $start; $pg <= $end; $pg++)
                        @if ($pg == $current)
                            <span class="px-4 py-2 text-sm text-white bg-orange-500 rounded-xl font-medium">
                                {{ $pg }}
                            </span>
                        @else
                            <button type="button" wire:click="gotoPage({{ $pg }})"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                                {{ $pg }}
                            </button>
                        @endif
                    @endfor

                    {{-- dots + last --}}
                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span class="px-3 py-2 text-sm text-gray-400">...</span>
                        @endif
                        <button type="button" wire:click="gotoPage({{ $last }})"
                            class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            {{ $last }}
                        </button>
                    @endif

                    {{-- Next --}}
                    @if ($orders->hasMorePages())
                        <button type="button" wire:click="nextPage"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @else
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>

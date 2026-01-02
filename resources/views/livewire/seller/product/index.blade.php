{{-- resources/views/livewire/seller/product/index.blade.php --}}
<div class="w-full space-y-4 sm:space-y-6">
    {{-- HEADER --}}
    <div>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Produk</h1>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">Kelola produk (harga, stok & status)</p>
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
        {{-- Total Produk --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Total Produk</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Mengikuti filter saat ini</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-box"></i>
                </span>
            </div>
        </div>

        {{-- Active --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Produk Active</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['active'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Status: active</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-check-circle"></i>
                </span>
            </div>
            <div class="mt-4">
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    @php $percent = $stats['total'] > 0 ? round(($stats['active'] / $stats['total']) * 100) : 0; @endphp
                    <div class="h-full bg-green-500" style="width: {{ $percent }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $percent }}% dari total</p>
            </div>
        </div>

        {{-- Inactive --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Produk Inactive</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['inactive'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Status: inactive</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-times-circle"></i>
                </span>
            </div>
            <div class="mt-4">
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    @php $percentIn = $stats['total'] > 0 ? round(($stats['inactive'] / $stats['total']) * 100) : 0; @endphp
                    <div class="h-full bg-gray-500" style="width: {{ $percentIn }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $percentIn }}% dari total</p>
            </div>
        </div>

        {{-- Out of Stock --}}
        <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-xs text-gray-500">Stok Habis</p>
                    <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">{{ $stats['out_of_stock'] }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">Stock = 0</p>
                </div>
                <span class="w-10 h-10 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                    <i class="fas fa-triangle-exclamation"></i>
                </span>
            </div>
            <div class="mt-4">
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    @php $percentOos = $stats['total'] > 0 ? round(($stats['out_of_stock'] / $stats['total']) * 100) : 0; @endphp
                    <div class="h-full bg-red-500" style="width: {{ $percentOos }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">{{ $percentOos }}% dari total</p>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 items-end">
            <div class="col-span-2 lg:col-span-2">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Nama produk..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl
                           focus:outline-none focus-visible:outline-none
                           focus:ring-2 focus:ring-orange-500 focus:ring-offset-0
                           focus:border-transparent text-sm">
            </div>

            <div class="col-span-1">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm
                           focus:outline-none focus-visible:outline-none">
                    <option value="">Semua</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="col-span-2 lg:col-span-1">
                <button type="button" wire:click="create"
                    class="w-full bg-orange-500 text-white px-4 py-2.5 rounded-xl hover:bg-orange-600 transition text-sm font-medium cursor-pointer">
                    <i class="fas fa-plus mr-2"></i>Tambah Produk
                </button>
            </div>
        </div>
    </div>

    {{-- LIST (MOBILE) --}}
    <div class="md:hidden bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Daftar Produk</h3>
            <span class="text-[10px] px-2 py-1 bg-orange-50 text-orange-700 rounded-full">
                <i class="fas fa-box mr-1"></i>Products
            </span>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($products as $p)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-start gap-3 min-w-0">
                            <img src="{{ $p->thumbnail_url }}"
                                class="w-14 h-14 rounded-xl object-cover border border-gray-100 shrink-0" />

                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">
                                    {{ \Illuminate\Support\Str::limit($p->name, 40) }}
                                </p>

                                <p class="text-xs text-gray-500 truncate mt-1">
                                    Rp{{ number_format($p->finalPrice()) }}
                                    @if ($p->sale_price)
                                        <span class="text-[11px] text-gray-400 line-through ml-1">
                                            Rp{{ number_format($p->price) }}
                                        </span>
                                    @endif
                                    • Stok: {{ $p->stock }}
                                </p>

                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    @if ($p->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            <i class="fas fa-times-circle mr-1"></i>Inactive
                                        </span>
                                    @endif

                                    @if ((int) $p->stock === 0)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            <i class="fas fa-triangle-exclamation mr-1"></i>Stok Habis
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- ACTIONS MOBILE --}}
                        <div class="flex items-center gap-3 text-lg shrink-0">
                            <button type="button" wire:click="detail('{{ $p->id }}')"
                                class="text-blue-600 hover:text-blue-800 transition cursor-pointer" title="Detail">
                                <i class="fas fa-eye"></i>
                            </button>

                            {{-- ✅ Edit selalu ada --}}
                            <button type="button" wire:click="edit('{{ $p->id }}')"
                                class="text-yellow-600 hover:text-yellow-800 transition cursor-pointer" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- ✅ Hapus hilang kalau ACTIVE --}}
                            @if ($p->status !== 'active')
                                <button type="button" wire:click="confirmDelete('{{ $p->id }}')"
                                    class="text-red-600 hover:text-red-800 transition cursor-pointer" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-10 text-center text-gray-500">
                    <i class="fas fa-box-open text-4xl mb-3 block"></i>
                    <p class="text-base">Belum ada data produk</p>
                    @if ($search || $filterStatus)
                        <p class="text-sm mt-2">Coba ubah filter atau kata kunci pencarian Anda</p>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    {{-- TABLE (DESKTOP) --}}
    <div class="hidden md:block bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between gap-3">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">Daftar Produk</h3>
            <span class="text-xs px-2 py-1 bg-orange-50 text-orange-700 rounded-full whitespace-nowrap">
                <i class="fas fa-store mr-1"></i>Seller Area
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Foto</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $index => $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $products->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                <img src="{{ $p->thumbnail_url }}"
                                    alt="thumbnail"
                                    class="w-12 h-12 rounded-xl object-cover border border-gray-100" />
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                                {{ \Illuminate\Support\Str::limit($p->name, 35) }}
                                <div class="text-[11px] text-gray-400 font-normal mt-1">{{ $p->slug }}</div>
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                Rp{{ number_format($p->finalPrice()) }}
                                @if ($p->sale_price)
                                    <div class="text-[11px] text-gray-400 line-through">
                                        Rp{{ number_format($p->price) }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $p->stock }}
                                @if ((int) $p->stock === 0)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-red-50 text-red-700">
                                        <i class="fas fa-triangle-exclamation mr-1"></i>Habis
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                @if ($p->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-3 text-lg">
                                    <button type="button" wire:click="detail('{{ $p->id }}')"
                                        class="text-blue-600 hover:text-blue-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>

                                    {{-- ✅ Edit selalu ada --}}
                                    <button type="button" wire:click="edit('{{ $p->id }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- ✅ Delete hilang kalau ACTIVE --}}
                                    @if ($p->status !== 'active')
                                        <button type="button" wire:click="confirmDelete('{{ $p->id }}')"
                                            class="text-red-600 hover:text-red-800 transition-transform hover:scale-110 cursor-pointer"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada data produk</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if ($products->hasPages())
        <div class="bg-white rounded-2xl shadow p-3 sm:p-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="text-xs sm:text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $products->firstItem() }}</span>
                    sampai <span class="font-medium">{{ $products->lastItem() }}</span>
                    dari <span class="font-medium">{{ $products->total() }}</span> hasil
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    @if ($products->onFirstPage())
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <button type="button" wire:click="previousPage" wire:loading.attr="disabled"
                            class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    @endif

                    @php
                        $current = $products->currentPage();
                        $last = $products->lastPage();
                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);

                        if ($end - $start < 4) {
                            if ($start == 1) $end = min($last, $start + 4);
                            elseif ($end == $last) $start = max(1, $end - 4);
                        }
                    @endphp

                    @if ($start > 1)
                        <button type="button" wire:click="gotoPage(1)" wire:loading.attr="disabled"
                            class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            1
                        </button>
                        @if ($start > 2)
                            <span class="px-3 py-2 text-sm text-gray-400">...</span>
                        @endif
                    @endif

                    @for ($pg = $start; $pg <= $end; $pg++)
                        @if ($pg == $current)
                            <span class="px-4 py-2 text-sm text-white bg-orange-500 rounded-xl font-medium">
                                {{ $pg }}
                            </span>
                        @else
                            <button type="button" wire:click="gotoPage({{ $pg }})" wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                                {{ $pg }}
                            </button>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span class="px-3 py-2 text-sm text-gray-400">...</span>
                        @endif
                        <button type="button" wire:click="gotoPage({{ $last }})" wire:loading.attr="disabled"
                            class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            {{ $last }}
                        </button>
                    @endif

                    @if ($products->hasMorePages())
                        <button type="button" wire:click="nextPage" wire:loading.attr="disabled"
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

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:confirm-delete', () => {
                Swal.fire({
                    title: 'Hapus produk ini?',
                    text: 'Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('delete');
                    }
                });
            });

            Livewire.on('swal:done', ({ type, message }) => {
                Swal.fire({
                    icon: type ?? 'success',
                    title: (type === 'error') ? 'Gagal' : 'Berhasil',
                    text: message ?? '',
                    timer: 1500,
                    showConfirmButton: false,
                });
            });
        });
    </script>
</div>

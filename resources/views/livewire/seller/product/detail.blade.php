{{-- resources/views/livewire/seller/product/detail.blade.php --}}
<div class="w-full space-y-4 sm:space-y-6">
    {{-- HEADER --}}
    <div class="flex items-start justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Detail Produk</h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Lihat informasi lengkap produk</p>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" wire:click="edit('{{ $product->id }}')"
                class="px-4 py-2.5 rounded-xl bg-orange-500 text-white hover:bg-orange-600 transition text-sm font-medium">
                <i class="fas fa-edit mr-2"></i>Edit
            </button>

            <button type="button" wire:click="back"
                class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">Informasi Produk</h3>

            @if ($product->status === 'active')
                <span class="text-xs px-2 py-1 bg-green-50 text-green-700 rounded-full">
                    <i class="fas fa-check-circle mr-1"></i>Active
                </span>
            @else
                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded-full">
                    <i class="fas fa-times-circle mr-1"></i>Inactive
                </span>
            @endif
        </div>

        <div class="p-4 sm:p-6 space-y-6">
            {{-- Top --}}
            <div class="flex flex-col sm:flex-row gap-5">
                <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://via.placeholder.com/240' }}"
                    class="w-full sm:w-64 h-64 rounded-2xl object-cover border" alt="thumbnail">

                <div class="flex-1 space-y-3">
                    <div>
                        <p class="text-xs text-gray-500">Nama</p>
                        <p class="text-lg font-bold text-gray-800">{{ $product->name }}</p>
                        <p class="text-xs text-gray-400 mt-1">Slug: {{ $product->slug }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-4 rounded-2xl bg-gray-50 border">
                            <p class="text-xs text-gray-500">Harga</p>
                            <p class="text-base font-semibold text-gray-800">Rp{{ number_format($product->price) }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-50 border">
                            <p class="text-xs text-gray-500">Harga Diskon</p>
                            <p class="text-base font-semibold text-gray-800">
                                {{ $product->sale_price ? 'Rp' . number_format($product->sale_price) : '-' }}
                            </p>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-50 border">
                            <p class="text-xs text-gray-500">Harga Final</p>
                            <p class="text-base font-semibold text-gray-800">
                                Rp{{ number_format($product->finalPrice()) }}</p>
                        </div>
                        <div class="p-4 rounded-2xl bg-gray-50 border">
                            <p class="text-xs text-gray-500">Stok</p>
                            <p class="text-base font-semibold text-gray-800">{{ $product->stock }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div>
                <p class="text-sm font-semibold text-gray-800 mb-2">Deskripsi</p>
                <div class="p-4 rounded-2xl bg-gray-50 border text-sm text-gray-700">
                    {!! nl2br(e($product->description ?? '-')) !!}
                </div>
            </div>

            {{-- Gallery --}}
            @if ($product->images()->count() > 0)
                <div>
                    <p class="text-sm font-semibold text-gray-800 mb-2">Gallery</p>
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-3">
                        @foreach ($product->images()->orderBy('sort_order')->get() as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                class="w-full aspect-square rounded-2xl object-cover border" alt="gallery">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

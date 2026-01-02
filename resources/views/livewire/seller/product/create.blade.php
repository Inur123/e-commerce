{{-- resources/views/livewire/seller/product/create.blade.php --}}
<div class="w-full space-y-4 sm:space-y-6">
    {{-- HEADER --}}
    <div class="flex items-start justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Tambah Produk</h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Lengkapi informasi produk baru</p>
        </div>

        <button type="button" wire:click="back"
            class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </button>
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

    {{-- FORM CARD --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">Form Produk</h3>
            <span class="text-xs px-2 py-1 bg-orange-50 text-orange-700 rounded-full">
                <i class="fas fa-box mr-1"></i>Create
            </span>
        </div>

        <div class="p-4 sm:p-6 space-y-5">
            {{-- Nama --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                <input type="text" wire:model.defer="name" placeholder="Contoh: Sepatu Running"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                @error('name') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Harga / Sale / Stock --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" wire:model.defer="price" placeholder="100000"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    @error('price') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Harga Diskon (opsional)</label>
                    <input type="number" wire:model.defer="sale_price" placeholder="90000"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    @error('sale_price') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" wire:model.defer="stock" placeholder="10"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    @error('stock') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.defer="status"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Deskripsi (opsional)</label>
                <textarea wire:model.defer="description" rows="4" placeholder="Tulis deskripsi produk..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none"></textarea>
                @error('description') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- Thumbnail --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Thumbnail</label>
                <input type="file" wire:model="thumbnailUpload" accept="image/*"
                    class="w-full text-sm file:mr-4 file:py-2 file:px-4
                           file:rounded-xl file:border-0 file:text-sm file:font-semibold
                           file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                @error('thumbnailUpload') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror

                {{-- Preview --}}
                @if ($thumbnailUpload)
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 mb-2">Preview:</p>
                        <img src="{{ $thumbnailUpload->temporaryUrl() }}" class="w-24 h-24 rounded-xl object-cover border">
                    </div>
                @endif
            </div>

            {{-- Gallery --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Foto Produk (Gallery, opsional)</label>
                <input type="file" wire:model="galleryUploads" accept="image/*" multiple
                    class="w-full text-sm file:mr-4 file:py-2 file:px-4
                           file:rounded-xl file:border-0 file:text-sm file:font-semibold
                           file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                @error('galleryUploads.*') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror

                {{-- Preview gallery --}}
                @if (!empty($galleryUploads))
                    <div class="mt-3 grid grid-cols-3 sm:grid-cols-6 gap-2">
                        @foreach ($galleryUploads as $img)
                            <img src="{{ $img->temporaryUrl() }}" class="w-full aspect-square rounded-xl object-cover border">
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ACTIONS --}}
            <div class="pt-2 flex flex-col sm:flex-row gap-3 sm:justify-end">
                <button type="button" wire:click="back"
                    class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                    Batal
                </button>

                <button type="button" wire:click="save" wire:loading.attr="disabled"
                    class="px-5 py-2.5 rounded-xl bg-orange-500 text-white hover:bg-orange-600 transition text-sm font-medium">
                    <span wire:loading.remove wire:target="save"><i class="fas fa-save mr-2"></i>Simpan</span>
                    <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
</div>

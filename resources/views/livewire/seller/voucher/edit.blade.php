<div class="w-full space-y-4 sm:space-y-6">

    {{-- HEADER --}}
    <div class="flex items-start justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Edit Voucher</h1>
            <p class="text-xs sm:text-sm text-gray-600 mt-1">Perbarui voucher diskon toko kamu</p>
        </div>

        <div class="flex gap-2">
            <button type="button" wire:click="$set('action','detail')"
                class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                <i class="fas fa-eye mr-2"></i>Detail
            </button>

            <button type="button" wire:click="back"
                class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
        </div>
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

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">Form Edit Voucher</h3>
            <span class="text-xs px-2 py-1 bg-yellow-50 text-yellow-700 rounded-full">
                <i class="fas fa-pen mr-1"></i>Edit
            </span>
        </div>

        <div class="p-4 sm:p-6 space-y-5">

            {{-- CODE --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Kode Voucher</label>
                <input type="text" wire:model.defer="code"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none uppercase">
                @error('code') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- DISCOUNT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Tipe Diskon</label>
                    <select wire:model.live="discount_type"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Potongan Rupiah</option>
                    </select>
                    @error('discount_type') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                <div x-data="{
                    raw: @entangle('discount_value').live,
                    format(val) {
                        val = String(val ?? '').replace(/\D/g,'');
                        return val ? val.replace(/\B(?=(\d{3})+(?!\d))/g,'.') : '';
                    }
                }">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Nilai Diskon</label>

                    <input type="text" inputmode="numeric"
                        x-bind:value="discount_type === 'fixed' ? format(raw) : raw"
                        x-on:input="
                            raw = $event.target.value.replace(/\D/g,'');
                            $event.target.value = discount_type === 'fixed' ? format(raw) : raw;
                        "
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">

                    @error('discount_value') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- LIMIT --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Max Usage</label>
                    <input type="number" wire:model.defer="max_usage"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    @error('max_usage') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Max per User</label>
                    <input type="number" wire:model.defer="max_usage_per_user"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    @error('max_usage_per_user') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                <div x-data="{
                    raw: @entangle('min_purchase').live,
                    format(val) {
                        val = String(val ?? '').replace(/\D/g,'');
                        return val ? val.replace(/\B(?=(\d{3})+(?!\d))/g,'.') : '';
                    }
                }">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Min Pembelian</label>

                    <input type="text" inputmode="numeric"
                        x-bind:value="format(raw)"
                        x-on:input="
                            raw = $event.target.value.replace(/\D/g,'');
                            $event.target.value = format(raw);
                        "
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">

                    @error('min_purchase') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- DATE --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="datetime-local" wire:model.defer="start_date"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    @error('start_date') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="datetime-local" wire:model.defer="end_date"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                               focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    @error('end_date') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- APPLY TO --}}
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Voucher berlaku untuk</label>
                <select wire:model.live="applies_to"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent focus:outline-none">
                    <option value="all">Semua Produk</option>
                    <option value="selected">Produk Tertentu</option>
                </select>
                @error('applies_to') <p class="text-xs text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            {{-- SELECTED PRODUCTS --}}
            @if ($applies_to === 'selected')
                <div class="border rounded-2xl p-4 bg-gray-50">
                    <h4 class="text-sm font-semibold text-gray-800 mb-3">
                        Pilih Produk yang Berlaku
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto">
                        @foreach($availableProducts as $p)
                            <label class="flex items-center gap-2 bg-white px-3 py-2 rounded-xl border cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" wire:model="selectedProducts" value="{{ $p['id'] }}"
                                    class="rounded text-orange-500 focus:ring-orange-500">
                                <span class="text-sm text-gray-700">{{ $p['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- STATUS --}}
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

            {{-- ACTIONS --}}
            <div class="pt-2 flex flex-col sm:flex-row gap-3 sm:justify-end">
                <button type="button" wire:click="back"
                    class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition text-sm font-medium">
                    Batal
                </button>

                <button type="button" wire:click="update" wire:loading.attr="disabled"
                    class="px-5 py-2.5 rounded-xl bg-orange-500 text-white hover:bg-orange-600 transition text-sm font-medium">
                    <span wire:loading.remove wire:target="update"><i class="fas fa-save mr-2"></i>Update</span>
                    <span wire:loading wire:target="update"><i class="fas fa-spinner fa-spin mr-2"></i>Mengupdate...</span>
                </button>
            </div>

        </div>
    </div>
</div>

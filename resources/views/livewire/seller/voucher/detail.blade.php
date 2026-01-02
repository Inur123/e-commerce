<div class="w-full space-y-6">

    {{-- BACK --}}
    <button wire:click="back"
        class="inline-flex items-center gap-2 text-orange-600 font-medium hover:underline">
        <i class="fas fa-arrow-left"></i> Kembali
    </button>

    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-wrap items-start justify-between gap-4">

            <div>
                <h2 class="text-xl font-bold text-gray-800">Detail Voucher</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Code: <b class="uppercase">{{ $voucher->code }}</b>
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $voucher->status === 'active'
                        ? 'bg-green-50 text-green-700'
                        : 'bg-gray-100 text-gray-700' }}">
                    {{ strtoupper($voucher->status) }}
                </span>
            </div>
        </div>

        {{-- INFO GRID --}}
        <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700 border-t pt-4">

            {{-- LEFT --}}
            <div class="space-y-2">
                <p>
                    <b>Tipe Diskon:</b>
                    {{ $voucher->discount_type === 'percentage' ? 'Persentase (%)' : 'Fixed Rupiah' }}
                </p>

                <p>
                    <b>Nilai Diskon:</b>
                    @if($voucher->discount_type === 'percentage')
                        {{ $voucher->discount_value }}%
                    @else
                        Rp{{ number_format($voucher->discount_value) }}
                    @endif
                </p>

                <p>
                    <b>Min Pembelian:</b>
                    {{ $voucher->min_purchase ? 'Rp'.number_format($voucher->min_purchase) : '-' }}
                </p>

                <p>
                    <b>Applies To:</b>
                    {{ $voucher->applies_to === 'all' ? 'Semua Produk' : 'Produk Tertentu' }}
                </p>
            </div>

            {{-- RIGHT --}}
            <div class="space-y-2">
                <p><b>Max Usage:</b> {{ $voucher->max_usage }}</p>
                <p><b>Used Count:</b> {{ $voucher->used_count }}</p>
                <p><b>Max per User:</b> {{ $voucher->max_usage_per_user ?? '-' }}</p>

                <p>
                    <b>Periode:</b><br>
                    <span class="text-gray-600">
                        {{ $voucher->start_date->format('d M Y H:i') }}
                        -
                        {{ $voucher->end_date->format('d M Y H:i') }}
                    </span>
                </p>
            </div>
        </div>

        {{-- PRODUK SELECTED --}}
        @if($voucher->applies_to === 'selected')
            <div class="border-t pt-4 space-y-3">
                <h3 class="font-semibold text-gray-800">Produk Voucher Berlaku</h3>

                @if($voucher->products->count() > 0)
                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($voucher->products as $p)
                            <div class="flex items-center gap-3 border rounded-xl p-3 hover:bg-gray-50 transition">
                                <img src="{{ $p->thumbnail ? asset('storage/'.$p->thumbnail) : 'https://via.placeholder.com/80' }}"
                                    class="w-14 h-14 rounded-xl object-cover border shrink-0" />

                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-gray-800 truncate">{{ $p->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Rp{{ number_format($p->finalPrice()) }} • Stok: {{ $p->stock }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">Tidak ada produk yang dipilih.</p>
                @endif
            </div>
        @endif

        {{-- ACTIONS --}}
        <div class="border-t pt-4 flex flex-wrap gap-3 justify-end">
            <button wire:click="edit('{{ $voucher->id }}')"
                class="px-4 py-2.5 rounded-xl bg-yellow-500 text-white hover:bg-yellow-600 transition text-sm font-medium">
                <i class="fas fa-pen mr-2"></i>Edit
            </button>

            <button wire:click="confirmDelete('{{ $voucher->id }}')"
                class="px-4 py-2.5 rounded-xl bg-red-500 text-white hover:bg-red-600 transition text-sm font-medium">
                <i class="fas fa-trash mr-2"></i>Hapus
            </button>
        </div>

    </div>

    {{-- ✅ SWEET ALERT --}}
    <script>
        document.addEventListener("livewire:init", () => {

            Livewire.on("swal:confirm-delete-voucher", () => {
                Swal.fire({
                    title: "Hapus voucher ini?",
                    text: "Voucher yang sudah dihapus tidak bisa dikembalikan.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal",
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call("delete");
                    }
                });
            });

            Livewire.on("swal:done", ({ type, message }) => {
                Swal.fire({
                    icon: type ?? "success",
                    title: (type === "error") ? "Gagal" : "Berhasil",
                    text: message ?? "",
                    timer: 1500,
                    showConfirmButton: false,
                });
            });

        });
    </script>

</div>

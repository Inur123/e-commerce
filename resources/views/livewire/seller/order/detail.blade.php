<div class="w-full space-y-6">

    <button wire:click="back"
        class="text-orange-600 font-medium hover:underline">
        ← Kembali
    </button>

    <div class="bg-white rounded-2xl shadow p-6 space-y-5">
        <h2 class="text-xl font-bold text-gray-800">Detail Pesanan</h2>

        <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700">
            <div>
                <p><b>Order Code:</b> {{ $order->order_code }}</p>
                <p><b>Status:</b> {{ $order->status }}</p>
                <p><b>Total:</b> Rp{{ number_format($order->total_amount) }}</p>
            </div>

            <div>
                <p><b>Buyer:</b> {{ $order->buyer->name ?? '-' }}</p>
                <p><b>Phone:</b> {{ $order->phone }}</p>
                <p><b>Voucher:</b> {{ $order->voucher?->code ?? '-' }}</p>
            </div>
        </div>

        <div class="border-t pt-4 text-sm text-gray-700">
            <p><b>Alamat:</b></p>
            <p class="text-gray-600 mt-1">{{ $order->address }}</p>
        </div>

        {{-- Items --}}
        <div class="border-t pt-4 space-y-3">
            <h3 class="font-semibold text-gray-800">Produk (milik kamu)</h3>

            @foreach($order->items->where('seller_id', auth()->id()) as $item)
                <div class="flex items-center gap-3 border rounded-xl p-3">
                    <img src="{{ $item->product->thumbnail ? asset('storage/'.$item->product->thumbnail) : 'https://via.placeholder.com/80' }}"
                        class="w-14 h-14 rounded-xl object-cover border">

                    <div class="flex-1">
                        <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                        <p class="text-xs text-gray-500">
                            Qty: {{ $item->qty }} |
                            Harga: Rp{{ number_format($item->price) }}
                        </p>
                    </div>

                    <div class="text-sm font-semibold text-gray-800">
                        Rp{{ number_format($item->subtotal) }}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ACTIONS --}}
        <div class="border-t pt-4 flex flex-wrap gap-3">
            @if ($order->status === 'paid')
                <button wire:click="updateStatus('{{ $order->id }}','shipped')"
                    class="px-4 py-2 bg-yellow-500 text-white rounded-xl hover:bg-yellow-600">
                    Mark Shipped
                </button>
            @endif

            @if ($order->status === 'shipped')
                <button wire:click="updateStatus('{{ $order->id }}','completed')"
                    class="px-4 py-2 bg-green-500 text-white rounded-xl hover:bg-green-600">
                    Mark Completed
                </button>
            @endif
        </div>
    </div>
</div>

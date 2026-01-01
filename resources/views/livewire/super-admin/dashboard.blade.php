<div>
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Super Admin</h1>
    <p class="mt-2 text-gray-600">Selamat datang, {{ auth()->user()->name }} 👋</p>

    {{-- Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Users</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">1,245</h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Produk</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">812</h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Transaksi Hari Ini</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">98</h2>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <p class="text-sm text-gray-500">Pendapatan</p>
            <h2 class="text-2xl font-bold text-gray-800 mt-2">Rp 12.500.000</h2>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mt-8 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Transaksi Terbaru</h3>
            <a href="#" class="text-sm text-orange-500 font-medium hover:underline">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-semibold">Invoice</th>
                        <th class="text-left px-6 py-3 font-semibold">Customer</th>
                        <th class="text-left px-6 py-3 font-semibold">Total</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-left px-6 py-3 font-semibold">Tanggal</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 text-gray-700">
                    @for($i=1; $i<=30; $i++)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium">INV-00{{ $i }}</td>
                        <td class="px-6 py-4">Customer {{ $i }}</td>
                        <td class="px-6 py-4">Rp {{ number_format(1000000 + $i*25000) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                Sukses
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ now()->subDays($i)->format('d M Y') }}</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

    {{-- Fake content panjang biar scroll kelihatan --}}
    <div class="mt-10 space-y-4">
        @for($i=1; $i<=20; $i++)
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <h4 class="font-bold text-gray-800">Widget Statistik {{ $i }}</h4>
                <p class="text-sm text-gray-600 mt-1">
                    Ini contoh konten panjang supaya kamu lihat scrolling hanya di area content, header & footer tetap fix.
                </p>
            </div>
        @endfor
    </div>

</div>

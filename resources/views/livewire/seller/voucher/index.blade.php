<div class="w-full space-y-4 sm:space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Voucher</h1>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">Kelola voucher diskon khusus toko kamu</p>
    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="bg-white rounded-2xl shadow p-4">
            <p class="text-xs text-gray-500">Total Voucher</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4">
            <p class="text-xs text-gray-500">Active</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-4">
            <p class="text-xs text-gray-500">Inactive</p>
            <p class="text-2xl font-bold text-gray-600">{{ $stats['inactive'] }}</p>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-2">Cari</label>
                <input type="text" wire:model.live.debounce.500ms="search"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-orange-500 focus:border-orange-500"
                    placeholder="Kode voucher..." />
            </div>

            <div>
                <label class="block text-xs font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="filterStatus"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-orange-500 focus:border-orange-500">
                    <option value="">Semua</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button wire:click="create"
                class="w-full bg-orange-500 text-white px-4 py-2.5 rounded-xl hover:bg-orange-600 transition text-sm font-medium">
                <i class="fas fa-plus mr-2"></i>Tambah Voucher
            </button>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Diskon</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Masa Berlaku</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($vouchers as $v)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-semibold text-gray-800">{{ $v->code }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @if($v->discount_type === 'percentage')
                                    {{ $v->discount_value }}%
                                @else
                                    Rp{{ number_format($v->discount_value) }}
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-gray-500">
                                {{ $v->start_date->format('d M Y') }} - {{ $v->end_date->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $v->status === 'active' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ strtoupper($v->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3 text-lg">
                                    <button wire:click="detail('{{ $v->id }}')" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button wire:click="edit('{{ $v->id }}')" class="text-yellow-600 hover:text-yellow-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete('{{ $v->id }}')" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                <i class="fas fa-ticket text-4xl mb-2"></i>
                                <p>Belum ada voucher</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $vouchers->links() }}
    </div>

    {{-- SWEET ALERT --}}
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal:confirm-delete', () => {
                Swal.fire({
                    title: 'Hapus voucher ini?',
                    text: 'Voucher yang dihapus tidak bisa dikembalikan.',
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

            Livewire.on('swal:done', ({type, message}) => {
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

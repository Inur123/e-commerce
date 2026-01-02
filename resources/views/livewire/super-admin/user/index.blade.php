{{-- resources/views/livewire/super-admin/user/index.blade.php --}}
<div class="w-full space-y-4 sm:space-y-6">
    {{-- HEADER --}}
    <div>
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Manajemen User</h1>
        <p class="text-xs sm:text-sm text-gray-600 mt-1">Kelola akun pengguna (role & status)</p>
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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
    {{-- Total User + Breakdown Role --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs text-gray-500">Total User</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                    {{ $stats['total'] }}
                </p>
                <p class="text-[11px] text-gray-400 mt-1">Mengikuti filter saat ini</p>
            </div>

            <span class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shrink-0">
                <i class="fas fa-users"></i>
            </span>
        </div>

        @php
            $roleLabels = [
                'super_admin' => 'Super Admin',
                'admin' => 'Admin',
                'seller' => 'Seller',
                'buyer' => 'Buyer',
            ];
        @endphp

        <div class="mt-4 space-y-2">
            @foreach ($roleLabels as $key => $label)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">{{ $label }}</span>
                    <span class="font-semibold text-gray-800">{{ $stats['roles'][$key] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Active --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs text-gray-500">User Active</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                    {{ $stats['active'] }}
                </p>
                <p class="text-[11px] text-gray-400 mt-1">Status: active</p>
            </div>

            <span class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                <i class="fas fa-check-circle"></i>
            </span>
        </div>

        <div class="mt-4">
            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                @php
                    $percent = ($stats['total'] > 0) ? round(($stats['active'] / $stats['total']) * 100) : 0;
                @endphp
                <div class="h-full bg-green-500" style="width: {{ $percent }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">{{ $percent }}% dari total</p>
        </div>
    </div>

    {{-- Inactive (opsional tapi enak) --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs text-gray-500">User Inactive</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-800 mt-1">
                    {{ $stats['inactive'] }}
                </p>
                <p class="text-[11px] text-gray-400 mt-1">Status: inactive</p>
            </div>

            <span class="w-10 h-10 rounded-xl bg-gray-100 text-gray-600 flex items-center justify-center shrink-0">
                <i class="fas fa-times-circle"></i>
            </span>
        </div>

        <div class="mt-4">
            <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                @php
                    $percentIn = ($stats['total'] > 0) ? round(($stats['inactive'] / $stats['total']) * 100) : 0;
                @endphp
                <div class="h-full bg-gray-500" style="width: {{ $percentIn }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">{{ $percentIn }}% dari total</p>
        </div>
    </div>
</div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow p-4 sm:p-5">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 items-end">
            <div class="col-span-2 lg:col-span-1">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Cari User</label>
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Nama atau email..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl
                           focus:outline-none focus-visible:outline-none
                           focus:ring-2 focus:ring-orange-500 focus:ring-offset-0
                           focus:border-transparent text-sm">
            </div>

            <div class="col-span-1">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Role</label>
                <select wire:model.live="filterRole"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl
                           focus:outline-none focus-visible:outline-none
                           focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                    <option value="">Semua</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="seller">Seller</option>
                    <option value="buyer">Buyer</option>
                </select>
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
                    <i class="fas fa-plus mr-2"></i>Tambah User
                </button>
            </div>
        </div>
    </div>

    {{-- LIST (MOBILE) --}}
    <div class="md:hidden bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-800">Daftar User</h3>
            <span class="text-[10px] px-2 py-1 bg-orange-50 text-orange-700 rounded-full">
                <i class="fas fa-users mr-1"></i>Users
            </span>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($users as $u)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">
                                {{ \Illuminate\Support\Str::title($u->name) }}
                            </p>
                            <p class="text-xs text-gray-500 truncate mt-1">
                                {{ $u->email }}
                            </p>

                            <div class="flex flex-wrap items-center gap-2 mt-3">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700">
                                    <i class="fas fa-user-tag mr-1"></i>
                                    {{ str_replace('_', ' ', \Illuminate\Support\Str::title($u->role)) }}
                                </span>

                                @if ($u->status === 'active')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-lg shrink-0">
                            <button type="button" wire:click="edit('{{ $u->id }}')"
                                class="text-yellow-600 hover:text-yellow-800 transition cursor-pointer" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>

                            {{-- ✅ HAPUS (SweetAlert) --}}
                            <button type="button" wire:click="confirmDelete('{{ $u->id }}')"
                                class="text-red-600 hover:text-red-800 transition cursor-pointer" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-10 text-center text-gray-500">
                    <i class="fas fa-users text-4xl mb-3 block"></i>
                    <p class="text-base">Belum ada data user</p>
                    @if ($search || $filterRole || $filterStatus)
                        <p class="text-sm mt-2">Coba ubah filter atau kata kunci pencarian Anda</p>
                    @endif
                </div>
            @endforelse
        </div>
    </div>

    {{-- TABLE (DESKTOP) --}}
    <div class="hidden md:block bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between gap-3">
            <h3 class="text-base lg:text-lg font-semibold text-gray-800">Daftar User</h3>

            <span class="text-xs px-2 py-1 bg-orange-50 text-orange-700 rounded-full whitespace-nowrap">
                <i class="fas fa-shield-alt mr-1"></i>Super Admin Area
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                            No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Role</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Aksi</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ $users->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-3 text-sm font-semibold text-gray-800 whitespace-nowrap">
                                {{ \Illuminate\Support\Str::title(\Illuminate\Support\Str::limit($u->name, 30)) }}
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                                {{ \Illuminate\Support\Str::limit($u->email, 50) }}
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-50 text-orange-700">
                                    <i class="fas fa-user-tag mr-1"></i>
                                    {{ str_replace('_', ' ', \Illuminate\Support\Str::title($u->role)) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                @if ($u->status === 'active')
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                        <i class="fas fa-check-circle mr-1"></i>Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        <i class="fas fa-times-circle mr-1"></i>Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-3 text-lg">
                                    <button type="button" wire:click="edit('{{ $u->id }}')"
                                        class="text-yellow-600 hover:text-yellow-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    {{-- ✅ HAPUS (SweetAlert) --}}
                                    <button type="button" wire:click="confirmDelete('{{ $u->id }}')"
                                        class="text-red-600 hover:text-red-800 transition-transform hover:scale-110 cursor-pointer"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                                <i class="fas fa-users text-4xl mb-3 block"></i>
                                <p class="text-base">Belum ada data user</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION (SEMUA DEVICE) --}}
    @if ($users->hasPages())
        <div class="bg-white rounded-2xl shadow p-3 sm:p-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="text-xs sm:text-sm text-gray-700">
                    Menampilkan <span class="font-medium">{{ $users->firstItem() }}</span>
                    sampai <span class="font-medium">{{ $users->lastItem() }}</span>
                    dari <span class="font-medium">{{ $users->total() }}</span> hasil
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    {{-- Prev --}}
                    @if ($users->onFirstPage())
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
                        $current = $users->currentPage();
                        $last = $users->lastPage();

                        $start = max(1, $current - 2);
                        $end = min($last, $current + 2);

                        if ($end - $start < 4) {
                            if ($start == 1) {
                                $end = min($last, $start + 4);
                            } elseif ($end == $last) {
                                $start = max(1, $end - 4);
                            }
                        }
                    @endphp

                    {{-- first + dots --}}
                    @if ($start > 1)
                        <button type="button" wire:click="gotoPage(1)" wire:loading.attr="disabled"
                            class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            1
                        </button>

                        @if ($start > 2)
                            <span class="px-3 py-2 text-sm text-gray-400">...</span>
                        @endif
                    @endif

                    {{-- window --}}
                    @for ($p = $start; $p <= $end; $p++)
                        @if ($p == $current)
                            <span class="px-4 py-2 text-sm text-white bg-orange-500 rounded-xl font-medium">
                                {{ $p }}
                            </span>
                        @else
                            <button type="button" wire:click="gotoPage({{ $p }})"
                                wire:loading.attr="disabled"
                                class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                                {{ $p }}
                            </button>
                        @endif
                    @endfor

                    {{-- dots + last --}}
                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span class="px-3 py-2 text-sm text-gray-400">...</span>
                        @endif

                        <button type="button" wire:click="gotoPage({{ $last }})"
                            wire:loading.attr="disabled"
                            class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                            {{ $last }}
                        </button>
                    @endif

                    {{-- Next --}}
                    @if ($users->hasMorePages())
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
            // tampil confirm
            Livewire.on('swal:confirm-delete', () => {
                Swal.fire({
                    title: 'Hapus user ini?',
                    text: 'Data yang sudah dihapus tidak bisa dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        // panggil method delete() (tanpa parameter) di component
                        @this.call('delete');
                    }
                });
            });

            // toast sukses/gagal (opsional)
            Livewire.on('swal:done', ({
                type,
                message
            }) => {
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

<div class="">
    <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
        {{-- Header --}}
        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Edit User</h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">
                    ID: <span class="font-medium">{{ $user->id }}</span>
                </p>
            </div>

            <button wire:click="back"
                class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form wire:submit="update" class="space-y-5">
            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                @error('name')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition">
                @error('email')
                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Role & Status --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select wire:model="role"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition bg-white">
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select wire:model="status"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition bg-white">
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-between pt-6 border-t border-gray-100">
                <button type="button" wire:click="back"
                    class="w-full sm:w-auto px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                    Batal
                </button>

                <button type="submit"
                    class="w-full sm:w-auto px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Update User</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- resources/views/livewire/super-admin/user/create.blade.php -->
<div class="">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Tambah User Baru</h2>
                <p class="text-gray-500 text-sm">Isi form untuk menambahkan user baru</p>
            </div>
            <button wire:click="back"
                class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form wire:submit="save" class="space-y-5">
            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                    placeholder="Masukkan nama lengkap">
                @error('name')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition"
                    placeholder="user@example.com">
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                <div class="relative">
                    <input type="password" wire:model="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition pr-10"
                        placeholder="Minimal 6 karakter">
                    <button type="button" class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600"
                        onclick="togglePassword(this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Role dan Status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Role --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                    <select wire:model="role"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition bg-white">
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select wire:model="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none transition bg-white">
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                <button type="button" wire:click="back"
                    class="px-5 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-xl transition duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Simpan User</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(button) {
        const input = button.previousElementSibling;
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

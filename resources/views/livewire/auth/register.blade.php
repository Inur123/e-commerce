<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold text-center mb-6">Register Super Admin</h1>

        <form wire:submit.prevent="register" class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Nama</label>
                <input type="text" wire:model="name"
                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring" />
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" wire:model="email"
                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring" />
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" wire:model="password"
                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring" />
                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Konfirmasi Password</label>
                <input type="password" wire:model="password_confirmation"
                    class="w-full border rounded-lg p-2 focus:outline-none focus:ring" />
            </div>

            <button type="submit"
                class="w-full bg-black text-white py-2 rounded-lg hover:opacity-90">
                Register
            </button>
        </form>

        <div class="mt-4 text-center text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                Login
            </a>
        </div>
    </div>
</div>

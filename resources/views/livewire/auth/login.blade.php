<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold text-center mb-6">Login Super Admin</h1>

        <form wire:submit.prevent="login" class="space-y-4">
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

            <button type="submit"
                class="w-full bg-black text-white py-2 rounded-lg hover:opacity-90">
                Login
            </button>
        </form>
    </div>
</div>

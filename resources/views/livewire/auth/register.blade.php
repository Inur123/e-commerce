<div x-data="{ show: false, show2: false }" class="rounded-3xl bg-white shadow-xl ring-1 ring-slate-200 p-6 sm:p-8">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-slate-900">Buat akun baru</h2>
        <p class="mt-1 text-sm text-slate-500">Isi data berikut untuk mendaftar sebagai buyer.</p>
    </div>

    {{-- ERROR LIST --}}
    @if ($errors->any())
        <div class="mt-5 rounded-2xl bg-rose-50 ring-1 ring-rose-200 p-4">
            <div class="text-sm font-semibold text-rose-700">Terjadi kesalahan:</div>
            <ul class="mt-2 space-y-1 text-sm text-rose-600">
                @foreach ($errors->all() as $err)
                    <li>• {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="register" class="mt-6 space-y-4">

        {{-- NAME --}}
        <div>
            <label class="text-sm font-medium text-slate-700">Nama Lengkap</label>
            <input type="text" wire:model.defer="name" wire:loading.attr="disabled" wire:target="register" required
                class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm
                       placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400
                       disabled:opacity-60 disabled:cursor-not-allowed"
                placeholder="Nama kamu">
            @error('name')
                <p class="text-rose-600 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="text-sm font-medium text-slate-700">Email</label>
            <input type="email" wire:model.defer="email" wire:loading.attr="disabled" wire:target="register" required
                class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm
                       placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400
                       disabled:opacity-60 disabled:cursor-not-allowed"
                placeholder="nama@email.com">
            @error('email')
                <p class="text-rose-600 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- PASSWORD --}}

        <div>
            <label class="text-sm font-medium text-slate-700">Password</label>
            <div class="mt-2 relative">
                <input :type="show ? 'text' : 'password'" wire:model.defer="password" wire:loading.attr="disabled"
                    wire:target="register" required
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm
                   placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400
                   disabled:opacity-60 disabled:cursor-not-allowed"
                    placeholder="••••••••">

                <button type="button"
                    class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-slate-600"
                    @click="show = !show">

                    <!-- Eye (password hidden) -->
                    <span x-show="!show" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </span>

                    <!-- Eye Slash (password visible) -->
                    <span x-show="show" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </span>
                </button>
            </div>

            @error('password')
                <p class="text-rose-600 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>



        {{-- PASSWORD CONFIRM --}}
        <div>
            <label class="text-sm font-medium text-slate-700">Konfirmasi Password</label>
            <div class="mt-2 relative">
                <input :type="show2 ? 'text' : 'password'" wire:model.defer="password_confirmation"
                    wire:loading.attr="disabled" wire:target="register" required
                    class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm
                   placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400
                   disabled:opacity-60 disabled:cursor-not-allowed"
                    placeholder="••••••••">

                <button type="button"
                    class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-400 hover:text-slate-600"
                    @click="show2 = !show2">

                    <!-- Eye (password hidden) -->
                    <span x-show="!show2" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </span>

                    <!-- Eye Slash (password visible) -->
                    <span x-show="show2" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>


        {{-- BUTTON + SPINNER --}}
        <button type="submit" wire:loading.attr="disabled" wire:target="register"
            class="relative w-full h-12 rounded-2xl bg-blue-600 hover:bg-blue-500 transition
           px-4 text-sm font-semibold text-white shadow-lg shadow-blue-600/20
           disabled:opacity-60 disabled:cursor-not-allowed">
            {{-- TEXT NORMAL --}}
            <span wire:loading.class="opacity-0" wire:target="register"
                class="inline-flex items-center justify-center w-full h-full">
                Daftar
            </span>

            {{-- SPINNER CENTER --}}
            <span wire:loading wire:target="register"
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                <svg class="h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
            </span>
        </button>


        {{-- LINK LOGIN (SPA) --}}
        <p class="text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" wire:navigate class="text-orange-600 hover:text-orange-500 font-semibold">
                Login
            </a>
        </p>

        <div class="mt-4 text-xs text-slate-400 text-center">
            Dengan mendaftar, kamu setuju dengan kebijakan dan ketentuan layanan.
        </div>
    </form>
</div>

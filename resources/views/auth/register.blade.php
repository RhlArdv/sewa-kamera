@extends('layouts.guest')

@section('content')
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black tracking-tighter text-zinc-950 uppercase" style="text-shadow: 2px 2px 0px #9E1B22;">Daftar</h2>
        <p class="text-zinc-500 font-medium mt-2">Buat akun untuk mulai menyewa kamera.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-black text-sm text-zinc-950 uppercase tracking-tight mb-2">Nama Lengkap</label>
            <input id="name" class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name')
                <p class="text-sm text-red-600 font-bold mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-black text-sm text-zinc-950 uppercase tracking-tight mb-2">Email</label>
            <input id="email" class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            @error('email')
                <p class="text-sm text-red-600 font-bold mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-black text-sm text-zinc-950 uppercase tracking-tight mb-2">Password</label>
            <div class="relative">
                <input id="password" class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4 pr-12" type="password" name="password" required autocomplete="new-password">
                <button type="button" onclick="togglePassword('password', 'eye-icon-password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-zinc-500 hover:text-zinc-950">
                    <svg id="eye-icon-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-sm text-red-600 font-bold mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block font-black text-sm text-zinc-950 uppercase tracking-tight mb-2">Konfirmasi Password</label>
            <div class="relative">
                <input id="password_confirmation" class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4 pr-12" type="password" name="password_confirmation" required autocomplete="new-password">
                <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-password-confirmation')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-zinc-500 hover:text-zinc-950">
                    <svg id="eye-icon-password-confirmation" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="text-sm text-red-600 font-bold mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3.5 bg-[#9E1B22] text-white font-black uppercase tracking-wider text-[15px] rounded-xl border-2 border-zinc-950 hover:-translate-y-1 hover:shadow-[4px_4px_0_0_#7A151B] active:translate-y-0 active:shadow-none transition-all duration-300">
                Daftar
            </button>
            
            <div class="mt-6 text-center">
                <p class="text-sm font-medium text-zinc-600">Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-black text-zinc-950 hover:text-[#9E1B22] transition-colors uppercase tracking-tight ml-1">Masuk di sini</a>
                </p>
            </div>
        </div>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />';
            }
        }
    </script>
@endsection

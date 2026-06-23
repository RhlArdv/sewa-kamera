@extends('layouts.guest')

@section('content')
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-black tracking-tighter text-zinc-950 uppercase" style="text-shadow: 2px 2px 0px #9E1B22;">Reset Password</h2>
    </div>

    <div class="mb-6 text-sm text-zinc-600 font-medium leading-relaxed bg-zinc-50 border-2 border-zinc-200 p-4 rounded-xl">
        {{ __('Lupa password? Tidak masalah. Masukkan email Anda dan kami akan mengirimkan tautan untuk membuat password baru.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-6 font-medium text-sm text-green-700 bg-green-50 p-4 rounded-xl border-2 border-green-200">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-black text-sm text-zinc-950 uppercase tracking-tight mb-2">{{ __('Email') }}</label>
            <input id="email" class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold placeholder-zinc-400 focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <p class="text-sm text-red-600 font-bold mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3.5 bg-[#9E1B22] text-white font-black uppercase tracking-wider text-[14px] rounded-xl border-2 border-zinc-950 hover:-translate-y-1 hover:shadow-[4px_4px_0_0_#7A151B] active:translate-y-0 active:shadow-none transition-all duration-300">
                Kirim Link Reset Password
            </button>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm font-black text-zinc-950 hover:text-[#9E1B22] transition-colors uppercase tracking-tight">Kembali ke halaman Login</a>
            </div>
        </div>
    </form>
@endsection

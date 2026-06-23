<nav x-data="{ open: false }" class="bg-white border-b-2 border-black sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}"
                        class="focus:outline-none focus-visible:ring-2 focus-visible:ring-black rounded-md flex items-center gap-3">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="CameraSewa Logo" class="block h-14 w-auto object-contain scale-110 origin-left">
                        <span class="font-extrabold text-2xl tracking-tight hidden sm:block pt-1">Camera<span class="text-[#9E1B22]">Sewa</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center px-1 pt-1 text-black font-extrabold text-sm border-b-4 transition duration-150 {{ request()->routeIs('home') ? 'border-[#9E1B22]' : 'border-transparent hover:border-[#9E1B22]' }}">
                        Katalog Kamera
                    </a>
                </div>
            </div>

            <!-- Authentication Actions -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if(auth()->check())
                    <div class="space-x-4 flex items-center">
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('menu.dashboard') }}"
                                class="text-sm font-black text-black border-2 border-black bg-white px-4 py-2 hover:bg-zinc-50 active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#9E1B22] hover:shadow-[4px_4px_0px_0px_#9E1B22] active:shadow-none transition-all outline-none focus-visible:ring-2 focus-visible:ring-black rounded-xl">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('cart.index') }}"
                                class="text-sm font-black text-black border-2 border-black bg-white px-4 py-2 hover:bg-zinc-50 active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#9E1B22] hover:shadow-[4px_4px_0px_0px_#9E1B22] active:shadow-none transition-all outline-none focus-visible:ring-2 focus-visible:ring-black rounded-xl relative">
                                Keranjang
                                @if(\App\Models\Cart::where('user_id', auth()->id())->count() > 0)
                                    <span class="absolute -top-2 -right-2 bg-[#9E1B22] text-white text-[10px] font-black px-2 py-0.5 border-2 border-black rounded-full">{{\App\Models\Cart::where('user_id', auth()->id())->count()}}</span>
                                @endif
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center text-xs uppercase tracking-wider font-black text-white border-2 border-black bg-[#9E1B22] px-5 py-2 hover:bg-[#7A151B] active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#7A151B] hover:shadow-[4px_4px_0px_0px_#7A151B] active:shadow-none transition-all outline-none focus-visible:ring-2 focus-visible:ring-black rounded-xl">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="space-x-4 flex items-center">
                        <a href="{{ route('login') }}"
                            class="text-sm font-black text-black border-2 border-black bg-white px-4 py-2 hover:bg-zinc-50 active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#9E1B22] hover:shadow-[4px_4px_0px_0px_#9E1B22] active:shadow-none transition-all outline-none focus-visible:ring-2 focus-visible:ring-black rounded-xl">
                            Log in
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center text-xs uppercase tracking-wider font-black text-white border-2 border-black bg-[#9E1B22] px-5 py-2 hover:bg-[#7A151B] active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#7A151B] hover:shadow-[4px_4px_0px_0px_#7A151B] active:shadow-none transition-all outline-none focus-visible:ring-2 focus-visible:ring-black rounded-xl">
                            Register
                        </a>
                    </div>
                @endif
            </div>

            <!-- Hamburger (Mobile) - Removed in favor of Floating Pill -->
        </div>
    </div>

    <!-- Neobrutalist Floating Bottom Pill (Mobile) -->
    <div class="fixed bottom-6 left-4 right-4 z-[100] sm:hidden font-sans pointer-events-none">
        <div class="bg-white border-[3px] border-black shadow-[6px_6px_0_0_#9E1B22] rounded-full flex justify-around items-center px-2 py-3 pointer-events-auto">
            
            {{-- Katalog --}}
            <a href="{{ route('home') }}"
                class="flex flex-col items-center justify-center gap-1 w-1/3 transition-transform hover:-translate-y-1 {{ request()->routeIs('home') || request()->routeIs('product.show') ? 'text-[#9E1B22]' : 'text-black' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('home') || request()->routeIs('product.show') ? '2.5' : '2' }}" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-[10px] font-black uppercase tracking-widest">Katalog</span>
            </a>

            @if(auth()->check())
                @if(auth()->user()->isAdmin())
                    {{-- Dashboard Admin --}}
                    <a href="{{ route('menu.dashboard') }}"
                        class="flex flex-col items-center justify-center gap-1 w-1/3 transition-transform hover:-translate-y-1 text-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest">Admin</span>
                    </a>
                @else
                    {{-- Keranjang --}}
                    <a href="{{ route('cart.index') }}"
                        class="flex flex-col items-center justify-center gap-1 w-1/3 transition-transform hover:-translate-y-1 relative {{ request()->routeIs('cart.index') ? 'text-[#9E1B22]' : 'text-black' }}">
                        <div class="relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="{{ request()->routeIs('cart.index') ? '2.5' : '2' }}" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @if(\App\Models\Cart::where('user_id', auth()->id())->count() > 0)
                                <span class="absolute -top-1.5 -right-2 bg-[#9E1B22] text-white text-[9px] font-black px-1.5 py-0.5 border-2 border-black rounded-full leading-none">{{\App\Models\Cart::where('user_id', auth()->id())->count()}}</span>
                            @endif
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest">Cart</span>
                    </a>
                @endif
                {{-- Profil / Logout --}}
                <div class="w-1/3 flex justify-center">
                    <form method="POST" action="{{ route('logout') }}" class="w-full flex justify-center">
                        @csrf
                        <button type="submit" class="flex flex-col items-center justify-center gap-1 transition-transform hover:-translate-y-1 text-black bg-transparent border-none p-0 w-full outline-none focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="text-[10px] font-black uppercase tracking-widest">Logout</span>
                        </button>
                    </form>
                </div>
            @else
                {{-- Login --}}
                <a href="{{ route('login') }}"
                    class="flex flex-col items-center justify-center gap-1 w-1/3 transition-transform hover:-translate-y-1 text-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">Login</span>
                </a>
                {{-- Register --}}
                <a href="{{ route('register') }}"
                    class="flex flex-col items-center justify-center gap-1 w-1/3 transition-transform hover:-translate-y-1 text-[#9E1B22]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest">Daftar</span>
                </a>
            @endif
        </div>
    </div>
</nav>

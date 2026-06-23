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

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 border-2 border-black bg-white text-black hover:bg-zinc-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-black transition duration-150 rounded-xl"
                    aria-label="Menu navigasi">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t-2 border-black">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('home') }}"
                class="block pl-3 pr-4 py-2 text-black font-extrabold hover:bg-zinc-50 {{ request()->routeIs('home') ? 'border-l-4 border-[#9E1B22] bg-zinc-50' : 'border-l-4 border-transparent' }}">
                Katalog Kamera
            </a>
        </div>

        <!-- Responsive Guest Options -->
        <div class="pt-4 pb-6 border-t border-black px-4 space-y-3">
            @if(auth()->check())
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('menu.dashboard') }}"
                        class="block text-center w-full py-2.5 border-2 border-black bg-white text-black font-black text-sm hover:bg-zinc-50 transition active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#9E1B22] active:shadow-none rounded-xl">
                        Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('cart.index') }}"
                        class="block text-center w-full py-2.5 border-2 border-black bg-white text-black font-black text-sm hover:bg-zinc-50 transition active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#9E1B22] active:shadow-none rounded-xl">
                        Keranjang
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block text-center w-full py-2.5 border-2 border-black bg-[#9E1B22] text-white font-black text-sm hover:bg-[#7A151B] transition active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#7A151B] active:shadow-none rounded-xl">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="block text-center w-full py-2.5 border-2 border-black bg-white text-black font-black text-sm hover:bg-zinc-50 transition active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#9E1B22] active:shadow-none rounded-xl">
                    Log in
                </a>
                <a href="{{ route('register') }}"
                    class="block text-center w-full py-2.5 border-2 border-black bg-[#9E1B22] text-white font-black text-sm hover:bg-[#7A151B] transition active:translate-x-[2px] active:translate-y-[2px] shadow-[3px_3px_0px_0px_#7A151B] active:shadow-none rounded-xl">
                    Register
                </a>
            @endif
        </div>
    </div>
</nav>

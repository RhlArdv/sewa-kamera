@if(auth()->check() && !request()->routeIs('home') && !request()->routeIs('product.show'))
    {{-- Authenticated Sidebar Dashboard Layout (Graphite / Slate Theme) --}}
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', 'Dashboard') — {{ config('app.name', 'Sewa Kamera') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link
            href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Poppins:wght@600;700&display=swap"
            rel="stylesheet">

        @stack('styles')

        <style>
            * {
                font-family: 'DM Sans', sans-serif;
            }

            ::-webkit-scrollbar {
                width: 4px;
                height: 4px;
            }

            ::-webkit-scrollbar-track {
                background: transparent;
            }

            ::-webkit-scrollbar-thumb {
                background: #e2e8f0;
                border-radius: 99px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #cbd5e1;
            }

            .nav-item-active::before {
                content: '';
                position: absolute;
                left: 0;
                top: 6px;
                bottom: 6px;
                width: 3px;
                background: #9E1B22;
                border-radius: 0 3px 3px 0;
            }

            main {
                animation: fadeUp 0.25s ease both;
            }

            @keyframes fadeUp {
                from {
                    opacity: 0;
                    transform: translateY(6px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            #sidebar {
                transition: transform 0.25s cubic-bezier(.4, 0, .2, 1);
            }

            .brand-font {
                font-family: 'Poppins', sans-serif;
            }
        </style>
    </head>

    <body class="bg-[#F3F4F6] text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black/30 backdrop-blur-sm lg:hidden"></div>

        <div class="flex min-h-screen">

            {{-- SIDEBAR --}}
            <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-[260px] bg-white border-r border-gray-100
                              flex flex-col -translate-x-full lg:translate-x-0"
                :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }">

                {{-- Brand --}}
                <div class="flex items-center justify-between px-5 h-[70px] border-b border-gray-100 flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="CameraSewa Logo"
                            class="h-10 w-auto object-contain scale-110 origin-left">
                        <span class="brand-font font-bold text-gray-900 text-[18px] tracking-tight">Camera<span
                                class="text-[#9E1B22]">Sewa</span></span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden p-1 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Nav --}}
                <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

                    @if(auth()->user()->isAdmin())
                                    {{-- ADMIN LINKS --}}
                                    <p class="px-3 pt-1 pb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Menu Utama
                                    </p>

                                    @php $activeDashboard = request()->routeIs('menu.dashboard'); @endphp
                                    <a href="{{ route('menu.dashboard') }}"
                                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                                      transition-all {{ $activeDashboard ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="{{ $activeDashboard ? '2.2' : '1.8' }}"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        Dashboard
                                    </a>

                                    <p class="px-3 pt-4 pb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Transaksi
                                    </p>

                        @php
                            $activeTransaksi = request()->routeIs('menu.transactions.index') || request()->routeIs('menu.transactions.show');
                            $countMenunggu = \App\Models\Transaction::where('transaksi_status', 'pending')->count();
                        @endphp
                                    <a href="{{ route('menu.transactions.index') }}"
                                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                                      transition-all {{ $activeTransaksi ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="{{ $activeTransaksi ? '2.2' : '1.8' }}"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span class="flex-1">Booking Masuk</span>
                                        @if($countMenunggu > 0)
                                            <span
                                                class="bg-[#9E1B22] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center leading-tight">
                                                {{ $countMenunggu }}
                                            </span>
                                        @endif
                                    </a>

                                    <p class="px-3 pt-4 pb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Katalog &
                                        Stok</p>

                                    @php $activeCategory = request()->routeIs('menu.categories.*'); @endphp
                                    <a href="{{ route('menu.categories.index') }}"
                                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                                      transition-all {{ $activeCategory ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="{{ $activeCategory ? '2.2' : '1.8' }}"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Kategori Kamera
                                    </a>

                                    @php $activeProducts = request()->routeIs('menu.products.*'); @endphp
                                    <a href="{{ route('menu.products.index') }}"
                                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                                      transition-all {{ $activeProducts ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="{{ $activeProducts ? '2.2' : '1.8' }}" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Kelola Kamera
                                    </a>


                                    <p class="px-3 pt-4 pb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Laporan &
                                        Pengguna</p>

                                    @php $activeReports = request()->routeIs('menu.reports.*'); @endphp
                                    <a href="{{ route('menu.reports.index') }}"
                                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                                      transition-all {{ $activeReports ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="{{ $activeReports ? '2.2' : '1.8' }}"
                                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Laporan Laba
                                    </a>

                                    @php $activeUsers = request()->routeIs('menu.users.*'); @endphp
                                    <a href="{{ route('menu.users.index') }}"
                                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                                      transition-all {{ $activeUsers ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                        <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="{{ $activeUsers ? '2.2' : '1.8' }}"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        Kelola Member
                                    </a>
                    @else
                        {{-- CUSTOMER / PELANGGAN LINKS --}}
                        <p class="px-3 pt-1 pb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Penyewaan
                        </p>

                        @php $activeHome = request()->routeIs('home') || request()->routeIs('product.show'); @endphp
                        <a href="{{ route('home') }}"
                            class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                          transition-all {{ $activeHome ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="{{ $activeHome ? '2.2' : '1.8' }}" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Katalog Kamera
                        </a>

                        @php
                            $activeCart = request()->routeIs('cart.index') || request()->routeIs('checkout.index');
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                        @endphp
                        <a href="{{ route('cart.index') }}"
                            class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                          transition-all {{ $activeCart ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="{{ $activeCart ? '2.2' : '1.8' }}"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="flex-1">Keranjang</span>
                            @if($cartCount > 0)
                                <span
                                    class="bg-[#9E1B22] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center leading-tight">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        @php
                            $activeOrders = request()->routeIs('orders.index');
                            $ordersCount = \App\Models\Transaction::where('user_id', auth()->id())->where('transaksi_status', 'pending')->count();
                        @endphp
                        <a href="{{ route('orders.index') }}"
                            class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                          transition-all {{ $activeOrders ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="{{ $activeOrders ? '2.2' : '1.8' }}"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="flex-1">Sewaan Saya</span>
                            @if($ordersCount > 0)
                                <span
                                    class="bg-[#9E1B22] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center leading-tight">
                                    {{ $ordersCount }}
                                </span>
                            @endif
                        </a>

                        <p class="px-3 pt-4 pb-2 text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Akun Saya
                        </p>

                        @php $activeProfile = request()->routeIs('profile.edit'); @endphp
                        <a href="{{ route('profile.edit') }}"
                            class="relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-[13px] font-medium
                                          transition-all {{ $activeProfile ? 'nav-item-active bg-red-50 text-[#9E1B22] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="w-[17px] h-[17px] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="{{ $activeProfile ? '2.2' : '1.8' }}"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Edit Profil
                        </a>
                    @endif

                </nav>

                {{-- User card bawah --}}
                <div class="flex-shrink-0 border-t border-gray-100 p-3 font-sans">
                    <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-gray-50 transition-colors">
                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-slate-700 to-slate-800
                                        flex items-center justify-center text-white text-xs font-bold flex-shrink-0 shadow-sm shadow-slate-200">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[13px] font-semibold text-gray-800 truncate leading-tight">
                                {{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-400 truncate uppercase">{{ auth()->user()->role }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Logout" class="p-1.5 text-gray-300 hover:text-red-500 hover:bg-red-50
                                               rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </aside>

            {{-- MAIN CONTENT --}}
            <div class="flex flex-col flex-1 min-w-0 lg:pl-[260px]">

                {{-- NAVBAR --}}
                <header class="sticky top-0 z-10 h-[70px] bg-white/90 backdrop-blur-md
                                   border-b border-gray-100 flex items-center px-5 gap-4">

                    {{-- Hamburger mobile --}}
                    @if(auth()->user()->isAdmin())
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="lg:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    @endif

                    <div class="flex-1"></div>

                    {{-- Notifikasi bell --}}
                    @php
                        $countAlert = auth()->user()->isAdmin()
                            ? \App\Models\Transaction::where('transaksi_status', 'pending')->count()
                            : \App\Models\Transaction::where('user_id', auth()->id())->where('transaksi_status', 'pending')->count();
                    @endphp
                    <div class="relative font-sans" x-data="{ open: false }">
                        <button @click="open = !open" class="relative w-9 h-9 flex items-center justify-center rounded-xl
                                           text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if($countAlert > 0)
                                <span class="absolute top-1.5 right-1.5 w-[7px] h-[7px] bg-red-500
                                                     rounded-full border-2 border-white"></span>
                            @endif
                        </button>

                        <div x-show="open" @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 top-full mt-2 w-72 bg-white rounded-2xl
                                        border border-gray-100 shadow-xl shadow-gray-200/60 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-800">Notifikasi</p>
                                @if($countAlert > 0)
                                    <span
                                        class="text-[11px] bg-slate-100 text-slate-750 font-semibold px-2 py-0.5 rounded-full">
                                        {{ $countAlert }} baru
                                    </span>
                                @endif
                            </div>
                            <div class="p-2 max-h-64 overflow-y-auto">
                                @if($countAlert > 0)
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('menu.transactions.index') }}" @click="open = false"
                                            class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                                            <div
                                                class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[13px] font-semibold text-gray-800">{{ $countAlert }} sewaan baru</p>
                                                <p class="text-xs text-gray-400 mt-0.5">Klik untuk lihat list booking pending</p>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('orders.index') }}" @click="open = false"
                                            class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                                            <div
                                                class="w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-slate-700" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[13px] font-semibold text-gray-800">{{ $countAlert }} booking pending
                                                </p>
                                                <p class="text-xs text-gray-400 mt-0.5">Segera selesaikan pembayaran DP Anda</p>
                                            </div>
                                        </a>
                                    @endif
                                @else
                                    <div class="py-8 text-center">
                                        <p class="text-sm text-gray-400">Tidak ada notifikasi baru</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="w-px h-6 bg-gray-200"></div>

                    {{-- Avatar + nama --}}
                    <div class="flex items-center gap-2.5 font-sans">
                        <div class="text-right hidden md:block">
                            <p class="text-[13px] font-semibold text-gray-800 leading-none">{{ auth()->user()->name }}</p>
                            <p class="text-[11px] text-gray-400 leading-none mt-0.5 uppercase">{{ auth()->user()->role }}
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-slate-700 to-slate-800
                                        flex items-center justify-center text-white text-xs font-bold cursor-pointer
                                        shadow-sm shadow-slate-200">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    </div>

                </header>

                {{-- KONTEN --}}
                <main class="flex-1 p-5 lg:p-6 pb-28 lg:pb-6 bg-[#F3F4F6]">
                    @hasSection('header')
                        <div class="mb-5">
                            @yield('header')
                        </div>
                    @elseif(isset($header))
                        <div class="mb-5">
                            {{ $header }}
                        </div>
                    @endif

                    @include('partials.alert')

                    @yield('content')
                    {{ $slot ?? '' }}
                </main>

                <footer class="px-6 py-4 text-center text-xs text-gray-400 border-t border-gray-100 bg-white">
                    © {{ date('Y') }} CameraSewa — Tempat Rental Kamera Premium Kota Padang
                </footer>

            </div>
        </div>

        @if(!auth()->user()->isAdmin())
            {{-- Floating Bottom Navigation for Mobile --}}
            <div class="fixed bottom-6 left-4 right-4 z-50 lg:hidden font-sans">
                <div
                    class="bg-white/95 backdrop-blur-md border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.08)] rounded-full flex justify-between items-center px-6 py-2">
                    {{-- Home / Katalog --}}
                    <a href="{{ route('home') }}"
                        class="flex flex-col items-center justify-center gap-1 transition-colors {{ request()->routeIs('home') || request()->routeIs('product.show') ? 'text-[#9E1B22]' : 'text-gray-400 hover:text-gray-600' }}">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="{{ request()->routeIs('home') || request()->routeIs('product.show') ? '2.2' : '1.8' }}"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="text-[9px] font-bold">Katalog</span>
                    </a>

                    {{-- Keranjang --}}
                    @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                    <a href="{{ route('cart.index') }}"
                        class="relative flex flex-col items-center justify-center gap-1 transition-colors {{ request()->routeIs('cart.index') || request()->routeIs('checkout.index') ? 'text-[#9E1B22]' : 'text-gray-400 hover:text-gray-600' }}">
                        <div class="relative">
                            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="{{ request()->routeIs('cart.index') || request()->routeIs('checkout.index') ? '2.2' : '1.8' }}"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            @if($cartCount > 0)
                                <span
                                    class="absolute -top-1.5 -right-2 bg-[#9E1B22] text-white text-[8px] font-bold px-1 rounded-full min-w-[14px] text-center border border-white">{{ $cartCount }}</span>
                            @endif
                        </div>
                        <span class="text-[9px] font-bold">Keranjang</span>
                    </a>

                    {{-- Pesanan --}}
                    @php $ordersCount = \App\Models\Transaction::where('user_id', auth()->id())->where('transaksi_status', 'pending')->count(); @endphp
                    <a href="{{ route('orders.index') }}"
                        class="relative flex flex-col items-center justify-center gap-1 transition-colors {{ request()->routeIs('orders.index') ? 'text-[#9E1B22]' : 'text-gray-400 hover:text-gray-600' }}">
                        <div class="relative">
                            <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="{{ request()->routeIs('orders.index') ? '2.2' : '1.8' }}"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            @if($ordersCount > 0)
                                <span
                                    class="absolute -top-1.5 -right-2 bg-[#9E1B22] text-white text-[8px] font-bold px-1 rounded-full min-w-[14px] text-center border border-white">{{ $ordersCount }}</span>
                            @endif
                        </div>
                        <span class="text-[9px] font-bold">Pesanan</span>
                    </a>

                    {{-- Profil --}}
                    <a href="{{ route('profile.edit') }}"
                        class="flex flex-col items-center justify-center gap-1 transition-colors {{ request()->routeIs('profile.edit') ? 'text-[#9E1B22]' : 'text-gray-400 hover:text-gray-600' }}">
                        <svg class="w-[22px] h-[22px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="{{ request()->routeIs('profile.edit') ? '2.2' : '1.8' }}"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-[9px] font-bold">Profil</span>
                    </a>
                </div>
            </div>
        @endif

        @stack('scripts')
    </body>

    </html>
@else
    {{-- Guest View (Bright Theme with Indigo/Purple highlights and background blobs) --}}
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CameraSewa') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body
        class="font-sans antialiased text-black bg-white selection:bg-[#9E1B22] selection:text-white relative min-h-screen flex flex-col justify-between overflow-x-hidden">
        <div>
            @include('layouts.navigation')

            <!-- Page Heading -->
            @hasSection('header')
                <header class="bg-white border-b-2 border-black">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                    @include('partials.alert')
                </div>
                @yield('content')
            </main>
        </div>

        <footer
            class="px-6 py-8 text-center text-xs text-black border-t-2 border-black bg-white mt-12 font-bold uppercase tracking-widest">
            © {{ date('Y') }} Tempat Rental Kamera Premium Kota Padang.
        </footer>
        @stack('scripts')
    </body>

    </html>
@endif
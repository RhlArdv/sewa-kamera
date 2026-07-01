@extends('layouts.app')

@section('content')
    <div class="relative min-h-[100dvh] text-zinc-950 bg-white selection:bg-[#9E1B22] selection:text-white"
        style="font-family: 'Outfit', sans-serif;" x-data="{ mobileMenuOpen: false, scrolled: false }"
        @scroll.window="scrolled = (window.pageYOffset > 50)">

        {{-- Floating Navigation is handled by navigation.blade.php now --}}

        {{-- Decorative Grid Background (Subtle) --}}
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none z-0">
        </div>

        {{-- Neobrutalist Hero Section --}}
        <div
            class="w-full max-w-7xl mx-auto px-4 sm:px-6 py-12 lg:py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-stretch relative z-10">

            {{-- Left Column: Content Card (Image 2) --}}
            <div
                class="relative bg-white border-[3px] border-black rounded-[2rem] p-8 sm:p-10 lg:p-12 shadow-[8px_8px_0_0_#9E1B22] flex flex-col items-start w-full z-20">

                {{-- Top right dot pattern (bigger 5x5 grid) --}}
                <div class="absolute top-6 right-6 sm:top-8 sm:right-8 text-black opacity-25">
                    <svg width="70" height="70" viewBox="0 0 70 70" fill="currentColor">
                        <circle cx="7" cy="7" r="3" />
                        <circle cx="21" cy="7" r="3" />
                        <circle cx="35" cy="7" r="3" />
                        <circle cx="49" cy="7" r="3" />
                        <circle cx="63" cy="7" r="3" />
                        <circle cx="7" cy="21" r="3" />
                        <circle cx="21" cy="21" r="3" />
                        <circle cx="35" cy="21" r="3" />
                        <circle cx="49" cy="21" r="3" />
                        <circle cx="63" cy="21" r="3" />
                        <circle cx="7" cy="35" r="3" />
                        <circle cx="21" cy="35" r="3" />
                        <circle cx="35" cy="35" r="3" />
                        <circle cx="49" cy="35" r="3" />
                        <circle cx="63" cy="35" r="3" />
                        <circle cx="7" cy="49" r="3" />
                        <circle cx="21" cy="49" r="3" />
                        <circle cx="35" cy="49" r="3" />
                        <circle cx="49" cy="49" r="3" />
                        <circle cx="63" cy="49" r="3" />
                        <circle cx="7" cy="63" r="3" />
                        <circle cx="21" cy="63" r="3" />
                        <circle cx="35" cy="63" r="3" />
                        <circle cx="49" cy="63" r="3" />
                        <circle cx="63" cy="63" r="3" />
                    </svg>
                </div>

                {{-- Badge --}}
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 mb-8 border-[2px] border-black rounded-full bg-white text-black font-extrabold text-[11px] sm:text-[13px] uppercase tracking-widest shadow-sm">
                    <span class="w-2.5 h-2.5 bg-[#9E1B22] rounded-full border border-black"></span>
                    Rental Kamera Padang
                </div>

                {{-- Title --}}
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-black leading-[0.95] mb-6 tracking-tighter uppercase"
                    style="font-family: 'Outfit', sans-serif; text-shadow: 4px 4px 0px #9E1B22;">
                    Abadikan<br>
                    Momen<br>
                    Tanpa Batas.
                </h1>

                {{-- Description --}}
                <p class="text-base sm:text-lg text-gray-800 mb-10 max-w-lg font-medium leading-laxed">
                    Penyewaan kamera DSLR & Mirrorless premium.<br>
                    Transparan per 6 jam, DP ringan, dan jaminan unit 100% mulus.
                </p>

                {{-- 3 USPs with lines --}}
                <div
                    class="flex flex-wrap sm:flex-nowrap gap-4 sm:gap-0 mb-10 w-full border-t border-b border-gray-200 py-6 items-center justify-between lg:pr-8">

                    {{-- USP 1 --}}
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div
                            class="w-10 h-10 rounded-xl border-2 border-black bg-[#9E1B22] flex items-center justify-center shrink-0 shadow-[3px_3px_0_0_#000]">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Mulai</span>
                            <span class="font-extrabold text-[13px] text-black">Rp 50.000 / 6 Jam</span>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="hidden sm:block w-[2px] h-10 bg-gray-200"></div>

                    {{-- USP 2 --}}
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div
                            class="w-10 h-10 rounded-xl border-2 border-black bg-[#9E1B22] flex items-center justify-center shrink-0 shadow-[3px_3px_0_0_#000]">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Ambil</span>
                            <span class="font-extrabold text-[13px] text-black">Hari Ini</span>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="hidden sm:block w-[2px] h-10 bg-gray-200"></div>

                    {{-- USP 3 --}}
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div
                            class="w-10 h-10 rounded-xl border-2 border-black bg-[#9E1B22] flex items-center justify-center shrink-0 shadow-[3px_3px_0_0_#000]">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">100%</span>
                            <span class="font-extrabold text-[13px] text-black">Unit Terawat</span>
                        </div>
                    </div>

                </div>

                {{-- CTAs --}}
                <div class="flex flex-wrap sm:flex-nowrap gap-4 w-full relative z-10">
                    <a href="#katalog-kamera"
                        class="w-full sm:w-1/2 text-center px-6 py-4 bg-[#9E1B22] text-white font-black text-sm uppercase tracking-wider rounded-xl border-[3px] border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0px_rgba(0,0,0,1)] transition-all">
                        EKSPLOR KATALOG
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-1/2 text-center px-6 py-4 bg-white text-black font-black text-sm uppercase tracking-wider rounded-xl border-[3px] border-black shadow-[4px_4px_0px_rgba(0,0,0,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0px_rgba(0,0,0,1)] transition-all">
                        DAFTAR GRATIS
                    </a>
                </div>

                {{-- Bottom left decoration --}}
                <div
                    class="absolute bottom-6 left-6 w-6 h-6 border-b-[3px] border-l-[3px] border-black opacity-30 pointer-events-none">
                </div>
            </div>

            {{-- Right Column: Camera Showcase + Stats --}}
            <div class="relative w-full mt-10 lg:mt-0 flex flex-col gap-5 z-10">

                {{-- TOP: White Camera Showcase Card (grows to fill space) --}}
                <div class="relative bg-white border-[3px] border-black rounded-[2rem] shadow-[8px_8px_0_0_#9E1B22] flex-1">

                    {{-- Camera Image with labels baked in --}}
                    <div class="w-full h-full overflow-hidden rounded-[calc(2rem-3px)]">
                        <img src="{{ asset('assets/img/hero-cameras1.png') }}"
                            alt="Rental Kamera Premium - Canon EOS M100, Canon EOS M10, Fujifilm XA2"
                            class="w-full h-full object-cover object-center">
                    </div>
                </div>

                {{-- BOTTOM: Red Stats Banner --}}
                <div
                    class="relative bg-[#9E1B22] border-[3px] border-black rounded-[2rem] shadow-[6px_6px_0_0_#7A151B] px-8 py-6 flex items-center justify-between overflow-visible">

                    {{-- Left: Stats --}}
                    <div>
                        <p class="text-4xl sm:text-5xl font-black text-white leading-none"
                            style="text-shadow: 2px 2px 0px #7A151B;">500+</p>
                        <p class="text-xs sm:text-sm font-extrabold text-white uppercase tracking-[0.2em] mt-1">Unit
                            Tersedia</p>
                    </div>

                    {{-- Right: 3 Circle Icons --}}
                    <div class="flex items-center gap-3">
                        {{-- Camera icon --}}
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-2 border-white/30 flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <circle cx="12" cy="13" r="3" stroke-width="2" />
                            </svg>
                        </div>
                        {{-- Photo icon --}}
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-2 border-white/30 flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        {{-- Video icon --}}
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-2 border-white/30 flex items-center justify-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>



        {{-- Bento Grid - Features Section --}}
        <div id="fitur" class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="mb-12">
                <h2 class="text-4xl sm:text-5xl font-black tracking-tighter text-zinc-950 mb-4 uppercase"
                    style="text-shadow: 3px 3px 0px #9E1B22;">Kenapa Pilih Kami.</h2>
                <p class="text-xl text-zinc-700 font-medium max-w-2xl">Kami berfokus pada kualitas, kecepatan, dan
                    transparansi harga agar Anda bisa fokus berkarya.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                {{-- Block 1 (Wide) --}}
                <div
                    class="col-span-1 md:col-span-8 bg-white border-[3px] border-black rounded-[2rem] p-8 sm:p-10 flex flex-col justify-between hover:-translate-y-2 hover:shadow-[12px_12px_0_0_#9E1B22] shadow-[4px_4px_0_0_#9E1B22] transition-all duration-300 relative overflow-hidden group">
                    {{-- Abstract Background Typography --}}
                    <div
                        class="absolute inset-0 z-0 flex items-center justify-center opacity-[0.03] pointer-events-none overflow-hidden">
                        <div
                            class="text-[120px] font-black uppercase text-black leading-none whitespace-nowrap -rotate-3 select-none group-hover:scale-110 transition-transform duration-700">
                            100% QUALITY 100% QUALITY
                        </div>
                    </div>

                    <div class="flex items-start justify-between mb-10 relative z-10">
                        <div
                            class="w-16 h-16 bg-[#9E1B22] border-[3px] border-black rounded-2xl flex items-center justify-center shadow-[4px_4px_0_0_#000] group-hover:-rotate-6 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                        <span
                            class="px-4 py-1.5 bg-black text-white font-black text-sm rounded-full border-2 border-white shadow-[4px_4px_0_0_#9E1B22] tracking-widest -rotate-3">01</span>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl sm:text-4xl font-black text-black mb-4 uppercase tracking-tight">Kualitas
                            Terjamin 100%</h3>
                        <p class="text-lg text-gray-700 font-bold leading-relaxed max-w-xl">Pengecekan ketat pada sensor,
                            kebersihan lensa, dan kondisi baterai sebelum unit diserahkan. Kami memastikan setiap alat siap
                            tempur untuk produksi Anda.</p>
                    </div>
                </div>

                {{-- Block 2 (Tall) --}}
                <div
                    class="col-span-1 md:col-span-4 bg-[#9E1B22] border-[3px] border-black rounded-[2rem] p-8 sm:p-10 flex flex-col justify-between hover:-translate-y-2 hover:shadow-[12px_12px_0_0_#000] shadow-[4px_4px_0_0_#000] transition-all duration-300 relative overflow-hidden group">
                    {{-- Abstract Background Typography --}}
                    <div
                        class="absolute inset-0 z-0 flex items-center justify-center opacity-10 pointer-events-none overflow-hidden">
                        <div
                            class="text-[120px] font-black uppercase text-white leading-none whitespace-nowrap rotate-90 select-none group-hover:scale-110 transition-transform duration-700">
                            6 HOURS
                        </div>
                    </div>

                    <div class="flex items-start justify-between mb-10 relative z-10">
                        <div
                            class="w-16 h-16 bg-white border-[3px] border-black rounded-2xl flex items-center justify-center shadow-[4px_4px_0_0_#000] group-hover:rotate-6 transition-transform">
                            <svg class="w-8 h-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span
                            class="px-4 py-1.5 bg-white text-black font-black text-sm rounded-full border-2 border-black shadow-[4px_4px_0_0_#000] tracking-widest rotate-6">02</span>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl sm:text-4xl font-black text-white mb-4 uppercase tracking-tight"
                            style="text-shadow: 3px 3px 0px #000;">Rental Per 6 Jam</h3>
                        <p class="text-lg text-white font-bold leading-relaxed">Lebih hemat dan super fleksibel tanpa harus
                            terikat harga rental harian yang menguras kantong.</p>
                    </div>
                </div>

                {{-- Block 3 (Tall) --}}
                <div
                    class="col-span-1 md:col-span-4 bg-white border-[3px] border-black rounded-[2rem] p-8 sm:p-10 flex flex-col justify-between hover:-translate-y-2 hover:shadow-[12px_12px_0_0_#000] shadow-[4px_4px_0_0_#000] transition-all duration-300 relative overflow-hidden group">
                    {{-- Abstract Background Typography --}}
                    <div
                        class="absolute inset-0 z-0 flex items-center justify-center opacity-[0.03] pointer-events-none overflow-hidden">
                        <div
                            class="text-[120px] font-black uppercase text-black leading-none whitespace-nowrap -rotate-90 select-none group-hover:scale-110 transition-transform duration-700">
                            FAST FAST
                        </div>
                    </div>

                    <div class="flex items-start justify-between mb-10 relative z-10">
                        <div
                            class="w-16 h-16 bg-[#9E1B22] border-[3px] border-black rounded-2xl flex items-center justify-center shadow-[4px_4px_0_0_#000] group-hover:-rotate-6 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <span
                            class="px-4 py-1.5 bg-black text-white font-black text-sm rounded-full border-2 border-white shadow-[4px_4px_0_0_#9E1B22] tracking-widest -rotate-6">03</span>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl sm:text-4xl font-black text-black mb-4 uppercase tracking-tight">Ambil Hari Ini
                        </h3>
                        <p class="text-lg text-gray-700 font-bold leading-relaxed">Proses booking super instan. Order
                            sekarang, alat langsung bisa dipickup hari ini juga, tanpa nunggu lama.</p>
                    </div>
                </div>

                {{-- Block 4 (Wide) --}}
                <div
                    class="col-span-1 md:col-span-8 bg-black border-[3px] border-black rounded-[2rem] p-8 sm:p-10 flex flex-col justify-between hover:-translate-y-2 hover:shadow-[12px_12px_0_0_#9E1B22] shadow-[4px_4px_0_0_#9E1B22] transition-all duration-300 relative overflow-hidden group">
                    {{-- Abstract Background Typography --}}
                    <div
                        class="absolute inset-0 z-0 flex items-center justify-center opacity-10 pointer-events-none overflow-hidden">
                        <div
                            class="text-[120px] font-black uppercase text-white leading-none whitespace-nowrap rotate-3 select-none group-hover:scale-110 transition-transform duration-700">
                            NO HIDDEN FEES
                        </div>
                    </div>

                    <div class="flex items-start justify-between mb-10 relative z-10">
                        <div
                            class="w-16 h-16 bg-[#9E1B22] border-[3px] border-white rounded-2xl flex items-center justify-center shadow-[4px_4px_0_0_#FFF] group-hover:rotate-6 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span
                            class="px-4 py-1.5 bg-white text-black font-black text-sm rounded-full border-2 border-white shadow-[4px_4px_0_0_#9E1B22] tracking-widest rotate-3">04</span>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl sm:text-4xl font-black text-white mb-4 uppercase tracking-tight">Harga
                            Transparan</h3>
                        <p class="text-lg text-gray-300 font-bold leading-relaxed max-w-xl">Tidak ada biaya tersembunyi. DP
                            sangat ringan, syarat rental mudah, dan harga bersahabat khusus didesain untuk mahasiswa dan
                            kreator muda.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gen Z Aesthetic Catalog Section --}}
        <div id="katalog-kamera" class="py-24 bg-white border-y-[4px] border-black relative overflow-hidden">
            {{-- Decorative Background Text --}}
            <div
                class="absolute -left-10 top-20 text-[150px] font-black text-black opacity-[0.03] rotate-90 select-none pointer-events-none uppercase">
                CHOOSE YOUR WEAPON
            </div>

            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16 relative z-10">
                    <div
                        class="inline-block bg-white border-[4px] border-black p-6 sm:p-8 rounded-[2rem] shadow-[8px_8px_0_0_#9E1B22] transform -rotate-1 hover:rotate-1 transition-transform">
                        <h2 class="text-4xl sm:text-6xl font-black tracking-tighter text-black uppercase"
                            style="text-shadow: 2px 2px 0px #FFF;">
                            Gear Catalog.
                        </h2>
                        <p class="text-xl text-black font-black uppercase tracking-wider mt-4">Pilih alat tempurmu. Eksekusi
                            ide liarmu.</p>
                    </div>
                </div>

                {{-- Search & Filters --}}
                <div class="mb-16">
                    <form action="{{ route('home') }}" method="GET"
                        class="flex flex-col lg:flex-row gap-6 items-center justify-between bg-white border-[4px] border-black rounded-[2rem] p-6 shadow-[8px_8px_0_0_#9E1B22]">
                        {{-- Brutalist Search Box --}}
                        <div class="relative w-full lg:w-[450px]">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="CARI GEAR..."
                                class="block w-full pl-14 pr-4 py-4 border-[3px] border-black rounded-2xl bg-zinc-100 text-black font-black placeholder-zinc-400 text-lg uppercase focus:outline-none focus:ring-0 focus:border-[#9E1B22] focus:bg-white transition-colors duration-200 shadow-[4px_4px_0_0_#000]">
                        </div>

                        {{-- Brutalist Badges --}}
                        <div class="flex flex-wrap gap-3 items-center w-full lg:w-auto">
                            <a href="{{ route('home', array_filter(['search' => request('search')])) }}#katalog-kamera"
                                class="px-6 py-3 text-[15px] font-black uppercase tracking-widest rounded-xl border-[3px] border-black transition-all duration-200 {{ !request('category') ? 'bg-[#9E1B22] text-white shadow-[4px_4px_0_0_#000] -rotate-2' : 'bg-white text-black hover:-translate-y-1 hover:shadow-[4px_4px_0_0_#9E1B22]' }}">
                                Semua
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('home', array_filter(['category' => $category->slug, 'search' => request('search')])) }}#katalog-kamera"
                                    class="px-6 py-3 text-[15px] font-black uppercase tracking-widest rounded-xl border-[3px] border-black transition-all duration-200 {{ request('category') === $category->slug ? 'bg-[#9E1B22] text-white shadow-[4px_4px_0_0_#000] rotate-2' : 'bg-white text-black hover:-translate-y-1 hover:shadow-[4px_4px_0_0_#9E1B22]' }}">
                                    {{ $category->kategori_name }}
                                </a>
                            @endforeach
                        </div>
                    </form>
                </div>

                {{-- Products Grid --}}
                @if($products->isEmpty())
                    <div
                        class="text-center py-32 bg-white border-[4px] border-black rounded-[3rem] shadow-[12px_12px_0_0_#9E1B22] relative overflow-hidden">
                        <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
                            <span class="text-[150px] font-black uppercase -rotate-6">EMPTY EMPTY</span>
                        </div>
                        <div class="relative z-10">
                            <div
                                class="w-24 h-24 mx-auto mb-8 bg-[#9E1B22] rounded-3xl border-[4px] border-black flex items-center justify-center shadow-[6px_6px_0_0_#000] -rotate-6">
                                <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-4xl font-black text-black mb-4 uppercase">Gear Tidak Ditemukan</h3>
                            <p class="text-xl font-bold text-zinc-600">Coba ubah kata kunci pencarian atau pilih kategori lain.
                            </p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($products as $product)
                            <div
                                class="group flex flex-col bg-white border-[3px] border-black rounded-[2rem] overflow-hidden hover:-translate-y-2 hover:shadow-[12px_12px_0_0_#9E1B22] shadow-[6px_6px_0_0_#000] transition-all duration-300 relative">
                                {{-- Image Container (with Alpine Carousel) --}}
                                <div class="relative w-full aspect-[4/3] bg-zinc-100 overflow-hidden border-b-[3px] border-black group/carousel"
                                    x-data="{ 
                                                                                            activeSlide: 0, 
                                                                                            slides: [{{ $product->galleries->map(fn($g) => "'" . asset('storage/' . $g->foto) . "'")->implode(',') }}] 
                                                                                         }">

                                    @if($product->galleries->isNotEmpty())
                                        <template x-for="(slide, index) in slides" :key="index">
                                            <div x-show="activeSlide === index" x-transition.opacity.duration.500ms
                                                class="absolute inset-0 p-4 md:p-6 bg-white flex items-center justify-center">
                                                <img :src="slide" alt="{{ $product->produk_name }}"
                                                    class="w-full h-full object-contain p-4 filter grayscale-[10%] group-hover/carousel:grayscale-0 transition-all duration-500">
                                            </div>
                                        </template>

                                        {{-- Carousel Controls (show only if > 1 slide) --}}
                                        @if($product->galleries->count() > 1)
                                            <button @click.prevent="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 border-2 border-zinc-950 rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-opacity z-10 hover:bg-white hover:text-[#9E1B22]">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </button>
                                            <button @click.prevent="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 border-2 border-zinc-950 rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-opacity z-10 hover:bg-white hover:text-[#9E1B22]">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </button>

                                            {{-- Dots --}}
                                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                                                <template x-for="(slide, index) in slides" :key="index">
                                                    <span class="w-2 h-2 rounded-full border border-zinc-950 transition-all"
                                                        :class="activeSlide === index ? 'bg-[#9E1B22] scale-125' : 'bg-white'"></span>
                                                </template>
                                            </div>
                                        @endif
                                    @else
                                        {{-- Placeholder --}}
                                        <div
                                            class="absolute inset-0 bg-white flex flex-col items-center justify-center p-4 text-center">
                                            <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <circle cx="12" cy="13" r="3" stroke-width="1.5" />
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Availability Indicator --}}
                                    <div
                                        class="absolute top-4 right-4 z-20 flex items-center gap-2 bg-white border-[2px] border-black px-3 py-1.5 rounded-xl shadow-[4px_4px_0_0_#000] rotate-2">
                                        <span
                                            class="w-3 h-3 border-[2px] border-black rounded-full {{ $product->available_units > 0 ? 'bg-[#00FF00]' : 'bg-[#FF0000]' }} animate-pulse"></span>
                                        <span
                                            class="text-[12px] font-black text-black uppercase tracking-widest">{{ $product->available_units }}
                                            Tersedia</span>
                                    </div>
                                </div>

                                {{-- Product Info --}}
                                <div class="flex-1 p-6 flex flex-col bg-white relative">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span
                                            class="px-3 py-1.5 bg-black text-white border-[2px] border-black rounded-xl text-[11px] font-black tracking-widest uppercase shadow-[2px_2px_0_0_#9E1B22] -rotate-1">{{ $product->category->kategori_name }}</span>
                                    </div>
                                    <h3
                                        class="text-2xl font-black text-black tracking-tight line-clamp-2 mb-6 leading-tight group-hover:text-[#9E1B22] transition-colors">
                                        {{ $product->produk_name }}
                                    </h3>

                                    <div
                                        class="mt-auto pt-4 border-t-[3px] border-dashed border-zinc-200 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                        <div>
                                            <p class="text-2xl font-black text-black">
                                                Rp {{ number_format($product->prices['6'] ?? 0, 0, ',', '.') }}<span
                                                    class="text-sm font-bold text-zinc-500">/6 jam</span>
                                            </p>
                                        </div>
                                        <a href="{{ route('product.show', $product->id_produk) }}"
                                            class="text-center px-6 py-3 bg-black text-white border-[3px] border-black rounded-xl font-black uppercase text-sm tracking-widest shadow-[4px_4px_0_0_#9E1B22] hover:bg-[#9E1B22] hover:text-white hover:shadow-[6px_6px_0_0_#000] hover:-translate-y-1 hover:rotate-2 transition-all active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                                            RENTAL
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Gen Z Aesthetic CTA Section --}}
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-24 relative">
            {{-- Decorative Stars --}}
            <div class="absolute top-16 right-10 md:right-32 text-black hidden md:block">
                <svg width="60" height="60" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M50 0L56.5 43.5L100 50L56.5 56.5L50 100L43.5 56.5L0 50L43.5 43.5L50 0Z" />
                </svg>
            </div>
            <div class="absolute bottom-16 left-10 md:left-24 text-[#9E1B22] hidden md:block">
                <svg width="40" height="40" viewBox="0 0 100 100" fill="currentColor">
                    <path d="M50 0L56.5 43.5L100 50L56.5 56.5L50 100L43.5 56.5L0 50L43.5 43.5L50 0Z" />
                </svg>
            </div>

            <div
                class="bg-white rounded-[3rem] border-[4px] border-black shadow-[16px_16px_0_0_#9E1B22] p-12 md:p-20 text-center relative overflow-hidden group hover:-translate-y-2 hover:shadow-[16px_20px_0_0_#9E1B22] transition-all duration-300">
                {{-- Abstract Marquee Background --}}
                <div
                    class="absolute inset-0 z-0 flex items-center justify-center opacity-[0.03] pointer-events-none overflow-hidden">
                    <div
                        class="text-[200px] font-black uppercase text-black leading-none whitespace-nowrap -rotate-6 select-none group-hover:scale-110 transition-transform duration-700">
                        RENT IT RENT IT
                    </div>
                </div>

                <div class="relative z-10">
                    <div
                        class="inline-block px-4 py-2 bg-black text-white border-2 border-black font-black uppercase tracking-widest rounded-full text-xs mb-8 -rotate-2 shadow-[2px_2px_0_0_#9E1B22]">
                        Don't Miss Out
                    </div>
                    <h2 class="text-5xl md:text-7xl font-black tracking-tighter text-black mb-6 uppercase leading-none"
                        style="text-shadow: 4px 4px 0px #e5e7eb;">
                        Mulai Berkarya<br>Hari Ini.
                    </h2>
                    <p class="text-zinc-600 text-lg md:text-xl font-bold max-w-2xl mx-auto mb-10 leading-relaxed">
                        Peralatan tempur sudah siap. Harga mahasiswa, kualitas pro. Booking sekarang sebelum keduluan yang
                        lain!
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-10 py-5 bg-[#9E1B22] text-white border-[3px] border-black font-black uppercase tracking-widest text-[16px] rounded-2xl hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#000] transition-all duration-300 transform hover:rotate-1">
                            Buat Akun Gratis
                        </a>
                        <a href="#katalog-kamera"
                            class="w-full sm:w-auto px-10 py-5 bg-white text-black border-[3px] border-black font-black uppercase tracking-widest text-[16px] rounded-2xl hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#9E1B22] transition-all duration-300 transform hover:-rotate-1">
                            Lihat Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Supported Brands Section (Bottom) --}}
    <div class="w-full bg-white py-16 border-t-2 border-zinc-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <h3 class="text-xl sm:text-2xl font-black text-black mb-12 tracking-tight">Backed by Industry-Leading Brands
            </h3>

            <div class="w-full flex justify-center items-center mb-8 px-4">
                <img src="{{ asset('assets/img/brand.avif') }}" alt="Supported Brands"
                    class="w-full max-w-5xl object-contain opacity-90 hover:opacity-100 transition-opacity duration-300">
            </div>

            <p class="text-sm font-bold text-gray-400 italic">And many more top-tier brands!</p>
        </div>
    </div>
    </div>
@endsection
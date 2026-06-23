@extends('layouts.app')

@section('content')
        <div class="relative min-h-[100dvh] text-zinc-950 bg-white selection:bg-[#9E1B22] selection:text-white"
            style="font-family: 'Outfit', sans-serif;" x-data="{ mobileMenuOpen: false, scrolled: false }"
            @scroll.window="scrolled = (window.pageYOffset > 50)">

            {{-- Floating Navigation is handled by navigation.blade.php now --}}

            {{-- Asymmetric Hero Section --}}
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16 md:pt-20 md:pb-24">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-10 items-stretch">

                    {{-- Text Content (Left, span 7) --}}
                    <div
                        class="lg:col-span-7 bg-white border-2 border-zinc-950 rounded-[2rem] p-8 md:p-14 shadow-[8px_8px_0_0_#9E1B22] flex flex-col justify-center">
                        <div
                            class="inline-flex items-center gap-2.5 px-4 py-2 bg-white border-2 border-zinc-950 rounded-full mb-8 shadow-[2px_2px_0_0_#9E1B22] w-max">
                            <span class="w-2.5 h-2.5 bg-[#9E1B22] rounded-full animate-pulse border border-zinc-950"></span>
                            <span class="text-[14px] font-bold text-zinc-950 tracking-wide uppercase">Sewa Kamera Premium Gen
                                Z</span>
                        </div>

                        <h1 class="text-5xl sm:text-6xl lg:text-[72px] font-black tracking-tighter leading-[0.95] text-zinc-950 mb-8 uppercase"
                            style="text-shadow: 4px 4px 0px #9E1B22;">
                            Abadikan <br>
                            Momen <br>
                            Tanpa Batas.
                        </h1>

                        <p class="text-xl text-zinc-700 font-medium leading-relaxed max-w-[500px] mb-10">
                            Penyewaan kamera DSLR & Mirrorless premium. Transparan per jam, DP ringan, dan jaminan unit 100%
                            mulus.
                        </p>

                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#katalog-kamera"
                                class="inline-flex items-center justify-center px-8 py-4 bg-[#9E1B22] text-white font-black uppercase tracking-wider text-[15px] rounded-xl border-2 border-zinc-950 hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#7A151B] transition-all duration-300">
                                Eksplor Katalog
                            </a>
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white text-zinc-950 font-black uppercase tracking-wider text-[15px] rounded-xl border-2 border-zinc-950 hover:-translate-y-1 hover:bg-zinc-50 hover:shadow-[6px_6px_0_0_#9E1B22] transition-all duration-300">
                                Daftar Gratis
                            </a>
                        </div>
                    </div>

                    {{-- Visual Hero Composition (Right, span 5) --}}
                    <div class="lg:col-span-5 relative hidden lg:flex flex-col gap-6">
                        <div
                            class="flex-1 bg-white border-2 border-zinc-950 rounded-[2rem] shadow-[8px_8px_0_0_#9E1B22] overflow-hidden relative group">
                            <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                                alt="Camera Setup"
                                class="w-full h-full object-cover filter grayscale hover:grayscale-0 transition-all duration-500">
                            <div
                                class="absolute inset-0 border-4 border-transparent group-hover:border-[#9E1B22] transition-all duration-500 rounded-[2rem] pointer-events-none">
                            </div>
                        </div>
                        <div
                            class="h-40 bg-[#9E1B22] border-2 border-zinc-950 rounded-[2rem] p-6 flex flex-col justify-center items-center text-center shadow-[6px_6px_0_0_#7A151B] hover:-translate-y-1 transition-transform duration-300">
                            <p class="text-4xl font-black tracking-tight text-white" style="text-shadow: 2px 2px 0px #7A151B;">
                                500+</p>
                            <p class="text-[15px] font-bold text-white mt-1 uppercase tracking-wider">Unit Tersedia</p>
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
                    {{-- Bento Block 1 (Wide) --}}
                    <div
                        class="col-span-1 md:col-span-8 bg-white border-2 border-zinc-950 rounded-[2rem] p-8 sm:p-10 flex flex-col justify-between hover:-translate-y-1 hover:shadow-[8px_8px_0_0_#9E1B22] shadow-[4px_4px_0_0_#9E1B22] transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-[#9E1B22] border-2 border-zinc-950 rounded-2xl flex items-center justify-center mb-10 shadow-[4px_4px_0_0_#7A151B]">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-zinc-950 mb-3 uppercase tracking-tight">Kualitas Terjamin</h3>
                            <p class="text-lg text-zinc-700 font-medium leading-relaxed">Pengecekan ketat (sensor, kebersihan,
                                baterai) sebelum diserahkan. Jamin 100% siap pakai.</p>
                        </div>
                    </div>

                    {{-- Bento Block 2 (Tall) --}}
                    <div
                        class="col-span-1 md:col-span-4 bg-[#9E1B22] border-2 border-zinc-950 rounded-[2rem] p-8 sm:p-10 flex flex-col justify-between shadow-[4px_4px_0_0_#7A151B] hover:-translate-y-1 hover:shadow-[8px_8px_0_0_#7A151B] transition-all duration-300">
                        <div
                            class="w-16 h-16 bg-white border-2 border-zinc-950 rounded-2xl flex items-center justify-center mb-10 shadow-[4px_4px_0_0_#7A151B]">
                            <svg class="w-8 h-8 text-zinc-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white mb-3 uppercase tracking-tight"
                                style="text-shadow: 2px 2px 0px #7A151B;">Sewa Per Jam</h3>
                            <p class="text-lg text-blue-100 font-medium leading-relaxed">Lebih hemat tanpa terikat harga penuh
                                sewa harian konvensional.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Minimalist Catalog Section --}}
            <div id="katalog-kamera" class="py-16 bg-zinc-50 border-y-2 border-zinc-950">
                <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
                        <div>
                            <h2 class="text-4xl sm:text-5xl font-black tracking-tighter text-zinc-950 mb-3 uppercase"
                                style="text-shadow: 3px 3px 0px #9E1B22;">Katalog Unit.</h2>
                            <p class="text-xl text-zinc-700 font-medium">Pilih alat yang tepat untuk menceritakan kisah Anda.
                            </p>
                        </div>
                    </div>

                    {{-- Search & Filters --}}
                    <div class="mb-12">
                        <form action="{{ route('home') }}" method="GET"
                            class="flex flex-col md:flex-row gap-4 items-center justify-between bg-white border-2 border-zinc-950 rounded-2xl p-4 shadow-[6px_6px_0_0_#9E1B22]">
                            {{-- Minimal Search Box --}}
                            <div class="relative w-full md:w-[400px]">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-zinc-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari model kamera..."
                                    class="block w-full pl-12 pr-4 py-3 border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold placeholder-zinc-400 text-[15px] focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200">
                            </div>

                            {{-- Clean Badges --}}
                            <div class="flex flex-wrap gap-2 items-center w-full md:w-auto">
                                <a href="{{ route('home', array_filter(['search' => request('search')])) }}#katalog-kamera"
                                    class="px-5 py-2.5 text-[14px] font-black uppercase tracking-wider rounded-xl border-2 transition-all duration-200 {{ !request('category') ? 'bg-[#9E1B22] text-white border-zinc-950 shadow-[3px_3px_0_0_#7A151B]' : 'bg-white text-zinc-950 border-zinc-950 hover:-translate-y-0.5 hover:shadow-[3px_3px_0_0_#9E1B22]' }}">
                                    Semua
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('home', array_filter(['category' => $category->slug, 'search' => request('search')])) }}#katalog-kamera"
                                        class="px-5 py-2.5 text-[14px] font-black uppercase tracking-wider rounded-xl border-2 transition-all duration-200 {{ request('category') === $category->slug ? 'bg-[#9E1B22] text-white border-zinc-950 shadow-[3px_3px_0_0_#7A151B]' : 'bg-white text-zinc-950 border-zinc-950 hover:-translate-y-0.5 hover:shadow-[3px_3px_0_0_#9E1B22]' }}">
                                        {{ $category->kategori_name }}
                                    </a>
                                @endforeach
                            </div>
                        </form>
                    </div>

                    {{-- Products Grid --}}
                    @if($products->isEmpty())
                        <div
                            class="text-center py-24 bg-white border-2 border-zinc-950 rounded-[2rem] shadow-[8px_8px_0_0_#9E1B22]">
                            <div
                                class="w-20 h-20 mx-auto mb-6 bg-[#9E1B22] rounded-2xl border-2 border-zinc-950 flex items-center justify-center shadow-[4px_4px_0_0_#7A151B]">
                                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-black text-zinc-950 mb-2 uppercase">Kamera Tidak Ditemukan</h3>
                            <p class="text-lg font-medium text-zinc-500">Coba ubah kata kunci pencarian atau pilih kategori lain.
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                            @foreach($products as $product)
                                <div
                                    class="group flex flex-col bg-white border-2 border-zinc-950 rounded-[2rem] overflow-hidden hover:-translate-y-1 hover:shadow-[8px_8px_0_0_#9E1B22] shadow-[4px_4px_0_0_#9E1B22] transition-all duration-300">
                                    {{-- Image Container (with Alpine Carousel) --}}
                                    <div class="relative w-full aspect-[4/3] bg-zinc-100 overflow-hidden border-b-2 border-zinc-950 group/carousel" 
                                         x-data="{ 
                                            activeSlide: 0, 
                                            slides: [{{ $product->galleries->map(fn($g) => "'" . asset('storage/' . $g->foto) . "'")->implode(',') }}] 
                                         }">
                                        
                                        @if($product->galleries->isNotEmpty())
                                            <template x-for="(slide, index) in slides" :key="index">
                                                <div x-show="activeSlide === index"
                                                     x-transition.opacity.duration.500ms
                                                     class="absolute inset-0 p-4 md:p-6 bg-white flex items-center justify-center">
                                                    <img :src="slide"
                                                        alt="{{ $product->produk_name }}"
                                                        class="w-full h-full object-contain p-4 filter grayscale-[10%] group-hover/carousel:grayscale-0 transition-all duration-500">
                                                </div>
                                            </template>
                                            
                                            {{-- Carousel Controls (show only if > 1 slide) --}}
                                            @if($product->galleries->count() > 1)
                                                <button @click.prevent="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" 
                                                        class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 border-2 border-zinc-950 rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-opacity z-10 hover:bg-white hover:text-[#9E1B22]">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                                </button>
                                                <button @click.prevent="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" 
                                                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 border-2 border-zinc-950 rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-opacity z-10 hover:bg-white hover:text-[#9E1B22]">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
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
                                            <div class="absolute inset-0 bg-white flex flex-col items-center justify-center p-4 text-center">
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
                                            class="absolute top-4 right-4 z-20 flex items-center gap-2 bg-white/90 backdrop-blur-sm border border-gray-100 px-2.5 py-1.5 rounded-lg shadow-sm">
                                            <span
                                                class="w-2 h-2 rounded-full {{ $product->unit > 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                            <span
                                                class="text-[10px] font-bold text-gray-700 uppercase tracking-widest">{{ $product->unit }}
                                                Unit</span>
                                        </div>
                                    </div>

                                    {{-- Product Info --}}
                                    <div class="flex-1 p-6 flex flex-col">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span
                                                class="px-2.5 py-1 bg-[#9E1B22] text-white border-2 border-zinc-950 rounded-lg text-[10px] font-black tracking-widest uppercase shadow-[2px_2px_0_0_#7A151B]">{{ $product->category->kategori_name }}</span>
                                        </div>
                                        <h3 class="text-xl font-black text-zinc-950 tracking-tight line-clamp-1 mb-4">
                                            {{ $product->produk_name }}
                                        </h3>

                                        <div
                                            class="mt-auto pt-4 border-t-2 border-zinc-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                            <div>
                                                <p class="text-2xl font-black text-zinc-950">
                                                    Rp {{ number_format($product->prices['6'] ?? 0, 0, ',', '.') }}<span
                                                        class="text-sm font-bold text-zinc-500">/6 jam</span>
                                                </p>
                                            </div>
                                            <a href="{{ route('product.show', $product->id_produk) }}"
                                                class="text-center px-4 py-2 bg-white text-zinc-950 border-2 border-zinc-950 rounded-xl font-black uppercase text-xs tracking-wider shadow-[3px_3px_0_0_#9E1B22] hover:bg-[#9E1B22] hover:text-white hover:shadow-[3px_3px_0_0_#7A151B] transition-all active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Elegant CTA Section --}}
            <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div
                    class="bg-[#9E1B22] rounded-[2rem] border-2 border-zinc-950 shadow-[8px_8px_0_0_#7A151B] p-12 md:p-20 text-center relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-4xl sm:text-6xl font-black tracking-tighter text-white mb-6 uppercase"
                            style="text-shadow: 4px 4px 0px #7A151B;">Mulai Berkarya Hari Ini.</h2>
                        <p class="text-blue-100 text-xl font-medium max-w-2xl mx-auto mb-10">Jadilah bagian dari komunitas kami
                            dan rasakan kemudahan menyewa perlengkapan produksi yang profesional.</p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('register') }}"
                                class="w-full sm:w-auto px-10 py-5 bg-white text-zinc-950 border-2 border-zinc-950 font-black uppercase tracking-wider text-[16px] rounded-xl hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#7A151B] transition-all duration-300">
                                Buat Akun
                            </a>
                            <a href="#katalog-kamera"
                                class="w-full sm:w-auto px-10 py-5 bg-zinc-950 text-white border-2 border-zinc-950 font-black uppercase tracking-wider text-[16px] rounded-xl hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#7A151B] transition-all duration-300">
                                Lihat Kamera
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

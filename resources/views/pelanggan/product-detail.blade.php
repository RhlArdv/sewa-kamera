@extends('layouts.app')

@section('content')
    {{-- Guest/Public Detail View (Soft Neobrutalism - High-End Aesthetic) --}}
    <div class="relative text-zinc-950 pb-24 pt-10" style="font-family: 'Outfit', sans-serif;">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Link -->
            <a href="{{ route('home') }}"
                class="inline-flex items-center text-sm font-black text-zinc-950 hover:-translate-x-1 transition-transform duration-300 mb-10 focus:outline-none focus-visible:ring-2 focus-visible:ring-zinc-950 rounded-md">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                KEMBALI KE KATALOG
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                <!-- Left: Galleries and Details (Span 8) -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Image Card (with Alpine Carousel) -->
                    <div class="bg-white border-2 border-zinc-950 shadow-[8px_8px_0px_0px_#9E1B22] overflow-hidden aspect-[16/10] flex items-center justify-center relative rounded-[2rem] group/carousel transition-all duration-300 hover:-translate-y-1 hover:shadow-[12px_12px_0px_0px_#9E1B22]"
                            x-data="{ 
                            activeSlide: 0, 
                            slides: [{{ $product->galleries->map(fn($g) => "'" . asset('storage/' . $g->foto) . "'")->implode(',') }}] 
                            }">
                        
                        @if($product->galleries->isNotEmpty())
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="activeSlide === index"
                                        x-transition.opacity.duration.500ms
                                        class="absolute inset-0 p-8 md:p-12 bg-white flex items-center justify-center">
                                    <img :src="slide"
                                        alt="{{ $product->produk_name }}"
                                        class="w-full h-full object-contain filter grayscale-[10%] group-hover/carousel:grayscale-0 transition-all duration-700">
                                </div>
                            </template>
                            
                            {{-- Carousel Controls --}}
                            @if($product->galleries->count() > 1)
                                <button @click.prevent="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" 
                                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 border-2 border-zinc-950 rounded-full w-12 h-12 flex items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-opacity z-10 hover:bg-[#9E1B22] hover:text-white shadow-[2px_2px_0px_0px_#7A151B]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button @click.prevent="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" 
                                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 border-2 border-zinc-950 rounded-full w-12 h-12 flex items-center justify-center opacity-0 group-hover/carousel:opacity-100 transition-opacity z-10 hover:bg-[#9E1B22] hover:text-white shadow-[2px_2px_0px_0px_#7A151B]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                </button>
                                
                                {{-- Dots --}}
                                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2.5 z-10">
                                    <template x-for="(slide, index) in slides" :key="index">
                                        <span class="w-3 h-3 rounded-full border-2 border-zinc-950 transition-all cursor-pointer" 
                                                @click="activeSlide = index"
                                                :class="activeSlide === index ? 'bg-[#9E1B22] scale-125' : 'bg-white'"></span>
                                    </template>
                                </div>
                            @endif
                        @else
                            <!-- Placeholder -->
                            <div class="absolute inset-0 bg-white flex flex-col items-center justify-center p-4">
                                <div class="p-6 border-2 border-zinc-950 rounded-3xl bg-zinc-50 text-zinc-300 mb-4 shadow-[4px_4px_0px_0px_#9E1B22]">
                                    <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <circle cx="12" cy="13" r="3" stroke-width="2" />
                                    </svg>
                                </div>
                                <span class="text-sm font-black uppercase tracking-widest text-zinc-950">{{ $product->category->kategori_name }}</span>
                            </div>
                        @endif
                    </div>

                    @if($product->results->isNotEmpty())
                    <div class="mt-8 border-t-2 border-zinc-100 pt-8">
                        <h3 class="text-xl font-black text-zinc-950 uppercase tracking-tight mb-4">Hasil Jepretan</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($product->results as $result)
                                <div class="aspect-square bg-white border-2 border-zinc-950 rounded-2xl overflow-hidden shadow-[4px_4px_0px_0px_#9E1B22] hover:-translate-y-1 hover:shadow-[6px_6px_0px_0px_#9E1B22] transition-all">
                                    <img src="{{ asset('storage/' . $result->foto) }}" alt="Hasil Jepretan" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Details Card -->
                    <div class="bg-white border-2 border-zinc-950 shadow-[6px_6px_0px_0px_#9E1B22] rounded-[2rem] p-8 md:p-12">
                        <span class="text-xs font-black tracking-widest text-white bg-[#9E1B22] border-2 border-zinc-950 px-3 py-1.5 inline-block shadow-[3px_3px_0px_0px_#7A151B] uppercase rounded-xl">{{ $product->category->kategori_name }}</span>

                        <h2 class="text-3xl md:text-5xl font-black text-zinc-950 mt-6 tracking-tighter uppercase" style="text-shadow: 2px 2px 0px #9E1B22;">{{ $product->produk_name }}</h2>

                        <div class="mt-8 border-t-2 border-zinc-100 pt-8">
                            <h3 class="text-xl font-black text-zinc-950 uppercase tracking-tight mb-4">Spesifikasi & Deskripsi</h3>
                            <p class="text-lg font-medium text-zinc-700 leading-relaxed">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Booking Prompt Card (Span 4) -->
                <div class="lg:col-span-4">
                    <div class="bg-white border-2 border-zinc-950 shadow-[6px_6px_0px_0px_#9E1B22] rounded-[2rem] p-8 md:p-10 sticky top-24" x-data="{
                                    prices: {{ json_encode($product->prices) }},
                                    package: '6',
                                    banyak: 1,
                                    startTime: '',
                                    get durationHours() {
                                        return parseInt(this.package) || 0;
                                    },
                                    getPrice() {
                                        let p = parseInt(this.prices[this.package]);
                                        if (isNaN(p)) {
                                            p = this.package == '0' ? (parseInt(this.prices['6']) || 10000) : 0;
                                        }
                                        return p;
                                    },
                                    get total() {
                                        return this.getPrice() * this.banyak;
                                    }
                                 }">
                        <h3 class="text-xl font-black text-zinc-950 uppercase tracking-tighter border-b-2 border-zinc-100 pb-4 mb-6">
                            Sewa Unit Ini
                        </h3>

                        <div class="mb-8">
                            <p class="text-xs text-zinc-500 uppercase tracking-widest font-black mb-2">Mulai Dari</p>
                            <p class="text-4xl font-black text-zinc-950 flex items-end gap-1">
                                Rp {{ number_format($product->prices['6'] ?? 0, 0, ',', '.') }}
                                <span class="text-sm text-zinc-500 font-bold mb-1">/6 jam</span>
                            </p>
                        </div>

                        @if(auth()->check())
                            @if(auth()->user()->isPelanggan())
                                <form action="{{ route('cart.store') }}" method="POST" class="space-y-5">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $product->id_produk }}">

                                    <div>
                                        <label for="banyak" class="block text-xs font-black text-zinc-950 uppercase tracking-wider mb-2">Jumlah Unit (Maks: {{ $product->unit }})</label>
                                        <input type="number" name="banyak" id="banyak" x-model.number="banyak" min="1" max="{{ $product->unit }}"
                                            class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4">
                                    </div>

                                    <div>
                                        <label for="start_time" class="block text-xs font-black text-zinc-950 uppercase tracking-wider mb-2">Tanggal & Waktu Mulai</label>
                                        <input type="datetime-local" name="start_time" id="start_time" x-model="startTime" required
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
                                            class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4">
                                    </div>

                                    <div>
                                        <label for="package" class="block text-xs font-black text-zinc-950 uppercase tracking-wider mb-2">Pilih Paket Sewa</label>
                                        <select name="package_duration" id="package" x-model="package" required
                                            class="block w-full border-2 border-zinc-950 rounded-xl bg-white text-zinc-950 font-bold focus:outline-none focus:ring-0 focus:border-[#9E1B22] transition duration-200 py-3 px-4">
                                            <option value="0">Paket 5 Menit (Test Stock) (Rp {{ number_format($product->prices['0'] ?? ($product->prices['6'] ?? 10000), 0, ',', '.') }})</option>
                                            <option value="6">Paket 6 Jam (Rp {{ number_format($product->prices['6'] ?? 0, 0, ',', '.') }})</option>
                                            <option value="12">Paket 12 Jam (Rp {{ number_format($product->prices['12'] ?? 0, 0, ',', '.') }})</option>
                                            <option value="24">Paket 24 Jam (Rp {{ number_format($product->prices['24'] ?? 0, 0, ',', '.') }})</option>
                                        </select>
                                    </div>

                                    <!-- Dynamic Total -->
                                    <div class="bg-zinc-50 border-2 border-zinc-950 rounded-xl p-4 space-y-2 shadow-[3px_3px_0px_0px_#9E1B22]" x-show="total > 0">
                                        <div class="flex justify-between text-xs text-zinc-600 font-bold">
                                            <span>Durasi Sewa:</span>
                                            <span x-text="package == '0' ? '5 menit (Test)' : durationHours + ' jam'"></span>
                                        </div>
                                        <div class="flex justify-between text-xs text-zinc-600 font-bold">
                                            <span>Subtotal Tarif:</span>
                                            <span x-text="'Rp ' + (getPrice() * banyak).toLocaleString('id-ID')"></span>
                                        </div>
                                        <div class="flex justify-between text-sm font-black text-zinc-950 border-t-2 border-zinc-200 pt-2.5 mt-2">
                                            <span>Estimasi Total:</span>
                                            <span x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-6 py-4 bg-zinc-950 text-white border-2 border-zinc-950 rounded-xl font-black uppercase tracking-wider text-[15px] hover:-translate-y-1 shadow-[4px_4px_0px_0px_#9E1B22] hover:shadow-[6px_6px_0px_0px_#9E1B22] transition-all duration-300">
                                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Masukkan Keranjang
                                    </button>
                                </form>
                            @else
                                <div class="bg-zinc-50 border-2 border-zinc-950 rounded-2xl p-6 text-center shadow-[4px_4px_0px_0px_#9E1B22]">
                                    <p class="text-sm font-black text-zinc-950 uppercase mb-2">Anda Masuk Sebagai Admin</p>
                                    <p class="text-sm text-zinc-600 font-bold leading-relaxed">Menu penyewaan hanya tersedia untuk akun Pelanggan.</p>
                                    <a href="{{ route('menu.dashboard') }}" class="mt-4 w-full inline-flex items-center justify-center px-4 py-3 bg-zinc-950 text-white border-2 border-zinc-950 rounded-xl font-black uppercase tracking-wider text-[13px] hover:-translate-y-1 shadow-[4px_4px_0px_0px_#9E1B22] transition-all duration-300">
                                        Ke Dashboard Admin
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="bg-zinc-50 border-2 border-zinc-950 rounded-2xl p-6 text-center shadow-[4px_4px_0px_0px_#9E1B22]">
                                <div class="w-12 h-12 bg-[#9E1B22] rounded-xl border-2 border-zinc-950 flex items-center justify-center mx-auto mb-4 shadow-[2px_2px_0px_0px_#7A151B]">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <p class="text-sm text-zinc-800 leading-relaxed font-bold mb-6">
                                    Unit ini tersedia untuk disewa. Silakan masuk (log in) untuk melakukan pemesanan dan mengatur jadwal.
                                </p>
                                <a href="{{ route('login') }}" class="w-full inline-flex items-center justify-center px-6 py-4 bg-[#9E1B22] text-white border-2 border-zinc-950 rounded-xl font-black uppercase tracking-wider text-[15px] hover:-translate-y-1 shadow-[4px_4px_0px_0px_#7A151B] hover:shadow-[6px_6px_0px_0px_#7A151B] transition-all duration-300">
                                    Masuk ke Akun
                                </a>
                                <p class="text-sm text-zinc-600 font-bold mt-5">
                                    Belum punya akun? <br>
                                    <a href="{{ route('register') }}" class="text-zinc-950 underline font-black hover:text-[#9E1B22] transition-colors mt-1 inline-block">Daftar sekarang</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

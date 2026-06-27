@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Keranjang Belanja</h1>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-xs font-semibold" role="alert" aria-live="polite">
                {{ session('success') }}
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="text-center py-16 bg-white border border-gray-100 rounded-2xl shadow-sm">
                <div class="p-4 rounded-full bg-gray-50 border border-gray-100 text-slate-500 inline-block mb-4 shadow-inner">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-700">Keranjang Anda Kosong</h3>
                <p class="mt-2 text-xs text-gray-400 max-w-sm mx-auto">Anda belum menambahkan kamera ke keranjang belanja. Jelajahi katalog kami untuk menemukan kamera terbaik.</p>
                <a href="{{ route('home') }}" class="mt-6 inline-flex items-center px-4 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold uppercase tracking-wider text-xs rounded-xl shadow-sm shadow-slate-100 transition duration-200 focus-visible:ring-2 focus-visible:ring-slate-500 outline-none">
                    Jelajahi Katalog
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <!-- Left: Cart Items List (Span 2) -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cartItems as $item)
                        <div class="bg-white border border-gray-100 rounded-2xl p-6 flex flex-col sm:flex-row gap-6 relative group transition-all duration-300 hover:border-gray-200 shadow-sm">
                            
                            <!-- Product Image / Placeholder -->
                            <div class="w-full sm:w-36 aspect-[4/3] bg-gray-50 rounded-xl overflow-hidden flex items-center justify-center shrink-0 border border-gray-100 relative">
                                @if($item->product->galleries->isNotEmpty())
                                    <img src="{{ asset('storage/' . $item->product->galleries->first()->foto) }}" 
                                         alt="{{ $item->product->produk_name }}"
                                         width="150"
                                         height="112"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                         class="w-full h-full object-cover">
                                @endif
                                <!-- Placeholder -->
                                <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-50 flex flex-col items-center justify-center p-2" style="{{ $item->product->galleries->isNotEmpty() ? 'display: none;' : '' }}">
                                    <svg class="h-6 w-6 text-gray-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    </svg>
                                    <span class="text-[8px] font-semibold tracking-wider text-gray-400 uppercase">{{ $item->product->category->kategori_name }}</span>
                                </div>
                            </div>

                            <!-- Product Rental Details -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <span class="text-[10px] font-semibold tracking-wider text-slate-500 uppercase">{{ $item->product->category->kategori_name }}</span>
                                            <h4 class="text-base font-bold text-gray-900 mt-0.5 leading-tight">{{ $item->product->produk_name }}</h4>
                                        </div>
                                        
                                        <!-- Delete Form -->
                                        <form action="{{ route('cart.destroy', $item->id_chart) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-500 hover:bg-red-50 transition duration-150 p-2 rounded-lg focus-visible:ring-2 focus-visible:ring-slate-500 outline-none" title="Hapus dari keranjang" aria-label="Hapus {{ $item->product->produk_name }} dari keranjang">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Rental Timeslot -->
                                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-50 border border-gray-100 rounded-xl p-3.5 text-xs text-gray-600">
                                        <div>
                                            <p class="text-[9px] text-gray-400 uppercase tracking-wider font-semibold">Mulai Sewa</p>
                                            <p class="mt-0.5 text-gray-800 font-bold font-mono">{{ $item->start_time->format('d M Y - H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[9px] text-gray-400 uppercase tracking-wider font-semibold">Selesai Sewa</p>
                                            <p class="mt-0.5 text-gray-800 font-bold font-mono">{{ $item->end_time->format('d M Y - H:i') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Price calculations -->
                                <div class="mt-5 pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-6 text-xs text-gray-500">
                                        <div>
                                            <span class="block text-gray-400 uppercase text-[9px] tracking-wider font-semibold">Durasi</span>
                                            <span class="font-bold text-gray-700 font-mono">{{ $item->duration_hours == 0 ? '5 Menit' : $item->duration_hours . ' Jam' }}</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-400 uppercase text-[9px] tracking-wider font-semibold">Kamera</span>
                                            <span class="font-bold text-gray-700 font-mono">{{ $item->banyak }} Unit</span>
                                        </div>
                                        <div>
                                            <span class="block text-gray-400 uppercase text-[9px] tracking-wider font-semibold font-sans">Tarif Paket</span>
                                            <span class="font-bold text-gray-700 font-mono">Rp&nbsp;{{ number_format($item->product->prices[$item->duration_hours] ?? ($item->duration_hours == 0 ? ($item->product->prices[6] ?? 10000) : 0), 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <span class="block text-gray-400 uppercase text-[9px] tracking-wider font-semibold">Total</span>
                                        <span class="text-base font-bold text-gray-900 font-mono">Rp&nbsp;{{ number_format($item->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right: Summary Sidebar (Span 1) -->
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm space-y-6">
                    <h3 class="text-base font-bold text-gray-900">Ringkasan Penyewaan</h3>

                    <div class="space-y-4 border-b border-gray-100 pb-5 text-xs text-gray-500">
                        <div class="flex justify-between">
                            <span>Jumlah Item:</span>
                            <span class="font-bold text-gray-800">{{ $cartItems->count() }} Kamera</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Total Tarif Sewa:</span>
                            <span class="font-bold text-gray-800 font-mono">Rp&nbsp;{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-100 pt-4 text-[10px] font-bold text-gray-450">
                            <span>Syarat Pengembalian:</span>
                            <span class="text-gray-700 bg-gray-50 border border-gray-200 px-2.5 py-0.5 rounded uppercase tracking-wider font-semibold">KTP & DP 30%</span>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-baseline mb-6">
                            <span class="text-xs font-bold text-gray-400">Estimasi Total:</span>
                            <span class="text-xl font-bold text-gray-900 font-mono">Rp&nbsp;{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="w-full flex items-center justify-center px-4 py-3 bg-slate-800 hover:bg-slate-700 text-white font-bold uppercase tracking-wider text-xs rounded-xl shadow-sm shadow-slate-100 transition duration-200 focus-visible:ring-2 focus-visible:ring-slate-500 outline-none">
                            Lanjut Ke Checkout
                            <svg class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        @endif
    </div>
@endsection


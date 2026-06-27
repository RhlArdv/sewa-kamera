@extends('layouts.app')

@section('content')
    <!-- Shopee-like Mobile View Container -->
    <div class="max-w-4xl mx-auto -mx-4 sm:mx-auto sm:rounded-xl overflow-hidden pb-4" x-data="{
            activeTab: 'all',
            showMockModal: false,
            mockTrxCode: '',
            mockTrxId: '',
            filterTrx(status) {
                if(this.activeTab === 'all') return true;
                return status === this.activeTab;
            },
            triggerPayment(token, code, id) {
                if (token.startsWith('mock-snap-token-')) {
                    this.mockTrxCode = code;
                    this.mockTrxId = id;
                    this.showMockModal = true;
                } else {
                    // Real Midtrans Snap call
                    if (typeof snap !== 'undefined') {
                        snap.pay(token, {
                            onSuccess: function(result) {
                                let form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '/orders/' + id + '/payment-success';
                                
                                let csrf = document.createElement('input');
                                csrf.type = 'hidden';
                                csrf.name = '_token';
                                csrf.value = '{{ csrf_token() }}';
                                form.appendChild(csrf);
                                
                                document.body.appendChild(form);
                                form.submit();
                            },
                            onPending: function(result) {
                                alert('Menunggu pembayaran Anda.');
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal.');
                            }
                        });
                    } else {
                        alert('Midtrans SDK gagal dimuat. Silakan coba beberapa saat lagi.');
                    }
                }
            }
        }">
        <!-- Midtrans Sandbox Snap JS -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key', 'mock_key') }}"></script>

        <!-- Header -->
        <div class="bg-white sticky top-0 z-40 border-b border-gray-100 shadow-sm lg:relative lg:border-none lg:shadow-none lg:bg-transparent lg:pt-4">
            <!-- Mobile Header -->
            <div class="flex items-center px-4 py-3 lg:hidden">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#9E1B22]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-lg font-bold text-gray-800 ml-4">Pesanan Saya</h1>
            </div>

            <!-- Desktop Header -->
            <div class="hidden lg:block px-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Pesanan Saya</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan pantau status penyewaan kamera Anda.</p>
            </div>

            <!-- Pill Tabs -->
            <div class="flex overflow-x-auto hide-scrollbar px-4 py-3 lg:px-0 lg:py-0 gap-2 lg:gap-3 border-t border-gray-50 lg:border-none bg-white lg:bg-transparent shadow-[inset_0_-1px_0_0_rgba(0,0,0,0.02)] lg:shadow-none lg:mb-4">
                <button @click="activeTab = 'all'"
                    :class="{'bg-[#9E1B22] text-white border-[#9E1B22] shadow-md shadow-[#9E1B22]/20': activeTab === 'all', 'bg-white text-gray-500 border-gray-200 hover:border-gray-300 lg:bg-white lg:shadow-sm': activeTab !== 'all'}"
                    class="whitespace-nowrap px-4 py-1.5 lg:px-6 lg:py-2.5 text-[11px] lg:text-sm font-bold rounded-full border transition-all">Semua</button>
                <button @click="activeTab = 'pending'"
                    :class="{'bg-[#9E1B22] text-white border-[#9E1B22] shadow-md shadow-[#9E1B22]/20': activeTab === 'pending', 'bg-white text-gray-500 border-gray-200 hover:border-gray-300 lg:bg-white lg:shadow-sm': activeTab !== 'pending'}"
                    class="whitespace-nowrap px-4 py-1.5 lg:px-6 lg:py-2.5 text-[11px] lg:text-sm font-bold rounded-full border transition-all">Belum Bayar</button>
                <button @click="activeTab = 'dp_paid'"
                    :class="{'bg-[#9E1B22] text-white border-[#9E1B22] shadow-md shadow-[#9E1B22]/20': activeTab === 'dp_paid', 'bg-white text-gray-500 border-gray-200 hover:border-gray-300 lg:bg-white lg:shadow-sm': activeTab !== 'dp_paid'}"
                    class="whitespace-nowrap px-4 py-1.5 lg:px-6 lg:py-2.5 text-[11px] lg:text-sm font-bold rounded-full border transition-all">Lunas (DP)</button>
                <button @click="activeTab = 'completed'"
                    :class="{'bg-[#9E1B22] text-white border-[#9E1B22] shadow-md shadow-[#9E1B22]/20': activeTab === 'completed', 'bg-white text-gray-500 border-gray-200 hover:border-gray-300 lg:bg-white lg:shadow-sm': activeTab !== 'completed'}"
                    class="whitespace-nowrap px-4 py-1.5 lg:px-6 lg:py-2.5 text-[11px] lg:text-sm font-bold rounded-full border transition-all">Selesai</button>
                <button @click="activeTab = 'cancelled'"
                    :class="{'bg-[#9E1B22] text-white border-[#9E1B22] shadow-md shadow-[#9E1B22]/20': activeTab === 'cancelled', 'bg-white text-gray-500 border-gray-200 hover:border-gray-300 lg:bg-white lg:shadow-sm': activeTab !== 'cancelled'}"
                    class="whitespace-nowrap px-4 py-1.5 lg:px-6 lg:py-2.5 text-[11px] lg:text-sm font-bold rounded-full border transition-all">Dibatalkan</button>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="mx-4 mt-4 p-3 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-lg text-xs font-semibold"
                role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($transactions->isEmpty())
            <div class="text-center py-20 bg-gray-50 lg:bg-white lg:rounded-2xl lg:shadow-sm">
                <div class="p-4 rounded-full bg-white border border-gray-100 text-slate-400 inline-block mb-4 shadow-sm">
                    <svg class="h-10 w-10 lg:h-14 lg:w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-sm lg:text-lg font-bold text-gray-700">Belum Ada Pesanan</h3>
                <p class="mt-2 text-xs lg:text-sm text-gray-500 max-w-xs mx-auto">Anda belum pernah menyewa kamera. Yuk, pilih kamera
                    idamanmu sekarang!</p>
                <a href="{{ route('home') }}"
                    class="mt-6 inline-block px-6 py-2 lg:px-8 lg:py-3 bg-[#9E1B22] hover:bg-[#7A151B] text-white font-bold text-xs lg:text-sm rounded-lg shadow-sm">
                    Sewa Sekarang
                </a>
            </div>
        @else
            <div class="bg-gray-100 lg:bg-transparent min-h-screen lg:min-h-0 space-y-4">
                @foreach($transactions as $trx)
                    <!-- Transaction Card -->
                    <div class="bg-white mt-2 lg:mt-0 border-y lg:border lg:rounded-xl border-gray-100 lg:shadow-sm overflow-hidden" x-show="filterTrx('{{ $trx->transaksi_status }}')">
                        <!-- Shop Header -->
                        <div class="flex justify-between items-center px-4 py-3 lg:px-6 lg:py-4 border-b border-gray-100 bg-white">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                    </path>
                                </svg>
                                <span class="text-xs lg:text-sm font-bold text-gray-800">Thasya Kamera</span>
                            </div>
                            <span class="text-[10px] lg:text-xs font-bold text-[#9E1B22] uppercase">
                                @if($trx->transaksi_status == 'pending') Belum Bayar
                                @elseif($trx->transaksi_status == 'dp_paid') Lunas (DP)
                                @elseif($trx->transaksi_status == 'completed') Selesai
                                @else Dibatalkan @endif
                            </span>
                        </div>

                        <!-- Order Items -->
                        @foreach($trx->details as $detail)
                            <div class="flex px-4 py-3 lg:px-6 lg:py-5 bg-gray-50/50 border-b border-gray-50">
                                <!-- Thumbnail -->
                                <div
                                    class="w-20 h-20 lg:w-24 lg:h-24 bg-white border border-gray-200 rounded shrink-0 flex items-center justify-center overflow-hidden relative">
                                    @if($detail->product->galleries->isNotEmpty())
                                        <img src="{{ asset('storage/' . $detail->product->galleries->first()->foto) }}" alt=""
                                            class="w-full h-full object-cover">
                                    @else
                                        <svg class="h-6 w-6 lg:h-8 lg:w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        </svg>
                                    @endif
                                </div>

                                <!-- Details -->
                                <div class="ml-3 lg:ml-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start">
                                            <h4 class="text-xs lg:text-base font-bold text-gray-800 line-clamp-2 leading-snug">
                                                {{ $detail->product->produk_name }}</h4>
                                            <span class="text-xs lg:text-sm text-gray-600 ml-2 font-mono">x{{ $detail->banyak }}</span>
                                        </div>
                                        <p class="text-[10px] lg:text-sm text-gray-500 mt-1 lg:mt-2">Paket: {{ $detail->duration_hours == 0 ? '5 Menit' : $detail->duration_hours . ' Jam' }}</p>
                                    </div>
                                    <div class="flex justify-between items-end mt-2">
                                        <div class="text-[9px] lg:text-xs text-gray-500 lg:text-gray-600 bg-white lg:bg-gray-100 lg:border-none px-1.5 py-0.5 lg:px-2.5 lg:py-1 rounded border border-gray-100">
                                            {{ $detail->start_time->format('d/m H:i') }} - {{ $detail->end_time->format('d/m H:i') }}
                                        </div>
                                        <span
                                            class="text-xs lg:text-base font-bold text-gray-800 font-mono">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Order Total -->
                        <div class="px-4 py-3 lg:px-6 lg:py-4 border-b border-gray-100 flex justify-between items-center bg-white">
                            <div class="flex flex-col">
                                <span class="text-[10px] lg:text-xs text-gray-500">Status KTP:
                                    <strong
                                        class="{{ $trx->ktp_status == 'pending' ? 'text-yellow-600' : ($trx->ktp_status == 'approved' ? 'text-emerald-600' : 'text-rose-600') }} lg:text-sm ml-1">
                                        {{ strtoupper($trx->ktp_status) }}
                                    </strong>
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-[11px] lg:text-sm text-gray-700 mr-1">Total Pesanan:</span>
                                <span
                                    class="text-sm lg:text-lg font-bold text-[#9E1B22] font-mono">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Location -->
                        <a href="https://maps.app.goo.gl/9ZpY2T9n3DZYPZcK6" target="_blank"
                            class="block px-4 py-3 lg:px-6 lg:py-4 border-b border-gray-100 bg-blue-50/30 hover:bg-blue-50/60 transition flex items-start gap-3 lg:gap-4">
                            <div class="mt-0.5 text-blue-600 shrink-0">
                                <svg class="h-4 w-4 lg:w-5 lg:h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-[10px] lg:text-sm font-bold text-gray-800">Lokasi Pengambilan & Pengembalian:</p>
                                    <span
                                        class="text-[9px] lg:text-xs font-semibold text-blue-600 bg-blue-100 px-1.5 py-0.5 lg:px-2.5 lg:py-1 rounded flex items-center gap-1">
                                        Maps <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <p class="text-[10px] lg:text-xs text-gray-600 mt-0.5 lg:mt-1.5 leading-relaxed font-sans pr-4 lg:pr-12">
                                    Jl. Gajah No.VII, Air Tawar Bar., Kec. Padang Utara, Kota Padang, Sumatera Barat
                                    25132
                                </p>
                            </div>
                        </a>

                        <!-- Actions -->
                        <div class="px-4 py-3 lg:px-6 lg:py-4 bg-white flex justify-end items-center space-x-2 lg:space-x-3">
                            <a href="{{ route('invoice.show', $trx->id_transaction) }}" target="_blank"
                                class="px-4 py-1.5 lg:px-6 lg:py-2 border border-gray-300 text-gray-600 bg-white hover:bg-gray-50 rounded lg:rounded-lg text-[11px] lg:text-sm font-bold transition-colors">
                                Lihat Faktur
                            </a>

                            @if($trx->transaksi_status == 'pending')
                                <form action="{{ route('orders.cancel', $trx->id_transaction) }}" method="POST"
                                    onsubmit="return confirm('Batalkan pesanan ini?');" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-1.5 lg:px-6 lg:py-2 border border-gray-300 text-gray-600 bg-white hover:bg-gray-50 rounded lg:rounded-lg text-[11px] lg:text-sm font-bold transition-colors">
                                        Batalkan
                                    </button>
                                </form>

                                @if($trx->ktp_status == 'approved')
                                    <button type="button"
                                        @click="triggerPayment('{{ $trx->midtrans_snap_token }}', '{{ $trx->code }}', '{{ $trx->id_transaction }}')"
                                        class="px-5 py-1.5 lg:px-8 lg:py-2 bg-[#9E1B22] hover:bg-[#7A151B] text-white rounded lg:rounded-lg text-[11px] lg:text-sm font-bold shadow-sm transition-colors">
                                        Bayar DP
                                    </button>
                                @elseif($trx->ktp_status == 'rejected')
                                    <div class="flex items-center gap-1.5 px-3 py-1.5 lg:px-4 lg:py-2 bg-rose-50 border border-rose-200 text-rose-600 rounded lg:rounded-lg text-[11px] lg:text-sm font-bold whitespace-nowrap shadow-sm">
                                        <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        KTP Ditolak
                                    </div>
                                @else
                                    <div class="flex items-center gap-1.5 px-3 py-1.5 lg:px-4 lg:py-2 bg-amber-50 border border-amber-200 text-amber-600 rounded lg:rounded-lg text-[11px] lg:text-sm font-bold whitespace-nowrap shadow-sm">
                                        <svg class="w-3.5 h-3.5 lg:w-4 lg:h-4 animate-spin-slow" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Menunggu Verifikasi KTP
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- AlpineJS Mock Payment Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60 backdrop-blur-sm px-4"
            x-show="showMockModal" x-cloak>
            <div class="bg-white border border-gray-150 rounded-2xl max-w-sm w-full p-6 shadow-xl space-y-5 transform transition-all"
                @click.away="showMockModal = false">
                <div class="text-center space-y-2">
                    <div
                        class="inline-flex p-3 bg-gray-50 border border-gray-100 text-[#9E1B22] rounded-full mb-1 shadow-inner">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Midtrans Sandbox</h3>
                    <p class="text-[11px] text-gray-500 leading-relaxed">Simulasi pembayaran untuk keperluan demo/skripsi.
                    </p>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-lg p-3 space-y-2 text-[11px] text-gray-600">
                    <div class="flex justify-between">
                        <span>Kode:</span>
                        <span class="font-bold text-gray-800 font-mono" x-text="mockTrxCode"></span>
                    </div>
                    <div class="flex justify-between text-emerald-600 font-bold">
                        <span>Simulasi DP:</span>
                        <span>Berhasil</span>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showMockModal = false"
                        class="flex-1 px-4 py-2 border border-gray-200 text-gray-600 text-xs font-bold rounded-lg bg-white">
                        Batal
                    </button>
                    <form :action="'/orders/' + mockTrxId + '/mock-pay'" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 bg-[#9E1B22] text-white font-bold text-xs rounded-lg shadow-sm">
                            Bayar Sukses
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Style for hide-scrollbar -->
    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
@extends('layouts.app')

    @section('header')
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 font-display">
                Detail Transaksi #{{ $transaction->code }}
            </h2>
            <div class="flex gap-3">
                <a 
                    href="{{ route('invoice.show', $transaction->id_transaction) }}" 
                    target="_blank"
                    class="inline-flex items-center px-4 py-2 border border-blue-200 rounded-lg shadow-sm text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none transition duration-150 font-sans gap-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak Faktur
                </a>
                <a 
                    href="{{ route('menu.transactions.index') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-lg shadow-sm text-xs font-semibold text-gray-600 bg-white hover:bg-gray-50 focus:outline-none transition duration-150 font-sans"
                >
                    Kembali
                </a>
            </div>
        </div>
    @endsection

@section('content')

    <div class="py-2" x-data="{ showImageModal: false, modalImageUrl: '', modalTitle: '' }">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kiri: Detail Informasi Sewa & Produk (Col span 2) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Produk yang Disewa -->
                    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 font-sans">
                        <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Kamera & Aksesoris yang Disewa</h3>
                        
                        <div class="space-y-4">
                            @foreach($transaction->details as $detail)
                                <div class="flex items-start sm:items-center space-x-4 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                                    <div class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 flex items-center justify-center border border-gray-200">
                                        @php
                                            $gallery = $detail->product->galleries->first();
                                        @endphp
                                        @if($gallery && file_exists(public_path('storage/products/' . $gallery->foto)))
                                            <img src="{{ asset('storage/products/' . $gallery->foto) }}" class="object-cover h-full w-full">
                                        @elseif($gallery)
                                            <img src="{{ asset('storage/' . $gallery->foto) }}" class="object-cover h-full w-full">
                                        @else
                                            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            </svg>
                                        @endif
                                    </div>

                                    <div class="flex-grow min-w-0">
                                        <h4 class="text-sm font-bold text-gray-800 truncate">{{ $detail->product->produk_name ?? 'Produk dihapus' }}</h4>
                                        <p class="text-xs text-gray-400 mt-1">Kode: <span class="font-mono text-gray-500 font-bold">#{{ $detail->code_produk ?? '-' }}</span></p>
                                        <p class="text-xs text-gray-400 mt-0.5">Durasi sewa: <span class="text-gray-600 font-semibold">{{ $detail->duration_hours == 0 ? '5 Menit' : $detail->duration_hours . ' Jam' }}</span></p>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <div class="text-xs text-gray-400 font-mono">{{ $detail->banyak }} Unit x Rp {{ number_format($detail->price, 0, ',', '.') }}</div>
                                        <div class="text-sm font-bold text-slate-800 mt-1">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Detail Pengiriman / Identitas Penyewa -->
                    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 font-sans">
                        <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Informasi Penyewa</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-gray-650">
                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</span>
                                <span class="font-bold text-gray-800">{{ $transaction->receiver }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Kota Tujuan</span>
                                <span class="font-bold text-gray-800">{{ $transaction->city }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Mulai Sewa</span>
                                <span class="font-bold text-gray-800">{{ $transaction->tanggal_sewa ? $transaction->tanggal_sewa->format('d M Y') : '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Metode Pembayaran</span>
                                <span class="font-bold text-gray-800">{{ $transaction->bayar->jenis_bayar ?? 'Manual' }}</span>
                            </div>
                            <div class="md:col-span-2">
                                <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Keterangan Tambahan / Catatan</span>
                                <p class="bg-gray-50 border border-gray-200 p-3 rounded-lg text-xs text-gray-500 mt-1 leading-relaxed">
                                    {{ $transaction->keterangan ?? 'Tidak ada catatan khusus.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Status, Verifikasi KTP, Pembayaran & Aksi (Col span 1) -->
                <div class="space-y-6">
                    
                    <!-- Box Persetujuan & Aksi Status Sewa -->
                    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 font-sans">
                        <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Ubah Status Sewa</h3>
                        
                        <form action="{{ route('menu.transactions.status', $transaction->id_transaction) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="transaksi_status" class="block text-xs font-semibold text-gray-400 uppercase mb-2">Status Transaksi</label>
                                <select 
                                    name="transaksi_status" 
                                    id="transaksi_status"
                                    class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-750 focus:outline-none focus:border-slate-500 focus:ring-1 focus:ring-slate-500 transition duration-150"
                                >
                                    <option value="pending" {{ $transaction->transaksi_status === 'pending' ? 'selected' : '' }}>Pending (Belum Bayar)</option>
                                    <option value="dp_paid" {{ $transaction->transaksi_status === 'dp_paid' ? 'selected' : '' }}>DP Paid (Sudah Bayar Uang Muka)</option>
                                    <option value="completed" {{ $transaction->transaksi_status === 'completed' ? 'selected' : '' }}>Completed (Selesai & Dikembalikan)</option>
                                    <option value="cancelled" {{ $transaction->transaksi_status === 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-xs font-bold uppercase tracking-wider text-white bg-slate-800 hover:bg-slate-700 focus:outline-none transition duration-150">
                                Perbarui Status
                            </button>
                        </form>
                    </div>

                    <!-- Box Verifikasi KTP -->
                    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 font-sans">
                        <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Verifikasi KTP</h3>
                        
                        @if($transaction->ktp_path)
                            <div class="mb-4">
                                <div class="aspect-[4/3] rounded-xl bg-gray-550 border border-gray-150 overflow-hidden relative group shadow-sm">
                                    <img 
                                        src="{{ asset('storage/' . $transaction->ktp_path) }}" 
                                        class="object-cover h-full w-full"
                                    >
                                    <div 
                                        @click="showImageModal = true; modalImageUrl = '{{ asset('storage/' . $transaction->ktp_path) }}'; modalTitle = 'Foto KTP Penyewa'"
                                        class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition duration-150"
                                    >
                                        <span class="text-xs text-gray-700 font-semibold bg-white border border-gray-200 px-3 py-1.5 rounded-lg shadow-sm">Lihat Gambar</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 border border-gray-100 text-xs mb-4">
                                <span class="text-gray-400">Status KTP saat ini:</span>
                                <span class="font-bold uppercase tracking-wider
                                    {{ $transaction->ktp_status === 'approved' ? 'text-emerald-600' : ($transaction->ktp_status === 'rejected' ? 'text-rose-600' : 'text-gray-500') }}">
                                    {{ $transaction->ktp_status }}
                                </span>
                            </div>

                            @if($transaction->ktp_status === 'pending')
                                <form action="{{ route('menu.transactions.ktp', $transaction->id_transaction) }}" method="POST" class="flex gap-3 mt-4">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        name="ktp_status" 
                                        value="approved"
                                        class="flex-1 inline-flex justify-center py-2 px-3 border border-transparent rounded-lg shadow-sm text-xs font-semibold text-white bg-emerald-500 hover:bg-emerald-600 focus:outline-none transition duration-150"
                                    >
                                        Setujui KTP
                                    </button>
                                    <button 
                                        type="submit" 
                                        name="ktp_status" 
                                        value="rejected"
                                        class="flex-1 inline-flex justify-center py-2 px-3 border border-gray-200 rounded-lg shadow-sm text-xs font-semibold text-rose-600 bg-white hover:bg-rose-50 hover:text-rose-700 hover:border-rose-150 focus:outline-none transition duration-150"
                                    >
                                        Tolak KTP
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="p-6 text-center text-xs text-gray-400 bg-gray-50 border border-gray-100 rounded-xl leading-relaxed">
                                Pelanggan belum mengunggah dokumen KTP.
                            </div>
                        @endif
                    </div>

                    <!-- Box Pembayaran & Bukti Pelunasan -->
                    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 font-sans">
                        <h3 class="text-sm font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Status Finansial</h3>
                        
                        <div class="space-y-3 text-xs text-gray-500 mb-6 font-mono">
                            <div class="flex justify-between">
                                <span>Total Biaya:</span>
                                <span class="text-gray-800 font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>DP Uang Muka:</span>
                                <span class="text-gray-800 font-bold">Rp {{ number_format($transaction->uang_panjar, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-gray-100 text-sm">
                                <span>Sisa Pembayaran:</span>
                                <span class="text-slate-800 font-bold">
                                    Rp {{ number_format(max(0, $transaction->total_price - $transaction->uang_panjar), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Bukti Pelunasan -->
                        @if($transaction->pelunasan)
                            <div class="border-t border-gray-100 pt-4 mt-4 space-y-4">
                                <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider">Verifikasi Pelunasan</h4>
                                
                                @if($transaction->pelunasan->bukti_pelunasan)
                                    <div class="aspect-[4/3] rounded-xl bg-gray-550 border border-gray-150 overflow-hidden relative group shadow-sm">
                                        <img 
                                            src="{{ asset('storage/' . $transaction->pelunasan->bukti_pelunasan) }}" 
                                            class="object-cover h-full w-full"
                                        >
                                        <div 
                                            @click="showImageModal = true; modalImageUrl = '{{ asset('storage/' . $transaction->pelunasan->bukti_pelunasan) }}'; modalTitle = 'Bukti Transfer Pelunasan'"
                                            class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition duration-150"
                                        >
                                            <span class="text-xs text-gray-700 font-semibold bg-white border border-gray-200 px-3 py-1.5 rounded-lg shadow-sm">Lihat Bukti</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 border border-gray-100 text-xs">
                                        <span class="text-gray-400">Status pelunasan:</span>
                                        <span class="font-bold uppercase tracking-wider
                                            {{ $transaction->pelunasan->status_transaction === 'Lunas' ? 'text-emerald-600' : 'text-slate-700' }}">
                                            {{ $transaction->pelunasan->status_transaction }}
                                        </span>
                                    </div>

                                    @if($transaction->pelunasan->status_transaction !== 'Lunas')
                                        <form action="{{ route('menu.transactions.pelunasan', $transaction->id_transaction) }}" method="POST">
                                            @csrf
                                            <button 
                                                type="submit"
                                                class="w-full inline-flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-xs font-bold text-white bg-emerald-500 hover:bg-emerald-600 focus:outline-none transition duration-150"
                                            >
                                                Konfirmasi Sisa Lunas
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <div class="p-4 text-center text-xs text-gray-400 bg-gray-50 border border-gray-100 rounded-xl leading-relaxed">
                                        Penyewa memilih opsi DP, sisa bayar belum dilunasi (belum ada bukti transfer diunggah).
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="border-t border-gray-100 pt-4 mt-4 text-center text-xs text-gray-400 font-sans">
                                Pelanggan menyewa dengan pembayaran langsung / lunas di awal.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Lightbox Image Modal (Global Alpine) -->
        <div 
            x-show="showImageModal" 
            class="fixed inset-0 z-50 overflow-y-auto" 
            style="display: none;"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Overlay -->
                <div class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" @click="showImageModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content -->
                <div 
                    x-show="showImageModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-gray-100"
                >
                    <div class="p-6">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-5">
                            <h3 class="text-sm font-bold text-gray-900" x-text="modalTitle"></h3>
                            <button @click="showImageModal = false" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex justify-center max-h-[70vh] overflow-y-auto">
                            <img :src="modalImageUrl" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

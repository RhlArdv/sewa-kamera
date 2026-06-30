@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 font-display">
                {{ __('Laporan Operasional Penyewaan') }}
            </h2>
            <p class="text-xs text-gray-500 mt-0.5">Statistik aktivitas sewa unit kamera dan frekuensi peminjaman alat</p>
        </div>
        
        <a 
            href="{{ route('menu.reports.rental.print') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
            target="_blank"
            class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none transition duration-150 font-sans"
        >
            <svg class="w-4 h-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Laporan Penyewaan (PDF)
        </a>
    </div>
@endsection

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Filter Tanggal -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 font-sans">Filter Periode Sewa</h3>
                
                <form action="{{ route('menu.reports.rental') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end font-sans">
                    <div>
                        <label for="start_date" class="block text-xs font-semibold text-gray-400 mb-2">Tanggal Mulai</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            value="{{ $startDate }}"
                            class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-sm text-gray-800 font-semibold focus:outline-none focus:border-slate-500 transition duration-150"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="block text-xs font-semibold text-gray-400 mb-2">Tanggal Selesai</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            value="{{ $endDate }}"
                            class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-sm text-gray-800 font-semibold focus:outline-none focus:border-slate-500 transition duration-150"
                        >
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="flex-grow inline-flex justify-center items-center py-2 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none transition duration-150">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('menu.reports.rental') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-250 hover:bg-gray-50 text-gray-600 text-xs font-semibold rounded-xl transition duration-150">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Statistik Operasional -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Booking -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block font-sans">Total Booking Sewa</span>
                        <h4 class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">
                            {{ $totalTransactions }} <span class="text-xs font-normal text-gray-400 font-sans">Transaksi</span>
                        </h4>
                    </div>
                    <div class="text-[11px] text-gray-400 mt-4 border-t border-gray-100 pt-2 font-sans leading-relaxed">
                        Jumlah booking masuk dengan status DP Paid dan Completed.
                    </div>
                </div>

                <!-- Total Unit Disewa -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block font-sans">Total Unit Kamera & Lensa Disewa</span>
                        <h4 class="text-3xl font-extrabold text-indigo-900 mt-2 font-mono">
                            {{ $totalUnitsRented }} <span class="text-xs font-normal text-gray-400 font-sans">Unit Barang</span>
                        </h4>
                    </div>
                    <div class="text-[11px] text-gray-400 mt-4 border-t border-gray-100 pt-2 font-sans leading-relaxed">
                        Akumulasi kuantitas seluruh barang yang keluar dipinjam pelanggan.
                    </div>
                </div>

                <!-- Kamera Paling Laris -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 flex flex-col justify-between font-sans">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block mb-3">Ranking Kamera Terlaris</span>
                        <div class="space-y-2.5 max-h-[120px] overflow-y-auto pr-1">
                            @forelse($popularProducts as $popular)
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-700 truncate pr-2 font-semibold">{{ $popular->product->produk_name ?? 'N/A' }}</span>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 font-bold font-mono text-[10px]">{{ $popular->total_rented }} Unit</span>
                                </div>
                            @empty
                                <div class="text-xs text-gray-400 italic text-center py-4">Belum ada alat disewa</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Riwayat Penyewaan -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Rincian Aktivitas Penyewaan</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Daftar transaksi penyewaan unit kamera pada rentang periode terpilih.</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-white border border-gray-200 rounded-lg text-gray-600">
                        Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-650">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100 font-sans">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Kode Trx</th>
                                <th scope="col" class="px-6 py-3.5">Penyewa / Penerima</th>
                                <th scope="col" class="px-6 py-3.5">Daftar Alat Disewa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Total Unit</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Tanggal Sewa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Status Operasional</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($transactions as $trx)
                                @php
                                    $qtyTrx = 0;
                                    foreach($trx->details as $d) { $qtyTrx += $d->banyak; }
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4 font-mono font-bold text-slate-800">
                                        #{{ $trx->code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800">{{ $trx->receiver }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 font-sans">{{ $trx->user->name ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            @forelse($trx->details as $detail)
                                                <div class="text-xs font-medium text-gray-700 flex items-center gap-2">
                                                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                    <span>{{ $detail->product->produk_name ?? 'Item Tidak Diketahui' }}</span>
                                                    <span class="px-1.5 py-0.2 rounded bg-gray-100 text-gray-600 font-mono text-[11px] font-bold">{{ $detail->banyak }} Unit</span>
                                                </div>
                                            @empty
                                                <span class="text-xs text-gray-400 italic">-</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-mono font-bold text-gray-800">
                                        {{ $qtyTrx }} Unit
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium font-sans text-gray-700">
                                        {{ $trx->tanggal_sewa ? $trx->tanggal_sewa->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                                            {{ $trx->transaksi_status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-250' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                            {{ $trx->transaksi_status === 'completed' ? 'Selesai / Kembali' : 'Sedang Disewa (DP)' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-sans">
                                        Tidak ada aktivitas penyewaan kamera pada rentang periode terpilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($transactions->count() > 0)
                            <tfoot class="bg-gray-50 font-semibold text-gray-800 border-t border-gray-150">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-sans uppercase tracking-wider text-xs">Total Unit Disewa Pada Periode Ini</td>
                                    <td class="px-6 py-4 text-center font-mono text-indigo-950 font-extrabold text-base">{{ $totalUnitsRented }} Unit</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

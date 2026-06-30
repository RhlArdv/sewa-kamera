@extends('layouts.app')

@section('header')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 font-display">
                {{ __('Laporan Keuangan & Laba Kotor') }}
            </h2>
            <p class="text-xs text-gray-500 mt-0.5">Analisis arus kas masuk (Cash Flow), Nilai Omset Booking, dan Rekapitulasi Pembayaran</p>
        </div>
        
        <a 
            href="{{ route('menu.reports.laba.print') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
            target="_blank"
            class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-emerald-800 hover:bg-emerald-700 focus:outline-none transition duration-150 font-sans"
        >
            <svg class="w-4 h-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Laporan Keuangan (PDF)
        </a>
    </div>
@endsection

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Filter Tanggal -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 font-sans">Filter Periode Laporan Keuangan</h3>
                
                <form action="{{ route('menu.reports.laba') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end font-sans">
                    <div>
                        <label for="start_date" class="block text-xs font-semibold text-gray-400 mb-2">Tanggal Mulai</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            value="{{ $startDate }}"
                            class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-sm text-gray-800 font-semibold focus:outline-none focus:border-emerald-600 transition duration-150"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="block text-xs font-semibold text-gray-400 mb-2">Tanggal Selesai</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            value="{{ $endDate }}"
                            class="w-full bg-white border border-gray-200 rounded-xl py-2 px-3 text-sm text-gray-800 font-semibold focus:outline-none focus:border-emerald-600 transition duration-150"
                        >
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="flex-grow inline-flex justify-center items-center py-2 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-emerald-800 hover:bg-emerald-700 focus:outline-none transition duration-150">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('menu.reports.laba') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-250 hover:bg-gray-50 text-gray-600 text-xs font-semibold rounded-xl transition duration-150">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Statistik Keuangan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Arus Kas Masuk Riil -->
                <div class="bg-gradient-to-br from-emerald-900 to-emerald-800 text-white shadow-md rounded-2xl p-5 md:p-6 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-emerald-200 uppercase tracking-wider font-semibold block font-sans">Arus Kas Masuk (Realized Revenue)</span>
                            <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-700/50 text-emerald-200 font-bold">CASH IN</span>
                        </div>
                        <h4 class="text-3xl font-extrabold text-white mt-2 font-mono">
                            Rp {{ number_format($totalCashReceived, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="text-[11px] text-emerald-200 mt-4 border-t border-emerald-700/60 pt-2 font-sans leading-relaxed">
                        Kas tunai/transfer yang benar-benar diterima dari Uang Panjar (DP) & Pelunasan selesai.
                    </div>
                </div>

                <!-- Total Omset Keseluruhan -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block font-sans">Total Nilai Booking (Omset Kotor)</span>
                        <h4 class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">
                            Rp {{ number_format($totalOmset, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="text-[11px] text-gray-400 mt-4 border-t border-gray-100 pt-2 font-sans leading-relaxed">
                        Nilai kontrak keseluruhan dari seluruh transaksi sewa yang masuk pada periode ini.
                    </div>
                </div>

                <!-- Piutang / Sisa Tagihan -->
                @php
                    $sisaTagihan = $totalOmset - $totalCashReceived;
                @endphp
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block font-sans">Potensi Kas / Sisa Belum Lunas</span>
                        <h4 class="text-3xl font-extrabold text-amber-600 mt-2 font-mono">
                            Rp {{ number_format($sisaTagihan > 0 ? $sisaTagihan : 0, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="text-[11px] text-gray-400 mt-4 border-t border-gray-100 pt-2 font-sans leading-relaxed">
                        Selisih omset yang masih berupa piutang (pelunasan saat unit dikembalikan pelanggan).
                    </div>
                </div>
            </div>

            <!-- Breakdown Metode Pembayaran -->
            @if(count($paymentMethods) > 0)
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5">
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 font-sans">Rekapitulasi Kas Berdasarkan Metode Pembayaran</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($paymentMethods as $method => $stats)
                            <div class="p-4 rounded-xl border border-gray-100 bg-gray-50/60 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <span class="font-bold text-sm text-gray-800">{{ $method }}</span>
                                    <span class="text-xs font-mono font-semibold px-2 py-0.5 rounded bg-white border border-gray-200 text-gray-600">{{ $stats['count'] }} Trx</span>
                                </div>
                                <div class="mt-3 pt-2 border-t border-gray-200/60">
                                    <div class="text-[11px] text-gray-400">Kas Diterima:</div>
                                    <div class="text-base font-extrabold font-mono text-emerald-800">Rp {{ number_format($stats['received'], 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tabel Rincian Arus Kas Transaksi -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Buku Kas & Transaksi Keuangan</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Rincian pergerakan kas masuk dan status pembayaran setiap transaksi.</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 bg-white border border-gray-200 rounded-lg text-gray-600">
                        Total Trx: {{ $totalTransactions }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-650">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100 font-sans">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Kode Trx</th>
                                <th scope="col" class="px-6 py-3.5">Penyewa</th>
                                <th scope="col" class="px-6 py-3.5">Metode Bayar</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Tanggal Sewa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Status Pembayaran</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Nilai Kontrak (Omset)</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Kas Masuk (Realized)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($transactions as $trx)
                                @php
                                    $received = $trx->transaksi_status === 'completed' ? $trx->total_price : $trx->uang_panjar;
                                    $methodName = $trx->bayar ? $trx->bayar->jenis_bayar : ($trx->midtrans_snap_token ? 'Midtrans Gateway' : 'Metode Lainnya');
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4 font-mono font-bold text-slate-800">
                                        #{{ $trx->code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800">{{ $trx->receiver }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 font-sans">{{ $trx->user->name ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-700">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold bg-gray-100 text-gray-700">
                                            {{ $methodName }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium font-sans text-gray-700">
                                        {{ $trx->tanggal_sewa ? $trx->tanggal_sewa->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                                            {{ $trx->transaksi_status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-250' : 'bg-amber-50 text-amber-700 border border-amber-250' }}">
                                            {{ $trx->transaksi_status === 'completed' ? 'Lunas 100%' : 'Panjar (DP Paid)' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono text-gray-600">
                                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-extrabold text-emerald-800">
                                        Rp {{ number_format($received, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-sans">
                                        Tidak ada catatan transaksi keuangan pada rentang periode terpilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($transactions->count() > 0)
                            <tfoot class="bg-gray-50 font-semibold text-gray-800 border-t border-gray-150">
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-right font-sans uppercase tracking-wider text-xs">Total Akumulasi Periode Ini</td>
                                    <td class="px-6 py-4 text-right font-mono text-gray-700">Rp {{ number_format($totalOmset, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right font-mono text-emerald-900 text-base font-extrabold">Rp {{ number_format($totalCashReceived, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

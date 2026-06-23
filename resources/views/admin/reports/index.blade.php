@extends('layouts.app')

    @section('header')
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-bold text-gray-900 font-display">
                {{ __('Laporan Pendapatan & Sewa') }}
            </h2>
            
            <a 
                href="{{ route('menu.reports.print') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                target="_blank"
                class="inline-flex items-center px-4 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none transition duration-150 font-sans"
            >
                <svg class="w-4 h-4 mr-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Laporan (PDF)
            </a>
        </div>
    @endsection

@section('content')

    <div class="py-2">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Filter Tanggal -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 font-sans">Filter Laporan</h3>
                
                <form action="{{ route('menu.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end font-sans">
                    <div>
                        <label for="start_date" class="block text-xs font-semibold text-gray-400 mb-2">Tanggal Mulai</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            value="{{ $startDate }}"
                            class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 font-semibold focus:outline-none focus:border-slate-500 transition duration-150"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="block text-xs font-semibold text-gray-400 mb-2">Tanggal Selesai</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            value="{{ $endDate }}"
                            class="w-full bg-white border border-gray-200 rounded-lg py-2 px-3 text-sm text-gray-800 font-semibold focus:outline-none focus:border-slate-500 transition duration-150"
                        >
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="flex-grow inline-flex justify-center items-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-slate-800 hover:bg-slate-700 focus:outline-none transition duration-150">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('menu.reports.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-250 hover:bg-gray-50 text-gray-600 text-xs font-semibold rounded-lg transition duration-150">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Ringkasan Statistik (Revenue & Booking) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pendapatan Rill -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block font-sans">Total Pendapatan Riil</span>
                        <h4 class="text-3xl font-extrabold text-slate-800 mt-2 font-mono">
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </h4>
                    </div>
                    <div class="text-[10px] text-gray-400 mt-4 border-t border-gray-100 pt-2 font-sans leading-relaxed">
                        Dihitung dari Uang Muka (DP) transaksi aktif + pelunasan transaksi selesai.
                    </div>
                </div>

                <!-- Total Transaksi -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 relative overflow-hidden flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block font-sans">Jumlah Transaksi Sukses</span>
                        <h4 class="text-3xl font-extrabold text-gray-800 mt-2 font-mono">
                            {{ $totalTransactions }} <span class="text-xs font-normal text-gray-400 font-sans">Penyewaan</span>
                        </h4>
                    </div>
                    <div class="text-[10px] text-gray-400 mt-4 border-t border-gray-100 pt-2 font-sans leading-relaxed">
                        Jumlah booking masuk (status DP Paid dan Completed).
                    </div>
                </div>

                <!-- Kamera Terlaris -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 md:p-6 flex flex-col justify-between font-sans">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider font-semibold block mb-3">Kamera Paling Laris</span>
                        <div class="space-y-2">
                            @forelse($popularProducts as $popular)
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-gray-650 truncate pr-2 font-semibold">{{ $popular->product->produk_name ?? 'N/A' }}</span>
                                    <span class="text-slate-700 font-bold font-mono">{{ $popular->total_rented }} Kali</span>
                                </div>
                            @empty
                                <div class="text-xs text-gray-400 italic text-center py-4">Belum ada kamera disewa</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Detail Penjualan -->
            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-900">Rincian Transaksi Sukses</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Daftar transaksi persewaan aktif dan selesai dalam periode yang dipilih.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-650">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100 font-sans">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Kode</th>
                                <th scope="col" class="px-6 py-3.5">Nama Penyewa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Tanggal Sewa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Status Sewa</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Nilai Transaksi</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Pendapatan Diterima</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @php
                                $totalTransactedVal = 0;
                                $totalReceivedVal = 0;
                            @endphp
                            @forelse($transactions as $trx)
                                @php
                                    $totalTransactedVal += $trx->total_price;
                                    $received = $trx->transaksi_status === 'completed' ? $trx->total_price : $trx->uang_panjar;
                                    $totalReceivedVal += $received;
                                @endphp
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4 font-mono font-semibold text-gray-800">
                                        #{{ $trx->code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800">{{ $trx->receiver }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 font-sans">{{ $trx->user->name ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium font-sans text-gray-700">
                                        {{ $trx->tanggal_sewa ? $trx->tanggal_sewa->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                            {{ $trx->transaksi_status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-250' : 'bg-slate-50 text-slate-700 border border-slate-200' }}">
                                            {{ $trx->transaksi_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono text-gray-650">
                                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-semibold text-slate-800">
                                        Rp {{ number_format($received, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-sans">
                                        Tidak ada transaksi sewa sukses pada rentang tanggal terpilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($transactions->count() > 0)
                            <tfoot class="bg-gray-50 font-semibold text-gray-800 border-t border-gray-150">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-right font-sans uppercase tracking-wider">Total Penjumlahan</td>
                                    <td class="px-6 py-4 text-right font-mono text-gray-650">Rp {{ number_format($totalTransactedVal, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-right font-mono text-slate-850 text-base">Rp {{ number_format($totalReceivedVal, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

    @section('header')
        <h2 class="text-xl font-bold text-gray-900 font-display">
            {{ __('Kelola Transaksi Sewa') }}
        </h2>
    @endsection

@section('content')

    <div class="py-2">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-900">Daftar Penyewaan</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Pantau transaksi penyewaan kamera, status verifikasi berkas, serta riwayat pembayaran pelanggan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-650">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100 font-sans">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Kode Transaksi</th>
                                <th scope="col" class="px-6 py-3.5">Penyewa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Tanggal Sewa</th>
                                <th scope="col" class="px-6 py-3.5">Metode Bayar</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Status Sewa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Status KTP</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Total Biaya</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($transactions as $trx)
                                <tr class="hover:bg-gray-50/50 transition duration-150">
                                    <td class="px-6 py-4 font-mono font-semibold text-gray-750">
                                        #{{ $trx->code }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-800">{{ $trx->user->name ?? 'User dihapus' }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 font-sans">{{ $trx->user->email ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-medium font-sans text-gray-700">
                                        {{ $trx->tanggal_sewa ? $trx->tanggal_sewa->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-xs font-sans">
                                        <div class="font-semibold text-gray-750">{{ $trx->bayar->jenis_bayar ?? 'Manual' }}</div>
                                        @if($trx->uang_panjar > 0 && $trx->uang_panjar < $trx->total_price)
                                            <div class="text-[10px] text-slate-700 font-bold uppercase mt-0.5">DP 30% / Uang Panjar</div>
                                        @else
                                            <div class="text-[10px] text-emerald-600 font-bold uppercase mt-0.5">Lunas / Pembayaran Penuh</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        @if($trx->transaksi_status === 'pending')
                                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-wider">
                                                Pending
                                            </span>
                                        @elseif($trx->transaksi_status === 'dp_paid')
                                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-slate-105 text-slate-750 border border-slate-200 uppercase tracking-wider">
                                                DP Paid
                                            </span>
                                        @elseif($trx->transaksi_status === 'completed')
                                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wider">
                                                Completed
                                            </span>
                                        @elseif($trx->transaksi_status === 'cancelled')
                                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-rose-50 text-rose-700 border border-rose-200 uppercase tracking-wider">
                                                Cancelled
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-gray-200 text-gray-700 uppercase tracking-wider">
                                                {{ $trx->transaksi_status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        @if($trx->ktp_status === 'pending')
                                            <span class="px-2 py-0.5 rounded-md text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">
                                                Pending
                                            </span>
                                        @elseif($trx->ktp_status === 'approved')
                                            <span class="px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Approved
                                            </span>
                                        @elseif($trx->ktp_status === 'rejected')
                                            <span class="px-2 py-0.5 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono font-semibold text-gray-800">
                                        Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-sans">
                                        <a 
                                            href="{{ route('menu.transactions.show', $trx->id_transaction) }}" 
                                            class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-slate-50 hover:text-slate-850 text-gray-600 text-xs font-semibold rounded-lg transition duration-150 border border-transparent hover:border-slate-200"
                                        >
                                            Detail & Aksi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-400 font-sans">
                                        Belum ada data transaksi penyewaan masuk.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

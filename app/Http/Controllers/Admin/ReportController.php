<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('menu.reports.laba', $request->query());
    }

    private function getLabaReportData($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::with(['user', 'bayar', 'details.product'])
            ->whereBetween('tanggal_sewa', [$start, $end])
            ->whereIn('transaksi_status', ['dp_paid', 'completed'])
            ->orderBy('tanggal_sewa', 'asc')
            ->get();

        $totalOmset = 0;
        $totalCashReceived = 0;
        $paymentMethods = [];

        foreach ($transactions as $trx) {
            $totalOmset += $trx->total_price;
            $received = ($trx->transaksi_status === 'completed') ? $trx->total_price : $trx->uang_panjar;
            $totalCashReceived += $received;

            $methodName = $trx->bayar ? $trx->bayar->jenis_bayar : ($trx->midtrans_snap_token ? 'Midtrans Gateway' : 'Metode Lainnya');
            if (!isset($paymentMethods[$methodName])) {
                $paymentMethods[$methodName] = [
                    'count' => 0,
                    'omset' => 0,
                    'received' => 0,
                ];
            }
            $paymentMethods[$methodName]['count']++;
            $paymentMethods[$methodName]['omset'] += $trx->total_price;
            $paymentMethods[$methodName]['received'] += $received;
        }

        return [
            'transactions' => $transactions,
            'totalOmset' => $totalOmset,
            'totalCashReceived' => $totalCashReceived,
            'totalTransactions' => $transactions->count(),
            'paymentMethods' => $paymentMethods,
            'startDate' => $start->format('Y-m-d'),
            'endDate' => $end->format('Y-m-d')
        ];
    }

    private function getRentalReportData($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::with(['user', 'details.product'])
            ->whereBetween('tanggal_sewa', [$start, $end])
            ->whereIn('transaksi_status', ['dp_paid', 'completed'])
            ->orderBy('tanggal_sewa', 'asc')
            ->get();

        $totalUnitsRented = 0;
        foreach ($transactions as $trx) {
            foreach ($trx->details as $detail) {
                $totalUnitsRented += $detail->banyak;
            }
        }

        $popularProducts = TransactionDetail::select('produk_id', DB::raw('SUM(banyak) as total_rented'))
            ->whereHas('transaction', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_sewa', [$start, $end])
                      ->whereIn('transaksi_status', ['dp_paid', 'completed']);
            })
            ->with('product')
            ->groupBy('produk_id')
            ->orderBy('total_rented', 'desc')
            ->take(8)
            ->get();

        return [
            'transactions' => $transactions,
            'totalTransactions' => $transactions->count(),
            'totalUnitsRented' => $totalUnitsRented,
            'popularProducts' => $popularProducts,
            'startDate' => $start->format('Y-m-d'),
            'endDate' => $end->format('Y-m-d')
        ];
    }

    public function labaIndex(Request $request)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: generate_laba_report_view", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);

        try {
            $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->query('end_date', Carbon::now()->format('Y-m-d'));

            $data = $this->getLabaReportData($startDate, $endDate);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: generate_laba_report_view", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'duration' => $duration
            ]);

            return view('admin.reports.laba', $data);
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: generate_laba_report_view", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal menghasilkan data laporan laba/keuangan.');
        }
    }

    public function labaPrint(Request $request)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: print_laba_report", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);

        try {
            $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->query('end_date', Carbon::now()->format('Y-m-d'));

            $data = $this->getLabaReportData($startDate, $endDate);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: print_laba_report", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'duration' => $duration
            ]);

            return view('admin.reports.laba_print', $data);
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: print_laba_report", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal memproses cetak laporan laba/keuangan.');
        }
    }

    public function rentalIndex(Request $request)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: generate_rental_report_view", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);

        try {
            $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->query('end_date', Carbon::now()->format('Y-m-d'));

            $data = $this->getRentalReportData($startDate, $endDate);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: generate_rental_report_view", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'duration' => $duration
            ]);

            return view('admin.reports.rental', $data);
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: generate_rental_report_view", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal menghasilkan data laporan penyewaan.');
        }
    }

    public function rentalPrint(Request $request)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: print_rental_report", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);

        try {
            $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->query('end_date', Carbon::now()->format('Y-m-d'));

            $data = $this->getRentalReportData($startDate, $endDate);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: print_rental_report", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'duration' => $duration
            ]);

            return view('admin.reports.rental_print', $data);
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: print_rental_report", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal memproses cetak laporan penyewaan.');
        }
    }
}

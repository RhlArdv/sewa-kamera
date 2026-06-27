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
    private function getReportData($startDate, $endDate)
    {
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Ambil transaksi yang masuk dalam rentang tanggal sewa
        // Mengabaikan status 'cancelled'
        $transactions = Transaction::with(['user', 'bayar', 'details.product'])
            ->whereBetween('tanggal_sewa', [$start, $end])
            ->whereIn('transaksi_status', ['dp_paid', 'completed'])
            ->orderBy('tanggal_sewa', 'asc')
            ->get();

        // Hitung total pendapatan riil (Cash Flow)
        // Jika status dp_paid, pendapatan baru dihitung dari uang_panjar (DP)
        // Jika status completed, pendapatan dihitung dari total_price (Lunas)
        $totalRevenue = 0;
        foreach ($transactions as $trx) {
            if ($trx->transaksi_status === 'completed') {
                $totalRevenue += $trx->total_price;
            } elseif ($trx->transaksi_status === 'dp_paid') {
                $totalRevenue += $trx->uang_panjar;
            }
        }

        $totalTransactions = $transactions->count();

        // Hitung kamera paling terlaris
        $popularProducts = TransactionDetail::select('produk_id', DB::raw('SUM(banyak) as total_rented'))
            ->whereHas('transaction', function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_sewa', [$start, $end])
                      ->whereIn('transaksi_status', ['dp_paid', 'completed']);
            })
            ->with('product')
            ->groupBy('produk_id')
            ->orderBy('total_rented', 'desc')
            ->take(5)
            ->get();

        return [
            'transactions' => $transactions,
            'totalRevenue' => $totalRevenue,
            'totalTransactions' => $totalTransactions,
            'popularProducts' => $popularProducts,
            'startDate' => $start->format('Y-m-d'),
            'endDate' => $end->format('Y-m-d')
        ];
    }

    public function index(Request $request)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: generate_report_view", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);

        try {
            // Default rentang tanggal: Awal bulan ini s/d hari ini
            $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->query('end_date', Carbon::now()->format('Y-m-d'));

            $data = $this->getReportData($startDate, $endDate);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: generate_report_view", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'duration' => $duration
            ]);

            return view('admin.reports.index', $data);
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: generate_report_view", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal menghasilkan data laporan.');
        }
    }

    public function print(Request $request)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: print_report", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'filters' => $request->only(['start_date', 'end_date'])
        ]);

        try {
            $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->query('end_date', Carbon::now()->format('Y-m-d'));

            $data = $this->getReportData($startDate, $endDate);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: print_report", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'duration' => $duration
            ]);

            return view('admin.reports.print', $data);
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: print_report", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal memproses cetak laporan.');
        }
    }
}

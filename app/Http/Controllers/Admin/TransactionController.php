<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Pelunasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: view_transactions_list", [
            'correlationId' => $correlationId,
            'userId' => $userId
        ]);

        try {
            $transactions = Transaction::with(['user', 'bayar'])
                ->orderBy('id_transaction', 'desc')
                ->get();

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: view_transactions_list", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'count' => $transactions->count(),
                'duration' => $duration
            ]);

            return view('admin.transactions.index', compact('transactions'));
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: view_transactions_list", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal mengambil data transaksi.');
        }
    }

    public function show($id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: view_transaction_details", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'transaction_id' => $id
        ]);

        try {
            $transaction = Transaction::with(['user', 'bayar', 'details.product', 'pelunasan'])
                ->findOrFail($id);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: view_transaction_details", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'duration' => $duration
            ]);

            return view('admin.transactions.show', compact('transaction'));
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: view_transaction_details", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(404, 'Transaksi tidak ditemukan.');
        }
    }

    public function updateKtpStatus(Request $request, $id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: update_ktp_status", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'transaction_id' => $id,
            'ktp_status' => $request->input('ktp_status')
        ]);

        try {
            $transaction = Transaction::findOrFail($id);

            $request->validate([
                'ktp_status' => 'required|in:pending,approved,rejected',
            ]);

            $oldStatus = $transaction->ktp_status;
            $transaction->update([
                'ktp_status' => $request->ktp_status
            ]);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: update_ktp_status", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $request->ktp_status,
                'duration' => $duration
            ]);

            return redirect()->back()->with('success', 'Status KTP berhasil diperbarui.');
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: update_ktp_status", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui status KTP: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: update_transaction_status", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'transaction_id' => $id,
            'new_status' => $request->input('transaksi_status')
        ]);

        try {
            $transaction = Transaction::findOrFail($id);

            $request->validate([
                'transaksi_status' => 'required|in:pending,dp_paid,completed,cancelled',
            ]);

            $oldStatus = $transaction->transaksi_status;
            $transaction->update([
                'transaksi_status' => $request->transaksi_status
            ]);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: update_transaction_status", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $request->transaksi_status,
                'duration' => $duration
            ]);

            return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: update_transaction_status", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            return redirect()->back()->withErrors(['error' => 'Gagal memperbarui status transaksi: ' . $e->getMessage()]);
        }
    }

    public function approvePelunasan(Request $request, $id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = auth()->id();
        $startTime = microtime(true);

        Log::info("Operation start: approve_pelunasan", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'transaction_id' => $id
        ]);

        try {
            $pelunasan = Pelunasan::where('transaction_id', $id)->firstOrFail();
            
            $pelunasan->update([
                'status_transaction' => 'Lunas'
            ]);

            // Secara opsional ubah status transaksi utama jika diinginkan, namun biarkan dinamis
            $transaction = Transaction::findOrFail($id);
            if ($transaction->transaksi_status === 'dp_paid') {
                // Jangan otomatis set completed karena kamera mungkin belum dikembalikan ke toko
                // Biarkan admin yang memproses status sewa secara manual menjadi completed
            }

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: approve_pelunasan", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'pelunasan_id' => $pelunasan->id_pelunasan,
                'duration' => $duration
            ]);

            return redirect()->back()->with('success', 'Bukti pelunasan disetujui. Pembayaran telah Lunas.');
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: approve_pelunasan", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            return redirect()->back()->withErrors(['error' => 'Gagal menyetujui pelunasan: ' . $e->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Pelunasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display the authenticated customer's order history.
     */
    public function index()
    {
        $correlationId = Str::uuid()->toString();
        $userId = Auth::id();
        $startTime = microtime(true);

        Log::info("Operation start: view_customer_orders", [
            'correlationId' => $correlationId,
            'userId' => $userId
        ]);

        try {
            $transactions = Transaction::with(['details.product', 'bayar'])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: view_customer_orders", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'count' => $transactions->count(),
                'duration' => $duration
            ]);

            return view('pelanggan.orders', compact('transactions'));
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: view_customer_orders", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            abort(500, 'Gagal memuat riwayat pesanan.');
        }
    }

    /**
     * Cancel a pending transaction.
     */
    public function cancel($id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = Auth::id();
        $startTime = microtime(true);

        Log::info("Operation start: cancel_customer_order", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'transaction_id' => $id
        ]);

        try {
            $transaction = Transaction::where('id_transaction', $id)
                ->where('user_id', $userId)
                ->where('transaksi_status', 'pending')
                ->firstOrFail();

            $transaction->update(['transaksi_status' => 'cancelled']);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: cancel_customer_order", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'duration' => $duration
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Pemesanan berhasil dibatalkan.');
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: cancel_customer_order", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            return redirect()->route('orders.index')
                ->withErrors(['error' => 'Gagal membatalkan pesanan.']);
        }
    }

    /**
     * Simulate a successful payment callback for mock tokens.
     */
    public function mockPay($id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = Auth::id();
        $startTime = microtime(true);

        Log::info("Operation start: mock_pay_customer_order", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'transaction_id' => $id
        ]);

        try {
            $transaction = Transaction::where('id_transaction', $id)
                ->where('user_id', $userId)
                ->where('transaksi_status', 'pending')
                ->firstOrFail();

            $transaction->update([
                'transaksi_status' => 'dp_paid',
            ]);

            Pelunasan::where('transaction_id', $transaction->id_transaction)
                ->where('status_transaction', 'DP')
                ->update(['status_transaction' => 'DP Lunas']);

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: mock_pay_customer_order", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'duration' => $duration
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Pembayaran DP berhasil disimulasikan! Status pesanan kini telah berubah.');
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: mock_pay_customer_order", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            return redirect()->route('orders.index')
                ->withErrors(['error' => 'Gagal memproses simulasi pembayaran.']);
        }
    }

    /**
     * Handle frontend callback when Midtrans Snap payment succeeds.
     */
    public function paymentSuccess($id)
    {
        $correlationId = Str::uuid()->toString();
        $userId = Auth::id();
        $startTime = microtime(true);

        Log::info("Operation start: midtrans_payment_success_callback", [
            'correlationId' => $correlationId,
            'userId' => $userId,
            'transaction_id' => $id
        ]);

        try {
            $transaction = Transaction::where('id_transaction', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            if ($transaction->transaksi_status === 'pending') {
                $transaction->update(['transaksi_status' => 'dp_paid']);

                Pelunasan::where('transaction_id', $transaction->id_transaction)
                    ->where('status_transaction', 'DP')
                    ->update(['status_transaction' => 'DP Lunas']);
            }

            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::info("Operation success: midtrans_payment_success_callback", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'new_status' => $transaction->transaksi_status,
                'duration' => $duration
            ]);

            return redirect()->route('orders.index')
                ->with('success', 'Pembayaran DP lewat Midtrans berhasil divalidasi! Pesanan Anda kini aktif.');
        } catch (\Exception $e) {
            $duration = round((microtime(true) - $startTime) * 1000, 2);
            Log::error("Operation failure: midtrans_payment_success_callback", [
                'correlationId' => $correlationId,
                'userId' => $userId,
                'transaction_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration' => $duration
            ]);
            return redirect()->route('orders.index')
                ->withErrors(['error' => 'Terjadi kesalahan saat memverifikasi pembayaran.']);
        }
    }
}

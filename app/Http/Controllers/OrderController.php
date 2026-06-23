<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display the authenticated customer's order history.
     */
    public function index()
    {
        $transactions = Transaction::with(['details.product', 'bayar'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pelanggan.orders', compact('transactions'));
    }

    /**
     * Cancel a pending transaction.
     */
    public function cancel($id)
    {
        $transaction = Transaction::where('id_transaction', $id)
            ->where('user_id', Auth::id())
            ->where('transaksi_status', 'pending')
            ->firstOrFail();

        $transaction->update(['transaksi_status' => 'cancelled']);

        return redirect()->route('orders.index')
            ->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    /**
     * Simulate a successful payment callback for mock tokens.
     */
    public function mockPay($id)
    {
        $transaction = Transaction::where('id_transaction', $id)
            ->where('user_id', Auth::id())
            ->where('transaksi_status', 'pending')
            ->firstOrFail();

        $transaction->update([
            'transaksi_status' => 'dp_paid',
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Pembayaran DP berhasil disimulasikan! Status pesanan kini telah berubah.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Pelunasan;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;
use Midtrans\Config;

class MidtransWebhookController extends Controller
{
    /**
     * Handle incoming webhooks from Midtrans.
     */
    public function handle(Request $request)
    {
        // Set configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);

        try {
            // Midtrans PHP SDK will automatically extract the JSON payload from the request
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            // If the JSON is invalid or not from Midtrans, it might fail.
            // We can also fallback to reading the request directly for local testing
            $payload = $request->getContent();
            $notif = json_decode($payload);
            
            if (!$notif) {
                return response()->json(['message' => 'Invalid JSON'], 400);
            }
        }

        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status ?? null;

        // Find the transaction by its unique code
        $transaction = Transaction::where('code', $orderId)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        Log::info("Midtrans Notification: Order ID $orderId with Status $transactionStatus");

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                // Ignore challenge for now, or mark as pending
            } else if ($fraudStatus == 'accept') {
                $this->markAsPaid($transaction);
            }
        } else if ($transactionStatus == 'settlement') {
            $this->markAsPaid($transaction);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $transaction->update(['transaksi_status' => 'cancelled']);
        } else if ($transactionStatus == 'pending') {
            $transaction->update(['transaksi_status' => 'pending']);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Helper to mark transaction and DP as paid.
     */
    private function markAsPaid(Transaction $transaction)
    {
        if ($transaction->transaksi_status == 'pending') {
            $transaction->update(['transaksi_status' => 'dp_paid']);
            
            Pelunasan::where('transaction_id', $transaction->id_transaction)
                ->where('status_transaction', 'DP')
                ->update(['status_transaction' => 'DP Lunas']);
        }
    }
}

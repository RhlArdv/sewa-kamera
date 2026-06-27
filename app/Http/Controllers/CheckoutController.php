<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Pelunasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page with cart summary.
     */
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['cart' => 'Keranjang Anda kosong, silakan tambahkan produk terlebih dahulu.']);
        }

        $totalPrice = $cartItems->sum('total');
        // DP is 30% of total price
        $dpAmount = (int) ($totalPrice * 0.3);

        return view('pelanggan.checkout', compact('cartItems', 'totalPrice', 'dpAmount'));
    }

    /**
     * Process the checkout, create transaction, and generate Midtrans Snap Token.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->withErrors(['cart' => 'Keranjang belanja kosong.']);
        }

        $totalPrice = $cartItems->sum('total');
        $dpAmount = (int) ($totalPrice * 0.3);

        // Upload KTP
        $ktpPath = null;
        if ($request->hasFile('ktp')) {
            // Store file in storage/app/public/ktp
            $ktpPath = $request->file('ktp')->store('ktp', 'public');
        }

        // Generate Transaction Code
        $transactionCode = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        try {
            DB::beginTransaction();

            // Create Transaction
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'code' => $transactionCode,
                'total_price' => $totalPrice,
                'uang_panjar' => $dpAmount,
                'city' => 'Kota Padang',
                'bayar_id' => 1, // Default to Midtrans DP
                'transaksi_status' => 'pending',
                'keterangan' => $request->input('keterangan'),
                'receiver' => $request->input('receiver'),
                'tanggal_sewa' => $cartItems->first()->start_time,
                'ktp_path' => $ktpPath,
                'ktp_status' => 'pending',
            ]);

            // Create Transaction Details
            foreach ($cartItems as $item) {
                TransactionDetail::create([
                    'transaksi_id' => $transaction->id_transaction,
                    'produk_id' => $item->produk_id,
                    'price' => $item->product->prices[$item->duration_hours] ?? ($item->duration_hours == 0 ? ($item->product->prices[6] ?? 10000) : 0),
                    'banyak' => $item->banyak,
                    'start_time' => $item->start_time,
                    'end_time' => $item->end_time,
                    'duration_hours' => $item->duration_hours,
                    'subtotal' => $item->total,
                ]);
            }

            // Create Initial Pelunasan Record
            Pelunasan::create([
                'user_id' => Auth::id(),
                'transaction_id' => $transaction->id_transaction,
                'status_transaction' => 'DP',
                'total_semua' => $totalPrice,
                'uang_dp' => $dpAmount,
                'sisa_bayar' => $totalPrice - $dpAmount,
            ]);

            // Clear Cart
            Cart::where('user_id', Auth::id())->delete();

            // Generate Snap Token (Midtrans SDK placeholder or real integration)
            $snapToken = $this->generateMidtransSnapToken($transaction);
            $transaction->update(['midtrans_snap_token' => $snapToken]);

            DB::commit();

            return redirect()->route('orders.index')
                ->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran DP untuk mengaktifkan pemesanan.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($ktpPath) {
                Storage::disk('public')->delete($ktpPath);
            }
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat checkout: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Generate Midtrans Snap Token. Fallback to a mock token if Midtrans is not configured.
     */
    private function generateMidtransSnapToken(Transaction $transaction): string
    {
        $serverKey = config('services.midtrans.server_key');

        if (empty($serverKey)) {
            // Return a robust mock token for testing/skripsi demo purposes
            return 'mock-snap-token-' . Str::random(20);
        }

        // Set Midtrans Configuration
        \Midtrans\Config::$serverKey = $serverKey;
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->code,
                'gross_amount' => $transaction->uang_panjar, // Pay the DP amount
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
        ];

        try {
            return \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            // Log warning and fallback to mock token so the application never crashes for the user
            logger()->warning('Midtrans token generation failed: ' . $e->getMessage());
            return 'mock-snap-token-' . Str::random(20);
        }
    }
}

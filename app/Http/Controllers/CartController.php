<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\RentalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected RentalService $rentalService;

    public function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }

    /**
     * Display the cart index page.
     */
    public function index()
    {
        $cartItems = Cart::with('product.galleries')
            ->where('user_id', Auth::id())
            ->get();

        $totalPrice = $cartItems->sum('total');

        return view('pelanggan.cart', compact('cartItems', 'totalPrice'));
    }

    /**
     * Add a camera to the cart with availability validation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:tb_product,id_produk',
            'banyak' => 'required|integer|min:1',
            'start_time' => 'required|date|after_or_equal:now',
            'package_duration' => 'required|in:0,6,12,24',
        ]);

        $productId = $request->input('produk_id');
        $banyak = $request->input('banyak');
        $startTime = Carbon::parse($request->input('start_time'));
        $durationHours = (int) $request->input('package_duration');
        if ($durationHours === 0) {
            $endTime = $startTime->copy()->addMinutes(5);
        } else {
            $endTime = $startTime->copy()->addHours($durationHours);
        }

        // Validate availability
        $availableUnits = $this->rentalService->getAvailableUnits($productId, $startTime, $endTime);

        if ($availableUnits < $banyak) {
            return redirect()->back()
                ->withErrors(['banyak' => "Kamera tidak tersedia pada tanggal/jam tersebut. Hanya tersisa {$availableUnits} unit."])
                ->withInput();
        }

        $product = Product::findOrFail($productId);
        $packagePrice = $product->prices[$durationHours] ?? ($durationHours === 0 ? ($product->prices[6] ?? 10000) : 0);
        $totalPrice = $packagePrice * $banyak;

        // Add to cart or update if exact item with same timeslot already exists
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('produk_id', $productId)
            ->where('start_time', $startTime)
            ->where('end_time', $endTime)
            ->first();

        if ($existingCart) {
            $newBanyak = $existingCart->banyak + $banyak;
            
            // Check availability again for the cumulative amount
            if ($availableUnits < $newBanyak) {
                return redirect()->back()
                    ->withErrors(['banyak' => "Jumlah sewa melebihi unit yang tersedia. Anda sudah memiliki {$existingCart->banyak} unit di keranjang."])
                    ->withInput();
            }

            $existingCart->update([
                'banyak' => $newBanyak,
                'total' => $packagePrice * $newBanyak,
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $productId,
                'banyak' => $banyak,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'duration_hours' => $durationHours,
                'total' => $totalPrice,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Kamera berhasil ditambahkan ke keranjang belanja.');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy($id)
    {
        $cartItem = Cart::where('id_chart', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}

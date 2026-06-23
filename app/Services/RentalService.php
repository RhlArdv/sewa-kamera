<?php

namespace App\Services;

use App\Models\Product;
use App\Models\TransactionDetail;
use Carbon\Carbon;

class RentalService
{
    /**
     * Get the number of available units for a product in a given time range.
     *
     * @param int $productId
     * @param string|\DateTimeInterface $startTime
     * @param string|\DateTimeInterface $endTime
     * @return int
     */
    public function getAvailableUnits(int $productId, $startTime, $endTime): int
    {
        $product = Product::findOrFail($productId);
        
        $start = Carbon::parse($startTime);
        $end = Carbon::parse($endTime);

        // Find sum of quantity rented that overlaps with requested time slot
        $rentedUnits = TransactionDetail::where('produk_id', $productId)
            ->whereHas('transaction', function ($query) {
                // Only count transactions that are active (pending approval, dp paid, or fully completed)
                // Filter out cancelled transactions
                $query->whereIn('transaksi_status', ['pending', 'dp_paid', 'completed']);
            })
            ->where(function ($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                      ->where('end_time', '>', $start);
            })
            ->sum('banyak');

        return max(0, $product->unit - $rentedUnits);
    }

    /**
     * Check if a product is available in a given time range for a specific quantity.
     *
     * @param int $productId
     * @param string|\DateTimeInterface $startTime
     * @param string|\DateTimeInterface $endTime
     * @param int $quantity
     * @return bool
     */
    public function isAvailable(int $productId, $startTime, $endTime, int $quantity = 1): bool
    {
        $available = $this->getAvailableUnits($productId, $startTime, $endTime);
        return $available >= $quantity;
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Services\RentalService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalServiceTest extends TestCase
{
    use RefreshDatabase;

    private RentalService $rentalService;
    private Product $camera;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rentalService = new RentalService();

        // Setup Category
        $category = Category::create([
            'kategori_name' => 'DSLR',
            'slug' => 'dslr',
        ]);

        // Setup Product with 2 units
        $this->camera = Product::create([
            'produk_name' => 'Canon EOS 3000D',
            'unit' => 2,
            'price' => 15000,
            'description' => 'Canon DSLR',
            'category_id' => $category->id_kategori,
        ]);

        // Setup User
        $this->user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_available_units_returns_full_stock_when_no_rentals(): void
    {
        $startTime = Carbon::now()->addHour();
        $endTime = Carbon::now()->addHours(3);

        $available = $this->rentalService->getAvailableUnits($this->camera->id_produk, $startTime, $endTime);

        $this->assertEquals(2, $available);
        $this->assertTrue($this->rentalService->isAvailable($this->camera->id_produk, $startTime, $endTime, 2));
    }

    public function test_available_units_decreases_when_overlapping_rental_exists(): void
    {
        $startTime = Carbon::parse('2026-06-18 10:00:00');
        $endTime = Carbon::parse('2026-06-18 12:00:00');

        // Create a transaction that rents 1 unit of this camera
        $transaction = Transaction::create([
            'user_id' => $this->user->id,
            'code' => 'TRX-123',
            'total_price' => 30000,
            'uang_panjar' => 10000,
            'city' => 'Jakarta',
            'transaksi_status' => 'dp_paid', // active transaction
            'receiver' => 'John Doe',
            'tanggal_sewa' => '2026-06-18',
        ]);

        TransactionDetail::create([
            'transaksi_id' => $transaction->id_transaction,
            'produk_id' => $this->camera->id_produk,
            'price' => 15000,
            'banyak' => 1,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_hours' => 2,
            'subtotal' => 30000,
        ]);

        // Test check overlapping:
        // 1. Same exact slot: 10:00 - 12:00 -> should return 1 available
        $this->assertEquals(1, $this->rentalService->getAvailableUnits($this->camera->id_produk, '2026-06-18 10:00:00', '2026-06-18 12:00:00'));

        // 2. Overlap start: 09:00 - 11:00 -> should return 1 available
        $this->assertEquals(1, $this->rentalService->getAvailableUnits($this->camera->id_produk, '2026-06-18 09:00:00', '2026-06-18 11:00:00'));

        // 3. Overlap end: 11:00 - 13:00 -> should return 1 available
        $this->assertEquals(1, $this->rentalService->getAvailableUnits($this->camera->id_produk, '2026-06-18 11:00:00', '2026-06-18 13:00:00'));

        // 4. Overlap middle: 10:30 - 11:30 -> should return 1 available
        $this->assertEquals(1, $this->rentalService->getAvailableUnits($this->camera->id_produk, '2026-06-18 10:30:00', '2026-06-18 11:30:00'));

        // 5. No overlap before: 08:00 - 09:59 -> should return 2 available
        $this->assertEquals(2, $this->rentalService->getAvailableUnits($this->camera->id_produk, '2026-06-18 08:00:00', '2026-06-18 09:59:00'));

        // 6. No overlap after: 12:00 - 14:00 -> should return 2 available (since it ends exactly at 12:00)
        $this->assertEquals(2, $this->rentalService->getAvailableUnits($this->camera->id_produk, '2026-06-18 12:00:00', '2026-06-18 14:00:00'));
    }

    public function test_cannot_rent_more_than_available_units(): void
    {
        $startTime = Carbon::parse('2026-06-18 10:00:00');
        $endTime = Carbon::parse('2026-06-18 12:00:00');

        // Create a transaction that rents both units (2 units)
        $transaction = Transaction::create([
            'user_id' => $this->user->id,
            'code' => 'TRX-456',
            'total_price' => 60000,
            'uang_panjar' => 20000,
            'city' => 'Jakarta',
            'transaksi_status' => 'dp_paid',
            'receiver' => 'John Doe',
            'tanggal_sewa' => '2026-06-18',
        ]);

        TransactionDetail::create([
            'transaksi_id' => $transaction->id_transaction,
            'produk_id' => $this->camera->id_produk,
            'price' => 15000,
            'banyak' => 2,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_hours' => 2,
            'subtotal' => 60000,
        ]);

        // Checking availability for same slot -> should return 0 units and isAvailable is false
        $this->assertEquals(0, $this->rentalService->getAvailableUnits($this->camera->id_produk, '2026-06-18 10:00:00', '2026-06-18 12:00:00'));
        $this->assertFalse($this->rentalService->isAvailable($this->camera->id_produk, '2026-06-18 10:00:00', '2026-06-18 12:00:00', 1));
    }
}

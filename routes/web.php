<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Menu\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [HomeController::class, 'show'])->name('product.show');

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/mock-pay', [OrderController::class, 'mockPay'])->name('orders.mock-pay');
});

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;

Route::middleware(['auth', 'role:admin'])->prefix('menu')->name('menu.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories CRUD
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Products CRUD
    Route::resource('products', ProductController::class)->except(['show']);
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('products/gallery/{id}', [ProductController::class, 'destroyPhoto'])->name('products.gallery.destroy');
    Route::delete('products/result/{id}', [ProductController::class, 'destroyResult'])->name('products.result.destroy');

    // Transactions Management
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::post('transactions/{id}/ktp', [TransactionController::class, 'updateKtpStatus'])->name('transactions.ktp');
    Route::post('transactions/{id}/status', [TransactionController::class, 'updateStatus'])->name('transactions.status');
    Route::post('transactions/{id}/pelunasan', [TransactionController::class, 'approvePelunasan'])->name('transactions.pelunasan');

    // Users Management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/{id}/role', [UserController::class, 'updateRole'])->name('users.role');

    // Reports Management
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [ReportController::class, 'print'])->name('reports.print');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('menu.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Invoice print route for both admin and pelanggan
    Route::get('/invoice/{id}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');
});

require __DIR__ . '/auth.php';

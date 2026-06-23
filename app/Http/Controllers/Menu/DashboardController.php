<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        
        $pendingTransactions = Transaction::where('transaksi_status', 'pending')->count();
        $activeRentals = Transaction::where('transaksi_status', 'dp_paid')->count();
        
        // Pendapatan kas masuk riil
        $completedTransactions = Transaction::where('transaksi_status', 'completed')->get();
        $dpTransactions = Transaction::where('transaksi_status', 'dp_paid')->get();
        
        $totalEarnings = $completedTransactions->sum('total_price') + $dpTransactions->sum('uang_panjar');

        return view('menu.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'pendingTransactions',
            'activeRentals',
            'totalEarnings'
        ));
    }
}

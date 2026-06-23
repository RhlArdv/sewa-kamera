<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $transaction = Transaction::with(['details.product', 'user', 'bayar'])
            ->where('id_transaction', $id)
            ->firstOrFail();

        // Check if user is admin or the owner
        if (!auth()->user()->isAdmin() && auth()->id() !== $transaction->user_id) {
            abort(403, 'Anda tidak memiliki akses ke faktur ini.');
        }

        return view('invoice.print', compact('transaction'));
    }
}

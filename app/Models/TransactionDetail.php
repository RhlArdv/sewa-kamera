<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_transaction_detail';
    protected $primaryKey = 'id_transaksi_detail';

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'price',
        'banyak',
        'start_time',
        'end_time',
        'duration_hours',
        'subtotal',
        'code_produk',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaksi_id', 'id_transaction');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id_produk');
    }
}

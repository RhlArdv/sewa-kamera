<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelunasan extends Model
{
    use HasFactory;

    protected $table = 'tb_pelunasan';
    protected $primaryKey = 'id_pelunasan';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'status_transaction',
        'total_semua',
        'uang_dp',
        'sisa_bayar',
        'bukti_pelunasan',
        'midtrans_snap_token_pelunasan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id_transaction');
    }
}

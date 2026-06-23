<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'tb_transaction';
    protected $primaryKey = 'id_transaction';

    protected $fillable = [
        'user_id',
        'code',
        'total_price',
        'uang_panjar',
        'city',
        'bayar_id',
        'transaksi_status',
        'keterangan',
        'receiver',
        'tanggal_sewa',
        'ktp_path',
        'ktp_status',
        'midtrans_snap_token',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sewa' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function bayar(): BelongsTo
    {
        return $this->belongsTo(Bayar::class, 'bayar_id', 'id_bayar');
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'transaksi_id', 'id_transaction');
    }

    public function pelunasan(): HasOne
    {
        return $this->hasOne(Pelunasan::class, 'transaction_id', 'id_transaction');
    }

    public function notifs(): HasMany
    {
        return $this->hasMany(Notif::class, 'transaction_id', 'id_transaction');
    }
}

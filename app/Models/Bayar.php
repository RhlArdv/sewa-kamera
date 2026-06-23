<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bayar extends Model
{
    use HasFactory;

    protected $table = 'tb_bayar';
    protected $primaryKey = 'id_bayar';

    protected $fillable = [
        'jenis_bayar',
        'keterangan',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'bayar_id', 'id_bayar');
    }
}

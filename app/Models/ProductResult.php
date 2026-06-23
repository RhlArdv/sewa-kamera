<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductResult extends Model
{
    use HasFactory;

    protected $table = 'product_results';
    protected $primaryKey = 'id_result';

    protected $fillable = [
        'produk_id',
        'foto',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'produk_id', 'id_produk');
    }
}

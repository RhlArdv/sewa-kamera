<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tb_product';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'produk_name',
        'unit',
        'prices',
        'description',
        'category_id',
    ];

    protected $casts = [
        'prices' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_kategori');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(ProductGallery::class, 'produk_id', 'id_produk');
    }

    public function results(): HasMany
    {
        return $this->hasMany(ProductResult::class, 'produk_id', 'id_produk');
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'produk_id', 'id_produk');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class, 'produk_id', 'id_produk');
    }
}

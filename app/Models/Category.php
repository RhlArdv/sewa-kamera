<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tb_categories';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'kategori_name',
        'slug',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id_kategori');
    }
}

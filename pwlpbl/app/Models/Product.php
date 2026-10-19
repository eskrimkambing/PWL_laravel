<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'nama_produk',
        'category',
        'harga_satuan',
        'portion',
        'deskripsi',
        'image',
    ];

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'product_id', 'id');
    }
}
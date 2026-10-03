<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'price',
        'portion',
        'description',
    ];

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'product_id', 'id');
    }
}
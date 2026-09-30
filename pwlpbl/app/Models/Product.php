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
    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'product_id');
    }
}

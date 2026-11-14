<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'price',
        'portion',
        'deskripsi',
        'image',
    ];

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'product_id', 'id');
    }

    /**
     * Ikut menghitung stok tersisa (jumlah seluruh baris stok produk)
     * dalam satu query, supaya halaman menu tidak query berulang.
     *
     * Pemakaian: Product::withStok()->latest()->get();
     */
    public function scopeWithStok(Builder $query): Builder
    {
        return $query->withSum('stoks as stok_tersisa', 'jumlah_stok');
    }

    /**
     * Stok tersisa produk ($product->stok_tersisa).
     * Memakai hasil withStok() jika ada; jika tidak, dihitung langsung.
     */
    protected function stokTersisa(): Attribute
    {
        return Attribute::get(function ($value, array $attributes) {
            $total = array_key_exists('stok_tersisa', $attributes)
                ? $attributes['stok_tersisa']
                : $this->stoks()->sum('jumlah_stok');

            return max(0, (int) $total);
        });
    }

    /**
     * Produk dianggap Sold Out kalau stok tersisa 0.
     * Status ini tidak disimpan, selalu dihitung dari stok, jadi
     * otomatis kembali tersedia saat admin menambah stok.
     */
    public function isSoldOut(): bool
    {
        return $this->stok_tersisa <= 0;
    }
}

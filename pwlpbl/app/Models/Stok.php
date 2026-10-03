<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stok extends Model
{
    protected $table = 'stoks';

    protected $primaryKey = 'id_stok';

    protected $fillable = [
        'product_id',
        'tanggal_stok',
        'jumlah_stok',
        'status_stok',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
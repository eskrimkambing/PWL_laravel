<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'pembeli_id',
        'total_harga',
        'jenis_pesanan',
        'status',
    ];

    public function pembeli(): BelongsTo
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id', 'id_pembeli');
    }

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id', 'id_pesanan');
    }
}

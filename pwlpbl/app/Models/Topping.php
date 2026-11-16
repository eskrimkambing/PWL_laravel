<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    protected $fillable = ['nama', 'harga', 'sold_out'];

    protected function casts(): array
    {
        return ['sold_out' => 'boolean'];
    }
}

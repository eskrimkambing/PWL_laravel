<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembeli extends Model
{
    protected $table = 'pembeli';
    protected $primaryKey = 'id_pembeli';   // sesuaikan, mis. 'id_pembeli'
    public $timestamps = false;

    protected $fillable = ['email', 'password'];
    protected $hidden = ['password'];
}

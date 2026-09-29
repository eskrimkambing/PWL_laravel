<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';   // sesuaikan, mis. 'id_admin'
    public $timestamps = false;     // ubah ke true kalau tabel punya created_at/updated_at

    protected $fillable = ['email', 'password'];
    protected $hidden = ['password'];
}

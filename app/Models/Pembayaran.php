<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $timestamps = false; // <--- WAJIB ADA: Mematikan timestamps otomatis

    protected $fillable = [
        'total_harga',
        'tipe_pembayaran'
    ];
}
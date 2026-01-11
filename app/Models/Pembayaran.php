<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model {
    protected $table = 'pembayaran';
    protected $fillable = ['total_harga', 'tipe_pembayaran'];
    
    public $timestamps = false; 
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotel';
    protected $primaryKey = 'id_hotel';
    public $timestamps = false; // <--- TAMBAHKAN INI
    // ...
    // Relasi ke Tipe Kamar
    public function tipeKamars()
    {
        return $this->hasMany(TipeKamar::class, 'id_hotel', 'id_hotel');
    }
}
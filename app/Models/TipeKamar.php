<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model
{
    use HasFactory;

    protected $table = 'tipe_kamar';
    protected $primaryKey = 'id_kamar'; // Sesuaikan dengan tripkuy.sql
    public $timestamps = false;
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'id_hotel', 'id_hotel');
    }
}
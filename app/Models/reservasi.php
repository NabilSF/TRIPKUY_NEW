<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';
    public $timestamps = false; // Pastikan tabel punya created_at/updated_at, jika tidak set false

    protected $fillable = [
        'id_user', 'id_kamar', 'id_pembayaran', 'id_pembatalan',
        'tanggal_reservasi', 'tanggal_check_in', 'tanggal_check_out',
        'jumlah_kamar', 'total_malam'
    ];

    // Relasi
    public function user() { return $this->belongsTo(User::class, 'id_user', 'id_user'); }
    public function kamar() { return $this->belongsTo(TipeKamar::class, 'id_kamar', 'id_kamar'); }
    public function pembayaran() { return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id_pembayaran'); }
    public function pembatalan() { return $this->belongsTo(Pembatalan::class, 'id_pembatalan', 'id_pembatalan'); }
}
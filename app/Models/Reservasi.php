<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model {
    protected $table = 'reservasi';
    public $timestamps = false;
    protected $fillable = ['user_id', 'tipe_kamar_id', 'pembayaran_id', 'pembatalan_id', 'tanggal_reservasi', 'tanggal_check_in', 'tanggal_check_out', 'jumlah_kamar', 'total_malam', 'status'];

    public function user() { return $this->belongsTo(User::class); }
    public function pembayaran() { return $this->belongsTo(Pembayaran::class); }
    
    // Gunakan nama ini secara konsisten di Controller dan Blade
    public function tipeKamar() { 
        return $this->belongsTo(TipeKamar::class, 'tipe_kamar_id'); 
    }
}
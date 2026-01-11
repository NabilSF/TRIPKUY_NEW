<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model {
    protected $table = 'tipe_kamar';
    protected $fillable = ['hotel_id', 'nama_kamar', 'deskripsi', 'kapasitas_orang', 'total_kamar', 'harga'];

    public function hotel() {
        return $this->belongsTo(Hotel::class);
    }
}
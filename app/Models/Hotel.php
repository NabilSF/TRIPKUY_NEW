<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table = 'hotel';

    protected $fillable = ['nama_hotel', 'email', 'alamat', 'kontak', 'deskripsi'];

    public function tipeKamars()
    {
        return $this->hasMany(TipeKamar::class);
    }
}

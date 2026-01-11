<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model {
    protected $table = 'tipe_kamar';
    public function hotel() { return $this->belongsTo(Hotel::class); }
}
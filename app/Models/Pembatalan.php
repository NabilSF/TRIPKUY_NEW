<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembatalan extends Model
{
    use HasFactory;

    protected $table = 'pembatalan';
    protected $primaryKey = 'id_pembatalan';

    protected $fillable = [
        'alasan',
        'tanggal_pengajuan',
        'catatan_admin',
        'tanggal_refund'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Nama Tabel
    protected $table = 'users';

    // 2. Primary Key
    protected $primaryKey = 'id_user';

    // 3. MATIKAN TIMESTAMPS (Tambahkan baris ini agar error hilang)
    public $timestamps = false;

    // 4. Kolom yang bisa diisi
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];
    public function reservasis()
    {
        // Relasi: Satu User punya banyak Reservasi
        return $this->hasMany(Reservasi::class, 'id_user', 'id_user');
    }
}
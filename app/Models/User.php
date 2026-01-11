<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama', 'email', 'password', 'role', 'no_telepon',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class);
    }
}
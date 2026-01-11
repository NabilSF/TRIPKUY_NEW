<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib ada untuk cek login

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah user sudah login?
        // 2. Cek apakah role-nya 'admin'?
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, kembalikan ke halaman utama (Home)
        return redirect('/'); 
    }
}
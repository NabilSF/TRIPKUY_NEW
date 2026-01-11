<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan Form Login
    public function showLoginForm() {
        return view('auth.login');
    }

    // PROSES LOGIN (LOGIKA REDIRECT ADMIN/USER ADA DI SINI)
    public function login(Request $request) {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek apakah email & password cocok
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // 3. CEK ROLE USER
            $role = Auth::user()->role; // Ambil kolom 'role' dari database

            if ($role === 'admin') {
                // Jika Admin -> Ke Dashboard Admin
                return redirect()->route('admin.dashboard');
            } else {
                // Jika User Biasa -> Ke Halaman Home
                return redirect()->route('home');
            }
        }

        // 4. Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Menampilkan Form Register
    public function showRegisterForm() {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request) {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', // Pastikan ada name="password_confirmation" di form
            'no_telepon' => 'required',
        ]);

        User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user', // Default role user biasa
            'no_telepon' => $validated['no_telepon'],
        ]);

        // Opsional: Langsung login setelah daftar
        // Auth::login($user); 

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
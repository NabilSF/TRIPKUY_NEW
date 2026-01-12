<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| AREA UMUM (Guest)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/hotel/{id}', [HomeController::class, 'detail'])->name('detail');

// --- AUTH ROUTES ---
// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| AREA USER (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Profil & Checkin
    Route::get('/profil', [HomeController::class, 'profile'])->name('user.profile');
    Route::get('/checkin-online/{id}', [HomeController::class, 'checkinOnline'])->name('user.checkin');
    Route::put('/profil/update', [HomeController::class, 'updateProfile'])->name('user.profile.update');
    // Reservasi
    Route::get('/reservasi-saya', [HomeController::class, 'reservasi'])->name('user.reservasi');
    Route::post('/reservasi-saya', [HomeController::class, 'storeReservasi'])->name('user.reservasi.store');
    Route::post('/reservasi/{id}/cancel', [HomeController::class, 'cancelReservasi'])->name('user.reservasi.cancel');
    // --- PEMBAYARAN (SANDBOX) ---
    // Pastikan 2 baris ini ada di SINI (di dalam middleware auth, tapi DI LUAR admin)
    Route::get('/pembayaran/{id}', [HomeController::class, 'showPayment'])->name('user.pembayaran');
    Route::post('/pembayaran/{id}/process', [HomeController::class, 'processPayment'])->name('user.pembayaran.process');
    Route::get('/pembayaran/success', [HomeController::class, 'paymentSuccess'])->name('user.pembayaran.success');
    Route::get('/pembayaran/cancel', [HomeController::class, 'paymentCancel'])->name('user.pembayaran.cancel');
    
});


/*
|--------------------------------------------------------------------------
| AREA ADMIN (Harus Login & Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Data Hotel (CRUD)
    Route::get('/data-hotel', [AdminController::class, 'dataHotel'])->name('datahotel');
    Route::put('/data-hotel/{id}', [AdminController::class, 'updateDataHotel'])->name('datahotel.update');
    
    // Manajemen Kamar (Update Harga)
    Route::get('/manage-kamar', [AdminController::class, 'manageKamar'])->name('managekamar');
    Route::put('/manage-kamar/{id}', [AdminController::class, 'updateKamar'])->name('managekamar.update');
    
    // Reservasi (Cancel)
    Route::get('/reservasi', [AdminController::class, 'reservasi'])->name('reservasi');
    Route::post('/reservasi/{id}/cancel', [AdminController::class, 'cancelReservasi'])->name('reservasi.cancel');
    
    // Pelanggan & Lainnya
    Route::get('/checkin-out', [AdminController::class, 'checkinOut'])->name('checkinout');
    Route::get('/pelanggan', [AdminController::class, 'pelanggan'])->name('pelanggan');
    Route::get('/harga', [AdminController::class, 'harga'])->name('harga');
    // Action Routes
    Route::post('/checkin/{id}', [AdminController::class, 'processCheckin'])->name('checkin.process');
    Route::post('/checkout/{id}', [AdminController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/pelanggan', [AdminController::class, 'pelanggan'])->name('pelanggan');
    
    Route::delete('/pelanggan/{id}', [AdminController::class, 'deletePelanggan'])->name('pelanggan.delete');

    Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
});

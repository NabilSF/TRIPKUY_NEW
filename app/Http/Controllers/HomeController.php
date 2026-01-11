<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\TipeKamar;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        $hotels = Hotel::with('tipeKamars')->get();
        return view('home', compact('hotels'));
    }

    public function blog() {
        $articles = [
            ['title' => '7 Hidden Gem di Bali', 'slug' => 'hidden-gem-bali', 'category' => 'Destinasi', 'author' => 'Admin', 'date' => '10 Jan 2026', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80', 'excerpt' => 'Bosan dengan pantai yang itu-itu saja? Simak daftar tempat tersembunyi di Bali.'],
            ['title' => 'Tips Staycation Hemat', 'slug' => 'tips-staycation', 'category' => 'Tips', 'author' => 'Sarah', 'date' => '08 Jan 2026', 'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80', 'excerpt' => 'Mau menikmati kemewahan tanpa bikin kantong bolong? Cek strateginya.'],
        ];
        return view('user.blog', compact('articles'));
    }

    public function detail($id) {
        $hotel = Hotel::with('tipeKamars')->findOrFail($id);
        return view('detail', compact('hotel'));
    }

    public function reservasi(Request $request) {
        if ($request->has(['hotel_id', 'room_id'])) {
            $kamar = TipeKamar::with('hotel')->findOrFail($request->room_id);
            return view('user.reservasi_form', compact('kamar'));
        }
        $reservasis = Reservasi::with(['tipeKamar.hotel', 'pembayaran'])->where('user_id', Auth::id())->orderBy('tanggal_reservasi', 'desc')->get();
        return view('user.reservasi', compact('reservasis'));
    }

    public function storeReservasi(Request $request) {
        // VALIDASI TANGGAL & INPUT
        $request->validate([
            'id_kamar' => 'required|exists:tipe_kamar,id',
            'check_in' => 'required|date|after_or_equal:today', // Minimal hari ini
            'check_out' => 'required|date|after:check_in',      // Harus setelah check-in
            'jumlah_kamar' => 'required|integer|min:1',
        ], [
            'check_in.after_or_equal' => 'Tanggal check-in tidak boleh di masa lalu.',
            'check_out.after' => 'Tanggal check-out harus setelah tanggal check-in.'
        ]);

        $kamar = TipeKamar::findOrFail($request->id_kamar);
        
        // Hitung Selisih Malam
        $checkIn = \Carbon\Carbon::parse($request->check_in);
        $checkOut = \Carbon\Carbon::parse($request->check_out);
        $totalMalam = $checkIn->diffInDays($checkOut);
        
        // Pastikan minimal 1 malam
        if($totalMalam < 1) $totalMalam = 1;

        $totalHarga = $kamar->harga * $request->jumlah_kamar * $totalMalam;

        // Simpan Pembayaran
        $pembayaran = Pembayaran::create([
            'total_harga' => $totalHarga,
            'tipe_pembayaran' => 'transfer_virtual_account'
        ]);

        // Simpan Reservasi
        $reservasi = Reservasi::create([
            'user_id' => Auth::id(),
            'tipe_kamar_id' => $kamar->id,
            'pembayaran_id' => $pembayaran->id,
            'tanggal_reservasi' => now(),
            'tanggal_check_in' => $request->check_in,
            'tanggal_check_out' => $request->check_out,
            'jumlah_kamar' => $request->jumlah_kamar,
            'total_malam' => $totalMalam,
            'status' => 'pending'
        ]);

        return redirect()->route('user.pembayaran', $reservasi->id);
    }
    public function showPayment($id) {
        $reservasi = Reservasi::with(['tipeKamar.hotel', 'pembayaran'])->where('user_id', Auth::id())->findOrFail($id);
        return view('pembayaran', compact('reservasi'));
    }

    public function processPayment($id) {
        Reservasi::where('user_id', Auth::id())->findOrFail($id)->update(['status' => 'confirmed']);
        return redirect()->route('user.reservasi')->with('success', 'Pembayaran Berhasil!');
    }

    public function profile() {
        return view('user.profile');
    }

    public function updateProfile(Request $request) {
        $user = User::findOrFail(Auth::id());
        $user->update($request->all());
        return redirect()->back()->with('success', 'Profil diperbarui!');
    }

    public function checkinOnline() {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');
        
        $readyToCheckin = Reservasi::with(['tipeKamar.hotel'])
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->get();
            
        $activeStays = Reservasi::with(['tipeKamar.hotel'])
            ->where('user_id', $userId)
            ->where('status', 'checked_in')
            ->get();

        return view('user.checkin', compact('readyToCheckin', 'activeStays'));
    }
    
    public function cancelReservasi($id) {
        $reservasi = Reservasi::where('user_id', Auth::id())->findOrFail($id);
        $reservasi->update(['status' => 'canceled']);
        return redirect()->back()->with('success', 'Reservasi dibatalkan.');
    }
}
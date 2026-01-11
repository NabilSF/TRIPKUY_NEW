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

    public function detail($id) {
        $hotel = Hotel::with(['tipeKamars'])->findOrFail($id);
        return view('detail', compact('hotel'));
    }

    public function reservasi(Request $request) {
        if ($request->has(['hotel_id', 'room_id'])) {
            $kamar = TipeKamar::with('hotel')->findOrFail($request->room_id);
            return view('user.reservasi_form', compact('kamar'));
        }

        // Lihat Riwayat (Menggunakan user_id standar)
        $reservasis = Reservasi::with(['tipeKamar.hotel', 'pembayaran'])
                        ->where('user_id', Auth::id())
                        ->orderBy('tanggal_reservasi', 'desc')
                        ->get();
        return view('user.reservasi', compact('reservasis'));
    }

    public function storeReservasi(Request $request) {
        $request->validate([
            'id_kamar' => 'required|exists:tipe_kamar,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'jumlah_kamar' => 'required|integer|min:1',
        ]);

        $kamar = TipeKamar::findOrFail($request->id_kamar);
        $totalMalam = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
        $totalHarga = $kamar->harga * $request->jumlah_kamar * $totalMalam;

        // Simpan Pembayaran
        $pembayaran = Pembayaran::create([
            'total_harga' => $totalHarga,
            'tipe_pembayaran' => 'transfer_virtual_account'
        ]);

        // Simpan Reservasi (Menggunakan foreign key standar)
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

    public function updateProfile(Request $request) {
        $user = User::findOrFail(Auth::id());
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string|max:15',
        ]);

        $user->update($request->all());
        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function checkinOnline() {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');
        
        $readyToCheckin = Reservasi::with(['tipeKamar.hotel'])
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->whereDate('tanggal_check_in', '<=', $today)
            ->get();

        return view('user.checkin', compact('readyToCheckin'));
    }
}
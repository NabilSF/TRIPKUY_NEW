<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Hotel, TipeKamar, Reservasi, Pembayaran, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {
    public function index() {
        $hotels = Hotel::with('tipeKamars')->get();
        return view('home', compact('hotels'));
    }

    public function detail($id) {
        $hotel = Hotel::with('tipeKamars')->findOrFail($id);
        return view('detail', compact('hotel'));
    }

    public function storeReservasi(Request $request) {
        $kamar = TipeKamar::findOrFail($request->id_kamar);
        $totalMalam = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
        
        $pembayaran = Pembayaran::create([
            'total_harga' => $kamar->harga * $request->jumlah_kamar * $totalMalam,
            'tipe_pembayaran' => 'transfer_virtual_account'
        ]);

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
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hotel;
use App\Models\Reservasi;
use App\Models\TipeKamar;
use App\Models\Pembayaran;
use App\Models\Pembatalan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index() {
        $total_reservasi = Reservasi::count();
        $pendapatan = Pembayaran::sum('total_harga');
        
        $pembatalan = Pembatalan::whereNull('tanggal_refund')->count();

        // Data Grafik: Pendapatan (Sudah disesuaikan ke kolom pembayaran_id dan id)
        $chartData = Reservasi::join('pembayaran', 'reservasi.pembayaran_id', '=', 'pembayaran.id')
            ->select(
                DB::raw('sum(pembayaran.total_harga) as sums'), 
                DB::raw("DATE_FORMAT(reservasi.tanggal_reservasi, '%M') as months")
            )
            ->groupBy('months')
            ->orderBy('reservasi.tanggal_reservasi', 'ASC')
            ->limit(6)
            ->pluck('sums', 'months');

        return view('admin.dashboard', compact('total_reservasi', 'pendapatan', 'pembatalan', 'chartData'));
    }

    public function dataHotel() {
        $hotels = Hotel::all(); 
        return view('admin.datahotel', compact('hotels'));
    }

    public function updateDataHotel(Request $request, $id) {
        $hotel = Hotel::findOrFail($id);
        $request->validate([
            'nama_hotel' => 'required|string',
            'alamat' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $hotel->update($request->except('gambar'));
        
        if ($request->hasFile('gambar')) {
            if ($hotel->gambar) Storage::delete('public/' . $hotel->gambar);
            $hotel->gambar = $request->file('gambar')->store('hotel_images', 'public');
            $hotel->save();
        }
        return back()->with('success', 'Data hotel berhasil diperbarui');
    }

    public function manageKamar() {
        $kamars = TipeKamar::with('hotel')->get();
        return view('admin.managekamar', compact('kamars'));
    }

    public function updateKamar(Request $request, $id) {
        $kamar = TipeKamar::findOrFail($id);
        $kamar->harga = str_replace('.', '', $request->harga);
        $kamar->save();
        return back()->with('success', 'Harga kamar berhasil diperbarui');
    }

    public function reservasi() {
        $reservasis = Reservasi::with(['user', 'tipeKamar'])
                        ->orderBy('tanggal_reservasi', 'desc') 
                        ->get();
        return view('admin.reservasi', compact('reservasis'));
    }

    public function processCheckin($id) {
        Reservasi::findOrFail($id)->update(['status' => 'checked_in']);
        return redirect()->back()->with('success', 'Tamu berhasil Check-in.');
    }

    public function processCheckout($id) {
        Reservasi::findOrFail($id)->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Tamu berhasil Check-out.');
    }
}
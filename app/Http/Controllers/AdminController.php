<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{User, Hotel, Reservasi, TipeKamar, Pembayaran, Pembatalan};
use Illuminate\Support\Facades\{Storage, DB};

class AdminController extends Controller {
    public function index() {
        $total_reservasi = Reservasi::count();
        $pendapatan = Pembayaran::sum('total_harga');
        $pembatalan = Pembatalan::whereNull('tanggal_refund')->count();

        $chartData = Reservasi::join('pembayaran', 'reservasi.pembayaran_id', '=', 'pembayaran.id')
            ->select(DB::raw('sum(pembayaran.total_harga) as sums'), DB::raw("DATE_FORMAT(reservasi.tanggal_reservasi, '%M') as months"))
            ->groupBy('months')->orderBy('reservasi.tanggal_reservasi', 'ASC')->limit(6)->pluck('sums', 'months');

        return view('admin.dashboard', compact('total_reservasi', 'pendapatan', 'pembatalan', 'chartData'));
    }

    public function dataHotel() {
        $hotels = Hotel::all();
        return view('admin.datahotel', compact('hotels'));
    }

    public function updateDataHotel(Request $request, $id) {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->except('gambar'));
        if ($request->hasFile('gambar')) {
            if ($hotel->gambar) Storage::delete('public/' . $hotel->gambar);
            $hotel->gambar = $request->file('gambar')->store('hotel_images', 'public');
            $hotel->save();
        }
        return back()->with('success', 'Data hotel diperbarui');
    }

    public function reservasi() {
        $reservasis = Reservasi::with(['user', 'tipeKamar'])->orderBy('tanggal_reservasi', 'desc')->get();
        return view('admin.reservasi', compact('reservasis'));
    }
}
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
    // 1. Dashboard Admin + Grafik Data
  // 1. Dashboard Admin + Grafik Data
    public function index() {
        $total_reservasi = Reservasi::count();
        $pendapatan = Pembayaran::sum('total_harga');
        
        // Cek jika tabel pembatalan ada
        $pembatalan = 0;
        try {
            $pembatalan = \App\Models\Pembatalan::whereNull('tanggal_refund')->count();
        } catch (\Exception $e) { /* Ignore if table not exists */ }

        // PERBAIKAN GRAFIK: Menggunakan 'tanggal_reservasi' (bukan created_at)
        // Data Grafik: Pendapatan 6 Bulan Terakhir
        $chartData = Reservasi::join('pembayaran', 'reservasi.id_pembayaran', '=', 'pembayaran.id_pembayaran')
            ->select(
                \Illuminate\Support\Facades\DB::raw('sum(pembayaran.total_harga) as sums'), 
                \Illuminate\Support\Facades\DB::raw("DATE_FORMAT(reservasi.tanggal_reservasi, '%M') as months")
            )
            ->groupBy('months')
            ->orderBy('reservasi.tanggal_reservasi', 'ASC')
            ->limit(6)
            ->pluck('sums', 'months');

        return view('admin.dashboard', compact('total_reservasi', 'pendapatan', 'pembatalan', 'chartData'));
    }
    // 2. Data Hotel (LIST VIEW)
    public function dataHotel() {
        // Ambil SEMUA data hotel dari database
        $hotels = \App\Models\Hotel::all(); 
        
        return view('admin.datahotel', compact('hotels'));
    }

    public function updateDataHotel(Request $request, $id) {
        $hotel = Hotel::findOrFail($id);
        
        $request->validate([
            'nama_hotel' => 'required|string',
            'kota' => 'required|string',
            'alamat' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $hotel->nama_hotel = $request->nama_hotel;
        $hotel->kota = $request->kota;
        $hotel->alamat = $request->alamat;
        
        if ($request->hasFile('gambar')) {
            if ($hotel->gambar && Storage::exists('public/' . $hotel->gambar)) {
                Storage::delete('public/' . $hotel->gambar);
            }
            $hotel->gambar = $request->file('gambar')->store('hotel_images', 'public');
        }

        $hotel->save();
        return back()->with('success', 'Data hotel berhasil diperbarui');
    }

    // 3. Manajemen Kamar (Edit Harga)
    public function manageKamar() {
        $kamars = TipeKamar::with('hotel')->get();
        return view('admin.managekamar', compact('kamars'));
    }

    public function updateKamar(Request $request, $id) {
        $kamar = TipeKamar::findOrFail($id);
        $kamar->harga = str_replace('.', '', $request->harga); // Hapus format ribuan jika ada
        $kamar->save();
        
        return back()->with('success', 'Harga kamar berhasil diperbarui dan tampil di halaman user.');
    }

    // 4. Reservasi (Batalkan Sepihak)
    public function reservasi() {
        // PERBAIKAN: Ganti latest() dengan orderBy('tanggal_reservasi', 'desc')
        $reservasis = Reservasi::with(['user', 'kamar'])
                        ->orderBy('tanggal_reservasi', 'desc') 
                        ->get();
                        
        return view('admin.reservasi', compact('reservasis'));
    }

    public function cancelReservasi($id) {
        $reservasi = Reservasi::findOrFail($id);
        
        // Logika Batalkan
        $reservasi->status = 'batal'; // Pastikan kolom status ada di tabel reservasi
        $reservasi->save();

        return back()->with('success', 'Reservasi berhasil dibatalkan secara sepihak.');
    }

    // 5. Pelanggan (Hanya yang pernah menyewa)
    public function pelanggan() {
        // Ambil user dengan role 'user', hitung jumlah reservasinya
        $users = \App\Models\User::where('role', 'user')
                    ->withCount('reservasis') // Menghitung jumlah booking otomatis
                    ->orderBy('nama', 'asc')
                    ->get();

        return view('admin.pelanggan', compact('users'));
    }

    public function deletePelanggan($id) {
        $user = \App\Models\User::findOrFail($id);

        return redirect()->back()->with('success', 'Data pelanggan berhasil dihapus.');
    }

    public function checkinOut() {
        $today = now()->format('Y-m-d');


        $todayCheckins = \App\Models\Reservasi::with(['user', 'kamar.hotel'])
                            ->where('status', 'confirmed')
                            ->whereDate('tanggal_check_in', '<=', $today) 
                            ->orderBy('tanggal_check_in', 'asc')
                            ->get();

        $todayCheckouts = \App\Models\Reservasi::with(['user', 'kamar.hotel'])
                            ->where('status', 'checked_in')
                            ->orderBy('tanggal_check_out', 'asc')
                            ->get();

        return view('admin.checkinout', compact('todayCheckins', 'todayCheckouts'));
    }

    // Proses Admin Melakukan Check-in Tamu
    public function processCheckin($id) {
        $reservasi = \App\Models\Reservasi::findOrFail($id);
        $reservasi->status = 'checked_in';
        $reservasi->save();

        return redirect()->back()->with('success', 'Tamu berhasil Check-in.');
    }

    // Proses Admin Melakukan Check-out Tamu
    public function processCheckout($id) {
        $reservasi = \App\Models\Reservasi::findOrFail($id);
        $reservasi->status = 'completed';
        $reservasi->save();

        return redirect()->back()->with('success', 'Tamu berhasil Check-out. Pesanan Selesai.');
    }


    public function harga() {
        return view('admin.harga');
    }
}
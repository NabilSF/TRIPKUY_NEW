<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\TipeKamar;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // 1. Halaman Home
    public function index()
    {
        // Ambil semua data hotel
        $hotels = Hotel::with('tipeKamars')->get();
        return view('home', compact('hotels'));
    }

    // 2. Halaman Blog (Opsional/Dummy)
   public function blog()
    {
        // Data Dummy Artikel (Simulasi Database)
        $articles = [
            [
                'id' => 1,
                'title' => '7 Hidden Gem di Bali yang Belum Banyak Orang Tahu',
                'slug' => 'hidden-gem-bali',
                'category' => 'Destinasi',
                'author' => 'Rizky Travel',
                'date' => '10 Jan 2026',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Bosan dengan pantai yang itu-itu saja? Simak daftar tempat tersembunyi di Bali yang menawarkan ketenangan dan pemandangan eksotis.'
            ],
            [
                'id' => 2,
                'title' => 'Tips Staycation Hemat di Hotel Bintang 5',
                'slug' => 'tips-staycation-hemat',
                'category' => 'Tips & Trik',
                'author' => 'Sarah Wijaya',
                'date' => '08 Jan 2026',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Mau menikmati kemewahan tanpa bikin kantong bolong? Cek strategi berburu promo dan waktu terbaik booking hotel mewah.'
            ],
            [
                'id' => 3,
                'title' => 'Kuliner Wajib Coba Saat Berkunjung ke Yogyakarta',
                'slug' => 'kuliner-jogja',
                'category' => 'Kuliner',
                'author' => 'Budi Santoso',
                'date' => '05 Jan 2026',
                'image' => 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Gudeg memang ikonik, tapi Jogja punya segudang kuliner lain mulai dari Sate Klathak hingga Kopi Joss yang legendaris.'
            ],
            [
                'id' => 4,
                'title' => 'Solo Safari: Wajah Baru Wisata Keluarga di Surakarta',
                'slug' => 'solo-safari',
                'category' => 'Wisata Keluarga',
                'author' => 'Admin TripKuy',
                'date' => '02 Jan 2026',
                'image' => 'https://images.unsplash.com/photo-1534567176735-8424074f663d?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Mengintip keseruan berinteraksi dengan satwa di Solo Safari. Destinasi edukasi yang cocok untuk liburan akhir pekan bersama anak.'
            ],
            [
                'id' => 5,
                'title' => 'Trend Hotel Kapsul: Solusi Menginap Murah & Nyaman',
                'slug' => 'trend-hotel-kapsul',
                'category' => 'Trend Hotel',
                'author' => 'Dimas Backpacker',
                'date' => '28 Dec 2025',
                'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Kenapa hotel kapsul makin digemari traveler milenial? Simak kelebihan dan rekomendasi hotel kapsul terbaik di Jakarta.'
            ],
            [
                'id' => 6,
                'title' => 'Persiapan Penting Sebelum Roadtrip Keliling Jawa',
                'slug' => 'persiapan-roadtrip',
                'category' => 'Tips Perjalanan',
                'author' => 'Rizky Travel',
                'date' => '25 Dec 2025',
                'image' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=80',
                'excerpt' => 'Cek kondisi kendaraan, rute tol trans jawa, dan daftar rest area terbaik agar perjalanan daratmu aman dan menyenangkan.'
            ],
        ];

        return view('user.blog', compact('articles'));
    }

    // 3. Halaman Detail Hotel
    public function detail($id)
    {

        $hotel = Hotel::with(['tipeKamars'])->findOrFail($id);
        
        return view('detail', compact('hotel'));
    }

    // 4. Halaman Reservasi (Handle Form Booking & List Riwayat)
    public function reservasi(Request $request)
    {
        // KONDISI A: User mau booking (Klik dari detail hotel)
        if ($request->has(['hotel_id', 'room_id'])) {
            $kamar = TipeKamar::with('hotel')->find($request->room_id);
            
            if (!$kamar) {
                return redirect()->route('home')->with('error', 'Kamar tidak ditemukan.');
            }

            return view('user.reservasi_form', compact('kamar'));
        }

        // KONDISI B: User mau lihat riwayat (Klik menu navbar)
        $reservasis = Reservasi::with(['kamar.hotel', 'pembayaran'])
                        ->where('id_user', Auth::id())
                        ->orderBy('tanggal_reservasi', 'desc')
                        ->get();

        return view('user.reservasi', compact('reservasis'));
    }

    // 5. Proses Simpan Reservasi (Langkah 1: Menuju Pembayaran)
    public function storeReservasi(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:tipe_kamar,id_kamar',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'jumlah_kamar' => 'required|integer|min:1',
        ]);

        $kamar = TipeKamar::findOrFail($request->id_kamar);
        
        // Hitung Total Malam
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $totalMalam = $checkIn->diffInDays($checkOut);
        
        // Hitung Total Harga
        $totalHarga = $kamar->harga * $request->jumlah_kamar * $totalMalam;

        // Buat Data Pembayaran Dulu (Status Awal)
        $pembayaran = new Pembayaran();
        $pembayaran->total_harga = $totalHarga;
        $pembayaran->tipe_pembayaran = 'transfer_virtual_account'; // Default
        $pembayaran->save();

        // Buat Data Reservasi
        $reservasi = new Reservasi();
        $reservasi->id_user = Auth::id();
        $reservasi->id_kamar = $kamar->id_kamar;
        $reservasi->id_pembayaran = $pembayaran->id_pembayaran;
        $reservasi->tanggal_reservasi = now();
        $reservasi->tanggal_check_in = $request->check_in;
        $reservasi->tanggal_check_out = $request->check_out;
        $reservasi->jumlah_kamar = $request->jumlah_kamar;
        $reservasi->total_malam = $totalMalam;
        $reservasi->status = 'pending'; // Status awal pending
        $reservasi->save();

        // Redirect ke Halaman Pembayaran Sandbox
        return redirect()->route('user.pembayaran', $reservasi->id_reservasi);
    }

    // 6. Tampilkan Halaman Pembayaran Sandbox
    public function showPayment($id)
    {
        $reservasi = Reservasi::with(['kamar.hotel', 'pembayaran'])
                        ->where('id_user', Auth::id())
                        ->findOrFail($id);

        // Jika sudah lunas, jangan boleh bayar lagi
        if ($reservasi->status == 'confirmed') {
            return redirect()->route('user.reservasi')->with('info', 'Pesanan ini sudah dibayar.');
        }

        return view('pembayaran', compact('reservasi'));
    }

    // 7. Proses Pembayaran (Simulasi Sukses)
    public function processPayment($id)
    {
        $reservasi = Reservasi::where('id_user', Auth::id())->findOrFail($id);
        
        // Update Status jadi Confirmed
        $reservasi->status = 'confirmed';
        $reservasi->save();

        return redirect()->route('user.reservasi')->with('success', 'Pembayaran Berhasil! Selamat berlibur.');
    }

    // 8. User Profile
    public function profile()
    {
        return view('user.profile'); // Pastikan view ini ada atau ganti redirect
    }
    public function updateProfile(Request $request)
    {
        $user = \App\Models\User::find(Auth::id());

        // Validasi Input
        $request->validate([
            'nama'       => 'required|string|max:255',
            // Validasi email unik kecuali milik user sendiri
            'email'      => 'required|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
            'no_telepon' => 'nullable|string|max:15',
        ]);

        // Simpan Perubahan
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telepon = $request->no_telepon;
        
        // Simpan ke database
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // 9. Checkin Online
   public function checkinOnline()
    {
        $userId = Auth::id();
        $today = now()->format('Y-m-d');

        // Cari yang SIAP CHECK-IN (Status Confirmed & Tanggal Check-in <= Hari ini)
        $readyToCheckin = Reservasi::with(['kamar.hotel'])
            ->where('id_user', $userId)
            ->where('status', 'confirmed')
            ->whereDate('tanggal_check_in', '<=', $today) // Boleh checkin hari H atau telat dikit
            ->whereDate('tanggal_check_out', '>', $today) // Belum lewat tanggal pulang
            ->get();

        // Cari yang SEDANG MENGINAP (Status Checked_in)
        $activeStays = Reservasi::with(['kamar.hotel'])
            ->where('id_user', $userId)
            ->where('status', 'checked_in')
            ->get();

        return view('user.checkin', compact('readyToCheckin', 'activeStays'));
    }

    // 12. Proses Check-in
    public function processCheckin($id)
    {
        $reservasi = Reservasi::where('id_user', Auth::id())->findOrFail($id);
        
        // Update status
        $reservasi->status = 'checked_in';
        $reservasi->save();

        return redirect()->back()->with('success', 'Check-in Berhasil! Selamat datang di hotel kami.');
    }

    // 13. Proses Check-out
    public function processCheckout($id)
    {
        $reservasi = Reservasi::where('id_user', Auth::id())->findOrFail($id);
        
        // Update status
        $reservasi->status = 'completed';
        $reservasi->save();

        return redirect()->back()->with('success', 'Check-out Berhasil! Terima kasih telah menginap.');
    }
   public function cancelReservasi($id)
    {
        // 1. Cari reservasi milik user
        $reservasi = Reservasi::where('id_user', Auth::id())
                        ->whereIn('status', ['pending', 'confirmed']) // Hanya yang belum selesai/batal
                        ->findOrFail($id);

        // 2. Cek Aturan H-2
        $tanggalCheckIn = Carbon::parse($reservasi->tanggal_check_in)->startOfDay();
        $hariIni = now()->startOfDay();
        
        // Hitung selisih hari (CheckIn - HariIni)
        $selisihHari = $hariIni->diffInDays($tanggalCheckIn, false); // false agar nilai minus jika lewat

        // Jika kurang dari 2 hari (misal H-1 atau Hari H), tolak
        if ($selisihHari < 2) {
            return redirect()->back()->with('error', 'Pembatalan gagal. Pembatalan hanya bisa dilakukan maksimal H-2 sebelum check-in.');
        }

        // 3. Proses Pembatalan
        $reservasi->status = 'canceled';
        $reservasi->save();

        return redirect()->back()->with('success', 'Reservasi berhasil dibatalkan.');
    }
}
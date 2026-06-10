<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Transaksi;

class PublicController extends Controller
{
    // ==========================================
    // 1. Tampilkan Halaman Depan (Pilih Nama Warga)
    // ==========================================
    public function index()
    {
        // Mengambil semua data warga untuk ditampilkan di Dropdown pilihan
        $nasabahs = Nasabah::orderBy('nama', 'asc')->get();
        return view('public.index', compact('nasabahs'));
    }

    // ==========================================
    // 2. Proses Pengecekan PIN Warga
    // ==========================================
    public function checkPin(Request $request)
    {
        // Hanya memvalidasi bahwa warga sudah memilih nama dari dropdown
        $request->validate([
            'nasabah_id' => 'required',
        ]);

        // [DIPERBAIKI] Catat sesi menggunakan nama kunci yang benar agar tidak ditendang oleh getHistory
        session(['izin_akses_' . $request->nasabah_id => true]);
        
        // Catat juga ID warga jika sewaktu-waktu dibutuhkan secara global
        session(['warga_id' => $request->nasabah_id]);

        // [DIPERBAIKI] Langsung arahkan ke fungsi getHistory (Halaman Saldo & Riwayat yang asli)
        return redirect()->route('public.history', ['id' => $request->nasabah_id]);
    }

    // ==========================================
    // 3. Menampilkan Halaman Saldo & Riwayat
    // ==========================================
    public function getHistory($id)
    {
        if (!session()->has('izin_akses_' . $id)) {
            
            return redirect()->route('public.index')->with('error_pin', 'Akses ditolak! Silakan masukkan PIN Anda terlebih dahulu.');
        }

        $warga = Nasabah::findOrFail($id);
        $transaksis = Transaksi::where('nasabah_id', $id)->latest()->get();

        return view('public.history', compact('warga', 'transaksis'));
    }

    // ==========================================
    // 4. Fitur Ganti PIN Rahasia Warga
    // ==========================================
    public function updatePin(Request $request, $id)
    {
        // Cek Keamanan
        if (!session()->has('izin_akses_' . $id)) {
            return redirect()->route('public.index')->with('error_pin', 'Akses ditolak! Waktu sesi habis.');
        }

        $warga = Nasabah::findOrFail($id);

        if ($request->pin_lama != $warga->pin) {
            return redirect()->back()->with('error_ubah_pin', 'Gagal! PIN Lama yang Anda masukkan salah.');
        }

  
        $request->validate([
            'pin_baru' => 'required|numeric|digits:6|confirmed'
        ], [
            // Pesan error khusus jika konfirmasi gagal
            'pin_baru.confirmed' => 'Gagal! Konfirmasi ketikan PIN Baru tidak cocok.',
            'pin_baru.digits' => 'PIN harus terdiri dari 6 angka.'
        ]);


        $warga->update([
            'pin' => $request->pin_baru
        ]);

        return redirect()->back()->with('success_ubah_pin', 'Hore! PIN Rahasia berhasil diperbarui. Gunakan PIN baru ini untuk kunjungan berikutnya!');
    }
}
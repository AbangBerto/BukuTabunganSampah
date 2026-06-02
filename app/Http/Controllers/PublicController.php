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
        // Validasi inputan harus terisi dan berupa 6 angka
        $request->validate([
            'nasabah_id' => 'required',
            'pin' => 'required|numeric|digits:6'
        ]);

        $warga = Nasabah::findOrFail($request->nasabah_id);

        // Jika PIN Cocok
        if ($request->pin == $warga->pin) {
            // Berikan tiket session (izin masuk)
            session()->put('izin_akses_' . $warga->id, true);
            return redirect()->route('public.history', $warga->id);
        }

        // Jika PIN Salah, tendang balik
        return redirect()->back()->with('error_pin', 'PIN yang Anda masukkan salah!');
    }

    // ==========================================
    // 3. Menampilkan Halaman Saldo & Riwayat
    // ==========================================
    public function getHistory($id)
    {
        // Cek Keamanan: Apakah warga ini punya tiket session?
        if (!session()->has('izin_akses_' . $id)) {
            // Jika memaksa masuk lewat URL, lempar kembali ke halaman depan
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

        // Cek apakah PIN Lama cocok
        if ($request->pin_lama != $warga->pin) {
            return redirect()->back()->with('error_ubah_pin', 'Gagal! PIN Lama yang Anda masukkan salah.');
        }

        // VALIDASI BARU: Wajib 6 angka dan wajib cocok dengan inputan konfirmasi
        $request->validate([
            'pin_baru' => 'required|numeric|digits:6|confirmed'
        ], [
            // Pesan error khusus jika konfirmasi gagal
            'pin_baru.confirmed' => 'Gagal! Konfirmasi ketikan PIN Baru tidak cocok.',
            'pin_baru.digits' => 'PIN harus terdiri dari 6 angka.'
        ]);

        // Simpan PIN Baru ke database
        $warga->update([
            'pin' => $request->pin_baru
        ]);

        return redirect()->back()->with('success_ubah_pin', 'Hore! PIN Rahasia berhasil diperbarui. Gunakan PIN baru ini untuk kunjungan berikutnya!');
    }
}
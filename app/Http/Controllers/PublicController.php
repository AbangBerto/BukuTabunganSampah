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
    // 2. cek saldo
    // ==========================================
    public function checkSaldo(Request $request)
    {
        // Validasi pastikan warga memilih nama dan ID-nya ada di database
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
        ]);

        // Langsung arahkan ke fungsi getHistory (Halaman Saldo & Riwayat)
        return redirect()->route('public.history', ['id' => $request->nasabah_id]);
    }

    // ==========================================
    // 3. Menampilkan Halaman Saldo & Riwayat
    // ==========================================
    public function getHistory($id)
    {
        $warga = Nasabah::findOrFail($id);
        $transaksis = Transaksi::where('nasabah_id', $id)->latest()->get();

        return view('public.history', compact('warga', 'transaksis'));
    }
}

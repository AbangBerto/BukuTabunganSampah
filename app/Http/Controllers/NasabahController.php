<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;

class NasabahController extends Controller
{
    // 1. Tampilkan Daftar Warga
    public function index()
    {
        $nasabahs = Nasabah::orderBy('nama', 'asc')->get();
        return view('nasabah.index', compact('nasabahs'));
    }

    // 2. Simpan Warga Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
        ]);

        Nasabah::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'saldo' => 0, // Saldo awal otomatis 0
        ]);

        return redirect()->back()->with('success', 'Warga baru berhasil didaftarkan!');
    }

    // 3. Tampilkan Halaman Edit Warga
    public function edit($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        return view('nasabah.edit', compact('nasabah'));
    }

    // 4. Proses Update Data Warga
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $nasabah = Nasabah::findOrFail($id);
        $nasabah->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('nasabah.index')->with('success', 'Data warga berhasil diperbarui!');
    }

    // 5. Proses Hapus Warga
    public function destroy($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        $nasabah->delete(); // Otomatis menghapus transaksi terkait karena fitur cascade di database

        return redirect()->route('nasabah.index')->with('success', 'Data warga berhasil dihapus dari sistem!');
    }
    // ==========================================
    // Fitur Khusus Admin: Reset PIN Warga ke 123456
    // ==========================================
    public function resetPin($id)
    {
        // Cari data warga berdasarkan ID yang diklik
        $warga = \App\Models\Nasabah::findOrFail($id);
        
        // Ubah PIN warga tersebut kembali ke bawaan pabrik
        $warga->update([
            'pin' => '123456'
        ]);

        // Kembalikan admin ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'PIN rahasia milik ' . $warga->nama . ' berhasil direset kembali ke 123456!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;     // Menggunakan model Nasabah (Warga)
use App\Models\Transaksi;   // Menggunakan model Transaksi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    // ==========================================
    // 1. Tampilkan Halaman Dashboard
    // ==========================================
    public function getDashboard()
    {
        // Ambil data warga
        $nasabahs = Nasabah::orderBy('nama', 'asc')->get();
        
        // Ambil 10 transaksi terakhir
        $transaksis = Transaksi::with('nasabah')->latest()->take(10)->get();
        
        return view('admin.dashboard', compact('nasabahs', 'transaksis'));
    }

    // ==========================================
    // 2. Proses Setor Sampah (Tambah Saldo)
    // ==========================================
    public function postTransaksi(Request $request)
    {
        // Validasi: pastikan nasabah_id yang dicari, BUKAN kepala_keluarga_id
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jenis_sampah' => 'required|in:Plastik,Besi,Lainnya',
            'berat' => 'required|numeric|min:0.01',
            'nominal' => 'required|integer|min:0',
        ]);

        // Cari data warga yang menabung
        $nasabah = Nasabah::findOrFail($request->nasabah_id);

        // A. Catat ke tabel riwayat transaksi
        Transaksi::create([
            'nasabah_id' => $request->nasabah_id,
            'jenis_transaksi' => 'setor', // Sesuai dengan database (huruf kecil)
            'nominal' => $request->nominal,
            'keterangan' => "Setor " . $request->jenis_sampah . " (" . $request->berat . " Kg)",
        ]);

        // B. UPDATE SALDO WARGA (Ditambah)
        $nasabah->update([
            'saldo' => $nasabah->saldo + $request->nominal
        ]);

        return redirect()->back()->with('success', 'Catatan setoran sampah berhasil disimpan! Saldo bertambah.');
    }

    // ==========================================
    // 3. Proses Tarik Tunai (Kurangi Saldo)
    // ==========================================
    public function postTarikUang(Request $request)
    {
        // Validasi
        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'nominal' => 'required|integer|min:1',
        ]);

        $nasabah = Nasabah::findOrFail($request->nasabah_id);

        // Cek apakah saldo cukup
        if ($nasabah->saldo < $request->nominal) {
            return redirect()->back()->with('error', 'Gagal! Saldo tidak mencukupi. (Sisa saldo: Rp ' . number_format($nasabah->saldo, 0, ',', '.') . ')');
        }

        // A. Catat ke tabel riwayat transaksi
        Transaksi::create([
            'nasabah_id' => $request->nasabah_id,
            'jenis_transaksi' => 'tarik', // Sesuai dengan database (huruf kecil)
            'nominal' => $request->nominal,
            'keterangan' => 'Tarik Saldo Tunai',
        ]);

        // B. UPDATE SALDO WARGA (Dikurangi)
        $nasabah->update([
            'saldo' => $nasabah->saldo - $request->nominal
        ]);

        return redirect()->back()->with('success', 'Berhasil mencatat penarikan uang tunai! Saldo berkurang.');
    }

    // ==========================================
    // 4. Bersihkan Cache
    // ==========================================
    public function getClearCache()
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        return redirect()->route('admin.dashboard')->with('success', 'Cache sistem hosting berhasil dibersihkan!');
    }
    // ==========================================
    // 5. Batalkan / Hapus Transaksi (Otomatis Sesuaikan Saldo)
    // ==========================================
    public function destroyTransaksi($id)
    {
        // 1. Cari data transaksinya
        $transaksi = Transaksi::findOrFail($id);
        
        // 2. Cari data warga pemilik transaksi tersebut
        $nasabah = Nasabah::findOrFail($transaksi->nasabah_id);

        // 3. Logika Matematika Pengembalian Saldo
        if ($transaksi->jenis_transaksi == 'setor') {
            // Jika hapus setoran, saldo ditarik kembali (dikurangi)
            $nasabah->update([
                'saldo' => $nasabah->saldo - $transaksi->nominal
            ]);
        } else {
            // Jika hapus penarikan, saldo dikembalikan utuh (ditambah)
            $nasabah->update([
                'saldo' => $nasabah->saldo + $transaksi->nominal
            ]);
        }

        // 4. Hapus catatan transaksinya dari riwayat
        $transaksi->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan! Saldo warga telah disesuaikan kembali secara otomatis.');
    }
    public function getLaporan()
    {
        // 1. Hitung total semua saldo warga saat ini
        $totalSaldoWarga = Nasabah::sum('saldo');
        
        // 2. Hitung total uang yang pernah disetor (Masuk)
        $totalUangMasuk = Transaksi::where('jenis_transaksi', 'setor')->sum('nominal');
        
        // 3. Hitung total uang yang pernah ditarik (Keluar)
        $totalUangKeluar = Transaksi::where('jenis_transaksi', 'tarik')->sum('nominal');
        
        // 4. Ambil SEMUA data transaksi untuk tabel laporan (bukan cuma 10 terakhir)
        $semuaTransaksi = Transaksi::with('nasabah')->latest()->get();

        return view('admin.laporan', compact('totalSaldoWarga', 'totalUangMasuk', 'totalUangKeluar', 'semuaTransaksi'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\KepalaKeluarga;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    public function getDashboard()
    {
        $all_kk = KepalaKeluarga::orderBy('nama', 'asc')->get();
        $transaksis = Transaksi::with('kepalaKeluarga')->latest()->take(10)->get();
        return view('admin.dashboard', compact('all_kk', 'transaksis'));
    }

    public function postKK(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        KepalaKeluarga::create($request->all());
        return redirect()->back()->with('success', 'Data Kepala Keluarga berhasil ditambahkan!');
    }

    public function postTransaksi(Request $request)
    {
        $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluargas,id',
            'jenis_sampah' => 'required|in:Plastik,Besi,Lainnya',
            'berat' => 'required|numeric|min:0.01',
            'nominal' => 'required|integer|min:0',
        ]);

        Transaksi::create([
            'kepala_keluarga_id' => $request->kepala_keluarga_id,
            'jenis_transaksi' => 'Setor',
            'jenis_sampah' => $request->jenis_sampah,
            'berat' => $request->berat,
            'nominal' => $request->nominal,
        ]);

        return redirect()->back()->with('success', 'Catatan setoran sampah berhasil disimpan!');
    }

    public function postTarikUang(Request $request)
    {
        $request->validate([
            'kepala_keluarga_id' => 'required|exists:kepala_keluargas,id',
            'nominal' => 'required|integer|min:1',
        ]);

        $kk = KepalaKeluarga::findOrFail($request->kepala_keluarga_id);

        if ($kk->saldo < $request->nominal) {
            return redirect()->back()->with('error', 'Gagal! Saldo tidak mencukupi. (Sisa saldo: Rp ' . number_format($kk->saldo, 0, ',', '.') . ')');
        }

        Transaksi::create([
            'kepala_keluarga_id' => $request->kepala_keluarga_id,
            'jenis_transaksi' => 'Tarik',
            'nominal' => $request->nominal,
            'jenis_sampah' => null,
            'berat' => null,
        ]);

        return redirect()->back()->with('success', 'Berhasil mencatat penarikan uang tunai!');
    }

    public function getClearCache()
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        return redirect()->route('admin.dashboard')->with('success', 'Cache sistem hosting berhasil dibersihkan!');
    }
}
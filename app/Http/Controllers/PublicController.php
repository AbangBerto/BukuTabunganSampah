<?php

namespace App\Http\Controllers;

use App\Models\KepalaKeluarga;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getHome(Request $request)
    {
        $search = $request->input('search');
        $warga = [];

        if ($search) {
            $warga = KepalaKeluarga::where('nama', 'like', "%{$search}%")->get();
        }

        return view('public.index', compact('warga', 'search'));
    }

    public function getHistory($id)
    {
        $kk = KepalaKeluarga::with('transaksis')->findOrFail($id);
        return view('public.history', compact('kk'));
    }
}
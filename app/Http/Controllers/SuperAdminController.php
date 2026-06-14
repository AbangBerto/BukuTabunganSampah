<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{

    public function index()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Akses Ditolak! Anda bukan Kepala/Super Admin.');
        }

        // Ambil data semua admin yang ada di sistem
        $admins = User::orderBy('created_at', 'desc')->get();
        return view('superadmin.dashboard', compact('admins'));
    }

    // 2. Simpan Admin Baru
    public function storeAdmin(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        return redirect()->back()->with('success', 'Akun Admin baru berhasil ditambahkan!');
    }
    // ==========================================
    // 3. Hapus Akun Admin
    // ==========================================
    public function destroyAdmin($id)
    {
        if (auth()->user()->role !== 'superadmin') abort(403);

        $admin = User::findOrFail($id);

        // Proteksi agar Super Admin tidak sengaja menghapus akunnya sendiri yang sedang digunakan
        if ($admin->id === auth()->user()->id) {
            return redirect()->back()->with('error', 'Gagal! Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif.');
        }

        $admin->delete();

        return redirect()->back()->with('success', 'Akun Admin berhasil dihapus dari sistem!');
    }
}
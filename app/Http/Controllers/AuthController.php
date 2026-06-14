<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite; 
use App\Models\User;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ==========================================
            // LOGIKA BARU: Cek Role Setelah Login Manual
            // ==========================================
            if (Auth::user()->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard')->with('success', 'Selamat datang kembali, Super Admin!');
            }

            // Jika bukan superadmin, arahkan ke dashboard transaksi biasa
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    public function postLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil keluar dari sistem admin.');
    }
    
    // 1. Mengarahkan admin ke halaman Login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // 2. Menangkap balasan dari Google setelah admin memilih akun
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update(['google_id' => $googleUser->getId()]);
                Auth::login($user);
                
                request()->session()->regenerate();

                // ==========================================
                // LOGIKA BARU: Cek Role Setelah Login via Google
                // ==========================================
                if (Auth::user()->role === 'superadmin') {
                    return redirect()->route('superadmin.dashboard')->with('success', 'Berhasil masuk menggunakan Google sebagai Super Admin!');
                }

                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login menggunakan Google!');
            } else {
                return redirect()->route('login')->with('error', 'Akses Ditolak: Email Anda tidak terdaftar sebagai Admin Desa.');
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat menghubungi server Google. Coba lagi.');
        }
    }
}
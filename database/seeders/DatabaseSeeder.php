<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Nasabah; // Memanggil model Nasabah
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. Membuat Akun Super Admin Utama
        // ==========================================
        User::create([
            'name' => 'Super Admin Desa',
            'email' => env('SUPERADMIN_EMAIL', 'superadmin@gmail.com'), 
            'password' => Hash::make(env('SUPERADMIN_PASSWORD', 'password123')), 
            'role' => 'superadmin',
        ]);

        // ==========================================
        // 2. Membuat Akun Admin Biasa (Petugas)
        // ==========================================
        User::create([
            'name' => 'Admin Bank Sampah',
            'email' => env('ADMIN_EMAIL', 'admin@gmail.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password123')), 
            'role' => 'admin',
        ]);

        // ==========================================
        // 3. Membuat Data Contoh Warga (Nasabah)
        // ==========================================
        Nasabah::create([
            'nama' => 'Budi Santoso',
            'alamat' => 'RT 01 / RW 01, Dusun Ngembringan',
            'no_hp' => '081234567890',
            'saldo' => 0
        ]);

        Nasabah::create([
            'nama' => 'Siti Aminah',
            'alamat' => 'RT 02 / RW 01, Dusun Ngembringan',
            'no_hp' => '089876543210',
            'saldo' => 0
        ]);
    }
}
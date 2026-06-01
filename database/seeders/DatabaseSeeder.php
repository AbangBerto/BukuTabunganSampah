<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KepalaKeluarga;
use App\Models\Transaksi;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data Login Akun Admin Utama
        User::create([
            'name' => 'Admin Desa',
            'email' => 'albertosafanda89@gmail.com', // <--- Hanya baris ini yang diubah
            'password' => bcrypt('rahasia123'),      // <--- Tetap gunakan bcrypt
        ]);

        // Data Dummy Kepala Keluarga
        $warga = [
            ['nama' => 'Budi Santoso', 'alamat' => 'RT 01 / RW 01, Dusun Ngembrinagan'],
            ['nama' => 'Siti Aminah', 'alamat' => 'RT 01 / RW 02, Dusun Ngembrinagan'],
            ['nama' => 'Ahmad Subarjo', 'alamat' => 'RT 02 / RW 01, Dusun Ngembrinagan'],
        ];

        foreach ($warga as $item) {
            $kk = KepalaKeluarga::create($item);

            // Transaksi Setor Sampah Dummy
            Transaksi::create([
                'kepala_keluarga_id' => $kk->id,
                'jenis_transaksi' => 'Setor',
                'jenis_sampah' => 'Plastik',
                'berat' => rand(5, 12),
                'nominal' => 20000,
                'created_at' => Carbon::now()->subDays(2),
            ]);

            // Transaksi Tarik Tunai Dummy
            Transaksi::create([
                'kepala_keluarga_id' => $kk->id,
                'jenis_transaksi' => 'Tarik',
                'jenis_sampah' => null,
                'berat' => null,
                'nominal' => 5000,
                'created_at' => Carbon::now()->subMinutes(10),
            ]);
        }
    }
}
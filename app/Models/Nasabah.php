<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    use HasFactory;

    // PASTIKAN 'pin' ADA DI DALAM DAFTAR INI:
    protected $fillable = [
        'nama', 
        'alamat', 
        'no_hp', 
        'saldo',
        'pin' // <--- Tambahkan baris ini
    ];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}
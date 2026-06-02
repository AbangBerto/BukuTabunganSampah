<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Menentukan kolom mana saja yang boleh diisi
    protected $fillable = [
        'nasabah_id',
        'jenis_transaksi',
        'nominal',
        'keterangan'
    ];

    // INI JEMBATAN RELASI YANG DICARI OLEH ERROR MERAH TERSEBUT
    // Menjelaskan ke sistem bahwa satu transaksi ini adalah milik dari seorang Nasabah (Warga)
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
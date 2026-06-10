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

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }
}
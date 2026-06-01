<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['kepala_keluarga_id', 'jenis_transaksi', 'jenis_sampah', 'berat', 'nominal'];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class);
    }
}
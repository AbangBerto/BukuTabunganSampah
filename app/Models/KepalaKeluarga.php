<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaKeluarga extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'alamat'];

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class)->latest();
    }

    public function getSaldoAttribute()
    {
        $totalSetor = Transaksi::where('kepala_keluarga_id', $this->id)->where('jenis_transaksi', 'Setor')->sum('nominal');
        $totalTarik = Transaksi::where('kepala_keluarga_id', $this->id)->where('jenis_transaksi', 'Tarik')->sum('nominal');
        
        return (int)($totalSetor - $totalTarik);
    }
}
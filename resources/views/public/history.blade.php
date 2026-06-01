@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <!-- Tombol Kembali -->
    <a href="{{ route('public.index') }}" class="btn-abu w-full py-3 rounded-xl text-sm shadow-sm">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Pencarian
    </a>

    <!-- Kartu Informasi Saldo Warga (DIKUNCI WARNANYA SECARA MANUAL) -->
    <div style="background-color: #059669;" class="rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-white opacity-80 text-xs font-bold uppercase tracking-widest mb-1">Total Tabungan</p>
            <h2 class="text-4xl font-extrabold tracking-tight">
                <span class="text-2xl mr-1">Rp</span>{{ number_format($kk->saldo, 0, ',', '.') }}
            </h2>
            
            <div class="mt-5 pt-4 border-t border-white border-opacity-30">
                <p class="text-white opacity-80 text-xs uppercase tracking-widest mb-1">Kepala Keluarga</p>
                <p class="text-lg font-bold">{{ $kk->nama }}</p>
                <p class="text-white opacity-70 text-xs mt-1"><i class="fa-solid fa-location-dot mr-1"></i>{{ $kk->alamat ?? '-' }}</p>
            </div>
        </div>
        
        <!-- Hiasan latar belakang -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
    </div>

    <!-- Log Aktivitas Keuangan -->
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-5 border-b pb-3 border-gray-100">
            <i class="fa-solid fa-clock-rotate-left mr-2" style="color: #059669;"></i> Riwayat Aktivitas
        </h3>
        
        @if($kk->transaksis->count() > 0)
            <div class="relative border-l-2 border-gray-200 ml-2 pl-6 space-y-6">
                @foreach($kk->transaksis as $t)
                    <div class="relative">
                        <!-- Titik Indikator Diatur Paksa Posisinya agar tidak bertumpuk -->
                        <span class="absolute top-1 {{ $t->jenis_transaksi == 'Setor' ? 'bg-green-500 ring-green-100' : 'bg-red-500 ring-red-100' }} w-3.5 h-3.5 rounded-full ring-4" style="left: -31px;"></span>
                        
                        <div>
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-sm font-bold text-gray-800">
                                    {{ $t->jenis_transaksi == 'Setor' ? 'Setor Sampah' : 'Tarik Tunai' }}
                                </span>
                                <!-- Nominal Uang -->
                                <span class="text-sm font-extrabold {{ $t->jenis_transaksi == 'Setor' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $t->jenis_transaksi == 'Setor' ? '+' : '-' }} Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center text-xs text-gray-500">
                                <span>
                                    @if($t->jenis_transaksi == 'Setor')
                                        {{ $t->jenis_sampah }} • <span class="font-semibold text-gray-700">{{ $t->berat }} Kg</span>
                                    @else
                                        Pengambilan Uang
                                    @endif
                                </span>
                                <span class="font-mono text-[10px] bg-gray-100 px-2 py-1 rounded-md">{{ $t->created_at->translatedFormat('d M Y, H:i') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-400">
                <p class="text-sm font-medium">Belum ada catatan aktivitas tabungan.</p>
            </div>
        @endif
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')

<style>
    .riwayat-scroll::-webkit-scrollbar {
        width: 5px;
    }
    .riwayat-scroll::-webkit-scrollbar-track {
        background: #f8fafc; 
        border-radius: 10px;
    }
    .riwayat-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 10px;
    }
    .riwayat-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
</style>

<div class="space-y-6">
    
    <a href="{{ route('public.index') }}" class="btn-abu w-full py-3 rounded-xl text-sm shadow-sm inline-flex items-center justify-center">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Pencarian
    </a>

    <div style="background-color: #059669;" class="rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-white opacity-80 text-xs font-bold uppercase tracking-widest mb-1">Total Tabungan</p>
            <h2 class="text-4xl font-extrabold tracking-tight">
                <span class="text-2xl mr-1">Rp</span>{{ number_format($warga->saldo, 0, ',', '.') }}
            </h2>
            
            <div class="mt-5 pt-4 border-t border-white border-opacity-30">
                <p class="text-white opacity-80 text-xs uppercase tracking-widest mb-1">Nama Warga</p>
                <p class="text-lg font-bold">{{ $warga->nama }}</p>
                <p class="text-white opacity-70 text-xs mt-1"><i class="fa-solid fa-location-dot mr-1"></i>{{ $warga->alamat ?? '-' }}</p>
            </div>
        </div>
        
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
    </div>


    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 mb-4 relative">
        <h3 class="text-sm font-extrabold text-gray-700 uppercase tracking-wider mb-4 border-b pb-3 border-gray-100">
            <i class="fa-solid fa-clock-rotate-left mr-2" style="color: #059669;"></i> Riwayat Aktivitas
        </h3>
        
        @if($transaksis->count() > 0)
            <div class="riwayat-scroll max-h-[320px] overflow-y-auto pr-3 pb-2 relative">
                <div class="relative border-l-2 border-gray-200 ml-2 pl-6 space-y-6 mt-2">
                    @foreach($transaksis as $t)
                        <div class="relative">
                            <span class="absolute top-1 {{ $t->jenis_transaksi == 'setor' ? 'bg-green-500 ring-green-100' : 'bg-red-500 ring-red-100' }} w-3.5 h-3.5 rounded-full ring-4" style="left: -31px;"></span>
                            
                            <div>
                                <div class="flex justify-between items-start mb-1">
                                    <span class="text-sm font-bold text-gray-800">
                                        {{ $t->jenis_transaksi == 'setor' ? 'Setor Sampah' : 'Tarik Tunai' }}
                                    </span>
                                    <span class="text-sm font-extrabold {{ $t->jenis_transaksi == 'setor' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $t->jenis_transaksi == 'setor' ? '+' : '-' }} Rp {{ number_format($t->nominal, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <span class="font-medium text-gray-600">
                                        {{ $t->keterangan ?? ($t->jenis_transaksi == 'setor' ? 'Penyetoran Sampah' : 'Pengambilan Uang') }}
                                    </span>
                                    <span class="font-mono text-[10px] bg-gray-100 px-2 py-1 rounded-md">
                                        {{ $t->created_at->translatedFormat('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="absolute bottom-5 left-5 right-5 h-8 bg-gradient-to-t from-white to-transparent pointer-events-none"></div>
        @else
            <div class="text-center py-8 text-gray-400">
                <i class="fa-regular fa-folder-open text-3xl mb-3 opacity-50"></i>
                <p class="text-sm font-medium">Belum ada catatan aktivitas tabungan.</p>
            </div>
        @endif
    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="space-y-6 mt-4">
    
    <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100">
        <div class="text-center mb-5">
            <h2 class="text-lg font-bold text-gray-800">Cek Tabungan Anda</h2>
            <p class="text-xs text-gray-400 mt-1">Masukkan nama kepala keluarga</p>
        </div>
        
        <form action="{{ route('public.index') }}" method="GET" class="space-y-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama di sini..." required
                   class="w-full bg-gray-50 text-center px-4 py-4 rounded-2xl text-base font-semibold border-2 border-gray-200 focus:outline-none focus:border-green-500 transition-all text-gray-700">
            
            <button type="submit" class="btn-hijau w-full py-4 rounded-2xl text-base shadow-md">
                <i class="fa-solid fa-magnifying-glass mr-2"></i> Cari Tabungan
            </button>
        </form>
    </div>

    @if($search)
        <div>
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 pl-2">Hasil Pencarian ({{ count($warga) }})</h3>
            @if(count($warga) > 0)
                <div class="space-y-3">
                    @foreach($warga as $w)
                        <a href="{{ route('public.history', $w->id) }}" class="flex p-4 bg-white border-2 border-gray-100 rounded-2xl shadow-sm hover:border-green-500 items-center transition-all group">
                            <div class="bg-green-100 text-green-700 w-10 h-10 rounded-full flex items-center justify-center font-bold mr-4">
                                {{ substr($w->nama, 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800 group-hover:text-green-600 text-sm">{{ $w->nama }}</h4>
                                <p class="text-[11px] text-gray-400 mt-0.5">{{ $w->alamat ?? 'Desa Ngembrinagan' }}</p>
                            </div>
                            <i class="fa-solid fa-chevron-right text-gray-300 group-hover:text-green-500"></i>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                    <i class="fa-solid fa-face-frown text-4xl text-gray-300 mb-3 block"></i>
                    <p class="text-sm font-semibold text-gray-500">Nama tidak ditemukan.</p>
                </div>
            @endif
        </div>
    @else
        <div class="pt-8">
            <a href="{{ route('login') }}" class="btn-gelap flex w-full py-4 rounded-2xl text-sm shadow-md">
                <i class="fa-solid fa-lock mr-2 text-green-400"></i> Masuk sebagai Admin Desa
            </a>
        </div>
    @endif

</div>
@endsection
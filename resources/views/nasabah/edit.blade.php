@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    
    <a href="{{ route('nasabah.index') }}" class="btn-abu inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Warga
    </a>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h2 class="text-lg font-black text-gray-800 mb-4 border-b border-gray-100 pb-3">
            <i class="fa-solid fa-user-gear text-yellow-500 mr-2"></i> Edit Data Warga / Nasabah
        </h2>

        <form action="{{ route('nasabah.update', $nasabah->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs font-extrabold text-gray-500 uppercase ml-1">Nama Lengkap Warga</label>
                <input type="text" name="nama" value="{{ old('nama', $nasabah->nama) }}" required
                       class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-yellow-500 font-bold text-gray-700 mt-1">
            </div>

            <div>
                <label class="text-xs font-extrabold text-gray-500 uppercase ml-1">Nomor HP / WhatsApp</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $nasabah->no_hp) }}" placeholder="Contoh: 0812345..."
                       class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-yellow-500 font-medium text-gray-700 mt-1">
            </div>

            <div>
                <label class="text-xs font-extrabold text-gray-500 uppercase ml-1">Alamat Rumah (RT/RW)</label>
                <textarea name="alamat" rows="3" placeholder="Contoh: RT 02 / RW 01, Dusun Ngembringan"
                          class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-yellow-500 font-medium text-gray-700 mt-1">{{ old('alamat', $nasabah->alamat) }}</textarea>
            </div>

            <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100 flex items-center justify-between">
                <span class="text-xs font-bold text-yellow-800 uppercase"><i class="fa-solid fa-wallet mr-1"></i> Saldo Saat Ini</span>
                <span class="text-sm font-black text-yellow-700">Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}</span>
            </div>

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3.5 rounded-xl text-sm shadow-md transition mt-2">
                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan Data
            </button>
        </form>
    </div>
</div>
@endsection
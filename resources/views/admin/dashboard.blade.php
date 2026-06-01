@extends('layouts.app')

@section('content')
<div class="space-y-6">
    
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-6">
        <h2 class="text-lg font-black text-gray-800 mb-4 border-b border-gray-100 pb-3">
            <i class="fa-solid fa-user-shield text-green-600 mr-2"></i> Panel Admin Desa
        </h2>
        
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.clearCache') }}" class="btn-abu flex flex-col py-2.5 rounded-xl shadow-sm text-center">
                <i class="fa-solid fa-broom mb-1 text-base text-blue-600"></i>
                <span class="text-[10px] font-bold uppercase">Refresh Server</span>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="btn-abu flex flex-col w-full py-2.5 rounded-xl shadow-sm text-center hover:bg-red-50">
                    <i class="fa-solid fa-power-off mb-1 text-base text-red-600"></i>
                    <span class="text-[10px] font-bold uppercase">Keluar Akun</span>
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 mb-4"><i class="fa-solid fa-user-plus text-green-600 mr-2"></i> 1. Tambah Warga Baru</h3>
        <form action="{{ route('admin.storeKK') }}" method="POST" class="space-y-3">
            @csrf
            <input type="text" name="nama" placeholder="Nama Lengkap Kepala Keluarga" required
                   class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-medium text-gray-700">
            <input type="text" name="alamat" placeholder="Alamat / RT / RW"
                   class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-medium text-gray-700">
            <button type="submit" class="btn-gelap w-full py-3.5 rounded-xl text-sm shadow-md mt-2">
                Simpan Warga
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 mb-4"><i class="fa-solid fa-scale-balanced text-green-600 mr-2"></i> 2. Catat Setoran Sampah (Tambah Uang)</h3>
        <form action="{{ route('admin.storeTransaksi') }}" method="POST" class="space-y-3">
            @csrf
            <select name="kepala_keluarga_id" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-bold text-gray-700">
                <option value="">-- Pilih Nama Warga --</option>
                @foreach($all_kk as $kk)
                    <option value="{{ $kk->id }}">{{ $kk->nama }}</option>
                @endforeach
            </select>
            
            <select name="jenis_sampah" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-medium text-gray-700">
                <option value="Plastik">Sampah Plastik</option>
                <option value="Besi">Sampah Besi</option>
                <option value="Lainnya">Lainnya / Campur</option>
            </select>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Berat (Kg)</label>
                    <input type="number" step="0.01" name="berat" placeholder="Contoh: 2.5" required
                           class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-bold text-green-700 mt-1">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Uang (Rp)</label>
                    <input type="number" name="nominal" placeholder="Contoh: 15000" required
                           class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-bold text-green-700 mt-1">
                </div>
            </div>
            
            <button type="submit" class="btn-hijau w-full py-3.5 rounded-xl text-sm shadow-md mt-3">
                <i class="fa-solid fa-plus mr-2"></i> Simpan Transaksi Masuk
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 mb-4"><i class="fa-solid fa-money-bill-wave text-red-600 mr-2"></i> 3. Tarik Saldo Tunai (Kurangi Uang)</h3>
        <form action="{{ route('admin.storeTarikUang') }}" method="POST" class="space-y-3">
            @csrf
            <select name="kepala_keluarga_id" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-red-500 font-bold text-gray-700">
                <option value="">-- Pilih Nama Warga --</option>
                @foreach($all_kk as $kk)
                    <option value="{{ $kk->id }}">{{ $kk->nama }} (Saldo: Rp {{ number_format($kk->saldo, 0, ',', '.') }})</option>
                @endforeach
            </select>
            
            <input type="number" name="nominal" placeholder="Jumlah Uang Diambil (Rp)" required
                   class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-red-500 font-bold text-red-600">
                   
            <button type="submit" class="btn-merah w-full py-3.5 rounded-xl text-sm shadow-md mt-2">
                <i class="fa-solid fa-minus mr-2"></i> Konfirmasi Penarikan
            </button>
        </form>
    </div>

</div>
@endsection
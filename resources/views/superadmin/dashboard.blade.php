@extends('layouts.app')

@section('content')
<div class="space-y-6 mt-6">

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
            <span class="font-bold">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
            <span class="font-bold">Gagal!</span> {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h2 class="text-xl font-black text-gray-800 mb-2">👑 Panel Super Admin</h2>
        <p class="text-xs text-gray-500 mb-5">Hanya Anda yang bisa mengelola akses aplikasi ini.</p>
        
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('admin.dashboard') }}" class="btn-hijau w-full flex justify-center items-center py-3 rounded-xl text-sm shadow-sm font-bold text-center">
                <i class="fa-solid fa-desktop mr-2"></i> Panel Transaksi
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="btn-gelap w-full py-3 rounded-xl text-sm shadow-sm font-bold">
                    <i class="fa-solid fa-power-off mr-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 mb-4"><i class="fa-solid fa-user-plus text-blue-600 mr-2"></i> Tambah Admin Baru</h3>
        
        <form action="{{ route('superadmin.storeAdmin') }}" method="POST" class="space-y-3">
            @csrf
            
            <input type="text" name="name" placeholder="Nama Lengkap Admin" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-blue-500 font-medium">
            
            <input type="email" name="email" placeholder="Alamat Email Akses" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-blue-500 font-medium">
            
            <input type="password" name="password" placeholder="Password (Minimal 6 huruf/angka)" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-blue-500 font-medium">

            <button type="submit" class="w-full py-3.5 rounded-xl text-sm shadow-md mt-2 text-white font-bold transition bg-blue-600 hover:bg-blue-700">
                <i class="fa-solid fa-plus mr-2"></i> Daftarkan Admin
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 mb-4"><i class="fa-solid fa-users-gear text-gray-600 mr-2"></i> Daftar Akun Pengelola</h3>
        
        <div class="space-y-3">
            @foreach($admins as $admin)
                <div class="flex justify-between items-center p-3 border border-gray-100 rounded-xl bg-gray-50">
                    <div>
                        <p class="font-bold text-sm text-gray-800">{{ $admin->name }} 
                            @if($admin->role == 'superadmin') 
                                <span class="bg-purple-100 text-purple-800 text-[10px] font-black px-2 py-0.5 rounded ml-1">SUPER</span> 
                            @endif
                        </p>
                        <p class="text-xs text-gray-500">{{ $admin->email }}</p>
                    </div>

                    @if($admin->id !== auth()->user()->id)
                        <form action="{{ route('superadmin.destroyAdmin', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun pengelola ini? Hak akses login mereka akan langsung dicabut.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition rounded-xl p-2.5" title="Hapus Akses Admin">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
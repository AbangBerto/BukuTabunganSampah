@extends('layouts.app')

@section('content')
<div class="mt-8 space-y-6">
    <div class="text-center">
        <div class="inline-flex justify-center items-center w-16 h-16 rounded-full bg-green-100 text-green-600 mb-4">
            <i class="fa-solid fa-user-lock text-2xl"></i>
        </div>
        <h2 class="text-xl font-bold text-gray-800">Login Admin Desa</h2>
        <p class="text-xs text-gray-400 mt-1">Masukkan email dan kata sandi Anda</p>
    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        
        @if($errors->any())
            <div class="bg-red-50 text-red-600 text-xs p-3 rounded-lg mb-4 text-center font-medium">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@desa.com"
                       class="w-full bg-gray-50 px-4 py-3 rounded-xl text-sm border-2 border-gray-200 focus:outline-none focus:border-green-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••"
                       class="w-full bg-gray-50 px-4 py-3 rounded-xl text-sm border-2 border-gray-200 focus:outline-none focus:border-green-500">
            </div>

            <button type="submit" class="btn-hijau w-full py-3.5 rounded-xl text-sm shadow-sm mt-2">
                Masuk
            </button>
        </form>

        <div class="mt-6 flex items-center justify-between">
            <span class="border-b w-1/5 border-gray-200"></span>
            <span class="text-xs text-center text-gray-400 uppercase font-bold tracking-widest">Atau</span>
            <span class="border-b w-1/5 border-gray-200"></span>
        </div>

        <a href="{{ route('google.login') }}" class="btn-abu w-full py-3.5 rounded-xl text-sm shadow-sm mt-6 hover:bg-gray-100 transition-colors">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 mr-3" alt="Logo Google">
            Masuk dengan Google
        </a>
        </div>

    <div class="text-center">
        <a href="{{ route('public.index') }}" class="text-xs text-gray-400 hover:text-gray-600 font-medium">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Halaman Utama
        </a>
    </div>
</div>
@endsection
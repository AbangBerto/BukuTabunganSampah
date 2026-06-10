@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Desain Kotak Select2 yang rapi */
    .select2-container .select2-selection--single {
        height: 56px !important; 
        border-radius: 1rem !important; 
        border: 2px solid #e5e7eb !important; 
        background-color: #f9fafb !important; 
        display: flex;
        align-items: center;
        padding-left: 0.5rem;
        font-size: 0.875rem;
        font-weight: 700;
        color: #374151 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #374151 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 56px !important;
        right: 15px !important;
    }
    .select2-container--open .select2-selection--single {
        border-color: #22c55e !important; 
    }
    .select2-dropdown {
        border-radius: 1rem !important;
        border: 2px solid #22c55e !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .select2-search__field {
        border-radius: 0.5rem !important;
        padding: 10px !important;
        outline: none !important;
    }
    .select2-search__field:focus {
        border: 2px solid #22c55e !important;
    }
</style>

<div class="max-w-md mx-auto space-y-6 mt-10 relative z-10">
    
    <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100">
        <div class="text-center mb-6">
            <h2 class="text-xl font-black text-green-700">Cek Tabungan Warga</h2>
            <p class="text-xs text-gray-400 mt-1">Cari dan pilih nama Anda untuk melihat saldo</p>
        </div>
        
        @if(session('error_pin'))
            <div class="p-3 mb-5 text-sm font-bold text-red-800 rounded-xl bg-red-50 border border-red-200 text-center shadow-sm">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ session('error_pin') }}
            </div>
        @endif

        <form action="{{ route('public.checkPin') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="text-xs font-extrabold text-gray-400 uppercase tracking-wider ml-1">Nama Nasabah (Warga)</label>
                <div class="mt-1">
                    <select name="nasabah_id" id="cari-nama" required class="w-full">
                        <option value=""></option>
                        @foreach ($nasabahs as $nasabah)
                            <option value="{{ $nasabah->id }}">{{ $nasabah->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn-hijau w-full py-4 rounded-2xl text-base shadow-md mt-2">
                <i class="fa-solid fa-magnifying-glass mr-2"></i> Cek Saldo & Riwayat
            </button>
        </form>
    </div>

    <div class="pt-4">
        <a href="{{ route('login') }}" class="btn-gelap flex w-full py-4 rounded-2xl text-sm shadow-md justify-center items-center">
            <i class="fa-solid fa-lock mr-2 text-green-400"></i> Masuk sebagai Admin Desa
        </a>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cari-nama').select2({
            placeholder: "-- Ketik nama Anda di sini --",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Nama tidak ditemukan";
                }
            }
        });
    });
</script>
@endsection
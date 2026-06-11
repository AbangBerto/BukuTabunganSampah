@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="max-w-md mx-auto space-y-6 mt-10 relative z-10">
    
    <div class="bg-white rounded-3xl p-6 shadow-lg border border-gray-100">
        <div class="text-center mb-6">
            <h2 class="text-xl font-black text-green-700">Cek Tabungan Warga</h2>
            <p class="text-xs text-gray-400 mt-1">Cari dan pilih nama Anda untuk melihat saldo</p>
        </div>

        <form action="{{ route('public.checkSaldo') }}" method="POST" class="space-y-5">
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
@endsection

@push('scripts')
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
@endpush
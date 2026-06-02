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

    <button onclick="toggleModal('modalPin')" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 rounded-2xl text-sm shadow-md transition flex justify-center items-center">
        <i class="fa-solid fa-lock mr-2"></i> Ganti PIN Rahasia
    </button>

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

<div id="modalPin" class="{{ ($errors->any() || session('error_ubah_pin') || session('success_ubah_pin')) ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-60 px-4 transition-opacity">
    
    <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl relative overflow-hidden transform transition-all">
        
        <button onclick="toggleModal('modalPin')" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition focus:outline-none">
            <i class="fa-solid fa-circle-xmark text-2xl"></i>
        </button>

        <div class="p-6">
            <h3 class="text-lg font-black text-gray-800 text-center mb-5 border-b pb-4 border-gray-100">
                <i class="fa-solid fa-key text-yellow-500 mr-2"></i> Pengaturan PIN
            </h3>

            @if ($errors->any())
                <div class="p-3 mb-4 text-xs font-bold text-red-800 rounded-lg bg-red-50 border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success_ubah_pin'))
                <div class="p-3 mb-4 text-xs font-bold text-green-800 rounded-lg bg-green-50 border border-green-200">
                    <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success_ubah_pin') }}
                </div>
            @endif

            @if(session('error_ubah_pin'))
                <div class="p-3 mb-4 text-xs font-bold text-red-800 rounded-lg bg-red-50 border border-red-200">
                    <i class="fa-solid fa-circle-xmark mr-1"></i> {{ session('error_ubah_pin') }}
                </div>
            @endif

            <form action="{{ route('public.updatePin', $warga->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="text-xs font-extrabold text-gray-500 uppercase ml-1">PIN Lama Anda</label>
                    <input type="password" name="pin_lama" maxlength="6" inputmode="numeric" placeholder="Masukkan 6 digit PIN saat ini" required
                           class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-yellow-500 font-bold text-gray-700 mt-1 tracking-widest text-center">
                </div>

                <div>
                    <label class="text-xs font-extrabold text-gray-500 uppercase ml-1">PIN Baru (6 Angka Rahasia)</label>
                    <input type="password" name="pin_baru" maxlength="6" inputmode="numeric" placeholder="Buat 6 digit angka baru" required
                           class="w-full bg-yellow-50 border-2 border-yellow-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-yellow-500 font-bold text-yellow-700 mt-1 tracking-widest text-center">
                </div>

                <div>
                    <label class="text-xs font-extrabold text-gray-500 uppercase ml-1">Ketik Ulang PIN Baru</label>
                    <input type="password" name="pin_baru_confirmation" maxlength="6" inputmode="numeric" placeholder="Ketik ulang 6 digit angka di atas" required
                           class="w-full bg-yellow-50 border-2 border-yellow-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-yellow-500 font-bold text-yellow-700 mt-1 tracking-widest text-center">
                </div>

                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3.5 rounded-xl text-sm shadow-md transition mt-4">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan PIN
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModal(modalID) {
        var modal = document.getElementById(modalID);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
</script>
@endsection
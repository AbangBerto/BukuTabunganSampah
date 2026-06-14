@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="space-y-6">
    
    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
            <span class="font-bold">Berhasil!</span> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
            <span class="font-bold">Gagal Menyimpan Transaksi!</span> Cek kesalahan berikut:
            <ul class="list-disc pl-5 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200">
            <span class="font-bold">Gagal!</span> {{ session('error') }}
        </div>
    @endif

    <div class="flex gap-3 mt-3">
        <a href="{{ route('nasabah.index') }}" class="bg-green-600 hover:bg-green-700 text-white w-full flex justify-center items-center rounded-xl py-3 font-bold shadow-md transition">
            <i class="fa-solid fa-users mr-2"></i> Buka Data Warga
        </a>
        <a href="{{ route('admin.laporan') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white w-full text-center rounded-xl py-3 font-bold shadow-md transition">
            <i class="fa-solid fa-print mr-2"></i> Rekap Laporan
        </a>
    </div>

    <div class="w-full">
        <h2 class="text-lg font-black text-gray-800 mb-4 border-b border-gray-100 pb-3">
            <i class="fa-solid fa-user-shield text-green-600 mr-2"></i> Panel Admin Desa
        </h2>
        <div class="grid grid-cols-2 gap-3">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="btn-abu flex flex-col w-full py-3.5 rounded-xl shadow-sm text-center">
                    <i class="fa-solid fa-power-off mb-1 text-base text-red-600"></i>
                    <span class="text-[10px] font-bold uppercase">Keluar Akun</span>
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 mb-4"><i class="fa-solid fa-scale-balanced text-green-600 mr-2"></i> 2. Catat Setoran Sampah (Tambah Uang)</h3>
        <form action="{{ route('admin.storeTransaksi') }}" method="POST" class="space-y-3">
            @csrf
            
            <div class="w-full">
                <select name="nasabah_id" id="pilih-warga-setor" class="w-full" required>
                    <option value=""></option> 
                    @foreach ($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}">{{ $nasabah->nama }}</option>
                    @endforeach
                </select>
            </div>

            <select name="jenis_sampah" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-medium text-gray-700">
                <option value="Plastik">Sampah Plastik</option>
                <option value="Besi">Sampah Besi</option>
                <option value="Lainnya">Lainnya / Campur</option>
            </select>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Berat (Kg)</label>
                    <input type="number" step="0.01" name="berat" placeholder="Contoh: 2.5" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-bold text-green-700 mt-1">
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase ml-1">Uang (Rp)</label>
                    <input type="number" name="nominal" placeholder="Contoh: 15000" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-green-500 font-bold text-green-700 mt-1">
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

            <div class="w-full">
                <select name="nasabah_id" id="pilih-warga-tarik" class="w-full" required>
                    <option value=""></option> 
                    @foreach ($nasabahs as $nasabah)
                        <option value="{{ $nasabah->id }}">{{ $nasabah->nama }} (Saldo: Rp {{ number_format($nasabah->saldo, 0, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>

            <input type="number" name="nominal" placeholder="Jumlah Uang Diambil (Rp)" required class="w-full bg-gray-50 border-2 border-gray-200 px-4 py-3 rounded-xl text-sm focus:outline-none focus:border-red-500 font-bold text-red-600 mt-2">

            <button type="submit" class="btn-merah w-full py-3.5 rounded-xl text-sm shadow-md mt-2">
                <i class="fa-solid fa-minus mr-2"></i> Konfirmasi Penarikan
            </button>
        </form>
    </div> 
    
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <h3 class="text-sm font-extrabold text-gray-700 mb-4">
            <i class="fa-solid fa-clock-rotate-left text-blue-600 mr-2"></i> 4. Riwayat Transaksi Terakhir
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Nama Warga</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Keterangan</th>
                        <th class="px-4 py-3 text-right">Nominal</th>
                        <th class="px-4 py-3 text-center">Aksi</th> 
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $trx)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 font-bold text-gray-900">{{ $trx->nasabah->nama ?? 'Warga Dihapus' }}</td>
                        <td class="px-4 py-3">
                            @if($trx->jenis_transaksi == 'setor')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Setor</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">Tarik</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $trx->keterangan }}</td>
                        <td class="px-4 py-3 text-right font-bold {{ $trx->jenis_transaksi == 'setor' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $trx->jenis_transaksi == 'setor' ? '+' : '-' }} Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('admin.destroyTransaksi', $trx->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan transaksi ini? Saldo warga akan dikoreksi secara otomatis.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition rounded p-2" title="Batalkan Transaksi">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-400 font-medium">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5 border-t border-gray-100 pt-5">
            <a href="{{ route('admin.laporan') }}" class="btn-abu w-full py-3.5 rounded-xl text-sm shadow-sm inline-flex items-center justify-center font-extrabold hover:bg-gray-200 transition">
                Lihat History Lengkap & Filter Transaksi <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pilih-warga-setor').select2({
            placeholder: "-- Ketik & Cari Nama Warga --",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() { return "Nama tidak ditemukan"; }
            }
        });

        $('#pilih-warga-tarik').select2({
            placeholder: "-- Ketik & Cari Nama Warga --",
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() { return "Nama tidak ditemukan"; }
            }
        });
    });
</script>
@endpush
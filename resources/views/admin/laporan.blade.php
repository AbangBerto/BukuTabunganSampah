@extends('layouts.app')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center print:hidden mb-6 gap-4">
    <a href="{{ route('admin.dashboard') }}" class="btn-abu px-4 py-2 rounded-xl text-sm font-bold shadow-sm inline-flex items-center">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
    </a>

    <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
        <select name="bulan" onchange="this.form.submit()" class="bg-white border-2 border-gray-200 px-4 py-2 rounded-xl text-sm font-bold focus:outline-none focus:border-green-600 shadow-sm cursor-pointer">
            <option value="semua" {{ $bulanDipilih == 'semua' ? 'selected' : '' }}>Semua Riwayat (Tanpa Filter)</option>
            @foreach($daftarBulan as $angka => $nama)
                <option value="{{ $angka }}" {{ $bulanDipilih == $angka ? 'selected' : '' }}>
                    Bulan {{ $nama }}
                </option>
            @endforeach
        </select>

        <button type="button" onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md inline-flex items-center transition whitespace-nowrap">
            <i class="fa-solid fa-print mr-2"></i> Cetak Laporan
        </button>
    </form>
</div>

<div id="print-area" class="bg-white p-4">
    
    <div class="text-center pb-4 border-b-2 border-black mb-6">
        <h1 class="text-2xl font-black uppercase tracking-wider print-title">Laporan Keuangan Bank Sampah</h1>
        <p class="text-gray-600 font-medium print-subtitle">Desa Ngembringan</p>
        
        <p class="text-green-700 font-bold mt-1 text-lg print-subtitle print-text-black uppercase">
            Periode: {{ $bulanDipilih == 'semua' ? 'Semua Waktu' : $daftarBulan[$bulanDipilih] . ' ' . $tahunSekarang }}
        </p>
        
        <p class="text-sm text-gray-500 mt-2 print-date">Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="border-2 border-gray-200 rounded-xl p-4 text-center summary-box">
            <p class="text-xs font-bold text-gray-500 uppercase">Total Uang Masuk</p>
            <h2 class="text-xl font-black text-green-600 mt-1">Rp {{ number_format($totalUangMasuk, 0, ',', '.') }}</h2>
        </div>
        <div class="border-2 border-gray-200 rounded-xl p-4 text-center summary-box">
            <p class="text-xs font-bold text-gray-500 uppercase">Total Uang Keluar</p>
            <h2 class="text-xl font-black text-red-600 mt-1">Rp {{ number_format($totalUangKeluar, 0, ',', '.') }}</h2>
        </div>
        <div class="border-2 border-gray-200 rounded-xl p-4 text-center bg-gray-50 summary-box">
            <p class="text-xs font-bold text-gray-500 uppercase">Total Tabungan Warga</p>
            <h2 class="text-xl font-black text-gray-800 mt-1">Rp {{ number_format($totalSaldoWarga, 0, ',', '.') }}</h2>
        </div>
    </div>

    <div>
        <h3 class="font-bold text-gray-800 mb-3 uppercase text-sm">Rincian Seluruh Transaksi</h3>
        
        <table class="w-full border-collapse border border-gray-300 text-sm print-table">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-2 py-2 text-center w-10">No</th>
                    <th class="border border-gray-300 px-2 py-2 text-left w-24">Tanggal</th>
                    <th class="border border-gray-300 px-2 py-2 text-left">Nama Warga</th>
                    <th class="border border-gray-300 px-2 py-2 text-left w-20">Jenis</th>
                    <th class="border border-gray-300 px-2 py-2 text-left w-auto">Keterangan</th>
                    <th class="border border-gray-300 px-2 py-2 text-right w-28">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($semuaTransaksi as $index => $trx)
                <tr>
                    <td class="border border-gray-300 px-2 py-1 text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $trx->created_at->format('d/m/Y') }}</td>
                    <td class="border border-gray-300 px-2 py-1 font-bold">{{ $trx->nasabah->nama ?? 'Warga Dihapus' }}</td>
                    <td class="border border-gray-300 px-2 py-1 uppercase text-xs font-bold {{ $trx->jenis_transaksi == 'setor' ? 'text-green-600 print-text-black' : 'text-red-600 print-text-black' }}">
                        {{ $trx->jenis_transaksi }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">{{ $trx->keterangan }}</td>
                    <td class="border border-gray-300 px-2 py-1 text-right font-bold">
                        Rp {{ number_format($trx->nominal, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="border border-gray-300 px-2 py-4 text-center italic text-gray-500">Belum ada data transaksi untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-8 flex justify-end hidden print:flex">
            <div class="text-center mr-10">
                <p>Mengetahui,</p>
                <p class="mt-20 font-bold underline">Kepala Desa Ngembringan</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        /* 1. Atur Kertas Landscape dan margin mepet */
        @page { size: landscape; margin: 10mm; }

        /* 2. SEMBUNYIKAN SEMUA ELEMEN WEBSITE (Sidebar, navbar, background) */
        body * {
            visibility: hidden;
        }

        /* 3. MUNCULKAN HANYA KOTAK LAPORAN SAJA */
        #print-area, #print-area * {
            visibility: visible;
        }

        /* 4. Paksa kotak laporan berada di ujung kiri atas kertas */
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .print-table { width: 100% !important; table-layout: fixed; }
        .print-table th, .print-table td { 
            font-size: 11px !important; 
            padding: 4px !important; 
            word-wrap: break-word;
        }
        
        
        .print-text-black { color: black !important; }

        /* 7. Munculkan area tanda tangan */
        .print\:flex { display: flex !important; }
     
        .summary-box h2 { font-size: 16px !important; }
        .print-title { font-size: 20px !important; }
    }
</style>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 mt-6 mb-10 space-y-6">

    @if(session('success'))
        <div class="p-4 text-sm font-bold text-green-800 rounded-xl bg-green-50 border border-green-200 shadow-sm">
            <i class="fa-solid fa-circle-check mr-1"></i> {{ session('success') }}
        </div>
    @endif

    <div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold shadow transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden">
        
        <div class="bg-green-700 px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-white font-bold text-lg m-0">Daftar Nasabah (Warga)</h2>
            <button onclick="openModal()" class="bg-white text-green-700 hover:bg-gray-100 px-4 py-2 rounded-lg text-sm font-bold shadow transition w-full sm:w-auto flex justify-center items-center">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Warga
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700 min-w-[900px]">
                <thead class="bg-gray-50 text-gray-600 text-sm border-b-2 border-gray-200">
                    <tr>
                        <th class="px-4 py-4 text-center w-12">No</th>
                        <th class="px-4 py-4 w-48">Nama Lengkap</th>
                        <th class="px-4 py-4 w-64">Alamat</th>
                        <th class="px-4 py-4 w-32">No. HP</th>
                        <th class="px-4 py-4 w-40">Saldo Tabungan</th>
                        <th class="px-4 py-4 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($nasabahs as $index => $nasabah)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 font-bold text-gray-900">{{ $nasabah->nama }}</td>
                        <td class="px-4 py-3">{{ $nasabah->alamat ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $nasabah->no_hp ?? '-' }}</td>
                        <td class="px-4 py-3 font-bold text-green-700">Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}</td>
                        
                        <td class="px-4 py-3">
                            <div class="flex justify-center items-center gap-2">
                                
                                <a href="{{ route('nasabah.edit', $nasabah->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg text-xs font-bold transition flex items-center shadow-sm">
                                    Edit
                                </a>
                                
                                <form action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus permanen warga ini?')" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-xs font-bold transition flex items-center shadow-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500 font-medium">
                            Belum ada data warga terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="modalTambahWarga" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4 transition-opacity">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-2xl overflow-hidden relative border border-gray-200">
        <div class="bg-green-700 px-6 py-4 flex justify-between items-center">
            <h5 class="text-white font-bold text-lg">Form Tambah Warga</h5>
            <button onclick="closeModal()" class="text-green-200 hover:text-white transition focus:outline-none">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        
        <form action="{{ route('nasabah.store') }}" method="POST" class="p-6 space-y-4">
            @csrf 
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase ml-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" class="w-full border border-gray-300 px-4 py-3 rounded-lg text-sm focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 mt-1" required>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase ml-1">Alamat Rumah / RT</label>
                <textarea name="alamat" rows="2" class="w-full border border-gray-300 px-4 py-3 rounded-lg text-sm focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 mt-1"></textarea>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase ml-1">Nomor WhatsApp / HP</label>
                <input type="text" name="no_hp" class="w-full border border-gray-300 px-4 py-3 rounded-lg text-sm focus:outline-none focus:border-green-600 focus:ring-1 focus:ring-green-600 mt-1">
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeModal()" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 rounded-lg text-sm transition">Batal</button>
                <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-lg text-sm transition shadow">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() { document.getElementById('modalTambahWarga').classList.remove('hidden'); }
    function closeModal() { document.getElementById('modalTambahWarga').classList.add('hidden'); }
</script>
@endsection
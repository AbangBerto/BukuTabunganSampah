<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga - Bank Sampah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
            &larr; Kembali ke Dashboard Admin
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Daftar Nasabah (Warga)</h5>
            <button type="button" class="btn btn-light btn-sm fw-bold text-success shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahWarga">
                + Tambah Warga
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3" width="5%">No</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Alamat</th>
                            <th class="py-3">No. HP</th>
                            <th class="py-3">Saldo Tabungan</th>
                            <th class="text-center py-3" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nasabahs as $index => $nasabah)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $nasabah->nama }}</td>
                            <td>{{ $nasabah->alamat ?? '-' }}</td>
                            <td>{{ $nasabah->no_hp ?? '-' }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($nasabah->saldo, 0, ',', '.') }}</td>
                            
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    
                                    <a href="{{ route('nasabah.edit', $nasabah->id) }}" class="btn btn-warning btn-sm text-dark fw-bold" title="Edit Data">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('nasabah.resetPin', $nasabah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset PIN rahasia milik {{ $nasabah->nama }} kembali ke 123456?')">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm fw-bold" title="Reset PIN Warga">
                                            <i class="fa-solid fa-key"></i> Reset
                                        </button>
                                    </form>

                                    <form action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus warga ini? Semua riwayat transaksinya akan ikut terhapus permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm fw-bold" title="Hapus Data">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                Belum ada data warga yang terdaftar. <br> 
                                Silakan klik tombol <strong>+ Tambah Warga</strong> di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahWarga" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Form Tambah Warga</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('nasabah.store') }}" method="POST">
                @csrf 
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Alamat Rumah / RT</label>
                        <textarea name="alamat" class="form-control" rows="2" placeholder="Contoh: RT 01 / RW 02"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Nomor WhatsApp / HP</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Contoh: 08123456789">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
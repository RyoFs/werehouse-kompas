@extends('layouts.app')
@section('content')

{{-- 🔝 HEADER --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0">📦 Daftar Alat</h3>

    <div class="d-flex gap-2">
        {{-- ⬇️ DOWNLOAD TEMPLATE --}}
        <a href="{{ route('alat.template.download') }}" class="btn btn-success">
            ⬇️ Download Template Excel
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAlatModal">
            + Tambah Alat
        </button>
    </div>
</div>

{{-- 📥 IMPORT CSV --}}
<form action="{{ route('alat.import') }}" method="POST" enctype="multipart/form-data" class="card card-body mb-4">
    @csrf
    <div class="row g-2 align-items-end">
        <div class="col-md-6">
            <label class="form-label">Import Data Alat (CSV / Excel)</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-primary w-100">
                Import
            </button>
        </div>
    </div>
</form>

{{-- 🔍 FILTER & SEARCH --}}
<form method="GET" action="{{ route('alat.index') }}" class="filter-card mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold">
                🔍 Cari Alat
            </label>
            <input type="text"
                   name="search"
                   class="form-control filter-input"
                   placeholder="🔍 Kode atau nama alat"
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <label class="form-label fw-semibold">
                 Jenis Alat
            </label>
            <select name="jenis" class="form-select filter-select">
                <option value="">Semua Jenis</option>
                @foreach($jenisList as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                        {{ $jenis }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-success w-100 filter-btn">
                 Filter
            </button>
        </div>

        <div class="col-md-2">
            <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary w-100 filter-reset">
                 Reset
            </a>
        </div>
    </div>
</form>

{{-- 📋 TABEL --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Nama</th>
                        <th>Awal</th>
                        <th>Gudang</th>
                        <th>Selisih</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($alats as $a)
                    <tr>
                        <td>{{ $a->kode_alat }}</td>
                        <td>{{ $a->jenis_alat }}</td>
                        <td>{{ $a->nama_alat }}</td>
                        <td class="text-center">{{ $a->persediaan_awal }}</td>
                        <td class="text-center">{{ $a->persediaan_gudang }}</td>
                        <td class="text-center {{ $a->persediaan_awal - $a->persediaan_gudang > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $a->persediaan_awal - $a->persediaan_gudang }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <button class="btn btn-warning btn-sm edit-btn"
                                    data-id="{{ $a->id }}"
                                    data-kode="{{ $a->kode_alat }}"
                                    data-jenis="{{ $a->jenis_alat }}"
                                    data-nama="{{ $a->nama_alat }}"
                                    data-awal="{{ $a->persediaan_awal }}"
                                    data-gudang="{{ $a->persediaan_gudang }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAlatModal">
                                    ✏️
                                </button>

                                <form action="{{ route('alat.destroy', $a->id) }}"
                                    method="POST"
                                    class="d-inline form-delete">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data alat
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- 📄 PAGINATION --}}
<div class="mt-3">
    {{ $alats->links('pagination::bootstrap-5') }}
</div>

{{-- 🟢 MODAL TAMBAH --}}
<div class="modal fade" id="tambahAlatModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('alat.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Tambah Alat Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Kode Alat</label>
                    <input type="text" name="kode_alat" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Jenis Alat</label>
                    <input type="text" name="jenis_alat" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Alat</label>
                    <input type="text" name="nama_alat" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Persediaan Awal</label>
                    <input type="number" name="persediaan_awal" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Persediaan Gudang</label>
                    <input type="number" name="persediaan_gudang" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- 🟡 MODAL EDIT --}}
<div class="modal fade" id="editAlatModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="formEditAlat" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Edit Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="form-label">Kode Alat</label>
                    <input type="text" id="editKode" name="kode_alat" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Jenis Alat</label>
                    <input type="text" id="editJenis" name="jenis_alat" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Nama Alat</label>
                    <input type="text" id="editNama" name="nama_alat" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Persediaan Awal</label>
                    <input type="number" id="editAwal" name="persediaan_awal" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Persediaan Gudang</label>
                    <input type="number" id="editGudang" name="persediaan_gudang" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- 🧠 SCRIPT EDIT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-btn');
    const formEdit = document.getElementById('formEditAlat');
    const kode = document.getElementById('editKode');
    const jenis = document.getElementById('editJenis');
    const nama = document.getElementById('editNama');
    const awal = document.getElementById('editAwal');
    const gudang = document.getElementById('editGudang');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            formEdit.action = `{{ route('alat.update', ':id') }}`.replace(':id', id);
            kode.value = this.dataset.kode;
            jenis.value = this.dataset.jenis;
            nama.value = this.dataset.nama;
            awal.value = this.dataset.awal;
            gudang.value = this.dataset.gudang;
        });
    });
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.form-delete');

            Swal.fire({
                title: 'Yakin hapus alat?',
                text: 'Data alat yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>


@endsection

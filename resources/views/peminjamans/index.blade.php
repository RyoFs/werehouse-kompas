@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">📚 Peminjaman Alat</h3>
    <div class="d-flex gap-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#filterModal">🔍 Filter</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Reset</a>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">+ Tambah</a>
    </div>
</div>

{{-- 📋 TABEL PEMINJAMAN --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Peminjam</th>
                        <th>Alat Dipinjam</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($peminjamans as $p)
                @php
                    $today = \Carbon\Carbon::today('Asia/Jakarta');
                    $expired = $p->status === 'dipinjam'
                        && $p->tanggal_kembali
                        && $today->gt(\Carbon\Carbon::parse($p->tanggal_kembali));
                @endphp
                    <tr>
                        <td>{{ $p->nama_peminjam }}</td>
                        <td>
                            @foreach($p->details as $d)
                                - {{ $d->nama_alat }} --> ({{ $d->qty_dipinjam }}x)<br>
                            @endforeach
                        </td>
                        <td>
                            <div><strong>Pinjam:</strong>
                                {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="text-muted">
                                <strong>Estimasi Kembali:</strong>
                                {{ \Carbon\Carbon::parse($p->tanggal_kembali)->translatedFormat('l, d F Y') }}
                            </div>
                        </td>
                        <td>
                            @if($expired)
                                <span class="badge bg-danger">Terlambat</span>
                            @elseif($p->status == 'dipinjam')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Dikembalikan</span>
                            @endif
                        </td>

                        <td class="text-nowrap">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $p->id }}">ℹ️ Detail</button>
                            @if($p->status == 'dipinjam') 
                            <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="POST" class="d-inline form-kembalikan"> 
                                @csrf 
                                <button type="button"
                                    class="btn btn-success btn-sm btn-kembalikan"
                                    data-id="{{ $p->id }}">
                                    ✅ Kembalikan
                                </button> 
                            </form> 
                            @else <span class="text-muted">Selesai</span> @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada data peminjaman</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $peminjamans->links('pagination::bootstrap-5') }}
</div>

{{-- MODAL DETAIL --}}
@foreach($peminjamans as $p)
<div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered mb-4">
                    <tr>
                        <th>Tanggal Pinjam</th>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali</th>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Nama Peminjam</th>
                        <td>{{ $p->nama_peminjam }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $p->status == 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' }}">{{ ucfirst($p->status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $p->keterangan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dicatat Oleh</th>
                        <td>{{ $p->user->name ?? 'User ID '.$p->user_id }}</td>
                    </tr>
                </table>

                <h5 class="mb-2">📦 Daftar Barang Dipinjam</h5>
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">#</th>
                            <th>Kode Alat</th>
                            <th>Nama Alat</th>
                            <th width="15%">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($p->details as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->kode_alat }}</td>
                                <td>{{ $d->nama_alat }}</td>
                                <td>{{ $d->qty_dipinjam }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-danger">Tidak ada detail item.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- MODAL FILTER --}}
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="GET" action="{{ route('peminjaman.index') }}" class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Filter Data Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Cari Nama Alat / Peminjam</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Filter Berdasarkan</label>
                    <select name="date_type" class="form-select">
                        <option value="">-- Pilih Jenis Tanggal --</option>
                        <option value="tanggal_pinjam" {{ request('date_type') == 'tanggal_pinjam' ? 'selected' : '' }}>
                            Tanggal Pinjam
                        </option>
                        <option value="tanggal_kembali" {{ request('date_type') == 'tanggal_kembali' ? 'selected' : '' }}>
                            Tanggal Kembali
                        </option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <span class="text-muted">*Kosongkan jika tidak ingin memfilter berdasarkan tanggal</span>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Terapkan Filter</button>
                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.btn-kembalikan').forEach(button => {
    button.addEventListener('click', function () {
        const form = this.closest('td').querySelector('.form-kembalikan');

        Swal.fire({
            title: 'Konfirmasi Pengembalian',
            text: 'Yakin ingin mengembalikan alat ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, kembalikan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection

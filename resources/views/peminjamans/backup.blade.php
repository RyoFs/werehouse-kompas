@extends('layouts.app')
@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <h3 class="fw-bold mb-0">💾 Backup Data Peminjaman</h3>
    </div>

    {{-- INFO CARD --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-2">ℹ️ Informasi</h6>
            <ul class="mb-0 text-muted small">
                <li>Backup berisi data transaksi peminjaman alat</li>
                <li>Dapat difilter berdasarkan tanggal</li>
                <li>Format file: <strong>.xlsx</strong></li>
                <li>Data aman dan bisa digunakan untuk arsip / audit</li>
            </ul>
        </div>
    </div>

    {{-- BACKUP ACTION --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('peminjaman.export') }}" method="GET">
                <div class="row g-3 align-items-end">

                    {{-- JENIS TANGGAL --}}
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold">Jenis Tanggal</label>
                        <select name="date_type" class="form-select" required>
                            <option value="tanggal_pinjam">Tanggal Pinjam</option>
                            <option value="tanggal_kembali">Tanggal Kembali (Rencana)</option>
                            <option value="tanggal_kembali_real">Tanggal Kembali (Realisasi)</option>
                        </select>
                    </div>

                    {{-- TANGGAL DARI --}}
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold">Dari Tanggal</label>
                        <input type="date" name="date_from" class="form-control">
                    </div>

                    {{-- TANGGAL SAMPAI --}}
                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold">Sampai Tanggal</label>
                        <input type="date" name="date_to" class="form-control">
                    </div>
                    {{-- BUTTON --}}
                    <div class="col-12 col-md-3">
                        <button class="btn btn-success w-100">
                            ⬇️ Download Backup
                        </button>
                    </div>
                    <span class="text-muted small">*kosongkan tanggal jika ingin backup semua data <br>*jika ingin mengisi sesuai range tanggal, isi kedua kolom tanggal</span>
                    
                </div>
            </form>

        </div>
    </div>

</div>

@endsection

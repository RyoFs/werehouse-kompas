@extends('layouts.app')
@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <h3 class="fw-bold mb-0">💾 Backup Data Alat</h3>
    </div>

    {{-- INFO CARD --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-2">ℹ️ Informasi</h6>
            <ul class="mb-0 text-muted small">
                <li>Backup berisi seluruh data alat</li>
                <li>Format file: <strong>.xlsx</strong></li>
                <li>Data aman dan bisa di-restore kembali</li>
            </ul>
        </div>
    </div>

    {{-- BACKUP ACTION --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('alat.export') }}" method="GET">
                <div class="row g-3 align-items-end">
                    {{-- BUTTON --}}
                    <div class="col-12 col-md-3">
                        <button class="btn btn-success w-100">
                            ⬇️ Download Backup
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

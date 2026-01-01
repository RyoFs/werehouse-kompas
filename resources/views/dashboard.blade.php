@extends('layouts.app')

@section('content')

<style>
    .dashboard-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    }

    .dashboard-card i {
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover i {
        transform: scale(1.15);
    }
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">🏠 Dashboard</h3>
    </div>

    <div class="row g-4 mb-4">

        {{-- TOTAL ALAT --}}
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 bg-primary bg-opacity-10">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-primary fw-semibold">Total Alat</small>
                        <h2 class="fw-bold text-primary mb-0">{{ $totalAlat }}</h2>
                    </div>
                    <div class="fs-1 text-primary">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL PEMINJAMAN --}}
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 bg-success bg-opacity-10">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-success fw-semibold">Total Peminjaman</small>
                        <h2 class="fw-bold text-success mb-0">{{ $totalPeminjaman }}</h2>
                    </div>
                    <div class="fs-1 text-success">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL USER --}}
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 bg-warning bg-opacity-10">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-warning fw-semibold">Total User</small>
                        <h2 class="fw-bold text-warning mb-0">{{ $totalUser }}</h2>
                    </div>
                    <div class="fs-1 text-warning">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL DIPINJAM --}}
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 bg-danger bg-opacity-10">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-danger fw-semibold">Sedang Dipinjam</small>
                        <h2 class="fw-bold text-danger mb-0">{{ $totalDipinjam }}</h2>
                    </div>
                    <div class="fs-1 text-danger">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- TOTAL DIKEMBALIKAN --}}
        <div class="col-md-4">
            <div class="card dashboard-card shadow-sm border-0 bg-info bg-opacity-10">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-info fw-semibold">Sudah Dikembalikan</small>
                        <h2 class="fw-bold text-info mb-0">{{ $totalDikembalikan }}</h2>
                    </div>
                    <div class="fs-1 text-info">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

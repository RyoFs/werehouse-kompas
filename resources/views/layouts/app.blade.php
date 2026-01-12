<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Peminjaman Alat') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/content.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/alat.css') }}">

</head>
<body>
    <!-- Navbar atas -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand px-3" href="{{ route('dashboard') }}">📦 Peminjaman Alat</a>

            <div class="d-flex align-items-center me-3">
                @auth
                    <span class="text-light me-3">👤 {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-light text-dark">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 col-lg-2 sidebar p-3">
                <h6 class="text-light text-uppercase fw-bold mb-3">Menu Navigasi</h6>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
                <a href="{{ route('alat.index') }}" class="{{ request()->routeIs('alat.*') ? 'active' : '' }}">📋 Daftar Alat</a>
                <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">📦 Menu Peminjaman</a>
                <a href="{{ route('logs.index') }}" class="{{ request()->routeIs('logs.*') ? 'active' : '' }}">🕑 Log Aktivitas</a>
                <hr class="text-secondary">
                <a href="#" data-bs-toggle="collapse" data-bs-target="#submenu" aria-expanded="false">
                    ⚙️ Pengaturan
                </a>
                <div class="collapse ms-3" id="submenu">
                    <a href="{{ route('alat.backup') }}" class="small">📁 Backup Data Alat</a>
                    <a href="{{ route('peminjaman.backup') }}" class="small">📁 Backup Data Peminjaman</a>
                    <a href="{{ route('user.index') }}" class="small">👥 Kelola Pengguna</a>
                </div>
            </div>

            <!-- Konten utama -->
            <div class="col-md-10 col-lg-10 p-4">
                <div class="content">
                    {{-- SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- ERROR CUSTOM --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- VALIDATION ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</body>
</html>

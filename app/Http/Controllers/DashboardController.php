<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalAlat'        => Alat::count(),
            'totalPeminjaman'  => Peminjaman::count(),
            'totalUser'        => User::count(),

            // STATUS PEMINJAMAN
            'totalDipinjam'    => Peminjaman::where('status', 'dipinjam')->count(),
            'totalDikembalikan'=> Peminjaman::where('status', 'dikembalikan')->count(),
        ]);
    }

}

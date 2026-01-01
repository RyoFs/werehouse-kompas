<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Log;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\ActivityLog;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $alats = Alat::all();

        $peminjamans = Peminjaman::with(['details', 'user'])
            ->when($request->search, function ($q, $s) {
                $q->where('nama_peminjam', 'like', "%{$s}%")
                ->orWhereHas('details', function ($dq) use ($s) {
                    $dq->where('nama_alat', 'like', "%{$s}%")
                        ->orWhere('kode_alat', 'like', "%{$s}%");
                });
            })
            ->when($request->status, fn($q, $status) => $q->where('status', $status))

            // ✅ FILTER TANGGAL
            ->when(
                $request->date_type && ($request->date_from || $request->date_to),
                function ($q) use ($request) {
                    $q->whereBetween(
                        $request->date_type,
                        [
                            $request->date_from ?? '1900-01-01',
                            $request->date_to ?? now()->format('Y-m-d')
                        ]
                    );
                }
            )

            ->latest()
            ->paginate(100)
            ->withQueryString();

        return view('peminjamans.index', compact('peminjamans', 'alats'));
    }


    public function search(Request $request)
    {
        $query = Alat::query();
        if ($request->search) {
            $query->where('nama_alat', 'like', "%{$request->search}%")
                  ->orWhere('kode_alat', 'like', "%{$request->search}%");
        }

        return response()->json($query->get(['kode_alat','nama_alat','persediaan_gudang']));
    }

    public function create()
    {
        return view('peminjamans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'items' => 'required|array',
            'items.*.kode' => 'required|string',
            'items.*.nama' => 'required|string',
            'items.*.qty'  => 'required|numeric|min:1',
        ]);

        $peminjaman = Peminjaman::create([
            'tanggal_pinjam'  => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'nama_peminjam'  => $request->nama_peminjam,
            'status'         => 'dipinjam',
            'keterangan'     => $request->keterangan,
            'user_id'        => auth()->id() ?? 1,
        ]);

        foreach ($request->items as $item) {
            $alat = Alat::where('kode_alat', $item['kode'])->first();
            if (!$alat) continue;

            $alat->decrement('persediaan_gudang', $item['qty']);

            PeminjamanDetail::create([
                'peminjamans_id' => $peminjaman->id,
                'kode_alat'      => $item['kode'],
                'nama_alat'      => $item['nama'],
                'qty_dipinjam'   => $item['qty'],
            ]);
        }

        ActivityLog::add(
            "Mencatat peminjaman baru oleh: {$request->nama_peminjam} (ID Transaksi: {$peminjaman->id})"
        );

        return redirect()
        ->route('peminjaman.index')
        ->with('success', 'Peminjaman berhasil dicatat!');

    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Barang sudah dikembalikan sebelumnya.');
        }

        foreach ($peminjaman->details as $detail) {
            Alat::where('kode_alat', $detail->kode_alat)
                ->increment('persediaan_gudang', $detail->qty_dipinjam);
        }

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali_real' => now('Asia/Jakarta'),
        ]);

        ActivityLog::add(
            "Mencatat pengembalian alat untuk peminjaman (ID Transaksi: {$peminjaman->id}) oleh {$peminjaman->nama_peminjam}"
        );

        return back()->with('success', 'Pengembalian alat berhasil dicatat.');
    }
}

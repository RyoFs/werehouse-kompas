<?php

namespace App\Console\Commands;

use App\Models\Peminjaman;
use App\Models\Alat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;

class AutoReturnPeminjaman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:return-peminjaman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today('Asia/Jakarta');

        $peminjamans = Peminjaman::with('details')
            ->where('status', 'dipinjam')
            ->whereDate('tanggal_kembali', '<=', $today)
            ->get();

        foreach ($peminjamans as $peminjaman) {

            foreach ($peminjaman->details as $detail) {
                Alat::where('kode_alat', $detail->kode_alat)
                    ->increment('persediaan_gudang', $detail->qty_dipinjam);
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
            ]);
        }
    }
}

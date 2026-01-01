<?php

namespace App\Imports;

use App\Models\Alat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Pastikan data yang wajib ada
        if (!isset($row['kode_alat']) || !isset($row['nama_alat'])) {
            return null;
        }

        // update jika kode_alat sudah ada, atau buat baru
        $alat = Alat::updateOrCreate(
            ['kode_alat' => $row['kode_alat']],
            [
                'jenis_alat' => $row['jenis_alat'] ?? '-',
                'nama_alat' => $row['nama_alat'] ?? '-',
                'persediaan_awal' => $row['persediaan_awal'] ?? 0,
                'persediaan_gudang' => $row['persediaan_gudang'] ?? ($row['persediaan_awal'] ?? 0),
            ]
        );

        return $alat;
    }
}

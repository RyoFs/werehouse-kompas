<?php

namespace App\Exports;

use App\Models\Alat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AlatExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Alat::orderBy('kode_alat')->get();
    }

    public function headings(): array
    {
        return [
            'Kode Alat',
            'Jenis Alat',
            'Nama Alat',
            'Persediaan Awal',
            'Persediaan Gudang',
            'Selisih',
        ];
    }

    public function map($alat): array
    {
        return [
            $alat->kode_alat,
            $alat->jenis_alat,
            $alat->nama_alat,
            $alat->persediaan_awal,
            $alat->persediaan_gudang,
            $alat->persediaan_awal - $alat->persediaan_gudang,
        ];
    }
}

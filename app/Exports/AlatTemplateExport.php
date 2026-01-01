<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlatTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'kode_alat',
            'jenis_alat',
            'nama_alat',
            'persediaan_awal',
            'persediaan_gudang',
        ];
    }

    public function array(): array
    {
        return [
            [
                'ALT-001',
                'Elektronik',
                'Laptop',
                10,
                10
            ],
            [
                'ALT-002',
                'Perkakas',
                'Bor Listrik',
                5,
                5
            ]
        ];
    }

    
}

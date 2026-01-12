<?php

namespace App\Exports;

use App\Models\Alat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AlatExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
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
        $awal   = $alat->persediaan_awal ?? 0;
        $gudang = $alat->persediaan_gudang ?? 0;
        $selisih = $awal - $gudang;

        return [
            $alat->kode_alat,
            $alat->jenis_alat,
            $alat->nama_alat,
            $awal === 0 ? '0' : $awal,
            $gudang === 0 ? '0' : $gudang,
            $selisih === 0 ? '0' : $selisih,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /** 🔒 Freeze header */
                $sheet->freezePane('A2');

                /** 📐 AutoSize semua kolom */
                foreach (range('A', 'F') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }

                /** 🔍 Ambil baris terakhir */
                $highestRow = $sheet->getHighestRow();

                /** 🎯 Loop kolom SELISIH (kolom F) */
                for ($row = 2; $row <= $highestRow; $row++) {
                    $cell = 'F' . $row;
                    $value = $sheet->getCell($cell)->getValue();

                    if ($value != 0) {
                        $sheet->getStyle($cell)->applyFromArray([
                            'font' => [
                                'bold'  => true,
                                'color' => ['rgb' => 'FF0000'],
                            ],
                        ]);
                    }
                }

                /** 🎨 STYLE HEADER (A1:F1) */
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'color' => ['rgb' => 'FFFFFF'], // teks putih
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '1F4E78'], // biru elegan
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
            },
        ];
    }

}

<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class PeminjamanExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnWidths
{
    protected $dateType;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateType, $dateFrom = null, $dateTo = null)
    {
        $this->dateType = $dateType;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    public function collection()
    {
        return Peminjaman::with(['details', 'user'])
            ->when(
                $this->dateType && ($this->dateFrom || $this->dateTo),
                function ($q) {
                    $q->whereBetween(
                        $this->dateType,
                        [
                            $this->dateFrom ?? '1900-01-01',
                            $this->dateTo ?? now()->format('Y-m-d')
                        ]
                    );
                }
            )
            ->orderBy('id', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Peminjam',
            'Tanggal Pinjam',
            'Tanggal Kembali (Rencana)',
            'Tanggal Kembali (Realisasi)',
            'Daftar Alat',
            'Status',
            'Keterangan',
            'Jumlah Total',
            'Dicatat Oleh',
        ];
    }

    public function map($peminjaman): array
    {
        $alat = $peminjaman->details->map(function ($d) {
            return "- {$d->nama_alat} ({$d->kode_alat}) x {$d->qty_dipinjam}";
        })->implode("\n");

        $totalQty = $peminjaman->details->sum('qty_dipinjam');

        return [
            $peminjaman->id,
            $peminjaman->nama_peminjam,
            $peminjaman->tanggal_pinjam,
            $peminjaman->tanggal_kembali,
            $peminjaman->tanggal_kembali_real,
            $alat,
            $peminjaman->status,
            $peminjaman->keterangan,
            $totalQty,
            optional($peminjaman->user)->name,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Hitung kolom terakhir (A–J)
        $highestColumn = $sheet->getHighestColumn();
        $highestRow    = $sheet->getHighestRow();

        // Style header (baris 1)
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1F4E78'], // Biru elegan
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        // === DATA: KIRI ATAS (TOP-LEFT) ===
        $sheet->getStyle("A2:{$highestColumn}{$highestRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_TOP);
        // Wrap text khusus kolom Daftar Alat (H)
        $sheet->getStyle('F')->getAlignment()->setWrapText(true);

        // Freeze header
        $sheet->freezePane('A2');

        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, // ID Transaksi
            'B' => 22, // Nama Peminjam
            'C' => 16, // Tanggal Pinjam
            'D' => 24, // Tgl Kembali Rencana
            'E' => 25, // Tgl Kembali Realisasi
            'F' => 43, // Daftar Alat (DIBATASI)
            'G' => 14, // Status
            'H' => 25, // Keterangan
            'I' => 14, // Jumlah Total
            'J' => 20, // Dicatat Oleh
        ];
    }


}

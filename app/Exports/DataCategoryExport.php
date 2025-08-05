<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;

class DataCategoryExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $data;
    protected $category;
    protected $title;

    public function __construct($data, $category)
    {
        $this->data = collect($data);
        $this->category = $category;
        $this->title = $this->getCategoryTitle($category);
    }

    /**
     * Return collection of data
     */
    public function collection()
    {
        return $this->data->map(function ($item, $index) {
            if ($this->category === 'penduduk') {
                return [
                    'no' => $index + 1,
                    'nik' => $item['nik'] ?? '',
                    'nama' => $item['nama'] ?? '',
                    'kelamin' => $item['kelamin'] ?? '',
                    'lahir' => $item['lahir'] ?? '',
                    'alamat' => $item['alamat'] ?? '',
                    'status' => $this->getStatusText($item['status'] ?? ''),
                ];
            } elseif ($this->category === 'keuangan') {
                return [
                    'no' => $index + 1,
                    'kode' => $item['kode'] ?? '',
                    'program' => $item['program'] ?? '',
                    'anggaran' => $item['anggaran'] ?? '',
                    'realisasi' => $item['realisasi'] ?? '',
                    'status' => $this->getStatusText($item['status'] ?? ''),
                ];
            } else {
                // Generic format for other categories
                return [
                    'no' => $index + 1,
                    'id' => $item['id'] ?? '',
                    'nama' => $item['nama'] ?? '',
                    'kategori' => $item['kategori'] ?? '',
                    'tanggal' => $item['tanggal'] ?? '',
                    'nilai' => $item['nilai'] ?? '',
                    'status' => $this->getStatusText($item['status'] ?? ''),
                ];
            }
        });
    }

    /**
     * Define headings for Excel
     */
    public function headings(): array
    {
        if ($this->category === 'penduduk') {
            return [
                'No',
                'NIK',
                'Nama Lengkap',
                'Jenis Kelamin',
                'Tanggal Lahir',
                'Alamat',
                'Status'
            ];
        } elseif ($this->category === 'keuangan') {
            return [
                'No',
                'Kode Program',
                'Nama Program',
                'Anggaran',
                'Realisasi',
                'Status'
            ];
        } else {
            return [
                'No',
                'ID',
                'Nama',
                'Kategori',
                'Tanggal',
                'Nilai',
                'Status'
            ];
        }
    }

    /**
     * Apply styles to worksheet
     */
    public function styles(Worksheet $sheet)
    {
        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(12);

        // Header styles
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '11998E'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Data styles
        $lastRow = $this->data->count() + 1;
        $sheet->getStyle('A2:G' . $lastRow)->applyFromArray([
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
        ]);

        // Center align number column
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Add title
        $sheet->insertNewRowBefore(1, 2);
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'DATA ' . strtoupper($this->title));
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '2C3E50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Add export info
        $sheet->insertNewRowBefore(2, 1);
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Diekspor pada: ' . now()->format('d/m/Y H:i:s') . ' | Desa Sosopan');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'size' => 10,
                'color' => ['rgb' => '666666'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        return [];
    }

    /**
     * Set worksheet title
     */
    public function title(): string
    {
        return 'Data ' . $this->title;
    }

    /**
     * Get category title
     */
    private function getCategoryTitle($category): string
    {
        $titles = [
            'penduduk' => 'Penduduk',
            'keuangan' => 'Keuangan',
            'pembangunan' => 'Pembangunan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'ekonomi' => 'Ekonomi',
        ];

        return $titles[$category] ?? ucfirst($category);
    }

    /**
     * Convert status to readable text
     */
    private function getStatusText($status): string
    {
        $statusMap = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'pending' => 'Pending',
        ];

        return $statusMap[$status] ?? $status;
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Collection;

class APBDesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle, ShouldAutoSize
{
    protected $data;
    protected $tahunAnggaran;
    protected $year;

    public function __construct($data, $tahunAnggaran, $year)
    {
        $this->data = $data;
        $this->tahunAnggaran = $tahunAnggaran;
        $this->year = $year;
    }

    public function collection()
    {
        $rows = collect();

        // Header Info
        $rows->push(['ANGGARAN PENDAPATAN DAN BELANJA DESA (APBDes)', '', '', '']);
        $rows->push(['TAHUN ANGGARAN ' . $this->year, '', '', '']);
        $rows->push(['Desa Sosopan - Kecamatan Padang Bolak - Kabupaten Padang Lawas Utara', '', '', '']);
        $rows->push(['', '', '', '']); // Empty row

        // Info Detail
        $rows->push(['Tahun Anggaran:', $this->tahunAnggaran->tahun, 'Tanggal Generate:', now()->format('d/m/Y H:i:s')]);
        $rows->push(['Petugas Keuangan:', $this->tahunAnggaran->nama_petugas_keuangan ?? 'Tidak Diketahui', '', '']);
        $rows->push(['', '', '', '']); // Empty row

        // 1. PENDAPATAN DESA
        $rows->push(['1. PENDAPATAN DESA', '', '', '']);
        
        // Pendapatan Asli Desa
        $pad_rencana = ($this->data->hasil_usaha_rencana ?? 0) + ($this->data->hasil_aset_rencana ?? 0) + ($this->data->swadaya_rencana ?? 0);
        $pad_realisasi = ($this->data->hasil_usaha_realisasi ?? 0) + ($this->data->hasil_aset_realisasi ?? 0) + ($this->data->swadaya_realisasi ?? 0);
        $pad_selisih = $pad_realisasi - $pad_rencana;

        $rows->push(['PENDAPATAN ASLI DESA', $this->formatCurrency($pad_rencana), $this->formatCurrency($pad_realisasi), $this->formatCurrency($pad_selisih)]);
        $rows->push(['  Hasil Usaha', $this->formatCurrency($this->data->hasil_usaha_rencana ?? 0), $this->formatCurrency($this->data->hasil_usaha_realisasi ?? 0), $this->formatCurrency(($this->data->hasil_usaha_realisasi ?? 0) - ($this->data->hasil_usaha_rencana ?? 0))]);
        $rows->push(['  Hasil Aset', $this->formatCurrency($this->data->hasil_aset_rencana ?? 0), $this->formatCurrency($this->data->hasil_aset_realisasi ?? 0), $this->formatCurrency(($this->data->hasil_aset_realisasi ?? 0) - ($this->data->hasil_aset_rencana ?? 0))]);
        $rows->push(['  Swadaya, Partisipasi, Gotong Royong', $this->formatCurrency($this->data->swadaya_rencana ?? 0), $this->formatCurrency($this->data->swadaya_realisasi ?? 0), $this->formatCurrency(($this->data->swadaya_realisasi ?? 0) - ($this->data->swadaya_rencana ?? 0))]);

        // Pendapatan Transfer
        $transfer_rencana = ($this->data->dana_desa_rencana ?? 0) + ($this->data->bagi_hasil_pajak_rencana ?? 0) + ($this->data->alokasi_dana_desa_rencana ?? 0) + ($this->data->bantuan_keuangan_kab_rencana ?? 0) + ($this->data->bantuan_keuangan_prov_rencana ?? 0);
        $transfer_realisasi = ($this->data->dana_desa_realisasi ?? 0) + ($this->data->bagi_hasil_pajak_realisasi ?? 0) + ($this->data->alokasi_dana_desa_realisasi ?? 0) + ($this->data->bantuan_keuangan_kab_realisasi ?? 0) + ($this->data->bantuan_keuangan_prov_realisasi ?? 0);
        $transfer_selisih = $transfer_realisasi - $transfer_rencana;

        $rows->push(['PENDAPATAN TRANSFER', $this->formatCurrency($transfer_rencana), $this->formatCurrency($transfer_realisasi), $this->formatCurrency($transfer_selisih)]);
        $rows->push(['  Dana Desa', $this->formatCurrency($this->data->dana_desa_rencana ?? 0), $this->formatCurrency($this->data->dana_desa_realisasi ?? 0), $this->formatCurrency(($this->data->dana_desa_realisasi ?? 0) - ($this->data->dana_desa_rencana ?? 0))]);
        $rows->push(['  Bagi Hasil Pajak & Retribusi', $this->formatCurrency($this->data->bagi_hasil_pajak_rencana ?? 0), $this->formatCurrency($this->data->bagi_hasil_pajak_realisasi ?? 0), $this->formatCurrency(($this->data->bagi_hasil_pajak_realisasi ?? 0) - ($this->data->bagi_hasil_pajak_rencana ?? 0))]);
        $rows->push(['  Alokasi Dana Desa', $this->formatCurrency($this->data->alokasi_dana_desa_rencana ?? 0), $this->formatCurrency($this->data->alokasi_dana_desa_realisasi ?? 0), $this->formatCurrency(($this->data->alokasi_dana_desa_realisasi ?? 0) - ($this->data->alokasi_dana_desa_rencana ?? 0))]);
        $rows->push(['  Bantuan Keuangan Kabupaten', $this->formatCurrency($this->data->bantuan_keuangan_kab_rencana ?? 0), $this->formatCurrency($this->data->bantuan_keuangan_kab_realisasi ?? 0), $this->formatCurrency(($this->data->bantuan_keuangan_kab_realisasi ?? 0) - ($this->data->bantuan_keuangan_kab_rencana ?? 0))]);
        $rows->push(['  Bantuan Keuangan Provinsi', $this->formatCurrency($this->data->bantuan_keuangan_prov_rencana ?? 0), $this->formatCurrency($this->data->bantuan_keuangan_prov_realisasi ?? 0), $this->formatCurrency(($this->data->bantuan_keuangan_prov_realisasi ?? 0) - ($this->data->bantuan_keuangan_prov_rencana ?? 0))]);

        // Pendapatan Lain-lain
        $lain_rencana = ($this->data->hibah_rencana ?? 0) + ($this->data->sumbangan_pihak_ketiga_rencana ?? 0) + ($this->data->pendapatan_lain_rencana ?? 0);
        $lain_realisasi = ($this->data->hibah_realisasi ?? 0) + ($this->data->sumbangan_pihak_ketiga_realisasi ?? 0) + ($this->data->pendapatan_lain_realisasi ?? 0);
        $lain_selisih = $lain_realisasi - $lain_rencana;

        $rows->push(['PENDAPATAN LAIN-LAIN', $this->formatCurrency($lain_rencana), $this->formatCurrency($lain_realisasi), $this->formatCurrency($lain_selisih)]);
        $rows->push(['  Hibah', $this->formatCurrency($this->data->hibah_rencana ?? 0), $this->formatCurrency($this->data->hibah_realisasi ?? 0), $this->formatCurrency(($this->data->hibah_realisasi ?? 0) - ($this->data->hibah_rencana ?? 0))]);
        $rows->push(['  Sumbangan Pihak Ketiga', $this->formatCurrency($this->data->sumbangan_pihak_ketiga_rencana ?? 0), $this->formatCurrency($this->data->sumbangan_pihak_ketiga_realisasi ?? 0), $this->formatCurrency(($this->data->sumbangan_pihak_ketiga_realisasi ?? 0) - ($this->data->sumbangan_pihak_ketiga_rencana ?? 0))]);
        $rows->push(['  Pendapatan Lain-lain', $this->formatCurrency($this->data->pendapatan_lain_rencana ?? 0), $this->formatCurrency($this->data->pendapatan_lain_realisasi ?? 0), $this->formatCurrency(($this->data->pendapatan_lain_realisasi ?? 0) - ($this->data->pendapatan_lain_rencana ?? 0))]);

        // Total Pendapatan
        $total_pendapatan_rencana = $pad_rencana + $transfer_rencana + $lain_rencana;
        $total_pendapatan_realisasi = $pad_realisasi + $transfer_realisasi + $lain_realisasi;
        $total_pendapatan_selisih = $total_pendapatan_realisasi - $total_pendapatan_rencana;
        $rows->push(['TOTAL PENDAPATAN', $this->formatCurrency($total_pendapatan_rencana), $this->formatCurrency($total_pendapatan_realisasi), $this->formatCurrency($total_pendapatan_selisih)]);

        $rows->push(['', '', '', '']); // Empty row

        // 2. BELANJA DESA
        $rows->push(['2. BELANJA DESA', '', '', '']);
        $rows->push(['Penyelenggaraan Pemerintahan Desa', $this->formatCurrency($this->data->penyelenggaraan_pemerintahan_desa_rencana ?? 0), $this->formatCurrency($this->data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0), $this->formatCurrency(($this->data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0) - ($this->data->penyelenggaraan_pemerintahan_desa_rencana ?? 0))]);
        $rows->push(['Pelaksanaan Pembangunan Desa', $this->formatCurrency($this->data->pelaksanaan_pembangunan_desa_rencana ?? 0), $this->formatCurrency($this->data->pelaksanaan_pembangunan_desa_realisasi ?? 0), $this->formatCurrency(($this->data->pelaksanaan_pembangunan_desa_realisasi ?? 0) - ($this->data->pelaksanaan_pembangunan_desa_rencana ?? 0))]);
        $rows->push(['Pembinaan Kemasyarakatan Desa', $this->formatCurrency($this->data->pembinaan_kemasyarakatan_desa_rencana ?? 0), $this->formatCurrency($this->data->pembinaan_kemasyarakatan_desa_realisasi ?? 0), $this->formatCurrency(($this->data->pembinaan_kemasyarakatan_desa_realisasi ?? 0) - ($this->data->pembinaan_kemasyarakatan_desa_rencana ?? 0))]);
        $rows->push(['Pemberdayaan Masyarakat Desa', $this->formatCurrency($this->data->pemberdayaan_masyarakat_desa_rencana ?? 0), $this->formatCurrency($this->data->pemberdayaan_masyarakat_desa_realisasi ?? 0), $this->formatCurrency(($this->data->pemberdayaan_masyarakat_desa_realisasi ?? 0) - ($this->data->pemberdayaan_masyarakat_desa_rencana ?? 0))]);
        $rows->push(['Belanja Tak Terduga', $this->formatCurrency($this->data->belanja_tak_terduga_rencana ?? 0), $this->formatCurrency($this->data->belanja_tak_terduga_realisasi ?? 0), $this->formatCurrency(($this->data->belanja_tak_terduga_realisasi ?? 0) - ($this->data->belanja_tak_terduga_rencana ?? 0))]);

        // Total Belanja
        $total_belanja_rencana = ($this->data->penyelenggaraan_pemerintahan_desa_rencana ?? 0) + ($this->data->pelaksanaan_pembangunan_desa_rencana ?? 0) + ($this->data->pembinaan_kemasyarakatan_desa_rencana ?? 0) + ($this->data->pemberdayaan_masyarakat_desa_rencana ?? 0) + ($this->data->belanja_tak_terduga_rencana ?? 0);
        $total_belanja_realisasi = ($this->data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0) + ($this->data->pelaksanaan_pembangunan_desa_realisasi ?? 0) + ($this->data->pembinaan_kemasyarakatan_desa_realisasi ?? 0) + ($this->data->pemberdayaan_masyarakat_desa_realisasi ?? 0) + ($this->data->belanja_tak_terduga_realisasi ?? 0);
        $total_belanja_selisih = $total_belanja_realisasi - $total_belanja_rencana;
        $rows->push(['TOTAL BELANJA', $this->formatCurrency($total_belanja_rencana), $this->formatCurrency($total_belanja_realisasi), $this->formatCurrency($total_belanja_selisih)]);

        $rows->push(['', '', '', '']); // Empty row

        // 3. PEMBIAYAAN DESA
        $rows->push(['3. PEMBIAYAAN DESA', '', '', '']);

        // Penerimaan Pembiayaan
        $penerimaan_rencana = ($this->data->silpa_rencana ?? 0) + ($this->data->pencairan_dana_cadangan_rencana ?? 0) + ($this->data->hasil_penjualan_kekayaan_rencana ?? 0);
        $penerimaan_realisasi = ($this->data->silpa_realisasi ?? 0) + ($this->data->pencairan_dana_cadangan_realisasi ?? 0) + ($this->data->hasil_penjualan_kekayaan_realisasi ?? 0);
        $penerimaan_selisih = $penerimaan_realisasi - $penerimaan_rencana;

        $rows->push(['PENERIMAAN PEMBIAYAAN', $this->formatCurrency($penerimaan_rencana), $this->formatCurrency($penerimaan_realisasi), $this->formatCurrency($penerimaan_selisih)]);
        $rows->push(['  SILPA', $this->formatCurrency($this->data->silpa_rencana ?? 0), $this->formatCurrency($this->data->silpa_realisasi ?? 0), $this->formatCurrency(($this->data->silpa_realisasi ?? 0) - ($this->data->silpa_rencana ?? 0))]);
        $rows->push(['  Pencairan Dana Cadangan', $this->formatCurrency($this->data->pencairan_dana_cadangan_rencana ?? 0), $this->formatCurrency($this->data->pencairan_dana_cadangan_realisasi ?? 0), $this->formatCurrency(($this->data->pencairan_dana_cadangan_realisasi ?? 0) - ($this->data->pencairan_dana_cadangan_rencana ?? 0))]);
        $rows->push(['  Hasil penjualan kekayaan Desa', $this->formatCurrency($this->data->hasil_penjualan_kekayaan_rencana ?? 0), $this->formatCurrency($this->data->hasil_penjualan_kekayaan_realisasi ?? 0), $this->formatCurrency(($this->data->hasil_penjualan_kekayaan_realisasi ?? 0) - ($this->data->hasil_penjualan_kekayaan_rencana ?? 0))]);

        // Pengeluaran Pembiayaan
        $pengeluaran_rencana = ($this->data->pembentukan_dana_cadangan_rencana ?? 0) + ($this->data->penyertaan_modal_desa_rencana ?? 0);
        $pengeluaran_realisasi = ($this->data->pembentukan_dana_cadangan_realisasi ?? 0) + ($this->data->penyertaan_modal_desa_realisasi ?? 0);
        $pengeluaran_selisih = $pengeluaran_realisasi - $pengeluaran_rencana;

        $rows->push(['PENGELUARAN PEMBIAYAAN', $this->formatCurrency($pengeluaran_rencana), $this->formatCurrency($pengeluaran_realisasi), $this->formatCurrency($pengeluaran_selisih)]);
        $rows->push(['  Pembentukan Dana Cadangan', $this->formatCurrency($this->data->pembentukan_dana_cadangan_rencana ?? 0), $this->formatCurrency($this->data->pembentukan_dana_cadangan_realisasi ?? 0), $this->formatCurrency(($this->data->pembentukan_dana_cadangan_realisasi ?? 0) - ($this->data->pembentukan_dana_cadangan_rencana ?? 0))]);
        $rows->push(['  Penyertaan Modal Desa', $this->formatCurrency($this->data->penyertaan_modal_desa_rencana ?? 0), $this->formatCurrency($this->data->penyertaan_modal_desa_realisasi ?? 0), $this->formatCurrency(($this->data->penyertaan_modal_desa_realisasi ?? 0) - ($this->data->penyertaan_modal_desa_rencana ?? 0))]);

        // Total Pembiayaan
        $total_pembiayaan_rencana = $penerimaan_rencana - $pengeluaran_rencana;
        $total_pembiayaan_realisasi = $penerimaan_realisasi - $pengeluaran_realisasi;
        $total_pembiayaan_selisih = $total_pembiayaan_realisasi - $total_pembiayaan_rencana;
        $rows->push(['TOTAL PEMBIAYAAN', $this->formatCurrency($total_pembiayaan_rencana), $this->formatCurrency($total_pembiayaan_realisasi), $this->formatCurrency($total_pembiayaan_selisih)]);

        $rows->push(['', '', '', '']); // Empty row

        // RINGKASAN
        $rows->push(['RINGKASAN ANGGARAN', '', '', '']);
        $rows->push(['Total Pendapatan', $this->formatCurrency($total_pendapatan_rencana), $this->formatCurrency($total_pendapatan_realisasi), $total_pendapatan_rencana > 0 ? round(($total_pendapatan_realisasi / $total_pendapatan_rencana) * 100, 2) . '%' : '0%']);
        $rows->push(['Total Belanja', $this->formatCurrency($total_belanja_rencana), $this->formatCurrency($total_belanja_realisasi), $total_belanja_rencana > 0 ? round(($total_belanja_realisasi / $total_belanja_rencana) * 100, 2) . '%' : '0%']);
        $rows->push(['Total Pembiayaan', $this->formatCurrency($total_pembiayaan_rencana), $this->formatCurrency($total_pembiayaan_realisasi), '-']);
        $rows->push(['Saldo Anggaran', $this->formatCurrency($total_pendapatan_rencana - $total_belanja_rencana + $total_pembiayaan_rencana), $this->formatCurrency($total_pendapatan_realisasi - $total_belanja_realisasi + $total_pembiayaan_realisasi), '-']);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Uraian',
            'Anggaran (Rp)',
            'Realisasi (Rp)', 
            'Lebih/(Kurang) (Rp)'
        ];
    }

    public function title(): string
    {
        return 'APBDes ' . $this->year;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 20,
            'D' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style for header
        $sheet->getStyle('A1:D3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'E3F2FD']]
        ]);

        // Style for column headers
        $sheet->getStyle('A8:D8')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => 'F8F9FA']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Apply borders to all data
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A8:D' . $highestRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        // Right align currency columns
        $sheet->getStyle('B:D')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        return [];
    }

    private function formatCurrency($amount)
    {
        if ($amount == 0) return '0';
        return number_format($amount, 0, ',', '.');
    }
}
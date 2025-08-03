<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>APBDes {{ $year }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
            border: 1px solid #ccc;
        }

        .info-label {
            background: #f0f0f0;
            font-weight: bold;
            width: 30%;
        }

        .section-title {
            background: #f0f0f0;
            padding: 10px;
            font-weight: bold;
            font-size: 14px;
            margin: 20px 0 10px 0;
            border: 1px solid #ccc;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        .data-table th {
            background: #f8f9fa;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }

        .currency {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .main-category {
            background: #e3f2fd;
            font-weight: bold;
        }

        .sub-item {
            padding-left: 20px;
        }

        .total-row {
            background: #fff3cd;
            font-weight: bold;
            border-top: 2px solid #856404;
        }

        .summary-section {
            margin-top: 30px;
            border-top: 2px solid #333;
            padding-top: 15px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }

        .positive {
            color: #28a745;
        }

        .negative {
            color: #dc3545;
        }

        .zero {
            color: #6c757d;
        }

        @page {
            margin: 2cm;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>ANGGARAN PENDAPATAN DAN BELANJA DESA (APBDes)</h1>
        <h2>TAHUN ANGGARAN {{ $year }}</h2>
        <p>Desa {{ $nama_desa }} - Kecamatan {{ $nama_kecamatan }} - Kabupaten {{ $nama_kabupaten }}</p>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="info-label">Tahun Anggaran</td>
                <td>{{ $tahunAnggaran->tahun }}</td>
                <td class="info-label">Tanggal Cetak</td>
                <td>{{ $generatedAt }}</td>
            </tr>
            <tr>
                <td class="info-label">Petugas Keuangan</td>
                <td>{{ $tahunAnggaran->nama_petugas_keuangan ?? 'Tidak Diketahui' }}</td>
                <td class="info-label">Status</td>
                <td>Laporan Resmi</td>
            </tr>
        </table>
    </div>

    <!-- 1. PENDAPATAN DESA -->
    <div class="section-title">1. PENDAPATAN DESA</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50%;">Uraian</th>
                <th style="width: 16.67%;">Anggaran (Rp)</th>
                <th style="width: 16.67%;">Realisasi (Rp)</th>
                <th style="width: 16.67%;">Lebih/(Kurang) (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Pendapatan Asli Desa -->
            @php
                $pad_rencana =
                    ($data->hasil_usaha_rencana ?? 0) +
                    ($data->hasil_aset_rencana ?? 0) +
                    ($data->swadaya_rencana ?? 0);
                $pad_realisasi =
                    ($data->hasil_usaha_realisasi ?? 0) +
                    ($data->hasil_aset_realisasi ?? 0) +
                    ($data->swadaya_realisasi ?? 0);
                $pad_selisih = $pad_realisasi - $pad_rencana;
            @endphp
            <tr class="main-category">
                <td>PENDAPATAN ASLI DESA</td>
                <td class="currency">{{ number_format($pad_rencana, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($pad_realisasi, 0, ',', '.') }}</td>
                <td class="currency {{ $pad_selisih > 0 ? 'positive' : ($pad_selisih < 0 ? 'negative' : 'zero') }}">
                    {{ number_format($pad_selisih, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="sub-item">Hasil Usaha</td>
                <td class="currency">{{ number_format($data->hasil_usaha_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->hasil_usaha_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->hasil_usaha_realisasi ?? 0) - ($data->hasil_usaha_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="sub-item">Hasil Aset</td>
                <td class="currency">{{ number_format($data->hasil_aset_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->hasil_aset_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->hasil_aset_realisasi ?? 0) - ($data->hasil_aset_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="sub-item">Swadaya, Partisipasi, Gotong Royong</td>
                <td class="currency">{{ number_format($data->swadaya_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->swadaya_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->swadaya_realisasi ?? 0) - ($data->swadaya_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>

            <!-- Pendapatan Transfer -->
            @php
                $transfer_rencana =
                    ($data->dana_desa_rencana ?? 0) +
                    ($data->bagi_hasil_pajak_rencana ?? 0) +
                    ($data->alokasi_dana_desa_rencana ?? 0) +
                    ($data->bantuan_keuangan_kab_rencana ?? 0) +
                    ($data->bantuan_keuangan_prov_rencana ?? 0);
                $transfer_realisasi =
                    ($data->dana_desa_realisasi ?? 0) +
                    ($data->bagi_hasil_pajak_realisasi ?? 0) +
                    ($data->alokasi_dana_desa_realisasi ?? 0) +
                    ($data->bantuan_keuangan_kab_realisasi ?? 0) +
                    ($data->bantuan_keuangan_prov_realisasi ?? 0);
                $transfer_selisih = $transfer_realisasi - $transfer_rencana;
            @endphp
            <tr class="main-category">
                <td>PENDAPATAN TRANSFER</td>
                <td class="currency">{{ number_format($transfer_rencana, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($transfer_realisasi, 0, ',', '.') }}</td>
                <td
                    class="currency {{ $transfer_selisih > 0 ? 'positive' : ($transfer_selisih < 0 ? 'negative' : 'zero') }}">
                    {{ number_format($transfer_selisih, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="sub-item">Dana Desa</td>
                <td class="currency">{{ number_format($data->dana_desa_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->dana_desa_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->dana_desa_realisasi ?? 0) - ($data->dana_desa_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="sub-item">Bagi Hasil Pajak & Retribusi</td>
                <td class="currency">{{ number_format($data->bagi_hasil_pajak_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->bagi_hasil_pajak_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->bagi_hasil_pajak_realisasi ?? 0) - ($data->bagi_hasil_pajak_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="sub-item">Alokasi Dana Desa</td>
                <td class="currency">{{ number_format($data->alokasi_dana_desa_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->alokasi_dana_desa_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->alokasi_dana_desa_realisasi ?? 0) - ($data->alokasi_dana_desa_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="sub-item">Bantuan Keuangan Kabupaten</td>
                <td class="currency">{{ number_format($data->bantuan_keuangan_kab_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->bantuan_keuangan_kab_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->bantuan_keuangan_kab_realisasi ?? 0) - ($data->bantuan_keuangan_kab_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="sub-item">Bantuan Keuangan Provinsi</td>
                <td class="currency">{{ number_format($data->bantuan_keuangan_prov_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->bantuan_keuangan_prov_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->bantuan_keuangan_prov_realisasi ?? 0) - ($data->bantuan_keuangan_prov_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>

            <!-- Pendapatan Lain-lain -->
            @php
                $lain_rencana =
                    ($data->hibah_rencana ?? 0) +
                    ($data->sumbangan_pihak_ketiga_rencana ?? 0) +
                    ($data->pendapatan_lain_rencana ?? 0);
                $lain_realisasi =
                    ($data->hibah_realisasi ?? 0) +
                    ($data->sumbangan_pihak_ketiga_realisasi ?? 0) +
                    ($data->pendapatan_lain_realisasi ?? 0);
                $lain_selisih = $lain_realisasi - $lain_rencana;
            @endphp
            <tr class="main-category">
                <td>PENDAPATAN LAIN-LAIN</td>
                <td class="currency">{{ number_format($lain_rencana, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($lain_realisasi, 0, ',', '.') }}</td>
                <td class="currency {{ $lain_selisih > 0 ? 'positive' : ($lain_selisih < 0 ? 'negative' : 'zero') }}">
                    {{ number_format($lain_selisih, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="sub-item">Hibah</td>
                <td class="currency">{{ number_format($data->hibah_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->hibah_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->hibah_realisasi ?? 0) - ($data->hibah_rencana ?? 0), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="sub-item">Sumbangan Pihak Ketiga</td>
                <td class="currency">{{ number_format($data->sumbangan_pihak_ketiga_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->sumbangan_pihak_ketiga_realisasi ?? 0, 0, ',', '.') }}
                </td>
                <td class="currency">
                    {{ number_format(($data->sumbangan_pihak_ketiga_realisasi ?? 0) - ($data->sumbangan_pihak_ketiga_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="sub-item">Pendapatan Lain-lain</td>
                <td class="currency">{{ number_format($data->pendapatan_lain_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->pendapatan_lain_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->pendapatan_lain_realisasi ?? 0) - ($data->pendapatan_lain_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>

            <!-- Total Pendapatan -->
            @php
                $total_pendapatan_rencana = $pad_rencana + $transfer_rencana + $lain_rencana;
                $total_pendapatan_realisasi = $pad_realisasi + $transfer_realisasi + $lain_realisasi;
                $total_pendapatan_selisih = $total_pendapatan_realisasi - $total_pendapatan_rencana;
            @endphp
            <tr class="total-row">
                <td><strong>TOTAL PENDAPATAN</strong></td>
                <td class="currency"><strong>{{ number_format($total_pendapatan_rencana, 0, ',', '.') }}</strong></td>
                <td class="currency"><strong>{{ number_format($total_pendapatan_realisasi, 0, ',', '.') }}</strong>
                </td>
                <td
                    class="currency {{ $total_pendapatan_selisih > 0 ? 'positive' : ($total_pendapatan_selisih < 0 ? 'negative' : 'zero') }}">
                    <strong>{{ number_format($total_pendapatan_selisih, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- 2. BELANJA DESA -->
    <div class="section-title">2. BELANJA DESA</div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 50%;">Uraian</th>
                <th style="width: 16.67%;">Anggaran (Rp)</th>
                <th style="width: 16.67%;">Realisasi (Rp)</th>
                <th style="width: 16.67%;">Lebih/(Kurang) (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Penyelenggaraan Pemerintahan Desa</td>
                <td class="currency">
                    {{ number_format($data->penyelenggaraan_pemerintahan_desa_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format($data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0) - ($data->penyelenggaraan_pemerintahan_desa_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Pelaksanaan Pembangunan Desa</td>
                <td class="currency">{{ number_format($data->pelaksanaan_pembangunan_desa_rencana ?? 0, 0, ',', '.') }}
                </td>
                <td class="currency">
                    {{ number_format($data->pelaksanaan_pembangunan_desa_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->pelaksanaan_pembangunan_desa_realisasi ?? 0) - ($data->pelaksanaan_pembangunan_desa_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Pembinaan Kemasyarakatan Desa</td>
                <td class="currency">
                    {{ number_format($data->pembinaan_kemasyarakatan_desa_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format($data->pembinaan_kemasyarakatan_desa_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->pembinaan_kemasyarakatan_desa_realisasi ?? 0) - ($data->pembinaan_kemasyarakatan_desa_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Pemberdayaan Masyarakat Desa</td>
                <td class="currency">{{ number_format($data->pemberdayaan_masyarakat_desa_rencana ?? 0, 0, ',', '.') }}
                </td>
                <td class="currency">
                    {{ number_format($data->pemberdayaan_masyarakat_desa_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->pemberdayaan_masyarakat_desa_realisasi ?? 0) - ($data->pemberdayaan_masyarakat_desa_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Belanja Tak Terduga</td>
                <td class="currency">{{ number_format($data->belanja_tak_terduga_rencana ?? 0, 0, ',', '.') }}</td>
                <td class="currency">{{ number_format($data->belanja_tak_terduga_realisasi ?? 0, 0, ',', '.') }}</td>
                <td class="currency">
                    {{ number_format(($data->belanja_tak_terduga_realisasi ?? 0) - ($data->belanja_tak_terduga_rencana ?? 0), 0, ',', '.') }}
                </td>
            </tr>

            <!-- Total Belanja -->
            @php
                $total_belanja_rencana =
                    ($data->penyelenggaraan_pemerintahan_desa_rencana ?? 0) +
                    ($data->pelaksanaan_pembangunan_desa_rencana ?? 0) +
                    ($data->pembinaan_kemasyarakatan_desa_rencana ?? 0) +
                    ($data->pemberdayaan_masyarakat_desa_rencana ?? 0) +
                    ($data->belanja_tak_terduga_rencana ?? 0);
                $total_belanja_realisasi =
                    ($data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0) +
                    ($data->pelaksanaan_pembangunan_desa_realisasi ?? 0) +
                    ($data->pembinaan_kemasyarakatan_desa_realisasi ?? 0) +
                    ($data->pemberdayaan_masyarakat_desa_realisasi ?? 0) +
                    ($data->belanja_tak_terduga_realisasi ?? 0);
                $total_belanja_selisih = $total_belanja_realisasi - $total_belanja_rencana;
            @endphp
            <tr class="total-row">
                <td><strong>TOTAL BELANJA</strong></td>
                <td class="currency"><strong>{{ number_format($total_belanja_rencana, 0, ',', '.') }}</strong></td>
                <td class="currency"><strong>{{ number_format($total_belanja_realisasi, 0, ',', '.') }}</strong></td>
                <td
                    class="currency {{ $total_belanja_selisih > 0 ? 'positive' : ($total_belanja_selisih < 0 ? 'negative' : 'zero') }}">
                    <strong>{{ number_format($total_belanja_selisih, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3 style="text-align: center; margin-bottom: 20px;">RINGKASAN ANGGARAN</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Anggaran (Rp)</th>
                    <th>Realisasi (Rp)</th>
                    <th>Persentase (%)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Total Pendapatan</strong></td>
                    <td class="currency"><strong>{{ number_format($total_pendapatan_rencana, 0, ',', '.') }}</strong>
                    </td>
                    <td class="currency">
                        <strong>{{ number_format($total_pendapatan_realisasi, 0, ',', '.') }}</strong></td>
                    <td class="currency">
                        <strong>{{ $total_pendapatan_rencana > 0 ? number_format(($total_pendapatan_realisasi / $total_pendapatan_rencana) * 100, 2) : 0 }}%</strong>
                    </td>
                </tr>
                <tr>
                    <td><strong>Total Belanja</strong></td>
                    <td class="currency"><strong>{{ number_format($total_belanja_rencana, 0, ',', '.') }}</strong>
                    </td>
                    <td class="currency"><strong>{{ number_format($total_belanja_realisasi, 0, ',', '.') }}</strong>
                    </td>
                    <td class="currency">
                        <strong>{{ $total_belanja_rencana > 0 ? number_format(($total_belanja_realisasi / $total_belanja_rencana) * 100, 2) : 0 }}%</strong>
                    </td>
                </tr>
                <tr class="total-row">
                    <td><strong>Saldo Anggaran</strong></td>
                    <td class="currency">
                        <strong>{{ number_format($total_pendapatan_rencana - $total_belanja_rencana, 0, ',', '.') }}</strong>
                    </td>
                    <td class="currency">
                        <strong>{{ number_format($total_pendapatan_realisasi - $total_belanja_realisasi, 0, ',', '.') }}</strong>
                    </td>
                    <td class="currency">-</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh Sistem APBDes pada {{ $generatedAt }}</p>
        <p>© {{ date('Y') }} Pemerintah Desa - Sistem Informasi APBDes</p>
    </div>
</body>

</html>

<table>
    <!-- Header -->
    <tr>
        <td colspan="4" style="text-align: center; font-weight: bold; font-size: 16px;">
            ANGGARAN PENDAPATAN DAN BELANJA DESA (APBDes) TAHUN {{ $year }}
        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: center;">
            Desa [Nama Desa] - Kecamatan [Nama Kecamatan] - Kabupaten [Nama Kabupaten]
        </td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr> <!-- Empty row -->

    <!-- Table Header -->
    <tr>
        <td style="font-weight: bold; text-align: center; background-color: #f8f9fa;">Uraian</td>
        <td style="font-weight: bold; text-align: center; background-color: #f8f9fa;">Anggaran (Rp)</td>
        <td style="font-weight: bold; text-align: center; background-color: #f8f9fa;">Realisasi (Rp)</td>
        <td style="font-weight: bold; text-align: center; background-color: #f8f9fa;">Lebih/(Kurang) (Rp)</td>
    </tr>

    <!-- 1. PENDAPATAN DESA -->
    <tr>
        <td colspan="4" style="font-weight: bold; background-color: #e3f2fd;">1. PENDAPATAN DESA</td>
    </tr>

    <!-- Pendapatan Asli Desa -->
    @php
        $pad_rencana =
            ($data->hasil_usaha_rencana ?? 0) + ($data->hasil_aset_rencana ?? 0) + ($data->swadaya_rencana ?? 0);
        $pad_realisasi =
            ($data->hasil_usaha_realisasi ?? 0) + ($data->hasil_aset_realisasi ?? 0) + ($data->swadaya_realisasi ?? 0);
        $pad_selisih = $pad_realisasi - $pad_rencana;
    @endphp
    <tr style="background-color: #e3f2fd;">
        <td style="font-weight: bold;">PENDAPATAN ASLI DESA</td>
        <td style="text-align: right;">{{ number_format($pad_rencana, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($pad_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($pad_selisih, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Hasil Usaha</td>
        <td style="text-align: right;">{{ number_format($data->hasil_usaha_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->hasil_usaha_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->hasil_usaha_realisasi ?? 0) - ($data->hasil_usaha_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Hasil Aset</td>
        <td style="text-align: right;">{{ number_format($data->hasil_aset_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->hasil_aset_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->hasil_aset_realisasi ?? 0) - ($data->hasil_aset_rencana ?? 0), 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Swadaya, Partisipasi, Gotong Royong</td>
        <td style="text-align: right;">{{ number_format($data->swadaya_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->swadaya_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->swadaya_realisasi ?? 0) - ($data->swadaya_rencana ?? 0), 0, ',', '.') }}</td>
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
    <tr style="background-color: #e3f2fd;">
        <td style="font-weight: bold;">PENDAPATAN TRANSFER</td>
        <td style="text-align: right;">{{ number_format($transfer_rencana, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($transfer_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($transfer_selisih, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Dana Desa</td>
        <td style="text-align: right;">{{ number_format($data->dana_desa_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->dana_desa_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->dana_desa_realisasi ?? 0) - ($data->dana_desa_rencana ?? 0), 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Bagi Hasil Pajak & Retribusi</td>
        <td style="text-align: right;">{{ number_format($data->bagi_hasil_pajak_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->bagi_hasil_pajak_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->bagi_hasil_pajak_realisasi ?? 0) - ($data->bagi_hasil_pajak_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Alokasi Dana Desa</td>
        <td style="text-align: right;">{{ number_format($data->alokasi_dana_desa_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->alokasi_dana_desa_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->alokasi_dana_desa_realisasi ?? 0) - ($data->alokasi_dana_desa_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Bantuan Keuangan Kabupaten</td>
        <td style="text-align: right;">{{ number_format($data->bantuan_keuangan_kab_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->bantuan_keuangan_kab_realisasi ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">
            {{ number_format(($data->bantuan_keuangan_kab_realisasi ?? 0) - ($data->bantuan_keuangan_kab_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Bantuan Keuangan Provinsi</td>
        <td style="text-align: right;">{{ number_format($data->bantuan_keuangan_prov_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->bantuan_keuangan_prov_realisasi ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">
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
    <tr style="background-color: #e3f2fd;">
        <td style="font-weight: bold;">PENDAPATAN LAIN-LAIN</td>
        <td style="text-align: right;">{{ number_format($lain_rencana, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($lain_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($lain_selisih, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Hibah</td>
        <td style="text-align: right;">{{ number_format($data->hibah_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->hibah_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->hibah_realisasi ?? 0) - ($data->hibah_rencana ?? 0), 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Sumbangan Pihak Ketiga</td>
        <td style="text-align: right;">{{ number_format($data->sumbangan_pihak_ketiga_rencana ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">{{ number_format($data->sumbangan_pihak_ketiga_realisasi ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">
            {{ number_format(($data->sumbangan_pihak_ketiga_realisasi ?? 0) - ($data->sumbangan_pihak_ketiga_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Pendapatan Lain-lain</td>
        <td style="text-align: right;">{{ number_format($data->pendapatan_lain_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->pendapatan_lain_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->pendapatan_lain_realisasi ?? 0) - ($data->pendapatan_lain_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>

    <!-- Total Pendapatan -->
    @php
        $total_pendapatan_rencana = $pad_rencana + $transfer_rencana + $lain_rencana;
        $total_pendapatan_realisasi = $pad_realisasi + $transfer_realisasi + $lain_realisasi;
        $total_pendapatan_selisih = $total_pendapatan_realisasi - $total_pendapatan_rencana;
    @endphp
    <tr style="background-color: #fff3cd; font-weight: bold;">
        <td style="font-weight: bold;">TOTAL PENDAPATAN</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_pendapatan_rencana, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_pendapatan_realisasi, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_pendapatan_selisih, 0, ',', '.') }}
        </td>
    </tr>

    <!-- Empty row -->
    <tr>
        <td colspan="4"></td>
    </tr>

    <!-- 2. BELANJA DESA -->
    <tr>
        <td colspan="4" style="font-weight: bold; background-color: #e3f2fd;">2. BELANJA DESA</td>
    </tr>
    <tr>
        <td>Penyelenggaraan Pemerintahan Desa</td>
        <td style="text-align: right;">
            {{ number_format($data->penyelenggaraan_pemerintahan_desa_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format($data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->penyelenggaraan_pemerintahan_desa_realisasi ?? 0) - ($data->penyelenggaraan_pemerintahan_desa_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td>Pelaksanaan Pembangunan Desa</td>
        <td style="text-align: right;">
            {{ number_format($data->pelaksanaan_pembangunan_desa_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format($data->pelaksanaan_pembangunan_desa_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->pelaksanaan_pembangunan_desa_realisasi ?? 0) - ($data->pelaksanaan_pembangunan_desa_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td>Pembinaan Kemasyarakatan Desa</td>
        <td style="text-align: right;">
            {{ number_format($data->pembinaan_kemasyarakatan_desa_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format($data->pembinaan_kemasyarakatan_desa_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->pembinaan_kemasyarakatan_desa_realisasi ?? 0) - ($data->pembinaan_kemasyarakatan_desa_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td>Pemberdayaan Masyarakat Desa</td>
        <td style="text-align: right;">
            {{ number_format($data->pemberdayaan_masyarakat_desa_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format($data->pemberdayaan_masyarakat_desa_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->pemberdayaan_masyarakat_desa_realisasi ?? 0) - ($data->pemberdayaan_masyarakat_desa_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td>Belanja Tak Terduga</td>
        <td style="text-align: right;">{{ number_format($data->belanja_tak_terduga_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->belanja_tak_terduga_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
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
    <tr style="background-color: #fff3cd; font-weight: bold;">
        <td style="font-weight: bold;">TOTAL BELANJA</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_belanja_rencana, 0, ',', '.') }}</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_belanja_realisasi, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_belanja_selisih, 0, ',', '.') }}</td>
    </tr>

    <!-- Empty row -->
    <tr>
        <td colspan="4"></td>
    </tr>

    <!-- 3. PEMBIAYAAN DESA -->
    <tr>
        <td colspan="4" style="font-weight: bold; background-color: #e3f2fd;">3. PEMBIAYAAN DESA</td>
    </tr>

    <!-- Penerimaan Pembiayaan -->
    @php
        $penerimaan_rencana =
            ($data->silpa_rencana ?? 0) +
            ($data->pencairan_dana_cadangan_rencana ?? 0) +
            ($data->hasil_penjualan_kekayaan_rencana ?? 0);
        $penerimaan_realisasi =
            ($data->silpa_realisasi ?? 0) +
            ($data->pencairan_dana_cadangan_realisasi ?? 0) +
            ($data->hasil_penjualan_kekayaan_realisasi ?? 0);
        $penerimaan_selisih = $penerimaan_realisasi - $penerimaan_rencana;
    @endphp
    <tr style="background-color: #e3f2fd;">
        <td style="font-weight: bold;">PENERIMAAN PEMBIAYAAN</td>
        <td style="text-align: right;">{{ number_format($penerimaan_rencana, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($penerimaan_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($penerimaan_selisih, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">SILPA</td>
        <td style="text-align: right;">{{ number_format($data->silpa_rencana ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($data->silpa_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->silpa_realisasi ?? 0) - ($data->silpa_rencana ?? 0), 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Pencairan Dana Cadangan</td>
        <td style="text-align: right;">{{ number_format($data->pencairan_dana_cadangan_rencana ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">{{ number_format($data->pencairan_dana_cadangan_realisasi ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">
            {{ number_format(($data->pencairan_dana_cadangan_realisasi ?? 0) - ($data->pencairan_dana_cadangan_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Hasil penjualan kekayaan Desa yang dipisahkan</td>
        <td style="text-align: right;">{{ number_format($data->hasil_penjualan_kekayaan_rencana ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">
            {{ number_format($data->hasil_penjualan_kekayaan_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->hasil_penjualan_kekayaan_realisasi ?? 0) - ($data->hasil_penjualan_kekayaan_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>

    <!-- Pengeluaran Pembiayaan -->
    @php
        $pengeluaran_rencana =
            ($data->pembentukan_dana_cadangan_rencana ?? 0) + ($data->penyertaan_modal_desa_rencana ?? 0);
        $pengeluaran_realisasi =
            ($data->pembentukan_dana_cadangan_realisasi ?? 0) + ($data->penyertaan_modal_desa_realisasi ?? 0);
        $pengeluaran_selisih = $pengeluaran_realisasi - $pengeluaran_rencana;
    @endphp
    <tr style="background-color: #e3f2fd;">
        <td style="font-weight: bold;">PENGELUARAN PEMBIAYAAN</td>
        <td style="text-align: right;">{{ number_format($pengeluaran_rencana, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($pengeluaran_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right;">{{ number_format($pengeluaran_selisih, 0, ',', '.') }}</td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Pembentukan Dana Cadangan</td>
        <td style="text-align: right;">{{ number_format($data->pembentukan_dana_cadangan_rencana ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">
            {{ number_format($data->pembentukan_dana_cadangan_realisasi ?? 0, 0, ',', '.') }}</td>
        <td style="text-align: right;">
            {{ number_format(($data->pembentukan_dana_cadangan_realisasi ?? 0) - ($data->pembentukan_dana_cadangan_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>
    <tr>
        <td style="padding-left: 20px;">Penyertaan Modal Desa</td>
        <td style="text-align: right;">{{ number_format($data->penyertaan_modal_desa_rencana ?? 0, 0, ',', '.') }}
        </td>
    <tr>
        <td style="padding-left: 20px;">Penyertaan Modal Desa</td>
        <td style="text-align: right;">{{ number_format($data->penyertaan_modal_desa_rencana ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">{{ number_format($data->penyertaan_modal_desa_realisasi ?? 0, 0, ',', '.') }}
        </td>
        <td style="text-align: right;">
            {{ number_format(($data->penyertaan_modal_desa_realisasi ?? 0) - ($data->penyertaan_modal_desa_rencana ?? 0), 0, ',', '.') }}
        </td>
    </tr>

    <!-- Total Pembiayaan -->
    @php
        $total_pembiayaan_rencana = $penerimaan_rencana - $pengeluaran_rencana;
        $total_pembiayaan_realisasi = $penerimaan_realisasi - $pengeluaran_realisasi;
        $total_pembiayaan_selisih = $total_pembiayaan_realisasi - $total_pembiayaan_rencana;
    @endphp
    <tr style="background-color: #fff3cd; font-weight: bold;">
        <td style="font-weight: bold;">TOTAL PEMBIAYAAN</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_pembiayaan_rencana, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($total_pembiayaan_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_pembiayaan_selisih, 0, ',', '.') }}
        </td>
    </tr>

    <!-- Empty rows -->
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>

    <!-- RINGKASAN -->
    <tr>
        <td colspan="4" style="font-weight: bold; background-color: #e3f2fd; text-align: center;">RINGKASAN
            ANGGARAN</td>
    </tr>
    <tr style="background-color: #f8f9fa; font-weight: bold;">
        <td style="font-weight: bold; text-align: center;">Keterangan</td>
        <td style="font-weight: bold; text-align: center;">Anggaran (Rp)</td>
        <td style="font-weight: bold; text-align: center;">Realisasi (Rp)</td>
        <td style="font-weight: bold; text-align: center;">Persentase (%)</td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Total Pendapatan</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_pendapatan_rencana, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($total_pendapatan_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right; font-weight: bold;">
            {{ $total_pendapatan_rencana > 0 ? number_format(($total_pendapatan_realisasi / $total_pendapatan_rencana) * 100, 2) : 0 }}%
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Total Belanja</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_belanja_rencana, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_belanja_realisasi, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ $total_belanja_rencana > 0 ? number_format(($total_belanja_realisasi / $total_belanja_rencana) * 100, 2) : 0 }}%
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold;">Total Pembiayaan</td>
        <td style="text-align: right; font-weight: bold;">{{ number_format($total_pembiayaan_rencana, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($total_pembiayaan_realisasi, 0, ',', '.') }}</td>
        <td style="text-align: right; font-weight: bold;">-</td>
    </tr>
    <tr style="background-color: #fff3cd;">
        <td style="font-weight: bold;">Saldo Anggaran</td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($total_pendapatan_rencana - $total_belanja_rencana + $total_pembiayaan_rencana, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">
            {{ number_format($total_pendapatan_realisasi - $total_belanja_realisasi + $total_pembiayaan_realisasi, 0, ',', '.') }}
        </td>
        <td style="text-align: right; font-weight: bold;">-</td>
    </tr>

    <!-- Empty rows -->
    <tr>
        <td colspan="4"></td>
    </tr>
    <tr>
        <td colspan="4"></td>
    </tr>

    <!-- Info -->
    <tr>
        <td colspan="2" style="font-weight: bold;">Tahun Anggaran:</td>
        <td colspan="2">{{ $tahunAnggaran->tahun }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Petugas Keuangan:</td>
        <td colspan="2">{{ $tahunAnggaran->nama_petugas_keuangan ?? 'Tidak Diketahui' }}</td>
    </tr>
    <tr>
        <td colspan="2" style="font-weight: bold;">Tanggal Generate:</td>
        <td colspan="2">{{ $generatedAt }}</td>
    </tr>
</table>

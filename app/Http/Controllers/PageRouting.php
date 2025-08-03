<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FotoHome;
use App\Models\AgendaDesa;
use App\Models\TahunAnggaranAPBDes;
use App\Models\DataAnggaranAPBDes;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\APBDesExport;
use App\Models\PimpinanOrganisasiDesa;
use App\Models\AnggotaOrganisasiDesa;

class PageRouting extends Controller
{
    public function index()
    {
        return view('landingPage.main');
    }

    public function halamanUtama()
    {
        return view('landingPage.components.halamanUtama', [
            'foto_home' => FotoHome::all()
        ]);
    }

    public function informasiDesa()
    {
        return view('landingPage.components.informasiDesa');
    }

    public function agendaDesa()
    {
        $agenda = AgendaDesa::orderBy('tanggal_kegiatan', 'desc')->get();
        return view('landingPage.components.agendaDesa', [
            'agenda' => json_encode($agenda)
        ]);
    }

    public function strukturOrganisasi()
    {
        // Ambil semua data pimpinan dengan anggota menggunakan eager loading
        $pimpinanData = PimpinanOrganisasiDesa::with('anggotaOrganisasiDesa')->get();

        // Debug: Log data yang diambil
        Log::info('Pimpinan Data Count: ' . $pimpinanData->count());
        foreach ($pimpinanData as $pimpinan) {
            Log::info('Pimpinan: ' . $pimpinan->nama . ' - Organisasi: ' . $pimpinan->organisasi . ' - Anggota Count: ' . $pimpinan->anggotaOrganisasiDesa->count());
        }

        // Organisasi struktur data berdasarkan organisasi
        $strukturData = $this->organizeStructureData($pimpinanData);

        // Debug: Log struktur data
        Log::info('Struktur Data: ' . json_encode(array_keys($strukturData)));

        return view('landingPage.components.strukturOrganisasi', [
            'strukturData' => $strukturData
        ]);
    }

    private function organizeStructureData($pimpinanData)
    {
        $struktur = [
            'pemerintah_desa' => [],
            'bpd' => [],
            'pkk' => [],
            'karang_taruna' => [],
            'lpmd' => [],
            'lembaga_adat' => []
        ];

        foreach ($pimpinanData as $pimpinan) {
            $organisasi = strtolower(str_replace([' ', '-'], '_', $pimpinan->organisasi));

            // Map organisasi name ke key yang sesuai
            $orgKey = $this->mapOrganisasiKey($organisasi);

            if (isset($struktur[$orgKey])) {
                $struktur[$orgKey]['pimpinan'] = $pimpinan;

                // Kelompokkan anggota berdasarkan posisi
                $anggotaGrouped = $this->groupAnggotaByPosisi($pimpinan->anggotaOrganisasiDesa);
                $struktur[$orgKey]['anggota'] = $anggotaGrouped;

                // Debug: Log anggota yang dikelompokkan
                Log::info('Anggota untuk ' . $orgKey . ': ' . json_encode(array_keys($anggotaGrouped)));
            }
        }

        return $struktur;
    }

    private function groupAnggotaByPosisi($anggotaCollection)
    {
        $grouped = [
            'wakil' => collect(),
            'sekretaris' => collect(),
            'bendahara' => collect(),
            'koordinator' => collect(),
            'anggota' => collect(),
            'lainnya' => collect()
        ];

        foreach ($anggotaCollection as $anggota) {
            $posisiLower = strtolower($anggota->posisi ?? '');

            if (str_contains($posisiLower, 'wakil')) {
                $grouped['wakil']->push($anggota);
            } elseif (str_contains($posisiLower, 'sekretaris')) {
                $grouped['sekretaris']->push($anggota);
            } elseif (str_contains($posisiLower, 'bendahara')) {
                $grouped['bendahara']->push($anggota);
            } elseif (str_contains($posisiLower, 'koordinator') || str_contains($posisiLower, 'kepala urusan') || str_contains($posisiLower, 'manajer') || str_contains($posisiLower, 'kepala bagian') || str_contains($posisiLower, 'kepala bidang')) {
                $grouped['koordinator']->push($anggota);
            } elseif (str_contains($posisiLower, 'anggota')) {
                $grouped['anggota']->push($anggota);
            } else {
                $grouped['lainnya']->push($anggota);
            }
        }

        return $grouped;
    }

    private function mapOrganisasiKey($organisasi)
    {
        $mapping = [
            'pemerintah_desa' => 'pemerintah_desa',
            'pemerintahan_desa' => 'pemerintah_desa',
            'bpd' => 'bpd',
            'badan_permusyawaratan_desa' => 'bpd',
            'pkk' => 'pkk',
            'pemberdayaan_kesejahteraan_keluarga' => 'pkk',
            'karang_taruna' => 'karang_taruna',
            'lpmd' => 'lpmd',
            'lembaga_pemberdayaan_masyarakat_desa' => 'lpmd',
            'bumdes' => 'lpmd', // BUMDes masuk ke LPMD sesuai tab yang ada
            'lembaga_adat' => 'lembaga_adat',
            'lembaga_sosial' => 'lembaga_adat'
        ];

        return $mapping[$organisasi] ?? 'pemerintah_desa';
    }

    public function getOrganisasiData($organisasi)
    {
        $pimpinan = PimpinanOrganisasiDesa::where('organisasi', $organisasi)
            ->with('anggotaOrganisasiDesa')
            ->first();

        if (!$pimpinan) {
            return response()->json([
                'success' => false,
                'message' => 'Data organisasi tidak ditemukan'
            ], 404);
        }

        // Kelompokkan anggota berdasarkan posisi
        $anggotaGrouped = $this->groupAnggotaByPosisi($pimpinan->anggotaOrganisasiDesa);

        return response()->json([
            'success' => true,
            'pimpinan' => $pimpinan,
            'anggota' => $anggotaGrouped
        ]);
    }

    public function tpid()
    {
        return view('landingPage.components.TPID');
    }

    public function daftarData()
    {
        return view('landingPage.components.daftarData');
    }

    public function jdih()
    {
        return view('landingPage.components.jdih');
    }

    public function apbdes()
    {
        $tahun_apbdes = TahunAnggaranAPBDes::orderBy('tahun', 'asc')->get();

        // Format data for JavaScript consumption
        $formatted_data = [];

        // Loop melalui setiap tahun anggaran
        foreach ($tahun_apbdes as $tahun_item) {
            // Cari data anggaran untuk tahun ini menggunakan foreign key yang benar
            $data_apbdes = DataAnggaranAPBDes::where('tahun_anggaran_id', $tahun_item->id)->first();

            // Skip jika tidak ada data untuk tahun ini
            if (!$data_apbdes) {
                continue;
            }

            // Gunakan tahun dari item yang sedang diloop, bukan dari first()
            $tahun = $tahun_item->tahun;

            $formatted_data[$tahun] = [
                'pendapatan' => [
                    [
                        'type' => 'main',
                        'name' => 'PENDAPATAN ASLI DESA',
                        'rencana' => ($data_apbdes->hasil_usaha_rencana ?? 0) + ($data_apbdes->hasil_aset_rencana ?? 0) + ($data_apbdes->swadaya_rencana ?? 0),
                        'realisasi' => ($data_apbdes->hasil_usaha_realisasi ?? 0) + ($data_apbdes->hasil_aset_realisasi ?? 0) + ($data_apbdes->swadaya_realisasi ?? 0),
                        'selisih' => (($data_apbdes->hasil_usaha_realisasi ?? 0) + ($data_apbdes->hasil_aset_realisasi ?? 0) + ($data_apbdes->swadaya_realisasi ?? 0)) - (($data_apbdes->hasil_usaha_rencana ?? 0) + ($data_apbdes->hasil_aset_rencana ?? 0) + ($data_apbdes->swadaya_rencana ?? 0)),
                        'children' => [
                            [
                                'name' => 'Hasil Usaha',
                                'rencana' => $data_apbdes->hasil_usaha_rencana ?? 0,
                                'realisasi' => $data_apbdes->hasil_usaha_realisasi ?? 0,
                                'selisih' => ($data_apbdes->hasil_usaha_realisasi ?? 0) - ($data_apbdes->hasil_usaha_rencana ?? 0)
                            ],
                            [
                                'name' => 'Hasil Aset',
                                'rencana' => $data_apbdes->hasil_aset_rencana ?? 0,
                                'realisasi' => $data_apbdes->hasil_aset_realisasi ?? 0,
                                'selisih' => ($data_apbdes->hasil_aset_realisasi ?? 0) - ($data_apbdes->hasil_aset_rencana ?? 0)
                            ],
                            [
                                'name' => 'Swadaya, Partisipasi, Gotong Royong',
                                'rencana' => $data_apbdes->swadaya_rencana ?? 0,
                                'realisasi' => $data_apbdes->swadaya_realisasi ?? 0,
                                'selisih' => ($data_apbdes->swadaya_realisasi ?? 0) - ($data_apbdes->swadaya_rencana ?? 0)
                            ]
                        ]
                    ],
                    [
                        'type' => 'main',
                        'name' => 'PENDAPATAN TRANSFER',
                        'rencana' => ($data_apbdes->dana_desa_rencana ?? 0) + ($data_apbdes->bagi_hasil_pajak_rencana ?? 0) + ($data_apbdes->alokasi_dana_desa_rencana ?? 0) + ($data_apbdes->bantuan_keuangan_kab_rencana ?? 0) + ($data_apbdes->bantuan_keuangan_prov_rencana ?? 0),
                        'realisasi' => ($data_apbdes->dana_desa_realisasi ?? 0) + ($data_apbdes->bagi_hasil_pajak_realisasi ?? 0) + ($data_apbdes->alokasi_dana_desa_realisasi ?? 0) + ($data_apbdes->bantuan_keuangan_kab_realisasi ?? 0) + ($data_apbdes->bantuan_keuangan_prov_realisasi ?? 0),
                        'selisih' => (($data_apbdes->dana_desa_realisasi ?? 0) + ($data_apbdes->bagi_hasil_pajak_realisasi ?? 0) + ($data_apbdes->alokasi_dana_desa_realisasi ?? 0) + ($data_apbdes->bantuan_keuangan_kab_realisasi ?? 0) + ($data_apbdes->bantuan_keuangan_prov_realisasi ?? 0)) - (($data_apbdes->dana_desa_rencana ?? 0) + ($data_apbdes->bagi_hasil_pajak_rencana ?? 0) + ($data_apbdes->alokasi_dana_desa_rencana ?? 0) + ($data_apbdes->bantuan_keuangan_kab_rencana ?? 0) + ($data_apbdes->bantuan_keuangan_prov_rencana ?? 0)),
                        'children' => [
                            [
                                'name' => 'Dana Desa',
                                'rencana' => $data_apbdes->dana_desa_rencana ?? 0,
                                'realisasi' => $data_apbdes->dana_desa_realisasi ?? 0,
                                'selisih' => ($data_apbdes->dana_desa_realisasi ?? 0) - ($data_apbdes->dana_desa_rencana ?? 0)
                            ],
                            [
                                'name' => 'Bagi Hasil Pajak & Retribusi',
                                'rencana' => $data_apbdes->bagi_hasil_pajak_rencana ?? 0,
                                'realisasi' => $data_apbdes->bagi_hasil_pajak_realisasi ?? 0,
                                'selisih' => ($data_apbdes->bagi_hasil_pajak_realisasi ?? 0) - ($data_apbdes->bagi_hasil_pajak_rencana ?? 0)
                            ],
                            [
                                'name' => 'Alokasi Dana Desa',
                                'rencana' => $data_apbdes->alokasi_dana_desa_rencana ?? 0,
                                'realisasi' => $data_apbdes->alokasi_dana_desa_realisasi ?? 0,
                                'selisih' => ($data_apbdes->alokasi_dana_desa_realisasi ?? 0) - ($data_apbdes->alokasi_dana_desa_rencana ?? 0)
                            ],
                            [
                                'name' => 'Bantuan Keuangan Kabupaten',
                                'rencana' => $data_apbdes->bantuan_keuangan_kab_rencana ?? 0,
                                'realisasi' => $data_apbdes->bantuan_keuangan_kab_realisasi ?? 0,
                                'selisih' => ($data_apbdes->bantuan_keuangan_kab_realisasi ?? 0) - ($data_apbdes->bantuan_keuangan_kab_rencana ?? 0)
                            ],
                            [
                                'name' => 'Bantuan Keuangan Provinsi',
                                'rencana' => $data_apbdes->bantuan_keuangan_prov_rencana ?? 0,
                                'realisasi' => $data_apbdes->bantuan_keuangan_prov_realisasi ?? 0,
                                'selisih' => ($data_apbdes->bantuan_keuangan_prov_realisasi ?? 0) - ($data_apbdes->bantuan_keuangan_prov_rencana ?? 0)
                            ]
                        ]
                    ],
                    [
                        'type' => 'main',
                        'name' => 'PENDAPATAN LAIN-LAIN',
                        'rencana' => ($data_apbdes->hibah_rencana ?? 0) + ($data_apbdes->sumbangan_pihak_ketiga_rencana ?? 0) + ($data_apbdes->pendapatan_lain_rencana ?? 0),
                        'realisasi' => ($data_apbdes->hibah_realisasi ?? 0) + ($data_apbdes->sumbangan_pihak_ketiga_realisasi ?? 0) + ($data_apbdes->pendapatan_lain_realisasi ?? 0),
                        'selisih' => (($data_apbdes->hibah_realisasi ?? 0) + ($data_apbdes->sumbangan_pihak_ketiga_realisasi ?? 0) + ($data_apbdes->pendapatan_lain_realisasi ?? 0)) - (($data_apbdes->hibah_rencana ?? 0) + ($data_apbdes->sumbangan_pihak_ketiga_rencana ?? 0) + ($data_apbdes->pendapatan_lain_rencana ?? 0)),
                        'children' => [
                            [
                                'name' => 'Hibah',
                                'rencana' => $data_apbdes->hibah_rencana ?? 0,
                                'realisasi' => $data_apbdes->hibah_realisasi ?? 0,
                                'selisih' => ($data_apbdes->hibah_realisasi ?? 0) - ($data_apbdes->hibah_rencana ?? 0)
                            ],
                            [
                                'name' => 'Sumbangan Pihak Ketiga',
                                'rencana' => $data_apbdes->sumbangan_pihak_ketiga_rencana ?? 0,
                                'realisasi' => $data_apbdes->sumbangan_pihak_ketiga_realisasi ?? 0,
                                'selisih' => ($data_apbdes->sumbangan_pihak_ketiga_realisasi ?? 0) - ($data_apbdes->sumbangan_pihak_ketiga_rencana ?? 0)
                            ],
                            [
                                'name' => 'Pendapatan Lain-lain',
                                'rencana' => $data_apbdes->pendapatan_lain_rencana ?? 0,
                                'realisasi' => $data_apbdes->pendapatan_lain_realisasi ?? 0,
                                'selisih' => ($data_apbdes->pendapatan_lain_realisasi ?? 0) - ($data_apbdes->pendapatan_lain_rencana ?? 0)
                            ]
                        ]
                    ]
                ],
                'belanja' => [
                    [
                        'type' => 'main',
                        'name' => 'PENYELENGGARAAN PEMERINTAHAN DESA',
                        'rencana' => $data_apbdes->penyelenggaraan_pemerintahan_desa_rencana ?? 0,
                        'realisasi' => $data_apbdes->penyelenggaraan_pemerintahan_desa_realisasi ?? 0,
                        'selisih' => ($data_apbdes->penyelenggaraan_pemerintahan_desa_realisasi ?? 0) - ($data_apbdes->penyelenggaraan_pemerintahan_desa_rencana ?? 0)
                    ],
                    [
                        'type' => 'main',
                        'name' => 'PELAKSANAAN PEMBANGUNAN DESA',
                        'rencana' => $data_apbdes->pelaksanaan_pembangunan_desa_rencana ?? 0,
                        'realisasi' => $data_apbdes->pelaksanaan_pembangunan_desa_realisasi ?? 0,
                        'selisih' => ($data_apbdes->pelaksanaan_pembangunan_desa_realisasi ?? 0) - ($data_apbdes->pelaksanaan_pembangunan_desa_rencana ?? 0)
                    ],
                    [
                        'type' => 'main',
                        'name' => 'PEMBINAAN KEMASYARAKATAN DESA',
                        'rencana' => $data_apbdes->pembinaan_kemasyarakatan_desa_rencana ?? 0,
                        'realisasi' => $data_apbdes->pembinaan_kemasyarakatan_desa_realisasi ?? 0,
                        'selisih' => ($data_apbdes->pembinaan_kemasyarakatan_desa_realisasi ?? 0) - ($data_apbdes->pembinaan_kemasyarakatan_desa_rencana ?? 0)
                    ],
                    [
                        'type' => 'main',
                        'name' => 'PEMBERDAYAAN MASYARAKAT DESA',
                        'rencana' => $data_apbdes->pemberdayaan_masyarakat_desa_rencana ?? 0,
                        'realisasi' => $data_apbdes->pemberdayaan_masyarakat_desa_realisasi ?? 0,
                        'selisih' => ($data_apbdes->pemberdayaan_masyarakat_desa_realisasi ?? 0) - ($data_apbdes->pemberdayaan_masyarakat_desa_rencana ?? 0)
                    ],
                    [
                        'type' => 'main',
                        'name' => 'BELANJA TAK TERDUGA',
                        'rencana' => $data_apbdes->belanja_tak_terduga_rencana ?? 0,
                        'realisasi' => $data_apbdes->belanja_tak_terduga_realisasi ?? 0,
                        'selisih' => ($data_apbdes->belanja_tak_terduga_realisasi ?? 0) - ($data_apbdes->belanja_tak_terduga_rencana ?? 0)
                    ]
                ],
                'pembiayaan' => [
                    [
                        'type' => 'main',
                        'name' => 'PENERIMAAN PEMBIAYAAN',
                        'rencana' => ($data_apbdes->silpa_rencana ?? 0) + ($data_apbdes->pencairan_dana_cadangan_rencana ?? 0) + ($data_apbdes->hasil_penjualan_kekayaan_rencana ?? 0),
                        'realisasi' => ($data_apbdes->silpa_realisasi ?? 0) + ($data_apbdes->pencairan_dana_cadangan_realisasi ?? 0) + ($data_apbdes->hasil_penjualan_kekayaan_realisasi ?? 0),
                        'selisih' => (($data_apbdes->silpa_realisasi ?? 0) + ($data_apbdes->pencairan_dana_cadangan_realisasi ?? 0) + ($data_apbdes->hasil_penjualan_kekayaan_realisasi ?? 0)) - (($data_apbdes->silpa_rencana ?? 0) + ($data_apbdes->pencairan_dana_cadangan_rencana ?? 0) + ($data_apbdes->hasil_penjualan_kekayaan_rencana ?? 0)),
                        'children' => [
                            [
                                'name' => 'SILPA',
                                'rencana' => $data_apbdes->silpa_rencana ?? 0,
                                'realisasi' => $data_apbdes->silpa_realisasi ?? 0,
                                'selisih' => ($data_apbdes->silpa_realisasi ?? 0) - ($data_apbdes->silpa_rencana ?? 0)
                            ],
                            [
                                'name' => 'Pencairan Dana Cadangan',
                                'rencana' => $data_apbdes->pencairan_dana_cadangan_rencana ?? 0,
                                'realisasi' => $data_apbdes->pencairan_dana_cadangan_realisasi ?? 0,
                                'selisih' => ($data_apbdes->pencairan_dana_cadangan_realisasi ?? 0) - ($data_apbdes->pencairan_dana_cadangan_rencana ?? 0)
                            ],
                            [
                                'name' => 'Hasil penjualan kekayaan Desa yang dipisahkan',
                                'rencana' => $data_apbdes->hasil_penjualan_kekayaan_rencana ?? 0,
                                'realisasi' => $data_apbdes->hasil_penjualan_kekayaan_realisasi ?? 0,
                                'selisih' => ($data_apbdes->hasil_penjualan_kekayaan_realisasi ?? 0) - ($data_apbdes->hasil_penjualan_kekayaan_rencana ?? 0)
                            ]
                        ]
                    ],
                    [
                        'type' => 'main',
                        'name' => 'PENGELUARAN PEMBIAYAAN',
                        'rencana' => ($data_apbdes->pembentukan_dana_cadangan_rencana ?? 0) + ($data_apbdes->penyertaan_modal_desa_rencana ?? 0),
                        'realisasi' => ($data_apbdes->pembentukan_dana_cadangan_realisasi ?? 0) + ($data_apbdes->penyertaan_modal_desa_realisasi ?? 0),
                        'selisih' => (($data_apbdes->pembentukan_dana_cadangan_realisasi ?? 0) + ($data_apbdes->penyertaan_modal_desa_realisasi ?? 0)) - (($data_apbdes->pembentukan_dana_cadangan_rencana ?? 0) + ($data_apbdes->penyertaan_modal_desa_rencana ?? 0)),
                        'children' => [
                            [
                                'name' => 'Pembentukan Dana Cadangan',
                                'rencana' => $data_apbdes->pembentukan_dana_cadangan_rencana ?? 0,
                                'realisasi' => $data_apbdes->pembentukan_dana_cadangan_realisasi ?? 0,
                                'selisih' => ($data_apbdes->pembentukan_dana_cadangan_realisasi ?? 0) - ($data_apbdes->pembentukan_dana_cadangan_rencana ?? 0)
                            ],
                            [
                                'name' => 'Penyertaan Modal Desa',
                                'rencana' => $data_apbdes->penyertaan_modal_desa_rencana ?? 0,
                                'realisasi' => $data_apbdes->penyertaan_modal_desa_realisasi ?? 0,
                                'selisih' => ($data_apbdes->penyertaan_modal_desa_realisasi ?? 0) - ($data_apbdes->penyertaan_modal_desa_rencana ?? 0)
                            ]
                        ]
                    ]
                ]
            ];
        }

        return view('landingPage.components.apbdes', [
            'tahun_apbdes' => $tahun_apbdes,
            'data_apbdes' => collect(), // Empty collection since we're not using it
            'formatted_data' => json_encode($formatted_data)
        ]);
    }

    /**
     * Get APBDes data by year for AJAX requests
     */
    public function getAPBDesByYear($year)
    {
        $tahunAnggaran = TahunAnggaranAPBDes::where('tahun', $year)->first();

        if (!$tahunAnggaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data untuk tahun ' . $year . ' tidak ditemukan'
            ], 404);
        }

        $data = DataAnggaranAPBDes::where('tahun_anggaran_id', $tahunAnggaran->id)->first();

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data anggaran untuk tahun ' . $year . ' tidak ditemukan'
            ], 404);
        }

        // Format the same way as in the main apbdes method
        $formatted_data = [
            'pendapatan' => [
                [
                    'type' => 'main',
                    'name' => 'PENDAPATAN ASLI DESA',
                    'rencana' => ($data->hasil_usaha_rencana ?? 0) + ($data->hasil_aset_rencana ?? 0) + ($data->swadaya_rencana ?? 0),
                    'realisasi' => ($data->hasil_usaha_realisasi ?? 0) + ($data->hasil_aset_realisasi ?? 0) + ($data->swadaya_realisasi ?? 0),
                    'selisih' => (($data->hasil_usaha_realisasi ?? 0) + ($data->hasil_aset_realisasi ?? 0) + ($data->swadaya_realisasi ?? 0)) - (($data->hasil_usaha_rencana ?? 0) + ($data->hasil_aset_rencana ?? 0) + ($data->swadaya_rencana ?? 0)),
                    'children' => [
                        [
                            'name' => 'Hasil Usaha',
                            'rencana' => $data->hasil_usaha_rencana ?? 0,
                            'realisasi' => $data->hasil_usaha_realisasi ?? 0,
                            'selisih' => ($data->hasil_usaha_realisasi ?? 0) - ($data->hasil_usaha_rencana ?? 0)
                        ],
                        [
                            'name' => 'Hasil Aset',
                            'rencana' => $data->hasil_aset_rencana ?? 0,
                            'realisasi' => $data->hasil_aset_realisasi ?? 0,
                            'selisih' => ($data->hasil_aset_realisasi ?? 0) - ($data->hasil_aset_rencana ?? 0)
                        ],
                        [
                            'name' => 'Swadaya, Partisipasi, Gotong Royong',
                            'rencana' => $data->swadaya_rencana ?? 0,
                            'realisasi' => $data->swadaya_realisasi ?? 0,
                            'selisih' => ($data->swadaya_realisasi ?? 0) - ($data->swadaya_rencana ?? 0)
                        ]
                    ]
                ]
                // Add other sections as needed...
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $formatted_data,
            'year' => $year,
            'petugas_keuangan' => $tahunAnggaran->nama_petugas_keuangan
        ]);
    }

    /**
     * Download APBDes as PDF
     */
    public function downloadAPBDesPDF($year)
    {
        try {
            // Log untuk debugging
            Log::info("PDF Download request for year: {$year}");

            // Cari tahun anggaran
            $tahunAnggaran = TahunAnggaranAPBDes::where('tahun', $year)->first();

            if (!$tahunAnggaran) {
                Log::error("Tahun anggaran {$year} tidak ditemukan");
                return response()->json(['error' => 'Data untuk tahun ' . $year . ' tidak ditemukan'], 404);
            }

            // Cari data anggaran menggunakan foreign key
            $data = DataAnggaranAPBDes::where('tahun_anggaran_id', $tahunAnggaran->id)->first();

            if (!$data) {
                Log::error("Data anggaran untuk tahun {$year} tidak ditemukan");
                return response()->json(['error' => 'Data anggaran untuk tahun ' . $year . ' tidak ditemukan'], 404);
            }

            Log::info("Data ditemukan, generating PDF...");

            // Buat direktori jika belum ada
            $viewPath = resource_path('views/landingPage/components/apbdes.blade.php');
            if (!file_exists($viewPath)) {
                Log::error("Template PDF tidak ditemukan: {$viewPath}");
                return response()->json(['error' => 'Template PDF tidak ditemukan'], 500);
            }

            // Generate PDF dengan semua data yang diperlukan
            $pdf = PDF::loadView('pdf.apbdes-template', [
                'nama_desa' => 'Sosopan',
                'nama_kecamatan' => 'Padang Bolak',
                'nama_kabupaten' => 'Padang Lawas Utara',
                'data' => $data,
                'tahunAnggaran' => $tahunAnggaran,
                'year' => $year,
                'generatedAt' => now()->format('d/m/Y H:i:s'),
                'generatedBy' => 'Sistem APBDes'
            ]);

            // Set paper size dan orientation
            $pdf->setPaper('A4', 'portrait');

            // Set options untuk better rendering
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'sans-serif',
                'isRemoteEnabled' => true
            ]);

            Log::info("PDF generated successfully");

            // Download file dengan nama yang informatif
            $fileName = 'APBDes_' . $year . '_' . date('Y-m-d_H-i-s') . '.pdf';

            return $pdf->download($fileName);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error generating PDF: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Terjadi kesalahan saat membuat PDF: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Download APBDes as Excel
     */
    public function downloadAPBDesExcel($year)
    {
        try {
            Log::info("Excel Download request for year: {$year}");

            // Cari tahun anggaran
            $tahunAnggaran = TahunAnggaranAPBDes::where('tahun', $year)->first();

            if (!$tahunAnggaran) {
                Log::error("Tahun anggaran {$year} tidak ditemukan");
                return response()->json(['error' => 'Data untuk tahun ' . $year . ' tidak ditemukan'], 404);
            }

            // Cari data anggaran menggunakan foreign key
            $dataAnggaran = DataAnggaranAPBDes::where('tahun_anggaran_id', $tahunAnggaran->id)->first();

            if (!$dataAnggaran) {
                Log::error("Data anggaran untuk tahun {$year} tidak ditemukan");
                return response()->json(['error' => 'Data anggaran untuk tahun ' . $year . ' tidak ditemukan'], 404);
            }

            Log::info("Data ditemukan, generating Excel...");

            // Buat nama file
            $fileName = 'APBDes_' . $year . '_' . date('Y-m-d_H-i-s') . '.xlsx';

            // Generate dan download Excel menggunakan Collection approach
            return Excel::download(new APBDesExport($dataAnggaran, $tahunAnggaran, $year), $fileName);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            Log::error('PhpSpreadsheet Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan pada spreadsheet: ' . $e->getMessage()
            ], 500);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            Log::error('Excel Validation Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan validasi Excel: ' . $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            Log::error('Error generating Excel: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => 'Terjadi kesalahan saat membuat Excel: ' . $e->getMessage(),
                'debug' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }
}

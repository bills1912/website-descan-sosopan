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
use App\Models\ReportPublicationData;
use Illuminate\Http\JsonResponse;

class PageRouting extends Controller
{
    public function index()
    {
        return view('landingPage.main');
    }

    public function halamanUtama()
    {
        return view('landingPage.components.halamanUtama', [
            'foto_home' => FotoHome::first()->foto ?? null
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
        try {
            // Get all reports for initial display, tapi batasi untuk featured saja
            $featuredReports = ReportPublicationData::whereIn('kategori', ['annual_report', 'financial_report', 'village_profile'])
                ->orderBy('waktu_terbit', 'desc')
                ->limit(3)  // Batasi hanya 3 untuk tampilan awal
                ->get();

            // Jika tidak ada featured reports, ambil 3 terbaru dari semua kategori
            if ($featuredReports->isEmpty()) {
                $featuredReports = ReportPublicationData::orderBy('waktu_terbit', 'desc')
                    ->limit(3)
                    ->get();
            }

            // Get total count untuk keperluan JavaScript
            $totalReports = ReportPublicationData::count();

            // Transform data for view
            $featuredReports->transform(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->judul,
                    'description' => $report->deskripsi,
                    'category_label' => $report->category_label,
                    'publication_date' => $report->publication_date->format('d M Y'),
                    'download_url' => $report->download_url,
                    'view_url' => $report->view_url,
                    'type_icon' => $report->type_icon,
                    'file_type' => $report->file_type,
                    'file_path' => $report->file_path, // Tambahkan ini
                    'formatted_file_size' => $report->formatted_file_size,
                    'download_count' => rand(10, 100), // Mock data since no field
                    'has_file' => $report->has_file,
                ];
            });

            return view('landingPage.components.daftarData', [
                'featuredReports' => $featuredReports,
                'totalReports' => $totalReports
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading daftar data page: ' . $e->getMessage());

            // Return view with empty collection if error occurs
            return view('landingPage.components.daftarData', [
                'featuredReports' => collect(),
                'totalReports' => 0
            ]);
        }
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

    /**
     * Get sample data for different categories (API endpoint)
     */
    public function getDataByCategory(Request $request, $category): JsonResponse
    {
        try {
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search', '');
            $status = $request->get('status', '');

            // Sample data generation based on category
            $data = $this->generateSampleDataByCategory($category, $search, $status);

            // Pagination
            $total = count($data);
            $offset = ($page - 1) * $perPage;
            $paginatedData = array_slice($data, $offset, $perPage);

            return response()->json([
                'success' => true,
                'data' => $paginatedData,
                'pagination' => [
                    'current_page' => (int) $page,
                    'per_page' => (int) $perPage,
                    'total' => $total,
                    'last_page' => ceil($total / $perPage),
                    'from' => $offset + 1,
                    'to' => min($offset + $perPage, $total)
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching data by category: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    /**
     * Generate sample data by category
     */
    private function generateSampleDataByCategory($category, $search = '', $status = '')
    {
        $data = [];

        switch ($category) {
            case 'penduduk':
                $data = [
                    [
                        'nik' => '3201234567890001',
                        'nama' => 'Ahmad Suryanto',
                        'kelamin' => 'Laki-laki',
                        'lahir' => '15/08/1985',
                        'alamat' => 'Dusun Maju RT 01/RW 01',
                        'status' => 'active'
                    ],
                    [
                        'nik' => '3201234567890002',
                        'nama' => 'Siti Nurhaliza',
                        'kelamin' => 'Perempuan',
                        'lahir' => '22/12/1990',
                        'alamat' => 'Dusun Sejahtera RT 02/RW 01',
                        'status' => 'active'
                    ],
                    [
                        'nik' => '3201234567890003',
                        'nama' => 'Budi Hartono',
                        'kelamin' => 'Laki-laki',
                        'lahir' => '03/05/1978',
                        'alamat' => 'Dusun Harmoni RT 01/RW 02',
                        'status' => 'inactive'
                    ],
                    [
                        'nik' => '3201234567890004',
                        'nama' => 'Ratna Dewi',
                        'kelamin' => 'Perempuan',
                        'lahir' => '18/09/1993',
                        'alamat' => 'Dusun Maju RT 03/RW 01',
                        'status' => 'pending'
                    ],
                    [
                        'nik' => '3201234567890005',
                        'nama' => 'Eko Prasetyo',
                        'kelamin' => 'Laki-laki',
                        'lahir' => '27/01/1987',
                        'alamat' => 'Dusun Sejahtera RT 01/RW 02',
                        'status' => 'active'
                    ]
                ];
                break;

            case 'keuangan':
                $data = [
                    [
                        'kode' => 'APB-001',
                        'program' => 'Pembangunan Jalan',
                        'anggaran' => 'Rp 150.000.000',
                        'realisasi' => '87%',
                        'status' => 'active'
                    ],
                    [
                        'kode' => 'APB-002',
                        'program' => 'Program Kesehatan',
                        'anggaran' => 'Rp 75.000.000',
                        'realisasi' => '95%',
                        'status' => 'active'
                    ],
                    [
                        'kode' => 'APB-003',
                        'program' => 'Bantuan Sosial',
                        'anggaran' => 'Rp 200.000.000',
                        'realisasi' => '73%',
                        'status' => 'pending'
                    ]
                ];
                break;

            default:
                // Generate placeholder data for other categories
                for ($i = 1; $i <= 25; $i++) {
                    $data[] = [
                        'id' => str_pad($i, 3, '0', STR_PAD_LEFT),
                        'nama' => "Data " . ucfirst($category) . " {$i}",
                        'kategori' => 'Kategori A',
                        'tanggal' => date('d/m/Y', strtotime("-{$i} days")),
                        'nilai' => 'Rp ' . number_format(rand(100000, 1000000), 0, ',', '.'),
                        'status' => ['active', 'inactive', 'pending'][rand(0, 2)]
                    ];
                }
                break;
        }

        // Apply filters
        if (!empty($search)) {
            $data = array_filter($data, function ($item) use ($search) {
                return stripos(json_encode($item), $search) !== false;
            });
        }

        if (!empty($status)) {
            $data = array_filter($data, function ($item) use ($status) {
                return $item['status'] === $status;
            });
        }

        return array_values($data);
    }

    /**
     * Export data by category
     */
    public function exportDataByCategory(Request $request, $category, $format)
    {
        try {
            $data = $this->generateSampleDataByCategory($category);

            if ($format === 'excel') {
                $fileName = "data_{$category}_" . date('Y-m-d_H-i-s') . '.xlsx';

                return Excel::download(new \App\Exports\DataCategoryExport($data, $category), $fileName);
            } elseif ($format === 'pdf') {
                $fileName = "data_{$category}_" . date('Y-m-d_H-i-s') . '.pdf';

                // Create PDF using DomPDF
                $pdf = PDF::loadView('pdf.data-category-template', [
                    'data' => $data,
                    'category' => $category,
                    'title' => $this->getCategoryTitle($category),
                    'generated_at' => now()->format('d/m/Y H:i:s')
                ]);

                $pdf->setPaper('A4', 'landscape');

                return $pdf->download($fileName);
            }

            return response()->json([
                'success' => false,
                'message' => 'Format export tidak valid'
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error exporting data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat export data'
            ], 500);
        }
    }

    /**
     * Get category title for display
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
}

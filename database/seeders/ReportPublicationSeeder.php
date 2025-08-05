<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReportPublicationData;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReportPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
                'judul' => 'Laporan Tahunan Desa Sosopan 2024',
                'waktu_terbit' => '2024-01-15',
                'deskripsi' => 'Laporan komprehensif mengenai perkembangan desa selama tahun 2024, termasuk capaian program dan statistik terkini.',
                'kategori' => 'annual_report',
                'file_path' => 'reports/laporan_tahunan_2024.pdf',
            ],
            [
                'judul' => 'Data Kependudukan Kuartal II 2024',
                'waktu_terbit' => '2024-06-30',
                'deskripsi' => 'Statistik kependudukan kuartal kedua 2024 dengan analisis pertumbuhan dan perubahan demografi.',
                'kategori' => 'demographic_data',
                'file_path' => 'reports/data_kependudukan_q2_2024.xlsx',
            ],
            [
                'judul' => 'Laporan Keuangan Semester I 2024',
                'waktu_terbit' => '2024-07-31',
                'deskripsi' => 'Laporan realisasi anggaran dan pertanggungjawaban keuangan desa semester pertama tahun 2024.',
                'kategori' => 'financial_report',
                'file_path' => 'reports/laporan_keuangan_sem1_2024.pdf',
            ],
            [
                'judul' => 'Profil Desa Sosopan 2024',
                'waktu_terbit' => '2024-03-10',
                'deskripsi' => 'Profil lengkap desa mencakup geografis, demografi, potensi ekonomi, dan fasilitas publik.',
                'kategori' => 'village_profile',
                'file_path' => 'reports/profil_desa_2024.pdf',
            ],
            [
                'judul' => 'Data Kesehatan Masyarakat 2024',
                'waktu_terbit' => '2024-06-20',
                'deskripsi' => 'Analisis data kesehatan masyarakat, cakupan imunisasi, dan program kesehatan desa.',
                'kategori' => 'health_data',
                'file_path' => 'reports/data_kesehatan_2024.xlsx',
            ],
            [
                'judul' => 'Monitoring UMKM Desa 2024',
                'waktu_terbit' => '2024-07-05',
                'deskripsi' => 'Perkembangan usaha mikro kecil menengah dan program pemberdayaan ekonomi masyarakat desa.',
                'kategori' => 'economic_data',
                'file_path' => 'reports/monitoring_umkm_2024.pdf',
            ],
            [
                'judul' => 'Laporan Pembangunan Infrastruktur 2024',
                'waktu_terbit' => '2024-05-15',
                'deskripsi' => 'Progres pembangunan infrastruktur desa, anggaran yang digunakan, dan dampak terhadap masyarakat.',
                'kategori' => 'development_report',
                'file_path' => 'reports/laporan_pembangunan_2024.pdf',
            ],
            [
                'judul' => 'Data Pendidikan Anak Desa 2024',
                'waktu_terbit' => '2024-04-20',
                'deskripsi' => 'Statistik pendidikan anak-anak desa, tingkat partisipasi sekolah, dan program pendidikan.',
                'kategori' => 'education_data',
                'file_path' => 'reports/data_pendidikan_2024.xlsx',
            ],
            [
                'judul' => 'Rencana Pembangunan Jangka Menengah Desa (RPJMDes)',
                'waktu_terbit' => '2024-02-15',
                'deskripsi' => 'Dokumen perencanaan pembangunan desa untuk periode 2024-2030 yang mencakup visi, misi, dan program strategis.',
                'kategori' => 'other',
                'file_path' => 'reports/rpjmdes_2024_2030.pdf',
            ],
            [
                'judul' => 'Laporan Kegiatan BUMDes 2024',
                'waktu_terbit' => '2024-08-01',
                'deskripsi' => 'Laporan kegiatan dan kinerja Badan Usaha Milik Desa termasuk omzet, keuntungan, dan kontribusi terhadap PADes.',
                'kategori' => 'economic_data',
                'file_path' => 'reports/laporan_bumdes_2024.pdf',
            ],
        ];

        foreach ($reports as $report) {
            ReportPublicationData::create($report);
        }

        // Create some sample files if they don't exist
        $this->createSampleFiles();
    }

    /**
     * Create sample files for demonstration
     */
    private function createSampleFiles()
    {
        $sampleContent = "This is a sample document for demonstration purposes.\n\nGenerated at: " . now();

        $files = [
            'reports/laporan_tahunan_2024.pdf',
            'reports/data_kependudukan_q2_2024.xlsx',
            'reports/laporan_keuangan_sem1_2024.pdf',
            'reports/profil_desa_2024.pdf',
            'reports/data_kesehatan_2024.xlsx',
            'reports/monitoring_umkm_2024.pdf',
            'reports/laporan_pembangunan_2024.pdf',
            'reports/data_pendidikan_2024.xlsx',
            'reports/rpjmdes_2024_2030.pdf',
            'reports/laporan_bumdes_2024.pdf',
        ];

        foreach ($files as $file) {
            if (!Storage::disk('public')->exists($file)) {
                Storage::disk('public')->put($file, $sampleContent);
            }
        }
    }
}

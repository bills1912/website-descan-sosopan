<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageRouting;
use App\Http\Controllers\JDIHController;
use App\Http\Controllers\KegiatanDesaController;
use App\Http\Controllers\ReportPublicationController;
use Illuminate\Support\Facades\Log;

Route::get('/', [PageRouting::class, 'halamanUtama'])->name('home');

// Informasi Desa Route
Route::get('/informasiDesa', [PageRouting::class, 'informasiDesa'])->name('informasi-desa');
Route::group(['prefix' => 'api/kegiatan-desa'], function () {
    // Get activity detail
    Route::get('/detail/{id}', [KegiatanDesaController::class, 'getKegiatanDetail'])
        ->name('api.kegiatan-desa.detail');

    // Get available activity types
    Route::get('/jenis-kegiatan', [KegiatanDesaController::class, 'getJenisKegiatan'])
        ->name('api.kegiatan-desa.jenis');

    // Search activities
    Route::get('/search', [KegiatanDesaController::class, 'searchKegiatan'])
        ->name('api.kegiatan-desa.search');

    // Get statistics
    Route::get('/statistik', [KegiatanDesaController::class, 'getStatistik'])
        ->name('api.kegiatan-desa.statistik');

    // Export activities
    Route::get('/export', [KegiatanDesaController::class, 'exportKegiatan'])
        ->name('api.kegiatan-desa.export');
});

// Alternative routes if you prefer different naming
Route::group(['as' => 'village.'], function () {
    Route::get('/village/information', [KegiatanDesaController::class, 'informasiDesa'])
        ->name('information');

    Route::get('/village/activities/{id}', [KegiatanDesaController::class, 'getKegiatanDetail'])
        ->name('activity.detail');
});

// Agenda Desa
Route::get('/agenda-desa', [PageRouting::class, 'agendaDesa'])->name('agenda-desa');

// Struktur Organisasi Route
Route::get('/strukturOrganisasi', [PageRouting::class, 'strukturOrganisasi'])->name('struktur-organisasi');

// Route tambahan untuk AJAX (opsional)
Route::get('/api/organisasi/{organisasi}', [PageRouting::class, 'getOrganisasiData'])->name('organisasi.data');

// TPID Route
Route::get('/tpid', [PageRouting::class, 'tpid'])->name('tpid');

// JDIH Route
Route::get('/jdih', [PageRouting::class, 'jdih'])->name('jdih');

// Route untuk JDIH
Route::get('/jdih', [JDIHController::class, 'index'])->name('jdih');

// Route untuk melihat dokumen
Route::get('/document/view/{filename}', [JDIHController::class, 'viewDocument'])->name('document.view');

// Route untuk download dokumen
Route::get('/document/download/{filename}', [JDIHController::class, 'downloadDocument'])->name('document.download');

// APBDesa Route
Route::get('/apbdes', [PageRouting::class, 'APBDes'])->name('apbdes');

// Route untuk mendapatkan data APBDes berdasarkan tahun (AJAX)
Route::get('/api/apbdes/{year}', [PageRouting::class, 'getAPBDesByYear'])->name('api.apbdes.year');

// Route untuk download APBDes PDF
Route::get('/download/apbdes/pdf/{year}', [PageRouting::class, 'downloadAPBDesPDF'])->name('download.apbdes.pdf');

// Route untuk download APBDes Excel
Route::get('/download/apbdes/excel/{year}', [PageRouting::class, 'downloadAPBDesExcel'])->name('download.apbdes.excel');

// Daftar Data Route
Route::get('/daftar-data', [PageRouting::class, 'daftarData'])->name('daftar-data');

// API routes untuk data kategori
Route::get('/api/data/{category}', [PageRouting::class, 'getDataByCategory'])->name('api.data.category');
Route::get('/api/data/{category}/export/{format}', [PageRouting::class, 'exportDataByCategory'])->name('api.data.export');

// Route untuk download file langsung dengan nama file
Route::get('/download-file/{filename}', [ReportPublicationController::class, 'downloadByFilename'])
    ->name('download.file')
    ->where('filename', '.*'); // Allow dots in filename

// Route untuk view file langsung dengan nama file  
Route::get('/view-file/{filename}', [ReportPublicationController::class, 'viewByFilename'])
    ->name('view.file')
    ->where('filename', '.*'); // Allow dots in filename

// ===== REPORTS & PUBLICATIONS =====
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportPublicationController::class, 'index'])->name('index');
    Route::get('/featured', [ReportPublicationController::class, 'featured'])->name('featured');
    Route::get('/{id}', [ReportPublicationController::class, 'show'])->name('show')->where('id', '[0-9]+');
    Route::get('/{id}/view', [ReportPublicationController::class, 'view'])->name('view');
    Route::get('/{id}/download', [ReportPublicationController::class, 'download'])->name('download');
});

// Tambahkan di web.php route yang lebih sederhana

// Tambahkan di web.php route yang lebih sederhana

Route::get('/simple-download/{id}', function ($id) {
    try {
        $report = \App\Models\ReportPublicationData::findOrFail($id);

        Log::info("Simple download request for report ID: {$id}");
        Log::info("Report title: {$report->judul}");
        Log::info("File path from DB: {$report->file_path}");

        if (!$report->file_path) {
            Log::error("No file_path in database for report ID: {$id}");
            abort(404, 'File path tidak ditemukan di database');
        }

        $filename = basename($report->file_path);
        Log::info("Looking for filename: {$filename}");

        // Coba berbagai lokasi
        $paths = [
            public_path('storage/reports/' . $filename),
            public_path('reports/' . $filename),
            storage_path('app/public/reports/' . $filename),
            storage_path('app/reports/' . $filename),
        ];

        // Jika tidak ditemukan dengan nama exact, coba scan folder
        $foundPath = null;
        foreach ($paths as $path) {
            Log::info("Checking path: {$path}");
            if (file_exists($path)) {
                $foundPath = $path;
                Log::info("✅ File found at: {$path}");
                break;
            } else {
                Log::info("❌ File not found at: {$path}");
            }
        }

        // Jika masih tidak ketemu, scan folder dan cari file yang mirip
        if (!$foundPath) {
            $reportsDir = public_path('storage/reports');
            Log::info("Scanning directory: {$reportsDir}");

            if (is_dir($reportsDir)) {
                $files = array_diff(scandir($reportsDir), ['.', '..']);
                Log::info("Available files: " . implode(', ', $files));

                // Coba exact match dulu
                if (in_array($filename, $files)) {
                    $foundPath = $reportsDir . '/' . $filename;
                    Log::info("✅ Found exact match: {$filename}");
                } else {
                    // Coba partial match
                    $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
                    Log::info("Trying partial match for: {$baseFilename}");

                    foreach ($files as $file) {
                        if (stripos($file, $baseFilename) !== false) {
                            $foundPath = $reportsDir . '/' . $file;
                            $filename = $file; // Update ke nama file yang benar
                            Log::info("✅ Found partial match: {$file}");
                            break;
                        }
                    }
                }
            }
        }

        if (!$foundPath) {
            Log::error("File not found after all attempts");
            $debugInfo = [
                'report_id' => $id,
                'searched_filename' => basename($report->file_path),
                'searched_paths' => $paths,
                'available_files' => is_dir($reportsDir ?? '') ? array_diff(scandir($reportsDir), ['.', '..']) : []
            ];

            return response()->json([
                'error' => 'File tidak ditemukan',
                'debug' => $debugInfo
            ], 404);
        }

        Log::info("✅ Starting download for: {$foundPath}");

        // Download dengan nama file asli
        return response()->download($foundPath, $filename);
    } catch (\Exception $e) {
        Log::error("Simple download error: " . $e->getMessage());
        Log::error("Stack trace: " . $e->getTraceAsString());

        return response()->json([
            'error' => 'Download error: ' . $e->getMessage()
        ], 500);
    }
})->name('simple.download');

// Route untuk view file di browser (untuk PDF)
Route::get('/simple-view/{id}', function ($id) {
    try {
        $report = \App\Models\ReportPublicationData::findOrFail($id);

        if (!$report->file_path) {
            abort(404, 'File path tidak ditemukan di database');
        }

        $filename = basename($report->file_path);

        // Coba berbagai lokasi (sama seperti download)
        $paths = [
            public_path('storage/reports/' . $filename),
            public_path('reports/' . $filename),
            storage_path('app/public/reports/' . $filename),
            storage_path('app/reports/' . $filename),
        ];

        $foundPath = null;
        foreach ($paths as $path) {
            if (file_exists($path)) {
                $foundPath = $path;
                break;
            }
        }

        // Scan folder jika tidak ketemu
        if (!$foundPath) {
            $reportsDir = public_path('storage/reports');
            if (is_dir($reportsDir)) {
                $files = array_diff(scandir($reportsDir), ['.', '..']);

                if (in_array($filename, $files)) {
                    $foundPath = $reportsDir . '/' . $filename;
                } else {
                    $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
                    foreach ($files as $file) {
                        if (stripos($file, $baseFilename) !== false) {
                            $foundPath = $reportsDir . '/' . $file;
                            $filename = $file;
                            break;
                        }
                    }
                }
            }
        }

        if (!$foundPath) {
            abort(404, 'File tidak ditemukan');
        }

        // Untuk PDF, tampilkan di browser
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($extension === 'pdf') {
            return response()->file($foundPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        }

        // Untuk file lain, download
        return response()->download($foundPath, $filename);
    } catch (\Exception $e) {
        abort(500, 'Error: ' . $e->getMessage());
    }
})->name('simple.view');

// Route untuk list semua file di folder reports (debugging)
Route::get('/list-reports-files', function () {
    $reportsDir = public_path('storage/reports');

    if (!is_dir($reportsDir)) {
        return response()->json(['error' => 'Reports directory not found: ' . $reportsDir]);
    }

    $files = array_diff(scandir($reportsDir), ['.', '..']);

    $fileDetails = [];
    foreach ($files as $file) {
        $filePath = $reportsDir . '/' . $file;
        $fileDetails[] = [
            'name' => $file,
            'size' => filesize($filePath),
            'modified' => date('Y-m-d H:i:s', filemtime($filePath)),
            'download_url' => url('/simple-download-direct/' . urlencode($file))
        ];
    }

    return response()->json([
        'directory' => $reportsDir,
        'files' => $fileDetails,
        'total_files' => count($files)
    ]);
});

// Route untuk download langsung berdasarkan nama file fisik
Route::get('/simple-download-direct/{filename}', function ($filename) {
    $filename = urldecode($filename);
    $filePath = public_path('storage/reports/' . $filename);

    if (!file_exists($filePath)) {
        abort(404, 'File tidak ditemukan: ' . $filename);
    }

    return response()->download($filePath, $filename);
})->where('filename', '.*')->name('simple.download.direct');
// Optional: Additional routes for API endpoints or admin functionality
Route::prefix('api')->group(function () {
    // API routes for data fetching
    Route::get('/penduduk', function () {
        // Return JSON data for population
        return response()->json([
            'status' => 'success',
            'data' => [
                [
                    'nik' => '3201234567890001',
                    'nama' => 'Ahmad Suryanto',
                    'kelamin' => 'Laki-laki',
                    'lahir' => '15/08/1985',
                    'alamat' => 'Dusun Maju RT 01/RW 01',
                    'status' => 'active'
                ],
                // Add more data as needed
            ]
        ]);
    })->name('api.penduduk');

    Route::get('/keuangan', function () {
        // Return JSON data for financial data
        return response()->json([
            'status' => 'success',
            'data' => [
                [
                    'kode' => 'APB-001',
                    'program' => 'Pembangunan Jalan',
                    'anggaran' => 'Rp 150.000.000',
                    'realisasi' => '87%',
                    'status' => 'active'
                ],
                // Add more data as needed
            ]
        ]);
    })->name('api.keuangan');

    Route::get('/harga-komoditas', function () {
        // Return JSON data for TPID price monitoring
        return response()->json([
            'status' => 'success',
            'data' => [
                [
                    'komoditas' => 'Beras Premium',
                    'harga' => 14500,
                    'satuan' => 'kg',
                    'perubahan' => 1.4,
                    'trend' => 'up'
                ],
                [
                    'komoditas' => 'Telur Ayam',
                    'harga' => 28000,
                    'satuan' => 'kg',
                    'perubahan' => 0,
                    'trend' => 'stable'
                ],
                // Add more data as needed
            ],
            'last_update' => now()->format('d M Y, H:i') . ' WIB'
        ]);
    })->name('api.harga-komoditas');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageRouting;
use App\Http\Controllers\JDIHController;
use App\Http\Controllers\ReportPublicationController;

Route::get('/', [PageRouting::class, 'halamanUtama'])->name('home');

// Informasi Desa Route
Route::get('/informasiDesa', [PageRouting::class, 'informasiDesa'])->name('informasi-desa');

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

// ===== REPORTS & PUBLICATIONS =====
Route::prefix('reports')->name('reports.')->group(function () {
    // Main reports endpoint dengan pagination dan filtering
    Route::get('/', [ReportPublicationController::class, 'index'])->name('index');

    // Featured reports
    Route::get('/featured', [ReportPublicationController::class, 'featured'])->name('featured');

    // Report details
    Route::get('/{id}', [ReportPublicationController::class, 'show'])->name('show')->where('id', '[0-9]+');

    // View report (untuk PDF bisa dibuka di browser)
    Route::get('/{id}/view', [ReportPublicationController::class, 'view'])->name('view');

    // Download report
    Route::get('/{id}/download', [ReportPublicationController::class, 'download'])->name('download');
});

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

<?php

namespace App\Http\Controllers;

use App\Models\DaftarProdukHukum;
use App\Models\KategoriProdukHukum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class JDIHController extends Controller
{
    /**
     * Path ke folder dokumen
     */
    private $documentPath = 'document/';

    /**
     * Daftar ekstensi file yang diizinkan
     */
    private $allowedExtensions = ['pdf', 'doc', 'docx', 'xlsx', 'xls'];

    /**
     * Database dokumen (bisa dipindah ke database sesungguhnya)
     */
    private $documentsDatabase = [];

    /**
     * Tampilkan halaman JDIH
     */
    public function index()
    {
        $kategoryProdukHukum = KategoriProdukHukum::all();
        foreach ($kategoryProdukHukum as $kategori) {
            $data_produk_hukum = DaftarProdukHukum::where('kategori_produk_hukum_id', $kategori->id)->get();
            if (!$data_produk_hukum) {
                continue; // Skip jika tidak ada produk hukum untuk kategori ini
            }

            foreach ($data_produk_hukum as $produk_hukum) {
                // Pastikan data produk hukum tidak kosong
                if (!$produk_hukum) {
                    continue;
                }

                // Tambahkan data produk hukum ke database dokumen
                $this->documentsDatabase[$kategori->slug][] = [
                    'id' => $produk_hukum->id_dok,
                    'title' => $produk_hukum->judul,
                    'year' => $produk_hukum->tahun,
                    'description' => $produk_hukum->deskripsi,
                    'filename' => $produk_hukum->dokumen,
                    'size' => $produk_hukum->ukuran,
                    'type' => $produk_hukum->tipe,
                ];
            }
        }
        $totalDocuments = 0;
        foreach ($this->documentsDatabase as $category) {
            $totalDocuments += count($category);
        }

        $data = [
            'title' => 'JDIH - Portal Desa',
            'totalDocuments' => $totalDocuments,
            'totalCategories' => count($this->documentsDatabase),
            'documentsDatabase' => $this->documentsDatabase
        ];

        return view('landingPage.components.jdih', $data);
    }

    /**
     * Cek apakah dokumen ada
     */
    public function checkDocument($filename)
    {
        try {
            $filePath = public_path($this->documentPath . $filename);

            if (!File::exists($filePath)) {
                return response()->json(['exists' => false], 404);
            }

            // Cek ekstensi file
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($extension, $this->allowedExtensions)) {
                return response()->json(['exists' => false, 'error' => 'File type not allowed'], 403);
            }

            return response()->json(['exists' => true], 200);
        } catch (\Exception $e) {
            Log::error('Error checking document: ' . $e->getMessage());
            return response()->json(['exists' => false, 'error' => 'Server error'], 500);
        }
    }

    /**
     * Tampilkan dokumen di browser
     */
    public function viewDocument($filename)
    {
        try {
            $filePath = public_path($this->documentPath . $filename);

            // Validasi file
            $validation = $this->validateFile($filePath, $filename);
            if ($validation !== true) {
                return $validation;
            }

            // Log aktivitas
            $this->logActivity('view', $filename);

            $mimeType = $this->getMimeType($filename);

            // Untuk PDF, tampilkan langsung di browser
            if ($mimeType === 'application/pdf') {
                return response()->file($filePath, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]);
            }

            // Untuk file lain, download
            return $this->downloadDocument($filename);
        } catch (\Exception $e) {
            Log::error('Error viewing document: ' . $e->getMessage());
            abort(500, 'Gagal membuka dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Download dokumen
     */
    public function downloadDocument($filename)
    {
        try {
            $filePath = public_path($this->documentPath . $filename);

            // Validasi file
            $validation = $this->validateFile($filePath, $filename);
            if ($validation !== true) {
                return $validation;
            }

            // Log aktivitas
            $this->logActivity('download', $filename);

            $mimeType = $this->getMimeType($filename);

            return response()->download($filePath, $filename, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
            ]);
        } catch (\Exception $e) {
            Log::error('Error downloading document: ' . $e->getMessage());
            abort(500, 'Gagal mengunduh dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Validasi file
     */
    private function validateFile($filePath, $filename)
    {
        // Cek apakah file ada
        if (!File::exists($filePath)) {
            abort(404, 'Dokumen tidak ditemukan');
        }

        // Cek ekstensi file
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($extension, $this->allowedExtensions)) {
            abort(403, 'Tipe file tidak diizinkan');
        }

        // Cek ukuran file (maksimal 50MB)
        $fileSize = File::size($filePath);
        if ($fileSize > 50 * 1024 * 1024) { // 50MB
            abort(413, 'Ukuran file terlalu besar');
        }

        // Cek apakah file benar-benar dapat dibaca
        if (!is_readable($filePath)) {
            abort(403, 'File tidak dapat dibaca');
        }

        return true;
    }

    /**
     * Dapatkan MIME type berdasarkan ekstensi
     */
    private function getMimeType($filename)
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Cari dokumen berdasarkan ID
     */
    private function findDocumentById($documentId)
    {
        foreach ($this->documentsDatabase as $category => $documents) {
            foreach ($documents as $document) {
                if ($document['id'] === $documentId) {
                    return $document;
                }
            }
        }
        return null;
    }

    /**
     * Log aktivitas download/view
     */
    private function logActivity($action, $filename, $userIp = null)
    {
        try {
            $logData = [
                'action' => $action,
                'filename' => $filename,
                'ip_address' => $userIp ?? request()->ip(),
                'user_agent' => request()->userAgent(),
                'timestamp' => now(),
            ];

            // Simpan ke log file
            Log::info('JDIH Activity', $logData);
        } catch (\Exception $e) {
            // Jangan sampai error log mengganggu proses utama
            Log::error('Failed to log JDIH activity', ['error' => $e->getMessage()]);
        }
    }

    /**
     * API endpoint untuk mendapatkan daftar dokumen (opsional)
     */
    public function getDocuments(Request $request)
    {
        try {
            $category = $request->get('category');
            $year = $request->get('year');
            $search = $request->get('search');

            $documents = [];

            foreach ($this->documentsDatabase as $cat => $docs) {
                if ($category && $cat !== $category) {
                    continue;
                }

                foreach ($docs as $doc) {
                    // Filter berdasarkan tahun
                    if ($year && $doc['year'] !== $year) {
                        continue;
                    }

                    // Filter berdasarkan pencarian
                    if (
                        $search &&
                        stripos($doc['title'], $search) === false &&
                        stripos($doc['description'], $search) === false
                    ) {
                        continue;
                    }

                    $documents[] = array_merge($doc, ['category' => $cat]);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $documents,
                'total' => count($documents)
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting documents: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan data dokumen',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mendapatkan statistik JDIH
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total_documents' => 0,
                'total_categories' => count($this->documentsDatabase),
                'documents_by_category' => [],
                'documents_by_year' => []
            ];

            foreach ($this->documentsDatabase as $category => $documents) {
                $stats['total_documents'] += count($documents);
                $stats['documents_by_category'][$category] = count($documents);

                foreach ($documents as $doc) {
                    $year = $doc['year'];
                    if (!isset($stats['documents_by_year'][$year])) {
                        $stats['documents_by_year'][$year] = 0;
                    }
                    $stats['documents_by_year'][$year]++;
                }
            }

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting statistics: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendapatkan statistik',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

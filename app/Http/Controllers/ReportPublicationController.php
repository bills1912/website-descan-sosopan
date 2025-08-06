<?php

namespace App\Http\Controllers;

use App\Models\ReportPublicationData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReportPublicationController extends Controller
{
    /**
     * Get reports with pagination and filtering
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Hapus filter file_path yang menyebabkan data tidak muncul
            $query = ReportPublicationData::query();

            // Apply filters
            if ($request->has('kategori') && $request->kategori != '') {
                $query->where('kategori', $request->kategori);
            }

            if ($request->has('search') && $request->search != '') {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'waktu_terbit');
            $sortOrder = $request->get('sort_order', 'desc');

            if ($sortBy === 'waktu_terbit') {
                $query->orderBy('waktu_terbit', $sortOrder)
                    ->orderBy('created_at', $sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }

            // Pagination - ubah default menjadi 3
            $perPage = $request->get('per_page', 3);
            $reports = $query->paginate($perPage);

            // Transform data for frontend
            $reports->getCollection()->transform(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->judul,
                    'description' => $report->deskripsi,
                    'category' => $report->kategori,
                    'category_label' => $report->category_label,
                    'file_type' => $report->file_type,
                    'file_size' => $report->formatted_file_size,
                    'type_icon' => $report->type_icon,
                    'publication_date' => $report->publication_date->format('d M Y'),
                    'download_count' => rand(10, 100), // Mock data since no field
                    'view_count' => rand(50, 200), // Mock data since no field
                    'download_url' => $report->download_url,
                    'view_url' => $report->view_url,
                    'is_featured' => in_array($report->kategori, ['annual_report', 'financial_report', 'village_profile']),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $reports->items(),
                'pagination' => [
                    'current_page' => $reports->currentPage(),
                    'last_page' => $reports->lastPage(),
                    'per_page' => $reports->perPage(),
                    'total' => $reports->total(),
                    'from' => $reports->firstItem(),
                    'to' => $reports->lastItem(),
                ],
                'filters' => [
                    'categories' => $this->getAvailableCategories(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching reports: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data laporan'
            ], 500);
        }
    }

    /**
     * View document
     */
    public function view($id)
    {
        try {
            $report = ReportPublicationData::findOrFail($id);

            // Increment view count (mock implementation)
            $report->incrementViewCount();

            // Jika tidak ada file fisik, tampilkan informasi dokumen
            if (!$report->file_path || !Storage::exists($report->file_path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File fisik tidak tersedia, namun informasi dokumen dapat dilihat di detail laporan'
                ], 404);
            }

            $filePath = Storage::path($report->file_path);
            $mimeType = Storage::mimeType($report->file_path);

            // For PDF files, display in browser
            if ($report->file_type === 'pdf') {
                return Response::file($filePath, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . basename($report->file_path) . '"'
                ]);
            }

            // For other files, download them
            return $this->download($id);
        } catch (\Exception $e) {
            Log::error('Error viewing document: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuka dokumen'
            ], 500);
        }
    }

    /**
     * Download document
     */
    public function download($id)
    {
        try {
            $report = ReportPublicationData::findOrFail($id);

            // Increment download count (mock implementation)
            $report->incrementDownloadCount();

            if (!$report->file_path) {
                return response()->json([
                    'success' => false,
                    'message' => 'Path file tidak ditemukan di database.'
                ], 404);
            }

            // Coba berbagai kemungkinan path
            $possiblePaths = [
                $report->file_path,
                'reports/' . basename($report->file_path),
                'public/reports/' . basename($report->file_path),
            ];

            $foundPath = null;
            $disk = 'local';

            // Cek di default storage
            foreach ($possiblePaths as $path) {
                if (Storage::exists($path)) {
                    $foundPath = $path;
                    $disk = 'local';
                    break;
                }
            }

            // Jika tidak ditemukan, cek di public disk
            if (!$foundPath) {
                foreach ($possiblePaths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        $foundPath = $path;
                        $disk = 'public';
                        break;
                    }
                }
            }

            // Jika masih tidak ditemukan, cek file fisik langsung
            if (!$foundPath) {
                $publicPaths = [
                    public_path('storage/reports/' . basename($report->file_path)),
                    public_path('reports/' . basename($report->file_path)),
                    public_path('storage/' . $report->file_path),
                ];

                foreach ($publicPaths as $path) {
                    if (file_exists($path)) {
                        $filename = $report->judul . '.' . $report->file_type;
                        return response()->download($path, $filename);
                    }
                }
            }

            if (!$foundPath) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan. Debug info: Path database = ' . $report->file_path . ', Filename = ' . basename($report->file_path)
                ], 404);
            }

            $filename = $report->judul . '.' . $report->file_type;

            if ($disk === 'public') {
                $filePath = Storage::disk('public')->path($foundPath);
                return response()->download($filePath, $filename);
            } else {
                return Storage::download($foundPath, $filename);
            }

        } catch (\Exception $e) {
            Log::error('Error downloading document: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunduh dokumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download file by filename
     */
    public function downloadByFilename($filename)
    {
        try {
            // Sanitize filename untuk keamanan
            $filename = basename($filename);
            
            // Decode URL jika ada encoding
            $filename = urldecode($filename);
            
            Log::info("Trying to download file: " . $filename);
            
            // Coba berbagai kemungkinan lokasi file
            $possiblePaths = [
                public_path('storage/reports/' . $filename),
                public_path('reports/' . $filename),
                storage_path('app/public/reports/' . $filename),
                storage_path('app/reports/' . $filename),
            ];

            // Jika filename dari database tidak sesuai, coba juga tanpa extension dan dengan extension berbeda
            $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
            $extensions = ['pdf', 'xlsx', 'docx', 'doc'];
            
            foreach ($extensions as $ext) {
                $possiblePaths[] = public_path('storage/reports/' . $baseFilename . '.' . $ext);
                $possiblePaths[] = public_path('reports/' . $baseFilename . '.' . $ext);
                $possiblePaths[] = storage_path('app/public/reports/' . $baseFilename . '.' . $ext);
                $possiblePaths[] = storage_path('app/reports/' . $baseFilename . '.' . $ext);
            }

            // Log semua path yang dicoba
            Log::info("Searching in paths: " . implode(', ', $possiblePaths));

            $foundPath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $foundPath = $path;
                    Log::info("File found at: " . $path);
                    break;
                }
            }

            if (!$foundPath) {
                // Coba scan folder reports untuk mencari file yang mirip
                $reportsDir = public_path('storage/reports');
                if (is_dir($reportsDir)) {
                    $files = scandir($reportsDir);
                    $matchedFile = null;
                    
                    foreach ($files as $file) {
                        if ($file === '.' || $file === '..') continue;
                        
                        // Coba match berdasarkan nama tanpa extension
                        if (stripos($file, $baseFilename) !== false) {
                            $matchedFile = $file;
                            break;
                        }
                    }
                    
                    if ($matchedFile) {
                        $foundPath = $reportsDir . '/' . $matchedFile;
                        $filename = $matchedFile; // Update filename ke yang benar
                        Log::info("Found similar file: " . $matchedFile);
                    }
                }
            }

            if (!$foundPath) {
                Log::error("File not found: " . $filename);
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan: ' . $filename . '. Lokasi dicari: ' . implode(', ', array_slice($possiblePaths, 0, 4))
                ], 404);
            }

            // Dapatkan nama file asli untuk download
            $originalFilename = basename($foundPath);
            
            // Return file untuk download dengan nama asli
            return response()->download($foundPath, $originalFilename);

        } catch (\Exception $e) {
            Log::error('Error downloading file: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunduh file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * View file by filename
     */
    public function viewByFilename($filename)
    {
        try {
            $filename = basename($filename);
            
            $possiblePaths = [
                public_path('storage/reports/' . $filename),
                public_path('reports/' . $filename),
                storage_path('app/public/reports/' . $filename),
                storage_path('app/reports/' . $filename),
            ];

            $foundPath = null;
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $foundPath = $path;
                    break;
                }
            }

            if (!$foundPath) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan: ' . $filename
                ], 404);
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
            Log::error('Error viewing file: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuka file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get report details
     */
    public function show($id): JsonResponse
    {
        try {
            $report = ReportPublicationData::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $report->id,
                    'title' => $report->judul,
                    'description' => $report->deskripsi,
                    'category' => $report->kategori,
                    'category_label' => $report->category_label,
                    'file_type' => $report->file_type,
                    'file_size' => $report->formatted_file_size,
                    'type_icon' => $report->type_icon,
                    'publication_date' => $report->publication_date->format('d M Y'),
                    'publisher' => 'Pemerintah Desa Sosopan',
                    'version' => '1.0',
                    'download_count' => rand(10, 100), // Mock data
                    'view_count' => rand(50, 200), // Mock data
                    'download_url' => $report->download_url,
                    'view_url' => $report->view_url,
                    'is_featured' => in_array($report->kategori, ['annual_report', 'financial_report', 'village_profile']),
                    'has_file' => $report->file_path && Storage::exists($report->file_path),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching report details: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail laporan'
            ], 500);
        }
    }

    /**
     * Get featured reports
     */
    public function featured(): JsonResponse
    {
        try {
            // Hapus filter file_path agar semua data bisa muncul
            $reports = ReportPublicationData::whereIn('kategori', ['annual_report', 'financial_report', 'village_profile'])
                ->orderBy('waktu_terbit', 'desc')
                ->limit(6)
                ->get();

            $reports->transform(function ($report) {
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
                    'formatted_file_size' => $report->formatted_file_size,
                    'download_count' => rand(10, 100), // Mock data
                    'has_file' => $report->file_path && Storage::exists($report->file_path),
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $reports
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching featured reports: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil laporan unggulan'
            ], 500);
        }
    }

    /**
     * Get available categories
     */
    private function getAvailableCategories(): array
    {
        return [
            'annual_report' => 'Laporan Tahunan',
            'financial_report' => 'Laporan Keuangan',
            'demographic_data' => 'Data Demografi',
            'health_data' => 'Data Kesehatan',
            'education_data' => 'Data Pendidikan',
            'economic_data' => 'Data Ekonomi',
            'village_profile' => 'Profil Desa',
            'development_report' => 'Laporan Pembangunan',
            'other' => 'Lainnya'
        ];
    }
}
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
            $query = ReportPublicationData::whereNotNull('file_path');
            dd($query);

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

            // Pagination
            $perPage = $request->get('per_page', 6);
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

            // Check if file exists
            if (!$report->file_path || !Storage::exists($report->file_path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan'
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

            // Check if file exists
            if (!$report->file_path || !Storage::exists($report->file_path)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan'
                ], 404);
            }

            $filename = $report->judul . '.' . $report->file_type;
            return Storage::download($report->file_path, $filename);
        } catch (\Exception $e) {
            Log::error('Error downloading document: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengunduh dokumen'
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
            $reports = ReportPublicationData::whereNotNull('file_path')
                ->whereIn('kategori', ['annual_report', 'financial_report', 'village_profile'])
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

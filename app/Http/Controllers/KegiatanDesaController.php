<?php

namespace App\Http\Controllers;

use App\Models\KegiatanDesa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KegiatanDesaController extends Controller
{

    /**
     * Get activity details for AJAX requests
     */
    public function getKegiatanDetail($id)
    {
        try {
            $kegiatan = KegiatanDesa::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $kegiatan->id,
                    'judul_kegiatan' => $kegiatan->judul_kegiatan,
                    'jenis_kegiatan' => $kegiatan->jenis_kegiatan,
                    'deskripsi_kegiatan' => $kegiatan->deskripsi_kegiatan,
                    'tanggal_kegiatan' => Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y'),
                    'tanggal_kegiatan_raw' => $kegiatan->tanggal_kegiatan,
                    'lokasi_kegiatan' => $kegiatan->lokasi_kegiatan,
                    'penanggung_jawab' => $kegiatan->penanggung_jawab,
                    'file_path' => $kegiatan->file_path ? asset('storage/' . $kegiatan->file_path) : null,
                    'created_at' => $kegiatan->created_at->format('d M Y H:i'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kegiatan tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Get available activity types for filter
     */
    public function getJenisKegiatan()
    {
        $jenisKegiatan = KegiatanDesa::select('jenis_kegiatan')
            ->distinct()
            ->whereNotNull('jenis_kegiatan')
            ->pluck('jenis_kegiatan')
            ->map(function ($jenis) {
                return [
                    'value' => $jenis,
                    'label' => ucfirst($jenis)
                ];
            });

        return response()->json($jenisKegiatan);
    }

    /**
     * Search activities (for AJAX search functionality)
     */
    public function searchKegiatan(Request $request)
    {
        $query = KegiatanDesa::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_kegiatan', 'like', "%{$searchTerm}%")
                    ->orWhere('deskripsi_kegiatan', 'like', "%{$searchTerm}%")
                    ->orWhere('lokasi_kegiatan', 'like', "%{$searchTerm}%")
                    ->orWhere('penanggung_jawab', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->jenis_kegiatan);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_kegiatan', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_kegiatan', '<=', $request->tanggal_sampai);
        }

        $activities = $query->orderBy('tanggal_kegiatan', 'desc')
            ->paginate(3)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'data' => $activities->items(),
            'pagination' => [
                'current_page' => $activities->currentPage(),
                'last_page' => $activities->lastPage(),
                'per_page' => $activities->perPage(),
                'total' => $activities->total(),
                'has_more_pages' => $activities->hasMorePages(),
            ]
        ]);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistik()
    {
        $totalKegiatan = KegiatanDesa::count();
        $kegiatanBulanIni = KegiatanDesa::whereMonth('tanggal_kegiatan', Carbon::now()->month)
            ->whereYear('tanggal_kegiatan', Carbon::now()->year)
            ->count();

        $kegiatanPerJenis = KegiatanDesa::selectRaw('jenis_kegiatan, COUNT(*) as total')
            ->groupBy('jenis_kegiatan')
            ->pluck('total', 'jenis_kegiatan');

        $kegiatanTerbaru = KegiatanDesa::orderBy('tanggal_kegiatan', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'total_kegiatan' => $totalKegiatan,
            'kegiatan_bulan_ini' => $kegiatanBulanIni,
            'kegiatan_per_jenis' => $kegiatanPerJenis,
            'kegiatan_terbaru' => $kegiatanTerbaru
        ]);
    }

    /**
     * Export activities to Excel/PDF
     */
    public function exportKegiatan(Request $request)
    {
        $query = KegiatanDesa::query();

        // Apply same filters as main query
        if ($request->filled('jenis_kegiatan')) {
            $query->where('jenis_kegiatan', $request->jenis_kegiatan);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_kegiatan', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_kegiatan', '<=', $request->tanggal_sampai);
        }

        $kegiatan = $query->orderBy('tanggal_kegiatan', 'desc')->get();

        // Here you can implement Excel/PDF export logic
        // For now, returning JSON data
        return response()->json([
            'success' => true,
            'data' => $kegiatan,
            'message' => 'Data berhasil diekspor'
        ]);
    }
}

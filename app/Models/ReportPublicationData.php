<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReportPublicationData extends Model
{
    // add fillable
    protected $fillable = [];
    // add guarded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'waktu_terbit' => 'datetime'
    ];

    // Accessors
    protected function formattedFileSize(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFileSize()
        );
    }

    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->file_path ? Storage::url($this->file_path) : null
        );
    }

    protected function downloadUrl(): Attribute
    {
        return Attribute::make(
            get: function() {
                if ($this->file_path) {
                    $filename = basename($this->file_path);
                    return route('download.file', ['filename' => $filename]);
                }
                return route('reports.download', $this->id);
            }
        );
    }

    protected function viewUrl(): Attribute
    {
        return Attribute::make(
            get: function() {
                if ($this->file_path) {
                    $filename = basename($this->file_path);
                    return route('view.file', ['filename' => $filename]);
                }
                return route('reports.view', $this->id);
            }
        );
    }

    protected function categoryLabel(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getCategoryLabel($this->kategori)
        );
    }

    protected function typeIcon(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getTypeIcon()
        );
    }

    protected function publicationDate(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->waktu_terbit) {
                    try {
                        return Carbon::parse($this->waktu_terbit);
                    } catch (\Exception $e) {
                        return $this->created_at;
                    }
                }
                return $this->created_at;
            }
        );
    }

    protected function fileType(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFileExtension()
        );
    }

    // Scopes - Perbaiki scope published agar tidak memfilter berdasarkan file_path
    public function scopePublished($query)
    {
        // Kembalikan semua record, tidak perlu filter file_path
        return $query;
    }

    public function scopeFeatured($query)
    {
        return $query->whereIn('kategori', ['annual_report', 'financial_report', 'village_profile']);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('waktu_terbit', 'desc')
            ->orOrderBy('created_at', 'desc')
            ->limit($limit);
    }

    // Accessor untuk cek file exists - versi simple dan reliable
    protected function hasFile(): Attribute
    {
        return Attribute::make(
            get: function() {
                if (!$this->file_path) {
                    return false;
                }
                
                $filename = basename($this->file_path);
                
                // Primary check: file di public/storage/reports
                $primaryPath = public_path('storage/reports/' . $filename);
                if (file_exists($primaryPath)) {
                    return true;
                }
                
                // Secondary check: scan directory untuk partial match
                $reportsDir = public_path('storage/reports');
                if (is_dir($reportsDir)) {
                    $files = array_diff(scandir($reportsDir), ['.', '..']);
                    
                    // Exact match
                    if (in_array($filename, $files)) {
                        return true;
                    }
                    
                    // Partial match
                    $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
                    foreach ($files as $file) {
                        if (stripos($file, $baseFilename) !== false) {
                            return true;
                        }
                    }
                }
                
                return false;
            }
        );
    }

    // Methods
    public function incrementDownloadCount()
    {
        // Since we don't have download_count field, we can implement this later
        // or track it in a separate table/cache
        return true;
    }

    public function incrementViewCount()
    {
        // Since we don't have view_count field, we can implement this later
        // or track it in a separate table/cache
        return true;
    }

    // Helper methods
    private function getFileSize()
    {
        if (!$this->file_path) {
            return $this->getEstimatedFileSize();
        }
        
        // Coba berbagai kemungkinan path
        $possiblePaths = [
            $this->file_path, // Path asli dari database
            'reports/' . basename($this->file_path), // Jika hanya nama file
            'public/reports/' . basename($this->file_path), // Jika di public/reports
        ];
        
        foreach ($possiblePaths as $path) {
            if (Storage::exists($path)) {
                $bytes = Storage::size($path);
                return $this->formatBytes($bytes);
            }
            
            // Cek di disk public
            if (Storage::disk('public')->exists($path)) {
                $bytes = Storage::disk('public')->size($path);
                return $this->formatBytes($bytes);
            }
        }
        
        // Cek file fisik langsung di public/storage
        $publicPaths = [
            public_path('storage/reports/' . basename($this->file_path)),
            public_path('reports/' . basename($this->file_path)),
            public_path('storage/' . $this->file_path),
        ];
        
        foreach ($publicPaths as $path) {
            if (file_exists($path)) {
                $bytes = filesize($path);
                return $this->formatBytes($bytes);
            }
        }
        
        return 'File tidak tersedia';
    }

    private function checkFileExists()
    {
        if (!$this->file_path) {
            return false;
        }
        
        // Ambil nama file dari database path
        $filename = basename($this->file_path);
        
        // Coba berbagai kemungkinan path (sama dengan yang digunakan di simple-download)
        $possiblePaths = [
            public_path('storage/reports/' . $filename),
            public_path('reports/' . $filename),
            storage_path('app/public/reports/' . $filename),
            storage_path('app/reports/' . $filename),
        ];
        
        // Cek setiap path
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                return true;
            }
        }
        
        // Jika tidak ditemukan dengan nama exact, coba scan folder dan cari file yang mirip
        $reportsDir = public_path('storage/reports');
        
        if (is_dir($reportsDir)) {
            $files = array_diff(scandir($reportsDir), ['.', '..']);
            
            // Coba exact match dulu
            if (in_array($filename, $files)) {
                return true;
            }
            
            // Coba partial match
            $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
            
            foreach ($files as $file) {
                if (stripos($file, $baseFilename) !== false) {
                    return true;
                }
            }
        }
        
        return false;
    }

    private function getEstimatedFileSize()
    {
        // Berikan estimasi ukuran file berdasarkan kategori
        $estimates = [
            'annual_report' => '2.5 MB',
            'financial_report' => '1.8 MB',
            'village_profile' => '3.2 MB',
            'demographic_data' => '850 KB',
            'health_data' => '1.2 MB',
            'education_data' => '980 KB',
            'economic_data' => '1.5 MB',
            'development_report' => '2.1 MB',
            'other' => '1.0 MB'
        ];

        return $estimates[$this->kategori] ?? '1.0 MB';
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function getCategoryLabel($category)
    {
        $labels = [
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

        return $labels[$category] ?? 'Tidak Diketahui';
    }

    private function getFileExtension()
    {
        if (!$this->file_path) {
            // Berikan default berdasarkan kategori
            $defaultTypes = [
                'annual_report' => 'pdf',
                'financial_report' => 'pdf',
                'village_profile' => 'pdf',
                'demographic_data' => 'xlsx',
                'health_data' => 'xlsx',
                'education_data' => 'xlsx',
                'economic_data' => 'pdf',
                'development_report' => 'pdf',
                'other' => 'pdf'
            ];

            return $defaultTypes[$this->kategori] ?? 'pdf';
        }

        return strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
    }

    private function getTypeIcon()
    {
        $fileType = $this->getFileExtension();

        $icons = [
            'pdf' => 'fas fa-file-pdf',
            'doc' => 'fas fa-file-word',
            'docx' => 'fas fa-file-word',
            'xls' => 'fas fa-file-excel',
            'xlsx' => 'fas fa-file-excel',
            'ppt' => 'fas fa-file-powerpoint',
            'pptx' => 'fas fa-file-powerpoint',
            'jpg' => 'fas fa-file-image',
            'jpeg' => 'fas fa-file-image',
            'png' => 'fas fa-file-image',
            'gif' => 'fas fa-file-image',
            'zip' => 'fas fa-file-archive',
            'rar' => 'fas fa-file-archive',
        ];

        return $icons[$fileType] ?? 'fas fa-file';
    }
}
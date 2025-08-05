<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ReportPublicationData extends Model
{
    //

    // add fillable
    protected $fillable = [];
    // add guaded
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
            get: fn() => route('reports.download', $this->id)
        );
    }

    protected function viewUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => route('reports.view', $this->id)
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

    // Scopes
    public function scopePublished($query)
    {
        return $query->whereNotNull('file_path');
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
        if (!$this->file_path || !Storage::exists($this->file_path)) {
            return 'N/A';
        }

        $bytes = Storage::size($this->file_path);
        return $this->formatBytes($bytes);
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
            return 'unknown';
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

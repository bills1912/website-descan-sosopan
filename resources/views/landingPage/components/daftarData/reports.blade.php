<section class="reports-section">
    <div class="container">
        <h2 class="section-title">Laporan & Publikasi</h2>

        <!-- Reports Controls -->
        <div class="reports-controls">
            <div class="reports-filters">
                <select id="category-filter-reports" class="filter-select">
                    <option value="">Semua Kategori</option>
                </select>
            </div>
            <div class="reports-search">
                <i class="fas fa-search"></i>
                <input type="text" id="search-reports" placeholder="Cari laporan atau publikasi...">
            </div>
        </div>

        <!-- Loading Spinner -->
        <div class="loading-spinner" id="loading-reports">
            <div class="spinner"></div>
        </div>

        <!-- Reports Grid -->
        <div class="report-grid" id="reports-grid">
            @if ($featuredReports && $featuredReports->isNotEmpty())
                @foreach ($featuredReports as $report)
                    <div class="report-card">
                        <div class="report-header">
                            <div class="report-title">{{ $report['title'] ?? 'Judul tidak tersedia' }}</div>
                            <div class="report-meta">
                                <div class="report-date">{{ $report['publication_date'] ?? 'Tanggal tidak tersedia' }}
                                </div>
                                <div class="report-category">
                                    {{ $report['category_label'] ?? 'Kategori tidak tersedia' }}</div>
                            </div>
                        </div>
                        <p class="report-description">{{ $report['description'] ?? 'Deskripsi tidak tersedia' }}</p>
                        <div class="report-stats">
                            <div class="report-stat">
                                <i class="{{ $report['type_icon'] ?? 'fas fa-file' }}"></i>
                                <span>{{ strtoupper($report['file_type'] ?? 'FILE') }}</span>
                            </div>
                            <div class="report-stat">
                                <i class="fas fa-file-alt"></i>
                                <span>{{ $report['formatted_file_size'] ?? 'N/A' }}</span>
                            </div>
                            <div class="report-stat">
                                <i class="fas fa-download"></i>
                                <span>{{ $report['download_count'] ?? 0 }} downloads</span>
                            </div>
                        </div>
                        <div class="report-actions">
                            @if ($report['has_file'] ?? false)
                                @php
                                    $filename = isset($report['file_path'])
                                        ? basename($report['file_path'])
                                        : 'file_' . $report['id'] . '.pdf';
                                @endphp
                                <button class="report-btn btn-download"
                                    onclick="downloadFileByName('{{ $filename }}')">
                                    <i class="fas fa-download"></i>
                                    Download
                                </button>
                            @else
                                <button class="report-btn btn-download" onclick="showFileNotAvailable()"
                                    style="opacity: 0.6; cursor: not-allowed;">
                                    <i class="fas fa-download"></i>
                                    File Tidak Tersedia
                                </button>
                            @endif
                            <button class="report-btn btn-view-report" onclick="viewReport({{ $report['id'] ?? 0 }})">
                                <i class="fas fa-eye"></i>
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-data">
                    <i class="fas fa-file-alt"></i>
                    <h3>Belum Ada Laporan</h3>
                    <p>Laporan dan publikasi akan ditampilkan di sini setelah data tersedia.</p>
                    <button class="report-btn btn-download" onclick="loadReports(1)" style="margin-top: 1rem;">
                        <i class="fas fa-sync"></i>
                        Muat Ulang Data
                    </button>
                </div>
            @endif
        </div>

        <!-- No Data Message -->
        <div class="no-data" id="no-reports" style="display: none;">
            <i class="fas fa-search"></i>
            <h3>Tidak Ada Data</h3>
            <p>Tidak ditemukan laporan yang sesuai dengan kriteria pencarian.</p>
        </div>

        <!-- Pagination -->
        <div class="reports-pagination" id="reports-pagination" style="display: none;">
            <button class="pagination-btn" id="prev-reports" onclick="prevPageReports()">
                <i class="fas fa-chevron-left"></i>
                Sebelumnya
            </button>
            <span class="pagination-info" id="pagination-info-reports"></span>
            <button class="pagination-btn" id="next-reports" onclick="nextPageReports()">
                Selanjutnya
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Load More Button (Alternative to pagination) -->
        <div class="text-center" style="margin-top: 2rem;">
            <button class="report-btn btn-download" onclick="loadReports(1)" id="load-more-reports">
                <i class="fas fa-plus"></i>
                Lihat Semua Laporan
            </button>
        </div>
    </div>
</section>

<script>
    // Initialize when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we need to show "Load More" button
        const totalReports = {{ $totalReports ?? 0 }};
        const featuredCount = {{ $featuredReports->count() }};

        if (totalReports > featuredCount) {
            const loadMoreBtn = document.getElementById('load-more-reports');
            if (loadMoreBtn) {
                loadMoreBtn.style.display = 'inline-flex';
                loadMoreBtn.onclick = function() {
                    loadReports(1);
                    this.style.display = 'none';
                };
            }
        } else {
            const loadMoreBtn = document.getElementById('load-more-reports');
            if (loadMoreBtn) {
                loadMoreBtn.style.display = 'none';
            }
        }
    });
</script>

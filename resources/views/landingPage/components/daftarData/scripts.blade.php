<script>
    // ===== GLOBAL VARIABLES =====
    let reportsData = {
        currentPage: 1,
        perPage: 3, // Ubah dari 6 menjadi 3
        totalPages: 1,
        filters: {
            category: '',
            type: '',
            search: ''
        }
    };

    // Sample data for different categories
    const sampleData = {
        penduduk: [{
                nik: '3201234567890001',
                nama: 'Ahmad Suryanto',
                kelamin: 'Laki-laki',
                lahir: '15/08/1985',
                alamat: 'Dusun Maju RT 01/RW 01',
                status: 'active'
            },
            {
                nik: '3201234567890002',
                nama: 'Siti Nurhaliza',
                kelamin: 'Perempuan',
                lahir: '22/12/1990',
                alamat: 'Dusun Sejahtera RT 02/RW 01',
                status: 'active'
            },
            {
                nik: '3201234567890003',
                nama: 'Budi Hartono',
                kelamin: 'Laki-laki',
                lahir: '03/05/1978',
                alamat: 'Dusun Harmoni RT 01/RW 02',
                status: 'inactive'
            },
            {
                nik: '3201234567890004',
                nama: 'Ratna Dewi',
                kelamin: 'Perempuan',
                lahir: '18/09/1993',
                alamat: 'Dusun Maju RT 03/RW 01',
                status: 'pending'
            },
            {
                nik: '3201234567890005',
                nama: 'Eko Prasetyo',
                kelamin: 'Laki-laki',
                lahir: '27/01/1987',
                alamat: 'Dusun Sejahtera RT 01/RW 02',
                status: 'active'
            }
        ],
        keuangan: [{
                kode: 'APB-001',
                program: 'Pembangunan Jalan',
                anggaran: 'Rp 150.000.000',
                realisasi: '87%',
                status: 'active'
            },
            {
                kode: 'APB-002',
                program: 'Program Kesehatan',
                anggaran: 'Rp 75.000.000',
                realisasi: '95%',
                status: 'active'
            },
            {
                kode: 'APB-003',
                program: 'Bantuan Sosial',
                anggaran: 'Rp 200.000.000',
                realisasi: '73%',
                status: 'pending'
            }
        ]
    };

    let currentData = [];
    let currentPage = 1;
    let itemsPerPage = 10;

    // ===== REPORTS FUNCTIONALITY =====
    async function loadReports(page = 1) {
        showLoading(true);

        try {
            const params = new URLSearchParams({
                page: page,
                per_page: reportsData.perPage,
                kategori: reportsData.filters.category,
                search: reportsData.filters.search
            });

            const response = await fetch(`/reports?${params}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();

            if (data.success) {
                renderReports(data.data);
                updatePaginationReports(data.pagination);
                updateFiltersOptions(data.filters);
                reportsData.currentPage = data.pagination.current_page;
                reportsData.totalPages = data.pagination.last_page;
            } else {
                showNoReportsMessage();
            }
        } catch (error) {
            console.error('Error loading reports:', error);
            showNoReportsMessage();
        } finally {
            showLoading(false);
        }
    }

    // Function untuk download yang konsisten dengan loading dan notifikasi
    function downloadReportFile(reportId, hasFile = true) {
        if (!hasFile) {
            showFileNotAvailable();
            return;
        }
        
        // Tampilkan loading pada tombol yang diklik
        const btn = event?.target?.closest('.btn-download');
        let originalText = '';
        
        if (btn) {
            originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Downloading...';
            btn.disabled = true;
        }
        
        // Tampilkan notifikasi
        showNotification('Download dimulai...', 'success');
        
        // Redirect ke route simple download
        setTimeout(() => {
            window.location.href = `/simple-download/${reportId}`;
            
            // Restore tombol setelah sedikit delay
            if (btn) {
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);
            }
        }, 500); // Delay sedikit untuk user experience
    }

    function renderReports(reports) {
        const grid = document.getElementById('reports-grid');
        const noReports = document.getElementById('no-reports');

        if (reports.length === 0) {
            grid.style.display = 'none';
            noReports.style.display = 'block';
            document.getElementById('reports-pagination').style.display = 'none';
            return;
        }

        grid.style.display = 'grid';
        noReports.style.display = 'none';

        grid.innerHTML = reports.map(report => {
            return `
            <div class="report-card">
                <div class="report-header">
                    <div class="report-title">${report.title}</div>
                    <div class="report-meta">
                        <div class="report-date">${report.publication_date}</div>
                        <div class="report-category">${report.category_label}</div>
                    </div>
                </div>
                <p class="report-description">${report.description}</p>
                ${report.summary ? `<p class="report-summary">${report.summary}</p>` : ''}
                <div class="report-stats">
                    <div class="report-stat">
                        <i class="${report.type_icon}"></i>
                        <span>${report.file_type.toUpperCase()}</span>
                    </div>
                    <div class="report-stat">
                        <i class="fas fa-file-alt"></i>
                        <span>${report.file_size || report.formatted_file_size}</span>
                    </div>
                    <div class="report-stat">
                        <i class="fas fa-download"></i>
                        <span>${report.download_count} downloads</span>
                    </div>
                </div>
                <div class="report-actions">
                    ${report.has_file !== false ? `
                        <button class="report-btn btn-download" onclick="downloadReportFile(${report.id}, true)">
                            <i class="fas fa-download"></i>
                            Download
                        </button>
                    ` : `
                        <button class="report-btn btn-download" onclick="downloadReportFile(${report.id}, false)" style="opacity: 0.6; cursor: not-allowed;">
                            <i class="fas fa-download"></i>
                            File Tidak Tersedia
                        </button>
                    `}
                    <button class="report-btn btn-view-report" onclick="viewReport(${report.id})">
                        <i class="fas fa-eye"></i>
                        Lihat Detail
                    </button>
                </div>
            </div>
        `}).join('');
    }

    function updatePaginationReports(pagination) {
        const paginationContainer = document.getElementById('reports-pagination');
        const paginationInfo = document.getElementById('pagination-info-reports');
        const prevBtn = document.getElementById('prev-reports');
        const nextBtn = document.getElementById('next-reports');

        if (pagination.last_page <= 1) {
            paginationContainer.style.display = 'none';
            return;
        }

        paginationContainer.style.display = 'flex';
        paginationInfo.textContent =
            `Halaman ${pagination.current_page} dari ${pagination.last_page} (${pagination.from || 0}-${pagination.to || 0} dari ${pagination.total} data)`;

        prevBtn.disabled = pagination.current_page === 1;
        nextBtn.disabled = pagination.current_page === pagination.last_page;
    }

    function updateFiltersOptions(filters) {
        const categorySelect = document.getElementById('category-filter-reports');

        if (!categorySelect) return;

        // Update category options
        categorySelect.innerHTML = '<option value="">Semua Kategori</option>';
        
        if (filters && filters.categories) {
            Object.entries(filters.categories).forEach(([key, value]) => {
                const option = document.createElement('option');
                option.value = key;
                option.textContent = value;
                if (key === reportsData.filters.category) option.selected = true;
                categorySelect.appendChild(option);
            });
        }
    }

    function showLoading(show) {
        const loading = document.getElementById('loading-reports');
        const grid = document.getElementById('reports-grid');

        if (loading && grid) {
            if (show) {
                loading.style.display = 'flex';
                grid.style.display = 'none';
            } else {
                loading.style.display = 'none';
                grid.style.display = 'grid';
            }
        }
    }

    function showNoReportsMessage() {
        const grid = document.getElementById('reports-grid');
        const noReports = document.getElementById('no-reports');
        const pagination = document.getElementById('reports-pagination');
        
        if (grid) grid.style.display = 'none';
        if (noReports) noReports.style.display = 'block';
        if (pagination) pagination.style.display = 'none';
        
        showLoading(false);
    }

    function prevPageReports() {
        if (reportsData.currentPage > 1) {
            loadReports(reportsData.currentPage - 1);
        }
    }

    function nextPageReports() {
        if (reportsData.currentPage < reportsData.totalPages) {
            loadReports(reportsData.currentPage + 1);
        }
    }

    function showFileNotAvailable() {
        showNotification('File belum tersedia untuk diunduh. Silakan hubungi administrator.', 'info');
    }

    // Definisi function downloadReport dan viewReport yang menggunakan URL langsung
    async function downloadReport(reportId) {
        // Ambil URL download dari data attribute atau gunakan ID
        const reportCard = event?.target?.closest('.report-card');
        let downloadUrl = `/reports/${reportId}/download`; // fallback
        
        // Cari URL download dari data yang ada
        const downloadBtn = event?.target?.closest('.btn-download');
        if (downloadBtn && downloadBtn.dataset.downloadUrl) {
            downloadUrl = downloadBtn.dataset.downloadUrl;
        }

        try {
            // Tampilkan loading pada tombol
            const btn = event?.target?.closest('.btn-download');
            if (btn) {
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Downloading...';
                btn.disabled = true;
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 3000);
            }

            // Untuk download file, kita bisa langsung redirect ke URL
            window.location.href = downloadUrl;
            showNotification('Download dimulai...', 'success');

        } catch (error) {
            console.error('Download error:', error);
            showNotification('Gagal mengunduh file. Silakan coba lagi.', 'error');
        }
    }

    // Function untuk download berdasarkan nama file langsung
    function downloadFileByName(filename) {
        try {
            const downloadUrl = `/download-file/${encodeURIComponent(filename)}`;
            window.location.href = downloadUrl;
            showNotification('Download dimulai...', 'success');
        } catch (error) {
            console.error('Download error:', error);
            showNotification('Gagal mengunduh file. Silakan coba lagi.', 'error');
        }
    }

    // Function untuk view berdasarkan nama file langsung
    function viewFileByName(filename) {
        try {
            const viewUrl = `/view-file/${encodeURIComponent(filename)}`;
            window.open(viewUrl, '_blank');
        } catch (error) {
            console.error('View error:', error);
            showNotification('Gagal membuka file. Silakan coba lagi.', 'error');
        }
    }

    async function viewReport(reportId) {
        try {
            openModal('report-modal');

            document.getElementById('modal-report-content').innerHTML = `
                <div class="loading-spinner" style="display: flex;">
                    <div class="spinner"></div>
                </div>
            `;

            const response = await fetch(`/reports/${reportId}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();

            if (data.success) {
                const report = data.data;
                document.getElementById('modal-report-title').textContent = report.title;
                document.getElementById('modal-report-content').innerHTML = `
                    <div class="report-details">
                        <div class="detail-section">
                            <h4>Informasi Dokumen</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <strong>Kategori:</strong>
                                    <span>${report.category_label}</span>
                                </div>
                                <div class="detail-item">
                                    <strong>Tanggal Terbit:</strong>
                                    <span>${report.publication_date}</span>
                                </div>
                                <div class="detail-item">
                                    <strong>Jenis File:</strong>
                                    <span>${report.file_type.toUpperCase()}</span>
                                </div>
                                <div class="detail-item">
                                    <strong>Ukuran File:</strong>
                                    <span>${report.file_size}</span>
                                </div>
                                <div class="detail-item">
                                    <strong>Penerbit:</strong>
                                    <span>${report.publisher}</span>
                                </div>
                                <div class="detail-item">
                                    <strong>Status File:</strong>
                                    <span style="color: ${report.has_file ? 'green' : 'red'}; font-weight: bold;">
                                        ${report.has_file ? '✅ Tersedia' : '❌ Belum Tersedia'}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="detail-section">
                            <h4>Deskripsi</h4>
                            <p>${report.description}</p>
                        </div>
                        
                        <div class="detail-actions">
                            ${report.has_file ? `
                                <button class="report-btn btn-download" onclick="downloadReportFile(${report.id}, true)">
                                    <i class="fas fa-download"></i>
                                    Download File
                                </button>
                                ${report.file_type === 'pdf' ? `
                                <button class="report-btn btn-view-report" onclick="openReportViewer(${report.id})">
                                    <i class="fas fa-external-link-alt"></i>
                                    Buka di Tab Baru
                                </button>
                                ` : ''}
                            ` : `
                                <button class="report-btn btn-download" onclick="showFileNotAvailable()" style="opacity: 0.6; cursor: not-allowed;">
                                    <i class="fas fa-download"></i>
                                    File Belum Tersedia
                                </button>
                                <button class="report-btn btn-view-report" onclick="showContactAdmin()">
                                    <i class="fas fa-envelope"></i>
                                    Hubungi Administrator
                                </button>
                            `}
                            
                            <!-- Debug button for development -->
                        </div>
                    </div>
                `;
            } else {
                document.getElementById('modal-report-content').innerHTML = `
                    <div class="error-message">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Gagal memuat detail laporan.</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error viewing report:', error);
            document.getElementById('modal-report-content').innerHTML = `
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Terjadi kesalahan saat memuat detail laporan.</p>
                </div>
            `;
        }
    }

    function openReportViewer(reportId) {
        // Gunakan route khusus untuk view (inline untuk PDF)
        const viewUrl = `/simple-view/${reportId}`;
        window.open(viewUrl, '_blank');
    }

    function showContactAdmin() {
        showNotification('Silakan hubungi administrator desa untuk mendapatkan dokumen ini.', 'info');
    }

    // Function untuk debug file status - versi simple
    function debugFileStatus(reportId) {
        // Open debug URL in new tab instead of AJAX
        var debugUrl = '/test-accessor/' + reportId;
        window.open(debugUrl, '_blank');
        showNotification('Debug window opened in new tab', 'info');
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;

        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            color: white;
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            background: ${type === 'success' ? '#28a745' : type === 'error' ? '#dc3545' : '#17a2b8'};
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // ===== EVENT LISTENERS FOR REPORTS =====
    document.addEventListener('DOMContentLoaded', function() {
        // Category filter
        const categoryFilter = document.getElementById('category-filter-reports');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', function(e) {
                reportsData.filters.category = e.target.value;
                reportsData.currentPage = 1;
                loadReports(1);
            });
        }

        // Search functionality
        const searchInput = document.getElementById('search-reports');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    reportsData.filters.search = e.target.value;
                    reportsData.currentPage = 1;
                    loadReports(1);
                }, 500);
            });
        }

        // Load initial reports if no featured reports
        @if ($featuredReports->isEmpty())
            loadReports(1);
        @else
            // Tampilkan pagination untuk featured reports jika ada
            const totalFeatured = {{ $featuredReports->count() }};
            if (totalFeatured > 3) {
                document.getElementById('reports-pagination').style.display = 'flex';
            }
        @endif
    });

    // ===== DATA TABLE FUNCTIONALITY =====
    function showDataTable(category) {
        document.getElementById('data-tables').style.display = 'block';
        document.getElementById('data-tables').scrollIntoView({
            behavior: 'smooth'
        });

        const titleMap = {
            penduduk: 'Data Penduduk',
            keuangan: 'Data Keuangan',
            pembangunan: 'Data Pembangunan',
            kesehatan: 'Data Kesehatan',
            pendidikan: 'Data Pendidikan',
            ekonomi: 'Data Ekonomi'
        };

        document.getElementById('table-title').textContent = titleMap[category];

        if (category === 'penduduk') {
            currentData = sampleData.penduduk;
            updateTable();
        } else {
            currentData = generatePlaceholderData(category);
            updateTable();
        }
    }

    function generatePlaceholderData(category) {
        const data = [];
        for (let i = 1; i <= 25; i++) {
            data.push({
                id: i.toString().padStart(3, '0'),
                nama: `Data ${category.charAt(0).toUpperCase() + category.slice(1)} ${i}`,
                kategori: 'Kategori A',
                tanggal: `${Math.floor(Math.random() * 28) + 1}/07/2024`,
                nilai: `Rp ${(Math.random() * 1000000).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`,
                status: ['active', 'inactive', 'pending'][Math.floor(Math.random() * 3)]
            });
        }
        return data;
    }

    function updateTable() {
        const tableBody = document.getElementById('table-body');
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageData = currentData.slice(startIndex, endIndex);

        let html = '';
        pageData.forEach((item, index) => {
            const statusClass = `status-${item.status}`;
            const statusText = item.status === 'active' ? 'Aktif' :
                item.status === 'inactive' ? 'Tidak Aktif' : 'Pending';

            if (item.nik) {
                html += `
                <tr>
                    <td>${startIndex + index + 1}</td>
                    <td>${item.nama}</td>
                    <td>${item.kelamin}</td>
                    <td>${item.lahir}</td>
                    <td>${item.alamat}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-small btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-small btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-small btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
            } else {
                html += `
                <tr>
                    <td>${startIndex + index + 1}</td>
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${item.kategori}</td>
                    <td>${item.tanggal}</td>
                    <td>${item.nilai}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-small btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-small btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-small btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
            }
        });

        tableBody.innerHTML = html;
    }

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updateTable();
            updatePagination();
        }
    }

    function nextPage() {
        const totalPages = Math.ceil(currentData.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updateTable();
            updatePagination();
        }
    }

    function updatePagination() {
        const totalPages = Math.ceil(currentData.length / itemsPerPage);
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');

        if (prevBtn) prevBtn.disabled = currentPage === 1;
        if (nextBtn) nextBtn.disabled = currentPage === totalPages;

        document.querySelectorAll('.pagination button').forEach(btn => {
            btn.classList.remove('active');
        });

        const pageButtons = document.querySelectorAll('.pagination button:not(#prev-btn):not(#next-btn)');
        pageButtons.forEach((btn, index) => {
            if (index + 1 === currentPage) {
                btn.classList.add('active');
            }
        });
    }

    function exportData(format) {
        const message = format === 'excel' ? 'Excel' : 'PDF';
        showNotification(`Mengexport data ke format ${message}...`, 'info');

        const btn = event?.target?.closest('.action-btn');
        if (btn) {
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                showNotification(`Data berhasil diexport ke ${message}!`, 'success');
            }, 2000);
        }
    }

    function printData() {
        window.print();
    }

    // ===== MODAL FUNCTIONS =====
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // ===== SEARCH FUNCTIONALITY FOR DATA TABLE =====
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filteredData = currentData.filter(item => {
                return Object.values(item).some(value =>
                    value.toString().toLowerCase().includes(searchTerm)
                );
            });

            const tableBody = document.getElementById('table-body');
            let html = '';

            filteredData.slice(0, itemsPerPage).forEach((item, index) => {
                const statusClass = `status-${item.status}`;
                const statusText = item.status === 'active' ? 'Aktif' :
                    item.status === 'inactive' ? 'Tidak Aktif' : 'Pending';

                if (item.nik) {
                    html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama}</td>
                        <td>${item.kelamin}</td>
                        <td>${item.lahir}</td>
                        <td>${item.alamat}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-small btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                                <button class="btn-small btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn-small btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
                } else {
                    html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.id}</td>
                        <td>${item.nama}</td>
                        <td>${item.kategori}</td>
                        <td>${item.tanggal}</td>
                        <td>${item.nilai}</td>
                        <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-small btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                                <button class="btn-small btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn-small btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `;
                }
            });

            if (tableBody) tableBody.innerHTML = html;
        });
    }

    // ===== FILTER FUNCTIONALITY FOR DATA TABLE =====
    const statusFilter = document.getElementById('status-filter');
    if (statusFilter) {
        statusFilter.addEventListener('change', function(e) {
            const filterValue = e.target.value;
            if (filterValue === '') {
                updateTable();
            } else {
                const filteredData = currentData.filter(item => item.status === filterValue);
                displayFilteredData(filteredData);
            }
        });
    }

    function displayFilteredData(data) {
        const tableBody = document.getElementById('table-body');
        let html = '';

        data.slice(0, itemsPerPage).forEach((item, index) => {
            const statusClass = `status-${item.status}`;
            const statusText = item.status === 'active' ? 'Aktif' :
                item.status === 'inactive' ? 'Tidak Aktif' : 'Pending';

            if (item.nik) {
                html += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.nama}</td>
                    <td>${item.kelamin}</td>
                    <td>${item.lahir}</td>
                    <td>${item.alamat}</td>
                    <td><span class="status-badge ${statusClass}">${statusText}</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-small btn-view" title="Lihat"><i class="fas fa-eye"></i></button>
                            <button class="btn-small btn-edit" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-small btn-delete" title="Hapus"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `;
            }
        });

        if (tableBody) tableBody.innerHTML = html;
    }

    // ===== ANIMATION FUNCTIONS =====
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-value');
        counters.forEach(counter => {
            const text = counter.textContent;
            if (text.includes('%')) {
                const target = parseFloat(text.replace('%', ''));
                animateCounter(counter, target, '%');
            } else if (text.includes(',')) {
                const target = parseInt(text.replace(/,/g, ''));
                animateCounter(counter, target, ',');
            } else if (!isNaN(parseInt(text))) {
                const target = parseInt(text);
                animateCounter(counter, target);
            }
        });
    }

    function animateCounter(element, target, suffix = '') {
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
            current += increment;
            if (suffix === '%') {
                element.textContent = current.toFixed(1) + '%';
            } else if (suffix === ',') {
                element.textContent = Math.floor(current).toLocaleString();
            } else {
                element.textContent = Math.floor(current);
            }

            if (current >= target) {
                if (suffix === '%') {
                    element.textContent = target + '%';
                } else if (suffix === ',') {
                    element.textContent = target.toLocaleString();
                } else {
                    element.textContent = target;
                }
                clearInterval(timer);
            }
        }, 30);
    }

    // ===== INTERSECTION OBSERVER FOR ANIMATIONS =====
    const observerOptionsDaftarData = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observerDaftarData = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptionsDaftarData);

    document.querySelectorAll('.category-card, .report-card, .stat-card').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(50px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observerDaftarData.observe(element);
    });

    const statsObserverDaftarData = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                statsObserverDaftarData.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    const statsSectionDaftarData = document.querySelector('.statistics-section');
    if (statsSectionDaftarData) {
        statsObserverDaftarData.observe(statsSectionDaftarData);
    }

    // ===== EVENT LISTENERS =====
    window.addEventListener('click', function(e) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (e.target === modal) {
                closeModal(modal.id);
            }
        });
    });

    function simulateDataUpdate() {
        const elements = document.querySelectorAll('.stat-value');
        elements.forEach(element => {
            if (!element.textContent.includes('Real-time')) {
                element.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    element.style.transform = 'scale(1)';
                }, 200);
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-small')) {
            const btn = e.target.closest('.btn-small');
            const originalContent = btn.innerHTML;

            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }, 1000);
        }
    });

    // ===== INITIALIZATION =====
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize reports functionality
        @if ($featuredReports->isEmpty())
            loadReports(1);
        @endif

        // Set interval for data simulation
        setInterval(simulateDataUpdate, 30000);
    });
</script>
@extends('landingPage.main')

@section('title', 'Daftar Data - Portal Desa')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 8rem 0 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200" fill="rgba(255,255,255,0.1)"><rect x="100" y="50" width="50" height="50"/><rect x="300" y="100" width="30" height="30"/><rect x="700" y="30" width="40" height="40"/><rect x="500" y="80" width="35" height="35"/></svg>');
            background-size: 100% 100%;
            animation: float 15s linear infinite;
        }

        .data-categories {
            background: white;
            padding: 5rem 0;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .category-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .category-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            transition: transform 0.3s ease;
        }

        .category-card:hover .category-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            text-align: center;
        }

        .category-description {
            color: #666;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .category-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #11998e;
            margin-bottom: 0.2rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #666;
        }

        .data-tables {
            background: #f8f9fa;
            padding: 5rem 0;
        }

        .table-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .table-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .action-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 25px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .table-filters {
            background: #f8f9fa;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #eee;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        .filter-group select,
        .filter-group input {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .search-box {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 0.9rem;
        }

        .search-box i {
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .data-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .data-table tbody tr {
            transition: background-color 0.3s ease;
        }

        .data-table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
            text-align: center;
            display: inline-block;
            min-width: 70px;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-small {
            padding: 0.3rem 0.6rem;
            border: none;
            border-radius: 5px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: #3498db;
            color: white;
        }

        .btn-edit {
            background: #f39c12;
            color: white;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-small:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            padding: 2rem;
            background: white;
        }

        .pagination button {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            background: white;
            color: #666;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination button:hover,
        .pagination button.active {
            background: #11998e;
            color: white;
            border-color: #11998e;
        }

        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .statistics-section {
            background: #2c3e50;
            color: white;
            padding: 5rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #38ef7d;
            margin-bottom: 0.5rem;
        }

        .stat-title {
            font-size: 1rem;
            opacity: 0.9;
        }

        .reports-section {
            background: white;
            padding: 5rem 0;
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .report-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            border-left: 4px solid #11998e;
            transition: all 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .report-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .report-date {
            font-size: 0.8rem;
            color: #666;
        }

        .report-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .report-actions {
            display: flex;
            gap: 1rem;
        }

        .report-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-download {
            background: #11998e;
            color: white;
        }

        .btn-view-report {
            background: #3498db;
            color: white;
        }

        .report-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 20px;
            padding: 2rem;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: #f0f0f0;
            color: #333;
        }

        @media (max-width: 768px) {
            .category-grid {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .table-filters {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: auto;
            }

            .data-table {
                font-size: 0.8rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .pagination {
                flex-wrap: wrap;
            }

            .modal-content {
                width: 95%;
                padding: 1rem;
            }
        }
    </style>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Daftar Data</h1>
            <p>Pusat informasi dan data terpadu untuk transparansi dan akuntabilitas</p>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>Daftar Data</span>
            </nav>
        </div>
    </section>

    <!-- Data Categories -->
    <section class="data-categories">
        <div class="container">
            <h2 class="section-title">Kategori Data</h2>
            <div class="category-grid">
                <div class="category-card card-3d" onclick="showDataTable('penduduk')">
                    <div class="category-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="category-title">Data Penduduk</h3>
                    <p class="category-description">
                        Data kependudukan lengkap termasuk demografi, statistik kelahiran, kematian, dan perpindahan
                        penduduk.
                    </p>
                    <div class="category-stats">
                        <div class="stat-item">
                            <div class="stat-number">1,247</div>
                            <div class="stat-label">Total Jiwa</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">387</div>
                            <div class="stat-label">Kepala Keluarga</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">12</div>
                            <div class="stat-label">Dusun</div>
                        </div>
                    </div>
                </div>

                <div class="category-card card-3d" onclick="showDataTable('keuangan')">
                    <div class="category-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3 class="category-title">Data Keuangan</h3>
                    <p class="category-description">
                        Transparansi pengelolaan keuangan desa, APBDesa, realisasi anggaran, dan laporan pertanggungjawaban.
                    </p>
                    <div class="category-stats">
                        <div class="stat-item">
                            <div class="stat-number">2.5M</div>
                            <div class="stat-label">Anggaran (M)</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">87%</div>
                            <div class="stat-label">Realisasi</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">24</div>
                            <div class="stat-label">Program</div>
                        </div>
                    </div>
                </div>

                <div class="category-card card-3d" onclick="showDataTable('pembangunan')">
                    <div class="category-icon">
                        <i class="fas fa-hammer"></i>
                    </div>
                    <h3 class="category-title">Data Pembangunan</h3>
                    <p class="category-description">
                        Informasi proyek pembangunan infrastruktur, progres pelaksanaan, dan anggaran pembangunan desa.
                    </p>
                    <div class="category-stats">
                        <div class="stat-item">
                            <div class="stat-number">15</div>
                            <div class="stat-label">Proyek Aktif</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">73%</div>
                            <div class="stat-label">Progress</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">1.2M</div>
                            <div class="stat-label">Dana (M)</div>
                        </div>
                    </div>
                </div>

                <div class="category-card card-3d" onclick="showDataTable('kesehatan')">
                    <div class="category-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h3 class="category-title">Data Kesehatan</h3>
                    <p class="category-description">
                        Data kesehatan masyarakat, program imunisasi, posyandu, dan fasilitas kesehatan desa.
                    </p>
                    <div class="category-stats">
                        <div class="stat-item">
                            <div class="stat-number">156</div>
                            <div class="stat-label">Balita</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">89%</div>
                            <div class="stat-label">Imunisasi</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">3</div>
                            <div class="stat-label">Posyandu</div>
                        </div>
                    </div>
                </div>

                <div class="category-card card-3d" onclick="showDataTable('pendidikan')">
                    <div class="category-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 class="category-title">Data Pendidikan</h3>
                    <p class="category-description">
                        Informasi tingkat pendidikan, fasilitas sekolah, program beasiswa, dan kegiatan pendidikan desa.
                    </p>
                    <div class="category-stats">
                        <div class="stat-item">
                            <div class="stat-number">234</div>
                            <div class="stat-label">Siswa</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">95%</div>
                            <div class="stat-label">Literacy</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">4</div>
                            <div class="stat-label">Sekolah</div>
                        </div>
                    </div>
                </div>

                <div class="category-card card-3d" onclick="showDataTable('ekonomi')">
                    <div class="category-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="category-title">Data Ekonomi</h3>
                    <p class="category-description">
                        Data ekonomi desa, UMKM, pertanian, perdagangan, dan program pemberdayaan ekonomi masyarakat.
                    </p>
                    <div class="category-stats">
                        <div class="stat-item">
                            <div class="stat-number">45</div>
                            <div class="stat-label">UMKM</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">78%</div>
                            <div class="stat-label">Pertanian</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">156</div>
                            <div class="stat-label">Petani</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Data Tables Section -->
    <section class="data-tables" id="data-tables" style="display: none;">
        <div class="container">
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-users"></i>
                        <span id="table-title">Data Penduduk</span>
                    </div>
                    <div class="table-actions">
                        <button class="action-btn" onclick="exportData('excel')">
                            <i class="fas fa-file-excel"></i>
                            Export Excel
                        </button>
                        <button class="action-btn" onclick="exportData('pdf')">
                            <i class="fas fa-file-pdf"></i>
                            Export PDF
                        </button>
                        <button class="action-btn" onclick="printData()">
                            <i class="fas fa-print"></i>
                            Print
                        </button>
                    </div>
                </div>

                <div class="table-filters">
                    <div class="filter-group">
                        <label for="status-filter">Status:</label>
                        <select id="status-filter">
                            <option value="">Semua</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="category-filter">Kategori:</label>
                        <select id="category-filter">
                            <option value="">Semua Kategori</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="search-input" placeholder="Cari data...">
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table" id="main-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <button onclick="previousPage()" id="prev-btn">
                        <i class="fas fa-chevron-left"></i>
                        Previous
                    </button>
                    <button class="active">1</button>
                    <button>2</button>
                    <button>3</button>
                    <button>4</button>
                    <button>5</button>
                    <button onclick="nextPage()" id="next-btn">
                        Next
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics-section">
        <div class="container">
            <h2 class="section-title" style="color: white;">Statistik Data Desa</h2>
            <div class="stats-grid">
                <div class="stat-card card-3d">
                    <div class="stat-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="stat-value">15,247</div>
                    <div class="stat-title">Total Record Data</div>
                </div>
                <div class="stat-card card-3d">
                    <div class="stat-icon">
                        <i class="fas fa-sync"></i>
                    </div>
                    <div class="stat-value">24</div>
                    <div class="stat-title">Update Harian</div>
                </div>
                <div class="stat-card card-3d">
                    <div class="stat-icon">
                        <i class="fas fa-shield"></i>
                    </div>
                    <div class="stat-value">99.8%</div>
                    <div class="stat-title">Akurasi Data</div>
                </div>
                <div class="stat-card card-3d">
                    <div class="stat-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div class="stat-value">2,156</div>
                    <div class="stat-title">Views Bulan Ini</div>
                </div>
                <div class="stat-card card-3d">
                    <div class="stat-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <div class="stat-value">347</div>
                    <div class="stat-title">Download Report</div>
                </div>
                <div class="stat-card card-3d">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">Real-time</div>
                    <div class="stat-title">Update Otomatis</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reports Section -->
    <section class="reports-section">
        <div class="container">
            <h2 class="section-title">Laporan & Publikasi</h2>
            <div class="report-grid">
                <div class="report-card">
                    <div class="report-header">
                        <div class="report-title">Laporan Tahunan 2024</div>
                        <div class="report-date">15 Jan 2024</div>
                    </div>
                    <p class="report-description">
                        Laporan komprehensif mengenai perkembangan desa selama tahun 2024, termasuk capaian program dan
                        statistik terkini.
                    </p>
                    <div class="report-actions">
                        <button class="report-btn btn-download">
                            <i class="fas fa-download"></i>
                            Download PDF
                        </button>
                        <button class="report-btn btn-view-report" onclick="openModal('report-modal')">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <div class="report-card">
                    <div class="report-header">
                        <div class="report-title">Data Kependudukan Q2 2024</div>
                        <div class="report-date">30 Jun 2024</div>
                    </div>
                    <p class="report-description">
                        Statistik kependudukan kuartal kedua 2024 dengan analisis pertumbuhan dan perubahan demografi.
                    </p>
                    <div class="report-actions">
                        <button class="report-btn btn-download">
                            <i class="fas fa-download"></i>
                            Download Excel
                        </button>
                        <button class="report-btn btn-view-report" onclick="openModal('report-modal')">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <div class="report-card">
                    <div class="report-header">
                        <div class="report-title">Laporan Keuangan Semester 1</div>
                        <div class="report-date">31 Jul 2024</div>
                    </div>
                    <p class="report-description">
                        Laporan realisasi anggaran dan pertanggungjawaban keuangan desa semester pertama tahun 2024.
                    </p>
                    <div class="report-actions">
                        <button class="report-btn btn-download">
                            <i class="fas fa-download"></i>
                            Download PDF
                        </button>
                        <button class="report-btn btn-view-report" onclick="openModal('report-modal')">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <div class="report-card">
                    <div class="report-header">
                        <div class="report-title">Profil Desa 2024</div>
                        <div class="report-date">10 Mar 2024</div>
                    </div>
                    <p class="report-description">
                        Profil lengkap desa mencakup geografis, demografi, potensi ekonomi, dan fasilitas publik.
                    </p>
                    <div class="report-actions">
                        <button class="report-btn btn-download">
                            <i class="fas fa-download"></i>
                            Download PDF
                        </button>
                        <button class="report-btn btn-view-report" onclick="openModal('report-modal')">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <div class="report-card">
                    <div class="report-header">
                        <div class="report-title">Data Kesehatan Masyarakat</div>
                        <div class="report-date">20 Jun 2024</div>
                    </div>
                    <p class="report-description">
                        Analisis data kesehatan masyarakat, cakupan imunisasi, dan program kesehatan desa.
                    </p>
                    <div class="report-actions">
                        <button class="report-btn btn-download">
                            <i class="fas fa-download"></i>
                            Download Excel
                        </button>
                        <button class="report-btn btn-view-report" onclick="openModal('report-modal')">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>

                <div class="report-card">
                    <div class="report-header">
                        <div class="report-title">Monitoring UMKM 2024</div>
                        <div class="report-date">05 Jul 2024</div>
                    </div>
                    <p class="report-description">
                        Perkembangan usaha mikro kecil menengah dan program pemberdayaan ekonomi masyarakat desa.
                    </p>
                    <div class="report-actions">
                        <button class="report-btn btn-download">
                            <i class="fas fa-download"></i>
                            Download PDF
                        </button>
                        <button class="report-btn btn-view-report" onclick="openModal('report-modal')">
                            <i class="fas fa-eye"></i>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal" id="report-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Laporan</h3>
                <button class="close-btn" onclick="closeModal('report-modal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Ini adalah contoh detail laporan. Konten lengkap akan ditampilkan di sini dengan informasi yang lebih
                    komprehensif.</p>
                <br>
                <p>Laporan ini mencakup:</p>
                <ul style="margin-left: 1rem; margin-top: 1rem;">
                    <li>Analisis data terkini</li>
                    <li>Grafik dan visualisasi</li>
                    <li>Rekomendasi kebijakan</li>
                    <li>Proyeksi masa depan</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
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

        function showDataTable(category) {
            document.getElementById('data-tables').style.display = 'block';
            document.getElementById('data-tables').scrollIntoView({
                behavior: 'smooth'
            });

            // Update table title and data
            const titleMap = {
                penduduk: 'Data Penduduk',
                keuangan: 'Data Keuangan',
                pembangunan: 'Data Pembangunan',
                kesehatan: 'Data Kesehatan',
                pendidikan: 'Data Pendidikan',
                ekonomi: 'Data Ekonomi'
            };

            document.getElementById('table-title').textContent = titleMap[category];

            // Load sample data
            if (category === 'penduduk') {
                currentData = sampleData.penduduk;
                updateTable();
            } else {
                // For other categories, show placeholder data
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
                    // Penduduk data format
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
                    // Generic data format
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

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;

            // Update active page button
            document.querySelectorAll('.pagination button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Simple pagination display (you can enhance this)
            const pageButtons = document.querySelectorAll('.pagination button:not(#prev-btn):not(#next-btn)');
            pageButtons.forEach((btn, index) => {
                if (index + 1 === currentPage) {
                    btn.classList.add('active');
                }
            });
        }

        function exportData(format) {
            const message = format === 'excel' ? 'Excel' : 'PDF';
            alert(`Mengexport data ke format ${message}...`);

            // Simulate export process
            const btn = event.target.closest('.action-btn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert(`Data berhasil diexport ke ${message}!`);
            }, 2000);
        }

        function printData() {
            window.print();
        }

        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Search functionality
        document.getElementById('search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filteredData = currentData.filter(item => {
                return Object.values(item).some(value =>
                    value.toString().toLowerCase().includes(searchTerm)
                );
            });

            // Update table with filtered data
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
                        <td>${item.nik}</td>
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

            tableBody.innerHTML = html;
        });

        // Filter functionality
        document.getElementById('status-filter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            if (filterValue === '') {
                updateTable();
            } else {
                const filteredData = currentData.filter(item => item.status === filterValue);
                // Update table with filtered data (similar to search)
                displayFilteredData(filteredData);
            }
        });

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
                        <td>${item.nik}</td>
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

            tableBody.innerHTML = html;
        }

        // Statistics counter animation
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

        // Intersection Observer for animations
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

        // Apply animations to cards
        document.querySelectorAll('.category-card, .report-card, .stat-card').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observerDaftarData.observe(element);
        });

        // Animate statistics when visible
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

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (e.target === modal) {
                    closeModal(modal.id);
                }
            });
        });

        // Real-time data update simulation
        function simulateDataUpdate() {
            const elements = document.querySelectorAll('.stat-value');
            elements.forEach(element => {
                if (!element.textContent.includes('Real-time')) {
                    // Add subtle animation to show data is updating
                    element.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        element.style.transform = 'scale(1)';
                    }, 200);
                }
            });
        }

        // Initialize
        setInterval(simulateDataUpdate, 30000); // Update every 30 seconds

        // Add loading animation for action buttons
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
    </script>

@endsection

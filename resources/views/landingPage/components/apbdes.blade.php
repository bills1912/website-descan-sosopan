@extends('landingPage.main')

@section('title', 'APBDes - Portal Desa')

@section('content')
    <style>
        /* [Previous CSS styles remain the same] */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #2c3e50;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Page Header */
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

        @keyframes float {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-50px);
            }
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }

        .page-header p {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .breadcrumb {
            margin-top: 2rem;
            position: relative;
            z-index: 2;
        }

        .breadcrumb a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: white;
        }

        /* Year Selector - Fixed Position (No Sticky) */
        .year-selector {
            background: white;
            padding: 2rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid #e9ecef;
            position: relative;
            /* Changed from sticky to relative */
        }

        .year-selector::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .year-selector-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .year-btn {
            padding: 0.8rem 2rem;
            border: 2px solid #11998e;
            background: transparent;
            color: #11998e;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .year-btn:hover,
        .year-btn.active {
            background: #11998e;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.3);
        }

        /* Floating Year Indicator */
        .floating-year-indicator {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 1rem;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .floating-year-indicator:hover {
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 15px 40px rgba(17, 153, 142, 0.4);
        }

        .floating-year-number {
            font-size: 1.5rem;
            line-height: 1;
            margin-bottom: 0.2rem;
        }

        .floating-year-label {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.9;
        }

        /* Quick Year Selector Modal */
        .quick-year-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .quick-year-content {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }

        .quick-year-modal.active .quick-year-content {
            transform: scale(1);
        }

        .quick-year-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 2rem;
        }

        .quick-year-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .quick-year-btn {
            padding: 1.5rem 2rem;
            border: 2px solid #11998e;
            background: transparent;
            color: #11998e;
            border-radius: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
        }

        .quick-year-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .quick-year-btn:hover::before,
        .quick-year-btn.active::before {
            left: 0;
        }

        .quick-year-btn:hover,
        .quick-year-btn.active {
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
        }

        /* APBDes Content */
        .apbdes-content {
            padding: 4rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 3rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 2px;
        }

        /* Table Container */
        .table-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .table-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .table-header h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .table-subheader {
            opacity: 0.9;
            font-size: 1rem;
        }

        /* APBDes Table */
        .apbdes-table {
            width: 100%;
            border-collapse: collapse;
        }

        .apbdes-table th {
            background: #f8f9fa;
            color: #2c3e50;
            font-weight: 700;
            padding: 1rem;
            text-align: center;
            border: 1px solid #e9ecef;
            font-size: 0.9rem;
        }

        .apbdes-table td {
            padding: 0.8rem 1rem;
            border: 1px solid #e9ecef;
            vertical-align: top;
        }

        .apbdes-table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Main Category Rows */
        .main-category {
            background: #e3f2fd !important;
            font-weight: 700;
            color: #1976d2;
        }

        .main-category td {
            font-size: 1rem;
            padding: 1.2rem 1rem;
        }

        /* Sub Category Rows */
        .sub-category {
            background: #f5f5f5 !important;
            font-weight: 600;
            color: #424242;
        }

        .sub-category td {
            padding-left: 2rem;
            font-style: italic;
        }

        /* Item Rows */
        .item-row td {
            padding-left: 3rem;
            font-size: 0.9rem;
        }

        .item-name {
            color: #424242;
        }

        /* Currency Format */
        .currency {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .positive {
            color: #27ae60;
        }

        .zero {
            color: #95a5a6;
        }

        /* Summary Section */
        .summary-section {
            background: #2c3e50;
            color: white;
            padding: 4rem 0;
            margin-top: 3rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
        }

        .summary-icon {
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

        .summary-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #38ef7d;
            margin-bottom: 0.5rem;
        }

        .summary-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Download Section */
        .download-section {
            background: white;
            padding: 3rem 0;
            text-align: center;
        }

        .download-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            margin: 0 0.5rem;
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }

            .year-selector-container {
                flex-direction: column;
                gap: 1rem;
            }

            .year-btn {
                width: 100%;
                max-width: 200px;
            }

            .floating-year-indicator {
                width: 60px;
                height: 60px;
                right: 15px;
            }

            .floating-year-number {
                font-size: 1.2rem;
            }

            .floating-year-label {
                font-size: 0.5rem;
            }

            .quick-year-content {
                margin: 1rem;
                padding: 2rem;
            }

            .quick-year-buttons {
                grid-template-columns: 1fr;
            }

            .apbdes-table {
                font-size: 0.8rem;
            }

            .apbdes-table th,
            .apbdes-table td {
                padding: 0.5rem;
            }

            .item-row td {
                padding-left: 1.5rem;
            }

            .sub-category td {
                padding-left: 1rem;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            z-index: 999;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
        }

        .back-to-top.show {
            display: flex;
        }

        /* Animation for table rows */
        .table-row-animate {
            opacity: 0;
            transform: translateY(20px);
            animation: slideIn 0.5s ease forwards;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Loading State */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            font-size: 1.2rem;
            color: #666;
        }

        .spinner {
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    {{-- @dd($formatted_data) --}}
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>APBDes - Anggaran Pendapatan dan Belanja Desa</h1>
            <p>Transparansi pengelolaan keuangan desa untuk pembangunan berkelanjutan</p>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> /
                <a href="{{ route('informasi-desa') }}">Informasi Desa</a> /
                <span>APBDes</span>
            </nav>
        </div>
    </section>


    <!-- Year Selector -->
    <section class="year-selector" id="year-selector">
        <div class="container">
            <div class="year-selector-container">
                <span style="font-weight: 600; color: #2c3e50;">Pilih Tahun Anggaran:</span>
                @foreach ($tahun_apbdes as $index => $tahun)
                    <button class="year-btn {{ $index == 0 ? 'active' : '' }}" onclick="selectYear('{{ $tahun->tahun }}')">
                        {{ $tahun->tahun }}
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Floating Year Indicator -->
    <div class="floating-year-indicator" id="floating-year" onclick="openQuickYearModal()">
        <div class="floating-year-number" id="floating-year-number">{{ date('Y') }}</div>
        <div class="floating-year-label">Tahun</div>
    </div>

    <!-- Quick Year Selector Modal -->
    <div class="quick-year-modal" id="quick-year-modal">
        <div class="quick-year-content">
            <h3 class="quick-year-title">Pilih Tahun Anggaran</h3>
            <div class="quick-year-buttons">
                @foreach ($tahun_apbdes as $index => $tahun)
                    <button class="quick-year-btn {{ $index == 0 ? 'active' : '' }}"
                        onclick="selectYear('{{ $tahun->tahun }}')">
                        {{ $tahun->tahun }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- APBDes Content -->
    <section class="apbdes-content">
        <div class="container">
            <h2 class="section-title">APBDes - Tahun <span
                    id="current-year">{{ $tahun_apbdes->first()->tahun ?? 'N/A' }}</span></h2>

            <!-- Pendapatan Desa -->
            <div class="table-container">
                <div class="table-header">
                    <h3>1. Pendapatan Desa</h3>
                    <div class="table-subheader">Sumber pendapatan desa dari berbagai sektor</div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="apbdes-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Uraian</th>
                                <th style="width: 16.67%;">Rencana / Anggaran</th>
                                <th style="width: 16.67%;">Realisasi</th>
                                <th style="width: 16.67%;">Lebih/Kurang</th>
                            </tr>
                        </thead>
                        <tbody id="pendapatan-tbody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Belanja Desa -->
            <div class="table-container">
                <div class="table-header">
                    <h3>2. Belanja Desa</h3>
                    <div class="table-subheader">Alokasi belanja untuk pembangunan dan operasional desa</div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="apbdes-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Uraian</th>
                                <th style="width: 16.67%;">Rencana / Anggaran</th>
                                <th style="width: 16.67%;">Realisasi</th>
                                <th style="width: 16.67%;">Lebih/Kurang</th>
                            </tr>
                        </thead>
                        <tbody id="belanja-tbody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pembiayaan Desa -->
            <div class="table-container">
                <div class="table-header">
                    <h3>3. Pembiayaan Desa</h3>
                    <div class="table-subheader">Sumber pembiayaan dan pengeluaran pembiayaan desa</div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="apbdes-table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">Uraian</th>
                                <th style="width: 16.67%;">Rencana / Anggaran</th>
                                <th style="width: 16.67%;">Realisasi</th>
                                <th style="width: 16.67%;">Lebih/Kurang</th>
                            </tr>
                        </thead>
                        <tbody id="pembiayaan-tbody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Summary Section -->
    <section class="summary-section">
        <div class="container">
            <h2 class="section-title" style="color: white;">Ringkasan APBDes <span
                    id="summary-year">{{ $tahun_apbdes->first()->tahun ?? 'N/A' }}</span></h2>
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    <div class="summary-value" id="total-pendapatan">Rp 0</div>
                    <div class="summary-label">Total Pendapatan</div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-arrow-up"></i>
                    </div>
                    <div class="summary-value" id="total-belanja">Rp 0</div>
                    <div class="summary-label">Total Belanja</div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="summary-value" id="total-pembiayaan">Rp 0</div>
                    <div class="summary-label">Total Pembiayaan</div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <div class="summary-value" id="saldo-anggaran">Rp 0</div>
                    <div class="summary-label">Saldo Anggaran</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section class="download-section" style="background: white; padding: 3rem 0; text-align: center;">
        <div class="container">
            <h3 style="margin-bottom: 2rem; color: #2c3e50;">Unduh Dokumen APBDes</h3>
            <a href="#" class="download-btn" onclick="downloadAPBDes('pdf')"
                style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; padding: 1rem 2rem; border: none; border-radius: 25px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; margin: 0 0.5rem;">
                <i class="fas fa-file-pdf"></i>
                Download PDF
            </a>
            <a href="#" class="download-btn" onclick="downloadAPBDes('excel')"
                style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; padding: 1rem 2rem; border: none; border-radius: 25px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; text-decoration: none; margin: 0 0.5rem;">
                <i class="fas fa-file-excel"></i>
                Download Excel
            </a>
        </div>
    </section>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="back-to-top" onclick="scrollToTop()">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Get data from PHP/Laravel controller
        const apbdesData = {!! $formatted_data !!};
        const availableYears = @json($tahun_apbdes->pluck('tahun'));

        // Set initial year (first available year)
        let currentYear = availableYears.length > 0 ? availableYears[0] : null;

        // Format currency
        function formatCurrency(amount) {
            if (amount === 0 || amount === null || amount === undefined) return 'Rp. 0';
            const formatted = Math.abs(amount).toLocaleString('id-ID');
            return amount < 0 ? `Rp. (${formatted})` : `Rp. ${formatted}`;
        }

        // Format currency for summary
        function formatSummary(amount) {
            if (amount === 0 || amount === null || amount === undefined) return 'Rp 0';
            if (amount >= 1000000000) {
                return `Rp ${(amount / 1000000000).toFixed(1)} M`;
            } else if (amount >= 1000000) {
                return `Rp ${(amount / 1000000).toFixed(1)} Jt`;
            } else if (amount >= 1000) {
                return `Rp ${(amount / 1000).toFixed(0)} K`;
            }
            return `Rp ${amount.toLocaleString('id-ID')}`;
        }

        // Create table row
        function createTableRow(item, isMain = false, isSub = false) {
            const row = document.createElement('tr');
            row.className = `table-row-animate ${isMain ? 'main-category' : isSub ? 'sub-category' : 'item-row'}`;

            const rencana = parseFloat(item.rencana) || 0;
            const realisasi = parseFloat(item.realisasi) || 0;
            const selisih = parseFloat(item.selisih) || 0;

            const rencanaClass = rencana === 0 ? 'zero' : 'positive';
            const realisasiClass = realisasi === 0 ? 'zero' : 'positive';
            const selisihClass = selisih === 0 ? 'zero' : selisih > 0 ? 'positive' : '';

            row.innerHTML = `
                <td class="item-name">${item.name}</td>
                <td class="currency ${rencanaClass}">${formatCurrency(rencana)}</td>
                <td class="currency ${realisasiClass}">${formatCurrency(realisasi)}</td>
                <td class="currency ${selisihClass}">${formatCurrency(selisih)}</td>
            `;

            return row;
        }

        // Populate table
        function populateTable(sectionId, data) {
            const tbody = document.getElementById(sectionId);
            if (!tbody) return;

            tbody.innerHTML = '';

            if (!data || data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="4" class="no-data">
                            <i class="fas fa-exclamation-circle"></i>
                            Data tidak tersedia untuk tahun ini
                        </td>
                    </tr>
                `;
                return;
            }

            data.forEach((mainItem, index) => {
                tbody.appendChild(createTableRow(mainItem, true));
                if (mainItem.children && mainItem.children.length > 0) {
                    mainItem.children.forEach(child => {
                        tbody.appendChild(createTableRow(child, false, false));
                    });
                }
            });
        }

        // Update summary
        function updateSummary(year) {
            const data = apbdesData[year];

            if (!data) {
                document.getElementById('total-pendapatan').textContent = 'Rp 0';
                document.getElementById('total-belanja').textContent = 'Rp 0';
                document.getElementById('total-pembiayaan').textContent = 'Rp 0';
                document.getElementById('saldo-anggaran').textContent = 'Rp 0';
                return;
            }

            const totalPendapatan = data.pendapatan ? data.pendapatan.reduce((sum, item) => {
                const rencana = parseFloat(item.rencana) || 0;
                return sum + rencana;
            }, 0) : 0;

            const totalBelanja = data.belanja ? data.belanja.reduce((sum, item) => {
                const rencana = parseFloat(item.rencana) || 0;
                return sum + rencana;
            }, 0) : 0;

            const totalPembiayaan = data.pembiayaan ? data.pembiayaan.reduce((sum, item) => {
                const rencana = parseFloat(item.rencana) || 0;
                return sum + rencana;
            }, 0) : 0;

            const saldoAnggaran = totalPendapatan - totalBelanja + totalPembiayaan;

            document.getElementById('total-pendapatan').textContent = formatSummary(totalPendapatan);
            document.getElementById('total-belanja').textContent = formatSummary(totalBelanja);
            document.getElementById('total-pembiayaan').textContent = formatSummary(totalPembiayaan);
            document.getElementById('saldo-anggaran').textContent = formatSummary(saldoAnggaran);
        }

        // Select year
        function selectYear(year) {
            updateYearSelection(year);
            loadYearData(year);
        }

        // Update year selection UI
        function updateYearSelection(year) {
            // Update buttons
            document.querySelectorAll('.year-btn').forEach(btn => btn.classList.remove('active'));
            const selectedBtn = document.querySelector(`[onclick="selectYear('${year}')"]`);
            if (selectedBtn) {
                selectedBtn.classList.add('active');
            }

            // Update current year displays
            currentYear = year;
            document.getElementById('current-year').textContent = year;
            document.getElementById('summary-year').textContent = year;
        }

        // Load year data
        function loadYearData(year) {
            // Show loading state
            const tbodies = ['pendapatan-tbody', 'belanja-tbody', 'pembiayaan-tbody'];
            tbodies.forEach(id => {
                const tbody = document.getElementById(id);
                if (tbody) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="loading">
                                <i class="fas fa-spinner spinner"></i>
                                Memuat data tahun ${year}...
                            </td>
                        </tr>
                    `;
                }
            });

            // Simulate loading and populate data
            setTimeout(() => {
                if (apbdesData[year]) {
                    populateTable('pendapatan-tbody', apbdesData[year].pendapatan);
                    populateTable('belanja-tbody', apbdesData[year].belanja);
                    populateTable('pembiayaan-tbody', apbdesData[year].pembiayaan);
                    updateSummary(year);
                } else {
                    tbodies.forEach(id => {
                        const tbody = document.getElementById(id);
                        if (tbody) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="4" class="no-data">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Data APBDes tahun ${year} belum tersedia
                                    </td>
                                </tr>
                            `;
                        }
                    });
                    // Reset summary when no data
                    updateSummary(null);
                }
            }, 800);
        }

        // Quick year modal functions
        function openQuickYearModal() {
            const modal = document.getElementById('quick-year-modal');
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }

        function closeQuickYearModal() {
            const modal = document.getElementById('quick-year-modal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Download APBDes
        function downloadAPBDes(format) {
            if (!currentYear) {
                alert('Pilih tahun terlebih dahulu');
                return;
            }

            const btn = event.target.closest('.download-btn');
            const originalContent = btn.innerHTML;

            // Disable button and show loading
            btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Mengunduh...`;
            btn.style.pointerEvents = 'none';

            // Create download URL
            let downloadUrl;
            if (format === 'pdf') {
                downloadUrl = `/download/apbdes/pdf/${currentYear}`;
            } else if (format === 'excel') {
                downloadUrl = `/download/apbdes/excel/${currentYear}`;
            }

            if (format === 'pdf' || format === 'excel') {
                // For file downloads, use window.location
                window.location.href = downloadUrl;

                // Reset button after a delay
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.style.pointerEvents = 'auto';
                }, 3000);

                // Optional: Check if download was successful
                // You can add additional logic here to verify download completion
                setTimeout(() => {
                    btn.innerHTML = `<i class="fas fa-check"></i> Download Selesai`;
                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                    }, 2000);
                }, 5000);
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📊 APBDes Data:', apbdesData);
            console.log('📅 Available Years:', availableYears);

            // Load initial data
            if (currentYear && apbdesData[currentYear]) {
                populateTable('pendapatan-tbody', apbdesData[currentYear].pendapatan);
                populateTable('belanja-tbody', apbdesData[currentYear].belanja);
                populateTable('pembiayaan-tbody', apbdesData[currentYear].pembiayaan);
                updateSummary(currentYear);
            } else if (availableYears.length === 0) {
                // No data available at all
                const tbodies = ['pendapatan-tbody', 'belanja-tbody', 'pembiayaan-tbody'];
                tbodies.forEach(id => {
                    const tbody = document.getElementById(id);
                    if (tbody) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="4" class="no-data">
                                    <i class="fas fa-database"></i>
                                    Belum ada data APBDes yang tersedia
                                </td>
                            </tr>
                        `;
                    }
                });
                updateSummary(null);
            }

            // Back to top button visibility
            window.addEventListener('scroll', function() {
                const backToTop = document.getElementById('back-to-top');
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });

            // Close modal when clicking outside
            document.getElementById('quick-year-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeQuickYearModal();
                }
            });

            // Animation for table containers
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Apply animations to containers
            document.querySelectorAll('.table-container, .summary-card').forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(element);
            });

            console.log('✨ APBDes Page with Dynamic Data Loaded Successfully!');
            console.log('📊 Financial Data: ✓');
            console.log('🎯 Dynamic Year Filter: ✓');
            console.log('🔄 Database Integration: ✓');
        });

        // Print functionality
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            if (e.key === 'ArrowLeft') {
                const years = availableYears;
                const currentIndex = years.indexOf(currentYear);
                if (currentIndex > 0) {
                    selectYear(years[currentIndex - 1]);
                }
            } else if (e.key === 'ArrowRight') {
                const years = availableYears;
                const currentIndex = years.indexOf(currentYear);
                if (currentIndex < years.length - 1) {
                    selectYear(years[currentIndex + 1]);
                }
            }

            // Y key to open quick year modal
            if (e.key === 'y' || e.key === 'Y') {
                if (!document.getElementById('quick-year-modal').classList.contains('active')) {
                    openQuickYearModal();
                }
            }

            // ESC to close modal
            if (e.key === 'Escape') {
                closeQuickYearModal();
            }
        });
    </script>
@endsection

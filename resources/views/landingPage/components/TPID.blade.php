@extends('landingPage.main')

@section('title', 'TPID - Portal Desa')

@section('content')
    <style>
        .page-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200" fill="rgba(255,255,255,0.1)"><circle cx="200" cy="50" r="50"/><circle cx="800" cy="150" r="30"/><circle cx="500" cy="100" r="40"/></svg>');
            background-size: 100% 100%;
            animation: float 20s linear infinite;
        }

        .tpid-intro {
            background: white;
            padding: 5rem 0;
        }

        .intro-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            margin-top: 3rem;
        }

        .intro-content h3 {
            font-size: 2rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .intro-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .intro-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .feature-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 1rem;
            border-radius: 15px;
            text-align: center;
            font-weight: 600;
            transition: transform 0.3s ease;
        }

        .feature-badge:hover {
            transform: translateY(-5px);
        }

        .intro-image {
            position: relative;
        }

        .intro-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .image-floating-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: float 6s ease-in-out infinite;
        }

        .floating-card-1 {
            top: 20px;
            right: 20px;
            animation-delay: 0s;
        }

        .floating-card-2 {
            bottom: 20px;
            left: 20px;
            animation-delay: 3s;
        }

        .programs-section {
            background: #f8f9fa;
            padding: 5rem 0;
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .program-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .program-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .program-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .program-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .program-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
        }

        .program-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .program-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .program-content {
            padding: 2rem;
        }

        .program-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .program-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #f5576c;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #666;
        }

        .program-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .program-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }

        .price-monitoring {
            background: white;
            padding: 5rem 0;
        }

        .price-table {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 3rem;
        }

        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
        }

        .table-header h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .table-date {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .price-table-content {
            padding: 2rem;
        }

        .price-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #f5576c;
        }

        .price-commodity {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .commodity-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .commodity-info h4 {
            font-size: 1rem;
            color: #2c3e50;
            margin-bottom: 0.2rem;
        }

        .commodity-unit {
            font-size: 0.8rem;
            color: #666;
        }

        .price-value {
            text-align: right;
        }

        .current-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .price-change {
            font-size: 0.8rem;
            margin-top: 0.2rem;
        }

        .price-up {
            color: #e74c3c;
        }

        .price-down {
            color: #27ae60;
        }

        .price-stable {
            color: #666;
        }

        .team-section {
            background: #2c3e50;
            color: white;
            padding: 5rem 0;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .team-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .team-avatar {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .team-name {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .team-position {
            color: #3498db;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .team-contact {
            font-size: 0.9rem;
            opacity: 0.9;
            line-height: 1.5;
        }

        .contact-section {
            background: #f8f9fa;
            padding: 5rem 0;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-top: 3rem;
        }

        .contact-info {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .contact-item:last-child {
            border-bottom: none;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .contact-details h4 {
            font-size: 1.1rem;
            color: #2c3e50;
            margin-bottom: 0.3rem;
        }

        .contact-details p {
            color: #666;
            font-size: 0.9rem;
        }

        .quick-form {
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 1rem;
            border: 2px solid #f0f0f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #f5576c;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }

        @media (max-width: 768px) {

            .intro-grid,
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .programs-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }

            .price-grid {
                grid-template-columns: 1fr;
            }

            .program-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Tim Pengendalian Inflasi Daerah</h1>
            <p>Memantau dan mengendalikan harga komoditas strategis untuk kesejahteraan masyarakat</p>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>TPID</span>
            </nav>
        </div>
    </section>

    <!-- TPID Introduction -->
    <section class="tpid-intro">
        <div class="container">
            <h2 class="section-title">Tentang TPID</h2>
            <div class="intro-grid">
                <div class="intro-content">
                    <h3>Tim Pengendalian Inflasi Daerah Desa</h3>
                    <p>TPID Desa adalah tim koordinasi yang bertugas memantau perkembangan harga komoditas strategis,
                        menganalisis faktor penyebab inflasi, dan mengambil langkah-langkah pengendalian untuk menjaga
                        stabilitas harga di tingkat desa.</p>
                    <p>Tim ini bekerja sama dengan berbagai stakeholder untuk memastikan ketersediaan dan keterjangkauan
                        kebutuhan pokok masyarakat, serta memberikan early warning system terhadap potensi gejolak harga.
                    </p>

                    <div class="intro-features">
                        <div class="feature-badge">Monitoring Harga Real-time</div>
                        <div class="feature-badge">Analisis Pasar Lokal</div>
                        <div class="feature-badge">Koordinasi Stakeholder</div>
                        <div class="feature-badge">Early Warning System</div>
                    </div>
                </div>
                <div class="intro-image">
                    <img src="https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="TPID">
                    <div class="image-floating-card floating-card-1">
                        <h4 style="color: #2c3e50; margin-bottom: 0.5rem;">15</h4>
                        <p style="color: #666; font-size: 0.9rem;">Komoditas Dipantau</p>
                    </div>
                    <div class="image-floating-card floating-card-2">
                        <h4 style="color: #2c3e50; margin-bottom: 0.5rem;">2.5%</h4>
                        <p style="color: #666; font-size: 0.9rem;">Inflasi Terkendali</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs-section">
        <div class="container">
            <h2 class="section-title">Program Kerja TPID</h2>
            <div class="programs-grid">
                <div class="program-card card-3d">
                    <div class="program-header">
                        <div class="program-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="program-title">Monitoring Harga</div>
                        <div class="program-subtitle">Pemantauan Harga Harian</div>
                    </div>
                    <div class="program-content">
                        <p class="program-description">
                            Memantau perkembangan harga komoditas strategis secara real-time melalui survei pasar
                            tradisional dan modern di wilayah desa.
                        </p>
                        <div class="program-stats">
                            <div class="stat-item">
                                <div class="stat-number">15</div>
                                <div class="stat-label">Komoditas</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">5</div>
                                <div class="stat-label">Lokasi Pasar</div>
                            </div>
                        </div>
                        <button class="program-btn">Lihat Detail Program</button>
                    </div>
                </div>

                <div class="program-card card-3d">
                    <div class="program-header">
                        <div class="program-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="program-title">Stabilisasi Pasokan</div>
                        <div class="program-subtitle">Jaminan Ketersediaan</div>
                    </div>
                    <div class="program-content">
                        <p class="program-description">
                            Koordinasi dengan petani lokal dan distributor untuk memastikan kontinuitas pasokan komoditas
                            pangan strategis.
                        </p>
                        <div class="program-stats">
                            <div class="stat-item">
                                <div class="stat-number">45</div>
                                <div class="stat-label">Petani Mitra</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">12</div>
                                <div class="stat-label">Distributor</div>
                            </div>
                        </div>
                        <button class="program-btn">Lihat Detail Program</button>
                    </div>
                </div>

                <div class="program-card card-3d">
                    <div class="program-header">
                        <div class="program-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="program-title">Early Warning</div>
                        <div class="program-subtitle">Sistem Peringatan Dini</div>
                    </div>
                    <div class="program-content">
                        <p class="program-description">
                            Mengidentifikasi potensi gangguan pasokan dan lonjakan harga serta memberikan rekomendasi
                            tindakan preventif.
                        </p>
                        <div class="program-stats">
                            <div class="stat-item">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Monitoring</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">48</div>
                                <div class="stat-label">Jam Respons</div>
                            </div>
                        </div>
                        <button class="program-btn">Lihat Detail Program</button>
                    </div>
                </div>

                <div class="program-card card-3d">
                    <div class="program-header">
                        <div class="program-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="program-title">Kemitraan Strategis</div>
                        <div class="program-subtitle">Kolaborasi Multi-Stakeholder</div>
                    </div>
                    <div class="program-content">
                        <p class="program-description">
                            Membangun jejaring kerjasama dengan berbagai pihak untuk memperkuat ekosistem pengendalian
                            inflasi daerah.
                        </p>
                        <div class="program-stats">
                            <div class="stat-item">
                                <div class="stat-number">8</div>
                                <div class="stat-label">Institusi</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">25</div>
                                <div class="stat-label">MoU Aktif</div>
                            </div>
                        </div>
                        <button class="program-btn">Lihat Detail Program</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Price Monitoring -->
    <section class="price-monitoring">
        <div class="container">
            <h2 class="section-title">Monitoring Harga Komoditas</h2>
            <div class="price-table">
                <div class="table-header">
                    <h3>Harga Komoditas Strategis</h3>
                    <div class="table-date">Update terakhir: 14 Juli 2024, 15:30 WIB</div>
                </div>
                <div class="price-table-content">
                    <div class="price-grid">
                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Beras Premium</h4>
                                    <div class="commodity-unit">per kg</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 14.500</div>
                                <div class="price-change price-up">↑ Rp 200 (1.4%)</div>
                            </div>
                        </div>

                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-egg"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Telur Ayam</h4>
                                    <div class="commodity-unit">per kg</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 28.000</div>
                                <div class="price-change price-stable">→ Stabil</div>
                            </div>
                        </div>

                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-drumstick-bite"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Daging Ayam</h4>
                                    <div class="commodity-unit">per kg</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 35.000</div>
                                <div class="price-change price-down">↓ Rp 1.000 (2.8%)</div>
                            </div>
                        </div>

                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-fish"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Ikan Segar</h4>
                                    <div class="commodity-unit">per kg</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 45.000</div>
                                <div class="price-change price-up">↑ Rp 3.000 (7.1%)</div>
                            </div>
                        </div>

                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-pepper-hot"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Cabai Merah</h4>
                                    <div class="commodity-unit">per kg</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 38.000</div>
                                <div class="price-change price-down">↓ Rp 2.000 (5.0%)</div>
                            </div>
                        </div>

                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-carrot"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Bawang Merah</h4>
                                    <div class="commodity-unit">per kg</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 32.000</div>
                                <div class="price-change price-stable">→ Stabil</div>
                            </div>
                        </div>

                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-oil-can"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Minyak Goreng</h4>
                                    <div class="commodity-unit">per liter</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 16.500</div>
                                <div class="price-change price-up">↑ Rp 500 (3.1%)</div>
                            </div>
                        </div>

                        <div class="price-item">
                            <div class="price-commodity">
                                <div class="commodity-icon">
                                    <i class="fas fa-cube"></i>
                                </div>
                                <div class="commodity-info">
                                    <h4>Gula Pasir</h4>
                                    <div class="commodity-unit">per kg</div>
                                </div>
                            </div>
                            <div class="price-value">
                                <div class="current-price">Rp 14.000</div>
                                <div class="price-change price-stable">→ Stabil</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <h2 class="section-title" style="color: white;">Tim TPID Desa</h2>
            <div class="team-grid">
                <div class="team-card card-3d">
                    <div class="team-avatar">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="team-name">Budi Santoso, S.AP</div>
                    <div class="team-position">Ketua TPID</div>
                    <div class="team-contact">
                        <i class="fas fa-phone"></i> (021) 1234-5678<br>
                        <i class="fas fa-envelope"></i> ketua@tpiddesa.id
                    </div>
                </div>

                <div class="team-card card-3d">
                    <div class="team-avatar">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="team-name">Eko Prasetyo, S.E</div>
                    <div class="team-position">Koordinator Monitoring</div>
                    <div class="team-contact">
                        <i class="fas fa-phone"></i> (021) 1234-5680<br>
                        <i class="fas fa-envelope"></i> monitoring@tpiddesa.id
                    </div>
                </div>

                <div class="team-card card-3d">
                    <div class="team-avatar">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="team-name">Agus Setiawan, SP</div>
                    <div class="team-position">Koordinator Pasokan</div>
                    <div class="team-contact">
                        <i class="fas fa-phone"></i> (021) 1234-5684<br>
                        <i class="fas fa-envelope"></i> pasokan@tpiddesa.id
                    </div>
                </div>

                <div class="team-card card-3d">
                    <div class="team-avatar">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="team-name">Siti Aminah, S.Sos</div>
                    <div class="team-position">Koordinator Sosial</div>
                    <div class="team-contact">
                        <i class="fas fa-phone"></i> (021) 1234-5679<br>
                        <i class="fas fa-envelope"></i> sosial@tpiddesa.id
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            <h2 class="section-title">Hubungi TPID</h2>
            <div class="contact-grid">
                <div class="contact-info">
                    <h3 style="color: #2c3e50; margin-bottom: 2rem;">Informasi Kontak</h3>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Alamat Kantor</h4>
                            <p>Balai Desa Maju Sejahtera<br>Jl. Merdeka No. 1, Desa Maju Sejahtera</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Telepon</h4>
                            <p>(021) 1234-5678<br>Jam kerja: 08.00 - 16.00 WIB</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Email</h4>
                            <p>info@tpiddesa.id<br>laporan@tpiddesa.id</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h4>Jam Operasional</h4>
                            <p>Senin - Jumat: 08.00 - 16.00 WIB<br>Sabtu: 08.00 - 12.00 WIB</p>
                        </div>
                    </div>
                </div>

                <div class="quick-form">
                    <h3 style="color: #2c3e50; margin-bottom: 2rem;">Laporan Harga</h3>
                    <form>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" required>
                        </div>

                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="tel" id="telepon" name="telepon" required>
                        </div>

                        <div class="form-group">
                            <label for="komoditas">Komoditas</label>
                            <input type="text" id="komoditas" name="komoditas"
                                placeholder="Contoh: Beras, Cabai, dll" required>
                        </div>

                        <div class="form-group">
                            <label for="harga">Harga yang Diamati</label>
                            <input type="text" id="harga" name="harga" placeholder="Contoh: Rp 15.000/kg"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="lokasi">Lokasi Pasar</label>
                            <input type="text" id="lokasi" name="lokasi" placeholder="Nama pasar atau toko"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan Tambahan</label>
                            <textarea id="keterangan" name="keterangan"
                                placeholder="Informasi tambahan tentang kondisi pasar, kualitas barang, dll"></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Price update animation
        function updatePriceAnimation() {
            const priceItems = document.querySelectorAll('.price-item');
            priceItems.forEach((item, index) => {
                setTimeout(() => {
                    item.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        item.style.transform = 'scale(1)';
                    }, 200);
                }, index * 100);
            });
        }

        // Real-time clock for price update
        function updateTimestamp() {
            const now = new Date();
            const timeString = now.toLocaleString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const timestampElement = document.querySelector('.table-date');
            if (timestampElement) {
                timestampElement.textContent = `Update terakhir: ${timeString} WIB`;
            }
        }

        // Intersection Observer for animations
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

        // Apply animations to cards
        document.querySelectorAll('.program-card, .team-card, .price-item').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(element);
        });

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            submitBtn.disabled = true;

            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Terkirim!';
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    this.reset();
                }, 2000);
            }, 1500);
        });

        // Statistics counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                if (!isNaN(target)) {
                    let current = 0;
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        counter.textContent = Math.floor(current);
                        if (current >= target) {
                            counter.textContent = target;
                            clearInterval(timer);
                        }
                    }, 30);
                }
            });
        }
        // Initialize
        updateTimestamp();
        setInterval(updateTimestamp, 60000); // Update every minute
        setInterval(updatePriceAnimation, 30000); // Animate prices every 30 seconds
    </script>

@endsection

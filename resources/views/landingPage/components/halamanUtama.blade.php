@extends('landingPage.main')

@section('content')
    <style>
        /* Hero Section */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('storage/{{ $foto_home }}');
            overflow: hidden;
        }

        .hero-layer {
            background-color: rgba(49, 49, 49, 0.7);
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="rgba(255,255,255,0.1)"><polygon points="0,0 1000,100 1000,0"/></svg>');
            background-size: 100% 100%;
            animation: wave 10s linear infinite;
        }

        @keyframes wave {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-50px);
            }
        }

        .hero-content {
            text-align: center;
            color: white;
            z-index: 10;
            max-width: 800px;
            padding: 0 2rem;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 1rem;
            animation: fadeInUp 1s ease-out;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            animation: fadeInUp 1s ease-out 0.3s both;
            opacity: 0.9;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .btn-primary,
        .btn-secondary {
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transform: translateY(0);
        }

        .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 100px;
            height: 100px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        /* About Section */
        .about {
            padding: 5rem 0;
            background: #f8f9fa;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-content h3 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .about-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .image-overlay {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.9);
            padding: 1rem;
            border-radius: 15px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .image-overlay h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .image-overlay p {
            color: #666;
            font-size: 0.9rem;
        }

        /* BPS Collaboration Section */
        .collaboration {
            padding: 5rem 0;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .collaboration::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20" fill="rgba(255,255,255,0.05)"><circle cx="10" cy="10" r="3"/><circle cx="30" cy="10" r="3"/><circle cx="50" cy="10" r="3"/><circle cx="70" cy="10" r="3"/><circle cx="90" cy="10" r="3"/></svg>');
            background-size: 200px 100px;
            animation: dots-move 20s linear infinite;
        }

        @keyframes dots-move {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 200px 0;
            }
        }

        .collaboration-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .collaboration-text h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .collaboration-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            opacity: 0.95;
        }

        .collaboration-highlight {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #3498db;
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            backdrop-filter: blur(10px);
        }

        .collaboration-highlight h4 {
            color: #3498db;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .collaboration-features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .collab-feature {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .collab-feature:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .collab-feature i {
            color: #3498db;
            font-size: 1.2rem;
        }

        .collab-feature span {
            font-size: 0.95rem;
            font-weight: 500;
        }

        .partnership-logos {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .logo-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transform: perspective(1000px) rotateY(-5deg);
            transition: all 0.3s ease;
            width: 100%;
            max-width: 400px;
            min-width: 380px;
            text-align: center;
        }

        .logo-container:hover {
            transform: perspective(1000px) rotateY(0deg) translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
        }

        .bps-logo {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #f3f3f3 0%, #d5d5d5 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            margin: 0 auto 1rem;
            font-weight: bold;
        }

        .logo-bps-ri {
            width: 70%
        }

        .partnership-text {
            color: #2c3e50;
        }

        .partnership-text h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            padding: 0 0.5rem;
            text-align: center;
        }

        .partnership-text p {
            font-size: 0.95rem;
            opacity: 0.8;
            margin: 0;
        }

        .desa-cinta-badge {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 1rem;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Services Section */
        .services {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }

        .service-card:hover {
            transform: translateY(-10px) rotateX(5deg);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: white;
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .service-card p {
            opacity: 0.9;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats {
            padding: 5rem 0;
            background: #2c3e50;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: #3498db;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* News Section */
        .news {
            padding: 5rem 0;
            background: #f8f9fa;
        }

        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .news-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .news-image {
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .news-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
        }

        .news-content {
            padding: 1.5rem;
        }

        .news-date {
            color: #3498db;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .news-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .news-excerpt {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .news-link {
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s ease;
        }

        .news-link:hover {
            color: #2980b9;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .about-grid,
            .collaboration-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .collaboration-text h3 {
                font-size: 1.8rem;
            }

            .collaboration-features {
                grid-template-columns: 1fr;
            }

            .services-grid,
            .stats-grid,
            .news-grid {
                grid-template-columns: 1fr;
            }

            .logo-container {
                max-width: 340px;
                min-width: 320px;
            }

            .partnership-text h4 {
                font-size: 1.05rem;
                padding: 0 0.3rem;
            }
        }
    </style>

    <!-- Hero Section -->
    {{-- @dd($foto_home) --}}
    <section class="hero parallax-container">
        <div class="hero-layer"></div>
        <div class="parallax-layer" data-speed="0.5">
            <div class="floating-shapes">
                <div class="shape"></div>
                <div class="shape"></div>
                <div class="shape"></div>
            </div>
        </div>

        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di Desa Sosopan</h1>
            <p class="hero-subtitle">Sistem Informasi Terpadu untuk Kemajuan Desa dan Pelayanan Masyarakat</p>
            <div class="hero-buttons">
                <a href="#about" class="btn-primary">
                    <i class="fas fa-arrow-down"></i>
                    Jelajahi Sekarang
                </a>
                <a href="{{ route('informasi-desa') }}" class="btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    Informasi Desa
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <h2 class="section-title fade-in-up">Tentang Portal Desa</h2>
            <div class="about-grid">
                <div class="about-content">
                    <h3>Membangun Desa Digital yang Maju</h3>
                    <p>Portal Desa adalah platform digital yang dirancang khusus untuk meningkatkan transparansi, efisiensi,
                        dan kualitas pelayanan publik di tingkat desa. Kami menyediakan akses mudah ke informasi dan layanan
                        yang dibutuhkan masyarakat.</p>

                    <div class="about-features">
                        <div class="feature-item card-3d">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h4>Pelayanan Terpadu</h4>
                                <p>Layanan satu pintu untuk kemudahan masyarakat</p>
                            </div>
                        </div>
                        <div class="feature-item card-3d">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <h4>Transparansi</h4>
                                <p>Informasi yang akurat dan dapat diakses publik</p>
                            </div>
                        </div>
                        <div class="feature-item card-3d">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div>
                                <h4>Akses Digital</h4>
                                <p>Platform responsive untuk semua perangkat</p>
                            </div>
                        </div>
                        <div class="feature-item card-3d">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div>
                                <h4>Keamanan Data</h4>
                                <p>Perlindungan data dengan teknologi terkini</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                        alt="Desa Digital">
                    <div class="image-overlay floating-element">
                        <h4>1.200+</h4>
                        <p>Warga Terlayani</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BPS Collaboration Section -->
    <section class="collaboration">
        <div class="container">
            <h2 class="section-title" style="color: white;">Kolaborasi dengan BPS</h2>
            <div class="collaboration-content">
                <div class="collaboration-text">
                    <h3>Desa Cinta Statistik</h3>
                    <p>Portal Desa ini merupakan hasil kolaborasi strategis antara pemerintah desa dengan Badan Pusat
                        Statistik (BPS) melalui program <strong>Desa Cinta Statistik</strong>. Kemitraan ini bertujuan untuk
                        membangun ekosistem data yang kuat di tingkat desa.</p>

                    <div class="collaboration-highlight">
                        <h4><i class="fas fa-handshake"></i> Program Desa Cinta Statistik</h4>
                        <p>Inisiatif nasional untuk memperkuat literasi statistik dan meningkatkan kualitas data di tingkat
                            desa sebagai fondasi perencanaan pembangunan yang berbasis bukti.</p>
                    </div>

                    <div class="collaboration-features">
                        <div class="collab-feature">
                            <i class="fas fa-database"></i>
                            <span>Integrasi Data Statistik</span>
                        </div>
                        <div class="collab-feature">
                            <i class="fas fa-chart-bar"></i>
                            <span>Dashboard Analytics</span>
                        </div>
                        <div class="collab-feature">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Pelatihan Literasi Data</span>
                        </div>
                        <div class="collab-feature">
                            <i class="fas fa-sync-alt"></i>
                            <span>Sinkronisasi Real-time</span>
                        </div>
                    </div>
                </div>

                <div class="partnership-logos">
                    <div class="logo-container">
                        <div class="bps-logo">
                            <img class="logo-bps-ri" src="{{ url('img/logo-bps.png') }}" alt="logo-bps">
                        </div>
                        <div class="partnership-text">
                            <h4>Badan Pusat Statistik<br>Kabupaten Padang Lawas Utara</h4>
                            <p>Mitra resmi dalam pengembangan sistem informasi desa berbasis data statistik yang akurat dan
                                terpercaya</p>
                        </div>
                        <div class="desa-cinta-badge">
                            <i class="fas fa-heart"></i> Desa Cinta Statistik
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <div class="container">
            <h2 class="section-title" style="color: white;">Layanan Kami</h2>
            <div class="services-grid">
                <div class="service-card card-3d">
                    <div class="service-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Administrasi Desa</h3>
                    <p>Pengurusan surat-surat administrasi seperti surat keterangan, surat pengantar, dan dokumen resmi
                        lainnya secara online.</p>
                </div>
                <div class="service-card card-3d">
                    <div class="service-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>Informasi Keuangan</h3>
                    <p>Transparansi pengelolaan keuangan desa, anggaran, dan realisasi pembangunan untuk akuntabilitas
                        publik.</p>
                </div>
                <div class="service-card card-3d">
                    <div class="service-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Pengumuman</h3>
                    <p>Penyampaian informasi terkini tentang kegiatan desa, program pemerintah, dan pengumuman penting
                        lainnya.</p>
                </div>
                <div class="service-card card-3d">
                    <div class="service-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>Agenda Kegiatan</h3>
                    <p>Jadwal kegiatan desa, pertemuan, dan acara-acara penting yang melibatkan partisipasi masyarakat.</p>
                </div>
                <div class="service-card card-3d">
                    <div class="service-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Layanan Pengaduan</h3>
                    <p>Sistem pengaduan masyarakat untuk menyampaikan aspirasi, keluhan, dan saran pembangunan desa.</p>
                </div>
                <div class="service-card card-3d">
                    <div class="service-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Data Statistik</h3>
                    <p>Informasi data kependudukan, ekonomi, dan sosial desa untuk mendukung perencanaan pembangunan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <h2 class="section-title" style="color: white;">Statistik Desa</h2>
            <div class="stats-grid">
                <div class="stat-item card-3d">
                    <div class="stat-number">521</div>
                    <div class="stat-label">Total Penduduk</div>
                </div>
                <div class="stat-item card-3d">
                    <div class="stat-number">139</div>
                    <div class="stat-label">Kepala Keluarga</div>
                </div>
                <div class="stat-item card-3d">
                    <div class="stat-number">255</div>
                    <div class="stat-label">Penduduk Laki-Laki</div>
                </div>
                <div class="stat-item card-3d">
                    <div class="stat-number">266</div>
                    <div class="stat-label">Penduduk Perempuan</div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news">
        <div class="container">
            <h2 class="section-title">Berita & Pengumuman</h2>
            <div class="news-grid">
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1577962917302-cd874c4e31d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                            alt="Berita 1" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="news-content">
                        <div class="news-date">15 Juli 2024</div>
                        <h3 class="news-title">Peluncuran Program Digitalisasi Desa</h3>
                        <p class="news-excerpt">Pemerintah desa meluncurkan program digitalisasi pelayanan untuk
                            meningkatkan efisiensi dan transparansi administrasi...</p>
                        <a href="#" class="news-link">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                            alt="Berita 2" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="news-content">
                        <div class="news-date">12 Juli 2024</div>
                        <h3 class="news-title">Gotong Royong Pembangunan Jalan Desa</h3>
                        <p class="news-excerpt">Masyarakat desa bersama-sama melaksanakan kegiatan gotong royong untuk
                            pembangunan infrastruktur jalan...</p>
                        <a href="#" class="news-link">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image">
                        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                            alt="Berita 3" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="news-content">
                        <div class="news-date">10 Juli 2024</div>
                        <h3 class="news-title">Pelatihan UMKM untuk Warga Desa</h3>
                        <p class="news-excerpt">Dinas Koperasi mengadakan pelatihan pengembangan usaha mikro kecil menengah
                            untuk meningkatkan ekonomi desa...</p>
                        <a href="#" class="news-link">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Counter animation
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 100;
            const timer = setInterval(() => {
                current += increment;
                element.textContent = Math.floor(current).toLocaleString();
                if (current >= target) {
                    element.textContent = target.toLocaleString();
                    clearInterval(timer);
                }
            }, 20);
        }

        // Parallax effect for hero section
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroContent = document.querySelector('.hero-content');
            if (heroContent) {
                heroContent.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });

        // Initialize counter animations when stats section is visible
        const observerOptionsHalamanUtama = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const statsObserverHalamanUtama = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('.stat-number');
                    counters.forEach(counter => {
                        const target = parseInt(counter.textContent.replace(/,/g, ''));
                        counter.textContent = '0';
                        animateCounter(counter, target);
                    });
                    statsObserverHalamanUtama.unobserve(entry.target);
                }
            });
        }, observerOptionsHalamanUtama);

        const statsSectionHalamanUtama = document.querySelector('.stats');
        if (statsSectionHalamanUtama) {
            statsObserverHalamanUtama.observe(statsSectionHalamanUtama);
        }

        // Add scroll-triggered animations
        const fadeElements = document.querySelectorAll('.fade-in-up');
        const fadeObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        fadeElements.forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            fadeObserver.observe(element);
        });
    </script>
@endsection

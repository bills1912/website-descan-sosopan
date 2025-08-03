@extends('landingPage.main')

@section('title', 'Informasi Desa - Portal Desa Sosopan')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Informasi Desa</h1>
            <p>Mengenal lebih dekat profil, sejarah, dan potensi desa kami</p>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>Informasi Desa</span>
            </nav>
        </div>
    </section>

    <!-- Content Section -->
    <section class="content-section">
        <div class="container">
            <div class="info-grid">
                <div class="info-card card-3d">
                    <h3>
                        <i class="fas fa-info-circle"></i>
                        Profil Desa
                    </h3>
                    <div class="info-item">
                        <span class="info-label">Nama Desa</span>
                        <span class="info-value">Desa Maju Sejahtera</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kecamatan</span>
                        <span class="info-value">Kecamatan Sentral</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kabupaten</span>
                        <span class="info-value">Kabupaten Harmoni</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Provinsi</span>
                        <span class="info-value">Provinsi Nusantara</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kode Pos</span>
                        <span class="info-value">12345</span>
                    </div>
                </div>

                <div class="info-card card-3d">
                    <h3>
                        <i class="fas fa-map-marker-alt"></i>
                        Geografis
                    </h3>
                    <div class="info-item">
                        <span class="info-label">Luas Wilayah</span>
                        <span class="info-value">15.75 km²</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Ketinggian</span>
                        <span class="info-value">450 mdpl</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Topografi</span>
                        <span class="info-value">Dataran Tinggi</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Curah Hujan</span>
                        <span class="info-value">2.500 mm/tahun</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Suhu Rata-rata</span>
                        <span class="info-value">24°C - 28°C</span>
                    </div>
                </div>

                <div class="info-card card-3d">
                    <h3>
                        <i class="fas fa-users"></i>
                        Demografi
                    </h3>
                    <div class="info-item">
                        <span class="info-label">Jumlah Penduduk</span>
                        <span class="info-value">1.247 jiwa</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Laki-laki</span>
                        <span class="info-value">623 jiwa</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Perempuan</span>
                        <span class="info-value">624 jiwa</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kepala Keluarga</span>
                        <span class="info-value">387 KK</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kepadatan</span>
                        <span class="info-value">79 jiwa/km²</span>
                    </div>
                </div>

                <div class="info-card card-3d">
                    <h3>
                        <i class="fas fa-briefcase"></i>
                        Ekonomi
                    </h3>
                    <div class="info-item">
                        <span class="info-label">Sektor Utama</span>
                        <span class="info-value">Pertanian</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Komoditas Unggulan</span>
                        <span class="info-value">Padi, Jagung</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">UMKM</span>
                        <span class="info-value">45 unit</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Industri Kecil</span>
                        <span class="info-value">12 unit</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Potensi Wisata</span>
                        <span class="info-value">3 lokasi</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="container">
            <h2 class="section-title">Galeri Desa</h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1586348943529-beaae6c28db9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Sawah Padi">
                    <div class="gallery-overlay">
                        <div class="gallery-title">Hamparan Sawah Padi</div>
                        <div class="gallery-description">Lahan pertanian yang subur menjadi tulang punggung ekonomi desa
                        </div>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Hutan Desa">
                    <div class="gallery-overlay">
                        <div class="gallery-title">Hutan Konservasi</div>
                        <div class="gallery-description">Area konservasi yang menjadi paru-paru hijau desa</div>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Balai Desa">
                    <div class="gallery-overlay">
                        <div class="gallery-title">Balai Desa</div>
                        <div class="gallery-description">Pusat pemerintahan dan kegiatan masyarakat desa</div>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Pasar Tradisional">
                    <div class="gallery-overlay">
                        <div class="gallery-title">Pasar Tradisional</div>
                        <div class="gallery-description">Pusat perdagangan dan interaksi ekonomi masyarakat</div>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Jalan Desa">
                    <div class="gallery-overlay">
                        <div class="gallery-title">Infrastruktur Jalan</div>
                        <div class="gallery-description">Akses jalan yang menghubungkan antar dusun</div>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Kegiatan Masyarakat">
                    <div class="gallery-overlay">
                        <div class="gallery-title">Kegiatan Gotong Royong</div>
                        <div class="gallery-description">Tradisi gotong royong yang masih kuat di masyarakat</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Facilities Section -->
    <section class="facilities-section">
        <div class="container">
            <h2 class="section-title">Fasilitas Desa</h2>
            <div class="facilities-grid">
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4>Pendidikan</h4>
                    <p>3 SD, 1 SMP, dan 1 PAUD yang melayani kebutuhan pendidikan anak-anak desa</p>
                </div>
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h4>Kesehatan</h4>
                    <p>1 Puskesmas, 2 Posyandu, dan 1 Apotek untuk pelayanan kesehatan masyarakat</p>
                </div>
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-mosque"></i>
                    </div>
                    <h4>Ibadah</h4>
                    <p>5 Masjid, 2 Mushola, dan 1 Gereja yang tersebar di seluruh wilayah desa</p>
                </div>
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-futbol"></i>
                    </div>
                    <h4>Olahraga</h4>
                    <p>1 Lapangan sepak bola, 2 Lapangan voli, dan jogging track sepanjang 2 km</p>
                </div>
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                    <h4>Air Bersih</h4>
                    <p>Sistem air bersih yang melayani 95% rumah tangga dengan kualitas air yang baik</p>
                </div>
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4>Listrik</h4>
                    <p>Elektrifikasi 100% dengan jaringan PLN dan panel surya di beberapa fasilitas umum</p>
                </div>
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-wifi"></i>
                    </div>
                    <h4>Internet</h4>
                    <p>Jaringan internet 4G dan WiFi gratis di balai desa dan fasilitas umum</p>
                </div>
                <div class="facility-card card-3d">
                    <div class="facility-icon">
                        <i class="fas fa-road"></i>
                    </div>
                    <h4>Transportasi</h4>
                    <p>Jalan aspal sepanjang 15 km dan angkutan umum yang melayani rute desa-kota</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <h2 class="section-title">Peta Wilayah Desa</h2>
            <div class="map-container">
                <div class="map-placeholder">
                    <div>
                        <i class="fas fa-map-marked-alt" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                        <div>Peta Interaktif Desa Maju Sejahtera</div>
                        <div style="font-size: 1rem; opacity: 0.8; margin-top: 0.5rem;">Koordinat: -6.2088, 106.8456</div>
                    </div>
                </div>
                <div class="map-info">
                    <div class="map-info-item">
                        <i class="fas fa-home"></i>
                        <h4>Balai Desa</h4>
                        <p>Jl. Merdeka No. 1</p>
                    </div>
                    <div class="map-info-item">
                        <i class="fas fa-hospital"></i>
                        <h4>Puskesmas</h4>
                        <p>Jl. Sehat No. 15</p>
                    </div>
                    <div class="map-info-item">
                        <i class="fas fa-school"></i>
                        <h4>SD Negeri 1</h4>
                        <p>Jl. Pendidikan No. 8</p>
                    </div>
                    <div class="map-info-item">
                        <i class="fas fa-shopping-cart"></i>
                        <h4>Pasar Desa</h4>
                        <p>Jl. Dagang No. 23</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Intersection Observer for animations
        const observerOptionsInformasiDesa = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observerInformasiDesa = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptionsInformasiDesa);

        // Apply initial styles and observe elements
        document.querySelectorAll('.info-card, .facility-card, .gallery-item').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observerInformasiDesa.observe(element);
        });

        // Gallery lightbox effect (simple implementation)
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.addEventListener('click', function() {
                const img = this.querySelector('img');
                const title = this.querySelector('.gallery-title').textContent;

                // Create lightbox overlay
                const lightbox = document.createElement('div');
                lightbox.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 9999;
                cursor: pointer;
            `;

                const lightboxImg = document.createElement('img');
                lightboxImg.src = img.src;
                lightboxImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            `;

                const lightboxTitle = document.createElement('div');
                lightboxTitle.textContent = title;
                lightboxTitle.style.cssText = `
                position: absolute;
                bottom: 50px;
                left: 50%;
                transform: translateX(-50%);
                color: white;
                font-size: 1.5rem;
                font-weight: 600;
                text-align: center;
            `;

                lightbox.appendChild(lightboxImg);
                lightbox.appendChild(lightboxTitle);
                document.body.appendChild(lightbox);

                // Close lightbox on click
                lightbox.addEventListener('click', () => {
                    document.body.removeChild(lightbox);
                });
            });
        });

        // Smooth reveal animation for sections
        const revealSections = document.querySelectorAll(
            '.content-section, .gallery-section, .facilities-section, .map-section');

        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        revealSections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            sectionObserver.observe(section);
        });
    </script>
@endsection

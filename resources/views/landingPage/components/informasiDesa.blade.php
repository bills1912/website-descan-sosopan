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
                        <span class="info-value">Desa Sosopan</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kecamatan</span>
                        <span class="info-value">Kecamatan Padang Bolak</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kabupaten</span>
                        <span class="info-value">Kabupaten Padang Lawas Utara</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Provinsi</span>
                        <span class="info-value">Provinsi Sumatera Utara</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kode Pos</span>
                        <span class="info-value">-</span>
                    </div>
                </div>

                <div class="info-card card-3d">
                    <h3>
                        <i class="fas fa-map-marker-alt"></i>
                        Geografis
                    </h3>
                    <div class="info-item">
                        <span class="info-label">Luas Wilayah</span>
                        <span class="info-value">0.6 km²</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Topografi</span>
                        <span class="info-value">Dataran Rendah</span>
                    </div>
                </div>

                <div class="info-card card-3d">
                    <h3>
                        <i class="fas fa-users"></i>
                        Demografi
                    </h3>
                    <div class="info-item">
                        <span class="info-label">Jumlah Penduduk</span>
                        <span class="info-value">521 jiwa</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Laki-laki</span>
                        <span class="info-value">255 jiwa</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Perempuan</span>
                        <span class="info-value">266 jiwa</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Kepala Keluarga</span>
                        <span class="info-value">139 KK</span>
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
                        <span class="info-value">Kelapa Sawit</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Industri Kecil</span>
                        <span class="info-value">3 unit</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <!-- Enhanced Gallery Section with Pagination and Filter -->
    <section class="gallery-section">
        <div class="container">
            <h2 class="section-title">Galeri Kegiatan Desa</h2>

            <!-- Filter Section -->
            <div class="gallery-filter">
                <form id="filterForm" method="GET" action="{{ route('informasi-desa') }}">
                    <div class="filter-container">
                        <div class="filter-group">
                            <label for="jenis_kegiatan">Jenis Kegiatan</label>
                            <select name="jenis_kegiatan" id="jenis_kegiatan" class="filter-select">
                                <option value="">Semua Kegiatan</option>
                                <option value="sosial" {{ request('jenis_kegiatan') == 'sosial' ? 'selected' : '' }}>Sosial
                                </option>
                                <option value="ekonomi" {{ request('jenis_kegiatan') == 'ekonomi' ? 'selected' : '' }}>
                                    Ekonomi</option>
                                <option value="pendidikan"
                                    {{ request('jenis_kegiatan') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                <option value="kesehatan" {{ request('jenis_kegiatan') == 'kesehatan' ? 'selected' : '' }}>
                                    Kesehatan</option>
                                <option value="lingkungan"
                                    {{ request('jenis_kegiatan') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                <option value="infrastruktur"
                                    {{ request('jenis_kegiatan') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur
                                </option>
                            </select>
                        </div>
                        <div class="filter-group">
                            <label for="tanggal_dari">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" id="tanggal_dari"
                                value="{{ request('tanggal_dari') }}" class="filter-input">
                        </div>
                        <div class="filter-group">
                            <label for="tanggal_sampai">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                                value="{{ request('tanggal_sampai') }}" class="filter-input">
                        </div>
                        <div class="filter-group">
                            <button type="submit" class="filter-btn">
                                <i class="fas fa-search"></i>
                                Filter
                            </button>
                            <a href="{{ route('informasi-desa') }}" class="reset-btn">
                                <i class="fas fa-undo"></i>
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-grid">
                @forelse($kegiatanDesa as $kegiatan)
                    <div class="gallery-item" data-kegiatan="{{ $kegiatan->id }}">
                        @if ($kegiatan->file_path)
                            <img src="{{ asset('storage/kegiatanDesa/' . $kegiatan->file_path) }}"
                                alt="{{ $kegiatan->judul_kegiatan }}"
                                onerror="this.src='https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80'">
                        @else
                            <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                                alt="{{ $kegiatan->judul_kegiatan }}">
                        @endif

                        <div class="gallery-overlay">
                            <div class="gallery-meta">
                                <span class="gallery-category">{{ ucfirst($kegiatan->jenis_kegiatan) }}</span>
                                <span class="gallery-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y') }}
                                </span>
                            </div>
                            <div class="gallery-title">{{ $kegiatan->judul_kegiatan }}</div>
                            <div class="gallery-description">
                                {{ Str::limit($kegiatan->deskripsi_kegiatan, 100) }}
                            </div>
                            <div class="gallery-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $kegiatan->lokasi_kegiatan }}
                            </div>
                            <div class="gallery-pic">
                                <i class="fas fa-user"></i>
                                {{ $kegiatan->penanggung_jawab }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <h3>Tidak ada kegiatan ditemukan</h3>
                        <p>Belum ada kegiatan yang sesuai dengan filter yang dipilih.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($kegiatanDesa->hasPages())
                <div class="gallery-pagination">
                    <div class="pagination-wrapper">
                        {{-- Previous Page Link --}}
                        @if ($kegiatanDesa->onFirstPage())
                            <span class="pagination-btn disabled">
                                <i class="fas fa-chevron-left"></i>
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $kegiatanDesa->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-btn">
                                <i class="fas fa-chevron-left"></i>
                                Sebelumnya
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        <div class="pagination-numbers">
                            @foreach ($kegiatanDesa->appends(request()->query())->getUrlRange(1, $kegiatanDesa->lastPage()) as $page => $url)
                                @if ($page == $kegiatanDesa->currentPage())
                                    <span class="pagination-number active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="pagination-number">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Page Link --}}
                        @if ($kegiatanDesa->hasMorePages())
                            <a href="{{ $kegiatanDesa->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-btn">
                                Selanjutnya
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="pagination-btn disabled">
                                Selanjutnya
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>

                    <!-- Pagination Info -->
                    <div class="pagination-info">
                        Menampilkan {{ $kegiatanDesa->firstItem() ?? 0 }} - {{ $kegiatanDesa->lastItem() ?? 0 }}
                        dari {{ $kegiatanDesa->total() }} kegiatan
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Enhanced Gallery Modal -->
    <div id="galleryModal" class="gallery-modal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-image-container">
                <img id="modalImage" src="" alt="">
            </div>
            <div class="modal-info">
                <div class="modal-header">
                    <h3 id="modalTitle"></h3>
                    <div class="modal-meta">
                        <span id="modalCategory" class="modal-category"></span>
                        <span id="modalDate" class="modal-date"></span>
                    </div>
                </div>
                <div class="modal-body">
                    <p id="modalDescription"></p>
                    <div class="modal-details">
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span id="modalLocation"></span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-user"></i>
                            <span id="modalPic"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

        document.addEventListener('DOMContentLoaded', function() {
            // Intersection Observer for animations
            const observerOptionsEnhanced = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observerEnhanced = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptionsEnhanced);

            // Apply initial styles and observe elements
            document.querySelectorAll('.gallery-item, .filter-container, .gallery-pagination').forEach((element,
                index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(50px)';
                element.style.transition =
                    `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
                observerEnhanced.observe(element);
            });

            // Enhanced Gallery Modal
            const modal = document.getElementById('galleryModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            const modalCategory = document.getElementById('modalCategory');
            const modalDate = document.getElementById('modalDate');
            const modalDescription = document.getElementById('modalDescription');
            const modalLocation = document.getElementById('modalLocation');
            const modalPic = document.getElementById('modalPic');
            const closeModal = document.querySelector('.modal-close');

            // Gallery item click handlers
            document.querySelectorAll('.gallery-item').forEach(item => {
                item.addEventListener('click', function() {
                    const kegiatanId = this.dataset.kegiatan;

                    // Get data from the clicked item
                    const img = this.querySelector('img');
                    const title = this.querySelector('.gallery-title').textContent;
                    const category = this.querySelector('.gallery-category').textContent;
                    const date = this.querySelector('.gallery-date').textContent.trim();
                    const description = this.querySelector('.gallery-description').textContent;
                    const location = this.querySelector('.gallery-location').textContent.trim();
                    const pic = this.querySelector('.gallery-pic').textContent.trim();

                    // Populate modal with data
                    modalImage.src = img.src;
                    modalImage.alt = title;
                    modalTitle.textContent = title;
                    modalCategory.textContent = category;
                    modalDate.textContent = date;
                    modalDescription.textContent = description;
                    modalLocation.textContent = location;
                    modalPic.textContent = pic;

                    // Show modal with animation
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';

                    // Add entrance animation
                    const modalContent = modal.querySelector('.modal-content');
                    modalContent.style.animation = 'modalSlideIn 0.4s ease';
                });
            });

            // Close modal handlers
            closeModal.addEventListener('click', closeModalHandler);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModalHandler();
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.style.display === 'block') {
                    closeModalHandler();
                }
            });

            function closeModalHandler() {
                const modalContent = modal.querySelector('.modal-content');
                modalContent.style.animation = 'modalSlideOut 0.3s ease';

                setTimeout(() => {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 300);
            }

            // Add modal slide out animation
            const style = document.createElement('style');
            style.textContent = `
        @keyframes modalSlideOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            to {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
        }
    `;
            document.head.appendChild(style);

            // Enhanced Filter Functionality
            const filterForm = document.getElementById('filterForm');
            const filterInputs = filterForm.querySelectorAll('select, input');

            // Auto-submit form when filter changes (optional)
            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Add loading animation
                    const filterBtn = filterForm.querySelector('.filter-btn');
                    const originalText = filterBtn.innerHTML;
                    filterBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memfilter...';
                    filterBtn.disabled = true;

                    // Submit form after short delay for better UX
                    setTimeout(() => {
                        filterForm.submit();
                    }, 500);
                });
            });

            // Smooth scroll to gallery when pagination is clicked
            document.querySelectorAll('.pagination-btn, .pagination-number').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading state
                    if (!this.classList.contains('disabled') && !this.classList.contains(
                        'active')) {
                        const gallerySection = document.querySelector('.gallery-section');

                        // Smooth scroll to gallery section
                        setTimeout(() => {
                            gallerySection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }, 100);
                    }
                });
            });

            // Gallery item hover effects
            document.querySelectorAll('.gallery-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.zIndex = '10';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.zIndex = '1';
                });
            });

            // Loading animation for images
            document.querySelectorAll('.gallery-item img').forEach(img => {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });

                img.addEventListener('error', function() {
                    this.style.opacity = '0.7';
                    this.parentElement.classList.add('image-error');
                });

                // Set initial opacity
                img.style.opacity = '0';
                img.style.transition = 'opacity 0.3s ease';
            });

            // Search functionality enhancement
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Enhanced date filter validation
            const tanggalDari = document.getElementById('tanggal_dari');
            const tanggalSampai = document.getElementById('tanggal_sampai');

            if (tanggalDari && tanggalSampai) {
                tanggalDari.addEventListener('change', function() {
                    if (tanggalSampai.value && this.value > tanggalSampai.value) {
                        tanggalSampai.value = this.value;
                    }
                    tanggalSampai.min = this.value;
                });

                tanggalSampai.addEventListener('change', function() {
                    if (tanggalDari.value && this.value < tanggalDari.value) {
                        tanggalDari.value = this.value;
                    }
                    tanggalDari.max = this.value;
                });
            }

            // Progressive image loading
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('.gallery-item img').forEach(img => {
                imageObserver.observe(img);
            });

            // Keyboard navigation for gallery
            let currentImageIndex = -1;
            const galleryItems = document.querySelectorAll('.gallery-item');

            document.addEventListener('keydown', function(e) {
                if (modal.style.display === 'block') {
                    if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                        e.preventDefault();

                        if (currentImageIndex === -1) {
                            // Find current image index
                            const currentSrc = modalImage.src;
                            galleryItems.forEach((item, index) => {
                                const img = item.querySelector('img');
                                if (img.src === currentSrc) {
                                    currentImageIndex = index;
                                }
                            });
                        }

                        if (e.key === 'ArrowLeft' && currentImageIndex > 0) {
                            currentImageIndex--;
                        } else if (e.key === 'ArrowRight' && currentImageIndex < galleryItems.length - 1) {
                            currentImageIndex++;
                        }

                        // Update modal with new image
                        if (currentImageIndex >= 0 && currentImageIndex < galleryItems.length) {
                            const newItem = galleryItems[currentImageIndex];
                            newItem.click();
                        }
                    }
                }
            });

            // Touch/swipe support for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            modal.addEventListener('touchstart', function(e) {
                touchStartX = e.changedTouches[0].screenX;
            });

            modal.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next image
                        const event = new KeyboardEvent('keydown', {
                            key: 'ArrowRight'
                        });
                        document.dispatchEvent(event);
                    } else {
                        // Swipe right - previous image
                        const event = new KeyboardEvent('keydown', {
                            key: 'ArrowLeft'
                        });
                        document.dispatchEvent(event);
                    }
                }
            }

            // Add loading states for better UX
            function addLoadingState(element, originalContent) {
                element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                element.disabled = true;

                return function removeLoadingState() {
                    element.innerHTML = originalContent;
                    element.disabled = false;
                };
            }

            // Gallery statistics (optional feature)
            function updateGalleryStats() {
                const totalItems = document.querySelectorAll('.gallery-item').length;
                const statsElement = document.querySelector('.gallery-stats');

                if (statsElement) {
                    statsElement.textContent = `Menampilkan ${totalItems} kegiatan`;
                }
            }

            // Call stats update
            updateGalleryStats();

            // Lazy loading for better performance
            const lazyLoadOptions = {
                root: null,
                rootMargin: '50px',
                threshold: 0.1
            };

            const lazyImageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        const placeholder = img.parentElement.querySelector('.image-placeholder');

                        img.addEventListener('load', () => {
                            img.style.opacity = '1';
                            if (placeholder) {
                                placeholder.style.opacity = '0';
                                setTimeout(() => placeholder.remove(), 300);
                            }
                        });

                        lazyImageObserver.unobserve(img);
                    }
                });
            }, lazyLoadOptions);

            // Apply lazy loading to all gallery images
            document.querySelectorAll('.gallery-item img').forEach(img => {
                lazyImageObserver.observe(img);
            });

            // Accessibility improvements
            document.querySelectorAll('.gallery-item').forEach((item, index) => {
                item.setAttribute('tabindex', '0');
                item.setAttribute('role', 'button');
                item.setAttribute('aria-label',
                    `Lihat detail kegiatan ${item.querySelector('.gallery-title').textContent}`);

                // Keyboard support
                item.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });

            // Focus management for modal
            modal.addEventListener('shown', function() {
                closeModal.focus();
            });

            // Announcement for screen readers
            const announcer = document.createElement('div');
            announcer.setAttribute('aria-live', 'polite');
            announcer.setAttribute('aria-atomic', 'true');
            announcer.className = 'sr-only';
            document.body.appendChild(announcer);

            function announce(message) {
                announcer.textContent = message;
                setTimeout(() => {
                    announcer.textContent = '';
                }, 1000);
            }

            // Error handling for failed image loads
            document.querySelectorAll('.gallery-item img').forEach(img => {
                img.addEventListener('error', function() {
                    const item = this.parentElement;
                    item.classList.add('image-error');

                    // Create error placeholder
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'image-error-placeholder';
                    errorDiv.innerHTML = `
                <i class="fas fa-image"></i>
                <span>Gambar tidak dapat dimuat</span>
            `;

                    this.style.display = 'none';
                    item.appendChild(errorDiv);
                });
            });

            console.log('Enhanced Gallery initialized successfully');
        });
    </script>
@endsection

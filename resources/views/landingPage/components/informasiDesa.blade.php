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

            <!-- Gallery Grid Container -->
            <div id="gallery-container">
                @include('landingPage.components.partials.gallery-content', [
                    'kegiatanDesa' => $kegiatanDesa,
                ])
            </div>
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
            const filterForm = document.getElementById('filterForm');
            const galleryContainer = document.getElementById('gallery-container');
            const resetBtn = document.querySelector('.reset-btn');
            const filterBtn = document.querySelector('.filter-btn');
            const gallerySection = document.querySelector('.gallery-section');

            // Configuration
            const config = {
                ajaxUrl: '/ajax/informasi-desa/gallery',
                debounceDelay: 500,
                animationDelay: 100,
                loadingTimeout: 10000 // 10 seconds timeout
            };

            // State management
            let currentFilters = {};
            let isLoading = false;
            let loadingTimeout = null;

            // Loading state management
            function showLoading() {
                if (isLoading) return;
                isLoading = true;

                const loadingHTML = `
            <div class="gallery-loading">
                <div class="loading-spinner"></div>
                <div class="loading-text">Memuat galeri kegiatan...</div>
            </div>
        `;
                galleryContainer.innerHTML = loadingHTML;

                // Set timeout for loading
                loadingTimeout = setTimeout(() => {
                    if (isLoading) {
                        showError('Waktu tunggu habis. Silakan coba lagi.');
                        isLoading = false;
                    }
                }, config.loadingTimeout);
            }

            function hideLoading() {
                isLoading = false;
                if (loadingTimeout) {
                    clearTimeout(loadingTimeout);
                    loadingTimeout = null;
                }
            }

            // Error state management
            function showError(message = 'Terjadi kesalahan saat memuat data') {
                const errorHTML = `
            <div class="gallery-grid">
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <div class="empty-icon" style="background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>Gagal Memuat Galeri</h3>
                    <p>${message}</p>
                    <div style="margin-top: 1rem;">
                        <button onclick="retryLoad()" class="filter-btn" style="margin-right: 0.5rem;">
                            <i class="fas fa-refresh"></i>
                            Coba Lagi
                        </button>
                        <button onclick="location.reload()" class="reset-btn">
                            <i class="fas fa-home"></i>
                            Muat Ulang Halaman
                        </button>
                    </div>
                </div>
            </div>
        `;
                galleryContainer.innerHTML = errorHTML;
            }

            // Success state with no data
            function showEmptyState(message = 'Tidak ada kegiatan yang sesuai dengan filter') {
                const emptyHTML = `
            <div class="gallery-grid">
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Tidak Ada Data</h3>
                    <p>${message}</p>
                    <button onclick="clearAllFilters()" class="filter-btn" style="margin-top: 1rem;">
                        <i class="fas fa-times-circle"></i>
                        Hapus Semua Filter
                    </button>
                </div>
            </div>
        `;
                galleryContainer.innerHTML = emptyHTML;
            }

            // Main AJAX function untuk load gallery
            async function loadGallery(params = {}, showLoadingState = true) {
                try {
                    if (showLoadingState) {
                        showLoading();
                    }

                    // Update current filters
                    currentFilters = {
                        ...params
                    };

                    // Build URL dengan parameters
                    const searchParams = new URLSearchParams();
                    Object.keys(params).forEach(key => {
                        if (params[key]) {
                            searchParams.append(key, params[key]);
                        }
                    });

                    // Add CSRF token if available
                    const token = document.querySelector('meta[name="csrf-token"]');
                    const headers = {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    };

                    if (token) {
                        headers['X-CSRF-TOKEN'] = token.content;
                    }

                    // Fetch data dari dedicated AJAX endpoint
                    const response = await fetch(`${config.ajaxUrl}?${searchParams.toString()}`, {
                        method: 'GET',
                        headers: headers
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        // Update gallery container dengan HTML yang diterima
                        galleryContainer.innerHTML = data.html;

                        // Re-initialize gallery items
                        initializeGalleryItems();

                        // Animate new items
                        animateGalleryItems();

                        // Update URL without page reload
                        updateUrl(params);

                        // Update filter summary - FIXED: Check if data.stats exists
                        if (data.stats && data.filters) {
                            updateFilterSummary(data.stats, data.filters);
                        } else {
                            // Create mock stats if not provided
                            const mockStats = {
                                total_kegiatan: data.pagination ? data.pagination.total : 0
                            };
                            updateFilterSummary(mockStats, data.filters || {});
                        }

                        // Announce to screen readers
                        const totalItems = data.pagination ? data.pagination.total : 0;
                        announce(`Galeri berhasil diperbarui. Menampilkan ${totalItems} kegiatan.`);

                        console.log('Gallery loaded successfully:', data);

                    } else {
                        throw new Error(data.message || 'Response tidak valid dari server');
                    }

                    hideLoading();

                } catch (error) {
                    console.error('Error loading gallery:', error);
                    hideLoading();

                    if (error.name === 'TypeError' && error.message.includes('fetch')) {
                        showError('Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
                    } else {
                        showError(error.message);
                    }
                }
            }

            // Update URL without page reload
            function updateUrl(params) {
                const url = new URL(window.location.href);
                const searchParams = new URLSearchParams();

                Object.keys(params).forEach(key => {
                    if (params[key]) {
                        searchParams.append(key, params[key]);
                    }
                });

                const newUrl = `${url.pathname}?${searchParams.toString()}`;

                // Only update if URL actually changed
                if (newUrl !== window.location.href) {
                    history.pushState({
                        filters: params
                    }, '', newUrl);
                }
            }

            // FIXED: Update filter summary display with better error handling
            function updateFilterSummary(stats, filters) {
                try {
                    let summaryElement = document.querySelector('.filter-summary');

                    // Create summary element if it doesn't exist
                    if (!summaryElement) {
                        summaryElement = document.createElement('div');
                        summaryElement.className = 'filter-summary';

                        // Find the best insertion point
                        const container = galleryContainer.parentNode;
                        if (container) {
                            container.insertBefore(summaryElement, galleryContainer);
                        } else {
                            // Fallback: insert after filter form
                            const filterContainer = filterForm.closest('.gallery-filter');
                            if (filterContainer && filterContainer.parentNode) {
                                filterContainer.parentNode.insertBefore(summaryElement, filterContainer
                                .nextSibling);
                            } else {
                                // Last resort: append to gallery section
                                gallerySection.appendChild(summaryElement);
                            }
                        }
                    }

                    const activeFilters = Object.keys(filters).filter(key => filters[key]);

                    if (activeFilters.length > 0) {
                        const filterTags = activeFilters.map(key => {
                            const value = filters[key];
                            const label = getFilterLabel(key, value);
                            return `
                        <span class="filter-tag" data-filter="${key}">
                            ${label}
                            <button type="button" class="remove-filter" data-filter="${key}" aria-label="Hapus filter ${label}">
                                <i class="fas fa-times"></i>
                            </button>
                        </span>
                    `;
                        }).join('');

                        summaryElement.innerHTML = `
                    <div class="filter-summary-content">
                        <span class="filter-summary-label">Filter aktif:</span>
                        <div class="filter-tags">${filterTags}</div>
                        <button type="button" class="clear-all-filters" onclick="clearAllFilters()">
                            <i class="fas fa-times-circle"></i>
                            Hapus Semua
                        </button>
                    </div>
                `;

                        // Add event listeners for individual filter removal
                        summaryElement.querySelectorAll('.remove-filter').forEach(btn => {
                            btn.addEventListener('click', function() {
                                const filterKey = this.dataset.filter;
                                removeFilter(filterKey);
                            });
                        });

                        summaryElement.style.display = 'block';
                    } else {
                        summaryElement.style.display = 'none';
                    }
                } catch (error) {
                    console.warn('Error updating filter summary:', error);
                    // Continue without filter summary if there's an error
                }
            }

            // Get human-readable filter label
            function getFilterLabel(key, value) {
                const labels = {
                    jenis_kegiatan: {
                        'sosial': 'Sosial',
                        'ekonomi': 'Ekonomi',
                        'pendidikan': 'Pendidikan',
                        'kesehatan': 'Kesehatan',
                        'lingkungan': 'Lingkungan',
                        'infrastruktur': 'Infrastruktur'
                    }
                };

                if (key === 'jenis_kegiatan' && labels.jenis_kegiatan[value]) {
                    return labels.jenis_kegiatan[value];
                } else if (key === 'tanggal_dari') {
                    return `Dari: ${formatDate(value)}`;
                } else if (key === 'tanggal_sampai') {
                    return `Sampai: ${formatDate(value)}`;
                }

                return `${key}: ${value}`;
            }

            // Format date for display
            function formatDate(dateString) {
                try {
                    const date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                } catch (error) {
                    return dateString;
                }
            }

            // Remove individual filter
            function removeFilter(filterKey) {
                const formElement = filterForm.querySelector(`[name="${filterKey}"]`);
                if (formElement) {
                    formElement.value = '';
                }

                const newFilters = {
                    ...currentFilters
                };
                delete newFilters[filterKey];

                loadGallery(newFilters);
            }

            // Clear all filters function (global for onclick handlers)
            window.clearAllFilters = function() {
                if (filterForm) {
                    filterForm.reset();
                }
                loadGallery({});
            };

            // Retry load function (global for onclick handlers)  
            window.retryLoad = function() {
                loadGallery(currentFilters);
            };

            // Initialize gallery items (modal, hover effects, etc.)
            function initializeGalleryItems() {
                const galleryItems = document.querySelectorAll('.gallery-item');

                galleryItems.forEach((item, index) => {
                    // Set initial state for animation
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(20px)';

                    // Re-attach click handlers for modal
                    item.addEventListener('click', function() {
                        openGalleryModal(this);
                    });

                    // Re-attach hover effects
                    item.addEventListener('mouseenter', function() {
                        this.style.zIndex = '10';
                    });

                    item.addEventListener('mouseleave', function() {
                        this.style.zIndex = '1';
                    });

                    // Re-attach keyboard support
                    item.setAttribute('tabindex', '0');
                    item.setAttribute('role', 'button');
                    item.setAttribute('aria-label',
                        `Lihat detail kegiatan ${item.querySelector('.gallery-title')?.textContent || ''}`
                    );

                    item.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        }
                    });
                });

                // Re-initialize pagination click handlers
                const paginationLinks = document.querySelectorAll(
                    '.pagination-btn:not(.disabled), .pagination-number:not(.active)');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        const url = new URL(this.href);
                        const searchParams = new URLSearchParams(url.search);
                        const params = Object.fromEntries(searchParams.entries());

                        loadGallery(params);

                        // Smooth scroll to gallery
                        gallerySection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    });
                });
            }

            // Animate gallery items entrance
            function animateGalleryItems() {
                const galleryItems = document.querySelectorAll('.gallery-item');

                galleryItems.forEach((item, index) => {
                    setTimeout(() => {
                        item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, index * config.animationDelay);
                });
            }

            // Enhanced filter form handler
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const params = Object.fromEntries(formData.entries());

                    // Remove empty values
                    Object.keys(params).forEach(key => {
                        if (!params[key]) {
                            delete params[key];
                        }
                    });

                    // Update filter button state
                    const originalText = filterBtn.innerHTML;
                    filterBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memfilter...';
                    filterBtn.disabled = true;

                    loadGallery(params).finally(() => {
                        filterBtn.innerHTML = originalText;
                        filterBtn.disabled = false;
                    });
                });

                // Enhanced auto-submit with better debouncing
                const filterInputs = filterForm.querySelectorAll('select, input[type="date"]');
                filterInputs.forEach(input => {
                    let timeout;

                    input.addEventListener('input', function() {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            if (this.value !== this.dataset.lastValue) {
                                this.dataset.lastValue = this.value;
                                filterForm.dispatchEvent(new Event('submit'));
                            }
                        }, config.debounceDelay);
                    });

                    input.addEventListener('change', function() {
                        clearTimeout(timeout);
                        if (this.value !== this.dataset.lastValue) {
                            this.dataset.lastValue = this.value;
                            filterForm.dispatchEvent(new Event('submit'));
                        }
                    });

                    // Store initial value
                    input.dataset.lastValue = input.value;
                });
            }

            // Enhanced reset button handler
            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Reset form fields
                    if (filterForm) {
                        filterForm.reset();
                        // Reset stored values
                        filterForm.querySelectorAll('select, input').forEach(input => {
                            input.dataset.lastValue = input.value;
                        });
                    }

                    // Update reset button state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mereset...';
                    this.disabled = true;

                    // Load gallery without any filters
                    loadGallery({}).finally(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    });

                    // Announce reset action
                    announce('Semua filter telah dihapus. Menampilkan semua kegiatan.');
                });
            }

            // Modal functions
            function openGalleryModal(galleryItem) {
                const modal = document.getElementById('galleryModal');
                if (!modal) return;

                const modalImage = document.getElementById('modalImage');
                const modalTitle = document.getElementById('modalTitle');
                const modalCategory = document.getElementById('modalCategory');
                const modalDate = document.getElementById('modalDate');
                const modalDescription = document.getElementById('modalDescription');
                const modalLocation = document.getElementById('modalLocation');
                const modalPic = document.getElementById('modalPic');

                // Get data from the clicked item
                const img = galleryItem.querySelector('img');
                const title = galleryItem.querySelector('.gallery-title')?.textContent?.trim() || '';
                const category = galleryItem.querySelector('.gallery-category')?.textContent?.trim() || '';
                const date = galleryItem.querySelector('.gallery-date')?.textContent?.trim() || '';
                const description = galleryItem.querySelector('.gallery-description')?.textContent?.trim() || '';
                const location = galleryItem.querySelector('.gallery-location')?.textContent?.trim() || '';
                const pic = galleryItem.querySelector('.gallery-pic')?.textContent?.trim() || '';

                // Populate modal with data
                if (modalImage && img) {
                    modalImage.src = img.src;
                    modalImage.alt = title;
                    modalImage.onerror = function() {
                        this.src =
                            'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80';
                    };
                }

                if (modalTitle) modalTitle.textContent = title;
                if (modalCategory) modalCategory.textContent = category;
                if (modalDate) modalDate.textContent = date;
                if (modalDescription) modalDescription.textContent = description;
                if (modalLocation) modalLocation.textContent = location;
                if (modalPic) modalPic.textContent = pic;

                // Show modal
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';

                // Add entrance animation
                const modalContent = modal.querySelector('.modal-content');
                if (modalContent) {
                    modalContent.style.animation = 'modalSlideIn 0.4s ease';
                }

                // Focus management for accessibility
                const closeBtn = modal.querySelector('.modal-close');
                if (closeBtn) {
                    closeBtn.focus();
                }

                // Announce modal opening
                announce(`Modal dibuka untuk kegiatan: ${title}`);
            }

            // Modal close functionality
            const modal = document.getElementById('galleryModal');
            const closeModal = document.querySelector('.modal-close');

            if (closeModal) {
                closeModal.addEventListener('click', closeModalHandler);
            }

            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeModalHandler();
                    }
                });
            }

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal && modal.style.display === 'block') {
                    closeModalHandler();
                }
            });

            function closeModalHandler() {
                if (!modal) return;

                const modalContent = modal.querySelector('.modal-content');
                if (modalContent) {
                    modalContent.style.animation = 'modalSlideOut 0.3s ease';
                }

                setTimeout(() => {
                    modal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 300);

                announce('Modal ditutup');
            }

            // Accessibility announcer
            function announce(message) {
                const announcer = document.querySelector('.sr-only[aria-live]') || createAnnouncer();
                announcer.textContent = message;
                setTimeout(() => {
                    announcer.textContent = '';
                }, 1000);
            }

            function createAnnouncer() {
                const announcer = document.createElement('div');
                announcer.setAttribute('aria-live', 'polite');
                announcer.setAttribute('aria-atomic', 'true');
                announcer.className = 'sr-only';
                announcer.style.cssText =
                    'position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0;';
                document.body.appendChild(announcer);
                return announcer;
            }

            // Handle browser back/forward buttons
            window.addEventListener('popstate', function(e) {
                if (e.state && e.state.filters) {
                    // Restore form values
                    const filters = e.state.filters;
                    Object.keys(filters).forEach(key => {
                        const input = filterForm.querySelector(`[name="${key}"]`);
                        if (input) {
                            input.value = filters[key];
                            input.dataset.lastValue = filters[key];
                        }
                    });

                    // Reload gallery with restored filters
                    loadGallery(filters, false);
                } else {
                    // No state, reset to default
                    if (filterForm) {
                        filterForm.reset();
                    }
                    loadGallery({}, false);
                }
            });

            // Initialize on page load
            initializeGalleryItems();

            // Store initial state
            const initialParams = new URLSearchParams(window.location.search);
            currentFilters = Object.fromEntries(initialParams.entries());

            console.log('Enhanced Gallery AJAX functionality initialized with config:', config);
        });
    </script>
@endsection

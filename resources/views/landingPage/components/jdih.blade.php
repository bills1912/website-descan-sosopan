@extends('landingPage.main')

@section('title', 'JDIH - Portal Desa')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Jaringan Dokumentasi dan Informasi Hukum</h1>
            <p>Pusat informasi produk hukum desa yang transparan dan mudah diakses</p>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>JDIH</span>
            </nav>
        </div>
    </section>

    <!-- JDIH Introduction -->
    <section class="jdih-intro">
        <div class="container">
            <h2 class="section-title">Tentang JDIH Desa</h2>
            <div class="intro-grid">
                <div class="intro-content">
                    <h3>Sistem Informasi Hukum Terpadu</h3>
                    <p>JDIH Desa menyediakan akses mudah dan transparan terhadap seluruh produk hukum yang berlaku di
                        tingkat desa. Mulai dari peraturan perundang-undangan hingga keputusan kepala desa, semua tersedia
                        dalam satu platform digital.</p>
                    <p>Sistem ini dirancang untuk meningkatkan transparansi, akuntabilitas, dan kemudahan akses masyarakat
                        terhadap informasi hukum yang berkaitan dengan tata kelola desa.</p>

                    <div class="intro-stats">
                        <div class="stat-badge">
                            <div class="stat-number">32</div>
                            <div class="stat-label">Total Dokumen</div>
                        </div>
                        <div class="stat-badge">
                            <div class="stat-number">6</div>
                            <div class="stat-label">Kategori Hukum</div>
                        </div>
                        <div class="stat-badge">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label">Akses Online</div>
                        </div>
                    </div>
                </div>
                <div class="intro-image">
                    <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="JDIH">
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-container">
                <div class="filter-group">
                    <label for="category-filter">Kategori:</label>
                    <select id="category-filter" class="filter-select">
                        <option value="">Semua Kategori</option>
                        <option value="uu">Undang-Undang</option>
                        <option value="permen">Peraturan Menteri</option>
                        <option value="pergub">Peraturan Gubernur</option>
                        <option value="perbup">Peraturan Bupati</option>
                        <option value="perdes">Peraturan Desa</option>
                        <option value="kades">Keputusan Kepala Desa</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="year-filter">Tahun:</label>
                    <select id="year-filter" class="filter-select">
                        <option value="">Semua Tahun</option>
                        <option value="2024">2024</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                        <option value="2018">2018</option>
                        <option value="2016">2016</option>
                        <option value="2015">2015</option>
                        <option value="2014">2014</option>
                    </select>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-input" placeholder="Cari dokumen hukum...">
                </div>
            </div>
        </div>
    </section>

    <!-- Documents Section -->
    <section class="documents-section">
        <div class="container">
            <h2 class="section-title">Kategori Dokumen Hukum</h2>
            <div class="document-categories">
                <!-- Undang-Undang -->
                <div class="category-card" data-category="undang-undang">
                    <div class="category-header">
                        <div class="document-count">Loading...</div>
                        <div class="category-icon">
                            <i class="fas fa-gavel"></i>
                        </div>
                        <div class="category-title">Undang-Undang</div>
                        <div class="category-subtitle">Peraturan tingkat nasional</div>
                    </div>
                    <ul class="document-list" id="uu-documents">
                        <!-- Akan di-render oleh JavaScript -->
                    </ul>
                </div>

                <!-- Peraturan Menteri -->
                <div class="category-card" data-category="peraturan-menteri">
                    <div class="category-header">
                        <div class="document-count">Loading...</div>
                        <div class="category-icon">
                            <i class="fas fa-scroll"></i>
                        </div>
                        <div class="category-title">Peraturan Menteri</div>
                        <div class="category-subtitle">Peraturan tingkat kementerian</div>
                    </div>
                    <ul class="document-list" id="permen-documents">
                        <!-- Akan di-render oleh JavaScript -->
                    </ul>
                </div>

                <!-- Peraturan Gubernur -->
                <div class="category-card" data-category="peraturan-gubernur">
                    <div class="category-header">
                        <div class="document-count">Loading...</div>
                        <div class="category-icon">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div class="category-title">Peraturan Gubernur</div>
                        <div class="category-subtitle">Peraturan tingkat provinsi</div>
                    </div>
                    <ul class="document-list" id="pergub-documents">
                        <!-- Akan di-render oleh JavaScript -->
                    </ul>
                </div>

                <!-- Peraturan DPRD -->
                <div class="category-card" data-category="peraturan-daerah">
                    <div class="category-header">
                        <div class="document-count">Loading...</div>
                        <div class="category-icon">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div class="category-title">Peraturan Daerah (DPRD)</div>
                        <div class="category-subtitle">Peraturan daerah setingkat kabupaten</div>
                    </div>
                    <ul class="document-list" id="perda-documents">
                        <!-- Akan di-render oleh JavaScript -->
                    </ul>
                </div>

                <!-- Peraturan Bupati -->
                <div class="category-card" data-category="peraturan-bupati">
                    <div class="category-header">
                        <div class="document-count">Loading...</div>
                        <div class="category-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="category-title">Peraturan Bupati</div>
                        <div class="category-subtitle">Peraturan tingkat kabupaten</div>
                    </div>
                    <ul class="document-list" id="perbup-documents">
                        <!-- Akan di-render oleh JavaScript -->
                    </ul>
                </div>

                <!-- Peraturan Desa -->
                <div class="category-card" data-category="peraturan-desa">
                    <div class="category-header">
                        <div class="document-count">Loading...</div>
                        <div class="category-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="category-title">Peraturan Desa</div>
                        <div class="category-subtitle">Peraturan tingkat desa</div>
                    </div>
                    <ul class="document-list" id="perdes-documents">
                        <!-- Akan di-render oleh JavaScript -->
                    </ul>
                </div>

                <!-- Keputusan Kepala Desa -->
                <div class="category-card" data-category="keputusan-kepala-desa">
                    <div class="category-header">
                        <div class="document-count">Loading...</div>
                        <div class="category-icon">
                            <i class="fas fa-stamp"></i>
                        </div>
                        <div class="category-title">Keputusan Kepala Desa</div>
                        <div class="category-subtitle">Keputusan dan penetapan</div>
                    </div>
                    <ul class="document-list" id="kades-documents">
                        <!-- Akan di-render oleh JavaScript -->
                    </ul>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <!-- Akan di-render oleh JavaScript -->
            </div>
        </div>
    </section>

    <script>
        const documentsDatabase = @json($documentsDatabase ?? []);
        // console.log(documentsDatabase);

        // Konfigurasi sistem
        const CONFIG = {
            ITEMS_PER_PAGE: 3,
            ANIMATION_DELAY: 150,
            SEARCH_DELAY: 300,
            DOCUMENT_PATH: '/document/', // Path ke folder dokumen
            BASE_URL: '{{ url('/') }}', // Base URL dari Laravel
            CSRF_TOKEN: '{{ csrf_token() }}' // CSRF token untuk request
        };

        // State management
        let state = {
            currentPage: 1,
            filteredCategories: [],
            allCategories: [],
            isLoading: false,
            activeFilters: {
                category: '',
                year: '',
                search: ''
            }
        };

        // Initialize system
        function initializeJDIHSystem() {
            console.log('🚀 Initializing JDIH System...');

            state.allCategories = Array.from(document.querySelectorAll('.category-card'));
            populateCategories();
            setupEventListeners();
            setupAnimationSystem();
            updateDisplay();

            console.log('✅ JDIH System Initialized Successfully');
            logSystemStats();

            // Test filters untuk debugging
            testFilters();
        }

        // Test filters function
        function testFilters() {
            console.log('=== TESTING FILTERS ===');
            console.log('Available documents database:', documentsDatabase);

            // Test setiap kategori
            Object.keys(documentsDatabase).forEach(category => {
                console.log(`\n${category.toUpperCase()}:`);
                documentsDatabase[category].forEach(doc => {
                    console.log(`- ${doc.title} (${doc.year})`);
                });
            });

            console.log('\nAvailable years:', [...new Set(
                Object.values(documentsDatabase)
                .flat()
                .map(doc => doc.year)
            )].sort());
        }

        // Populate categories with document data
        function populateCategories() {
            state.allCategories.forEach(categoryElement => {
                const categoryType = categoryElement.getAttribute('data-category');
                const documents = documentsDatabase[categoryType] || [];
                renderCategoryDocuments(categoryElement, documents);
            });

            state.filteredCategories = [...state.allCategories];
        }

        // Render documents in a category
        function renderCategoryDocuments(categoryElement, documents) {
            const documentList = categoryElement.querySelector('.document-list');
            const documentCount = categoryElement.querySelector('.document-count');

            updateDocumentCount(documentCount, documents.length);
            documentList.innerHTML = '';

            documents.forEach((doc, index) => {
                const documentElement = createDocumentElement(doc, index);
                documentList.appendChild(documentElement);
            });
        }

        // Create individual document element dengan struktur yang benar
        function createDocumentElement(doc, index) {
            const li = document.createElement('li');
            li.className = 'document-item';
            li.style.animationDelay = `${index * 100}ms`;

            li.innerHTML = `
        <div class="document-content">
            <div class="document-icon">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="document-info">
                <div class="document-title">${doc.title}</div>
                <div class="document-description">${doc.description || ''}</div>
                <div class="document-meta">
                    <span class="meta-item">
                        <i class="fas fa-calendar-alt"></i> ${doc.year}
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-file-alt"></i> ${doc.type}
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-download"></i> ${doc.size}
                    </span>
                </div>
            </div>
        </div>
        <div class="document-actions">
            <button class="action-btn btn-view" onclick="viewDocument('${doc.id}')" title="Lihat dokumen">
                <i class="fas fa-eye"></i>
                <span>Lihat</span>
            </button>
            <button class="action-btn btn-download" onclick="downloadDocument('${doc.id}')" title="Unduh dokumen">
                <i class="fas fa-download"></i>
                <span>Unduh</span>
            </button>
        </div>
    `;

            return li;
        }

        // Setup event listeners - DIPERBAIKI
        function setupEventListeners() {
            const categoryFilter = document.getElementById('category-filter');
            const yearFilter = document.getElementById('year-filter');
            const searchInput = document.getElementById('search-input');

            if (categoryFilter) {
                categoryFilter.addEventListener('change', handleCategoryFilter);
                console.log('✅ Category filter event listener added');
            }

            // ✅ PERBAIKAN: Tambahkan event listener untuk year filter
            if (yearFilter) {
                yearFilter.addEventListener('change', handleYearFilter);
                console.log('✅ Year filter event listener added');
            }

            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', (e) => {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        handleSearchFilter(e.target.value);
                    }, CONFIG.SEARCH_DELAY);
                });
                console.log('✅ Search filter event listener added');
            }

            document.addEventListener('keydown', handleKeyboardNavigation);
        }

        // Filter handlers
        function handleCategoryFilter(e) {
            state.activeFilters.category = e.target.value;
            console.log('Category filter changed:', e.target.value);
            applyFilters();
        }

        function handleYearFilter(e) {
            state.activeFilters.year = e.target.value;
            console.log('Year filter changed:', e.target.value);
            applyFilters();
        }

        function handleSearchFilter(value) {
            state.activeFilters.search = value.toLowerCase();
            console.log('Search filter changed:', value);
            applyFilters();
        }

        // Apply all active filters - DIPERBAIKI
        function applyFilters() {
            state.isLoading = true;
            showLoadingState();

            console.log('Applying filters:', state.activeFilters);

            setTimeout(() => {
                state.filteredCategories = state.allCategories.filter(categoryElement => {
                    const categoryType = categoryElement.getAttribute('data-category');
                    const documents = documentsDatabase[categoryType] || [];

                    // Filter kategori
                    if (state.activeFilters.category && categoryType !== state.activeFilters.category) {
                        console.log(`Filtering out category: ${categoryType}`);
                        return false;
                    }

                    // Filter dokumen dalam kategori
                    const filteredDocs = documents.filter(doc => {
                        // Filter tahun - PERBAIKAN: Pastikan perbandingan yang tepat
                        if (state.activeFilters.year && doc.year !== state.activeFilters.year) {
                            console.log(
                                `Document ${doc.title} filtered out by year: ${doc.year} vs ${state.activeFilters.year}`
                            );
                            return false;
                        }

                        // Filter pencarian
                        if (state.activeFilters.search) {
                            const searchText = state.activeFilters.search;
                            const titleMatch = doc.title.toLowerCase().includes(searchText);
                            const descMatch = doc.description && doc.description.toLowerCase()
                                .includes(searchText);

                            if (!titleMatch && !descMatch) {
                                console.log(`Document ${doc.title} filtered out by search`);
                                return false;
                            }
                        }

                        return true;
                    });

                    console.log(
                        `Category ${categoryType}: ${filteredDocs.length}/${documents.length} documents after filter`
                    );

                    if (filteredDocs.length > 0) {
                        renderCategoryDocuments(categoryElement, filteredDocs);
                        return true;
                    } else {
                        showEmptyState(categoryElement);
                        return state.activeFilters.category === categoryType;
                    }
                });

                console.log(`Total filtered categories: ${state.filteredCategories.length}`);

                state.currentPage = 1;
                state.isLoading = false;

                updateDisplay();
                hideLoadingState();
            }, 300);
        }

        // Clear all filters
        function clearAllFilters() {
            document.getElementById('category-filter').value = '';
            document.getElementById('year-filter').value = '';
            document.getElementById('search-input').value = '';

            state.activeFilters = {
                category: '',
                year: '',
                search: ''
            };

            applyFilters();
            console.log('All filters cleared');
        }

        // Get document by ID
        function getDocumentById(documentId) {
            for (const category in documentsDatabase) {
                const doc = documentsDatabase[category].find(d => d.id === documentId);
                if (doc) return doc;
            }
            return null;
        }

        // Check if file exists using Laravel route
        async function checkFileExists(filename) {
            try {
                const response = await fetch(`${CONFIG.BASE_URL}/storage/${encodeURIComponent(filename)}`, {
                    method: 'HEAD',
                    headers: {
                        'X-CSRF-TOKEN': CONFIG.CSRF_TOKEN
                    }
                });
                return response.ok;
            } catch (error) {
                console.warn('Error checking file:', error);
                return false;
            }
        }

        // View document function using Laravel route
        async function viewDocument(documentId) {
            const button = event.target.closest('.action-btn');
            const doc = getDocumentById(documentId);

            if (!doc) {
                showNotification('Dokumen tidak ditemukan', 'error');
                return;
            }

            setButtonLoading(button, 'Tunggu...');

            try {
                const fileExists = await checkFileExists(doc.filename);

                if (!fileExists) {
                    resetButton(button);
                    showNotification(`File ${doc.filename} tidak ditemukan di server`, 'error');
                    return;
                }

                // Update ke status membuka
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Buka</span>';

                setTimeout(() => {
                    resetButton(button);
                    const viewUrl = `${CONFIG.BASE_URL}/storage/${doc.filename}`;
                    window.open(viewUrl, '_blank');
                    showNotification(`Dokumen ${doc.title} dibuka di tab baru`, 'success');
                }, 800);

            } catch (error) {
                resetButton(button);
                showNotification('Gagal membuka dokumen', 'error');
                console.error('View document error:', error);
            }
        }

        // Download document function using Laravel route
        async function downloadDocument(documentId) {
            const button = event.target.closest('.action-btn');
            const doc = getDocumentById(documentId);

            if (!doc) {
                showNotification('Dokumen tidak ditemukan', 'error');
                return;
            }

            setButtonLoading(button, 'Cek...');

            try {
                const fileExists = await checkFileExists(doc.filename);

                if (!fileExists) {
                    resetButton(button);
                    showNotification(`File ${doc.filename} tidak ditemukan di server`, 'error');
                    return;
                }

                // Update ke status download
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Unduh</span>';

                setTimeout(() => {
                    const downloadUrl = `${CONFIG.BASE_URL}/storage/${doc.filename}`;
                    const link = document.createElement('a');
                    link.href = downloadUrl;
                    link.download = doc.filename.split("/")[1];
                    link.style.display = 'none';

                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    setButtonSuccess(button, 'Selesai');
                    showNotification(`${doc.title} berhasil diunduh`, 'success');

                    setTimeout(() => {
                        resetButton(button);
                    }, 2000);

                }, 1000);

            } catch (error) {
                resetButton(button);
                showNotification('Gagal mengunduh dokumen', 'error');
                console.error('Download document error:', error);
            }
        }

        // Button state management
        // Perbaikan fungsi untuk mencegah tombol memanjang ke bawah
        function setButtonLoading(button, text) {
            // Simpan konten asli
            if (!button.dataset.originalContent) {
                button.dataset.originalContent = button.innerHTML;
            }

            button.disabled = true;
            // PERBAIKAN: Pastikan konten tetap dalam satu baris
            button.innerHTML = `<i class="fas fa-spinner fa-spin"></i><span>${text}</span>`;
            button.classList.add('loading');
        }

        function setButtonSuccess(button, text) {
            // PERBAIKAN: Pastikan konten tetap dalam satu baris
            button.innerHTML = `<i class="fas fa-check"></i><span>${text}</span>`;
            button.classList.remove('loading');
            button.classList.add('success');
        }

        function resetButton(button, originalContent = null) {
            button.disabled = false;

            // Gunakan konten asli yang disimpan
            const content = originalContent || button.dataset.originalContent;
            if (content) {
                button.innerHTML = content;
            } else {
                // Fallback ke konten default
                if (button.classList.contains('btn-view')) {
                    button.innerHTML = '<i class="fas fa-eye"></i><span>Lihat</span>';
                } else if (button.classList.contains('btn-download')) {
                    button.innerHTML = '<i class="fas fa-download"></i><span>Unduh</span>';
                }
            }

            button.classList.remove('loading', 'success');
        }

        // Show notification
        function showNotification(message, type = 'info', duration = 4000) {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type}`;

            const icons = {
                success: 'fas fa-check-circle',
                error: 'fas fa-exclamation-circle',
                info: 'fas fa-info-circle',
                warning: 'fas fa-exclamation-triangle'
            };

            notification.innerHTML = `
        <div class="notification-content">
            <i class="${icons[type]}"></i>
            <span class="notification-message">${message}</span>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    `;

            if (!document.getElementById('notification-styles')) {
                const style = document.createElement('style');
                style.id = 'notification-styles';
                style.textContent = `
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background: white;
                border-radius: 10px;
                padding: 1rem 1.5rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                max-width: 400px;
                border-left: 4px solid #3498db;
            }
            
            .notification.notification-success {
                border-left-color: #27ae60;
            }
            
            .notification.notification-error {
                border-left-color: #e74c3c;
            }
            
            .notification.notification-warning {
                border-left-color: #f39c12;
            }
            
            .notification.show {
                transform: translateX(0);
            }
            
            .notification-content {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
            
            .notification-content i {
                font-size: 1.2rem;
            }
            
            .notification-success .notification-content i {
                color: #27ae60;
            }
            
            .notification-error .notification-content i {
                color: #e74c3c;
            }
            
            .notification-warning .notification-content i {
                color: #f39c12;
            }
            
            .notification-info .notification-content i {
                color: #3498db;
            }
            
            .notification-message {
                flex: 1;
                font-size: 0.9rem;
                line-height: 1.4;
            }
            
            .notification-close {
                background: none;
                border: none;
                font-size: 1rem;
                cursor: pointer;
                color: #999;
                padding: 0;
                margin-left: 1rem;
                transition: color 0.3s ease;
            }
            
            .notification-close:hover {
                color: #666;
            }
        `;
                document.head.appendChild(style);
            }

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.classList.add('show');
            }, 10);

            setTimeout(() => {
                if (notification.parentNode) {
                    notification.classList.remove('show');
                    setTimeout(() => notification.remove(), 300);
                }
            }, duration);
        }

        // Show empty state in category
        function showEmptyState(categoryElement) {
            const documentList = categoryElement.querySelector('.document-list');
            const documentCount = categoryElement.querySelector('.document-count');

            documentCount.textContent = '0 Dokumen';

            documentList.innerHTML = `
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="empty-text">
                <h4>Tidak ada dokumen</h4>
                <p>Tidak ditemukan dokumen yang sesuai dengan filter yang diterapkan</p>
            </div>
        </div>
    `;
        }

        // Update document count with animation
        function updateDocumentCount(element, count) {
            const currentCount = parseInt(element.textContent) || 0;

            if (currentCount !== count) {
                element.classList.add('updating');

                animateNumber(element, currentCount, count, 500, (value) => {
                    element.textContent = `${value} Dokumen`;
                });

                setTimeout(() => {
                    element.classList.remove('updating');
                }, 600);
            }
        }

        // Animate number changes
        function animateNumber(element, start, end, duration, callback) {
            const startTime = performance.now();
            const difference = end - start;

            function updateNumber(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const current = Math.round(start + (difference * easeOutCubic(progress)));

                callback(current);

                if (progress < 1) {
                    requestAnimationFrame(updateNumber);
                }
            }

            requestAnimationFrame(updateNumber);
        }

        // Easing function
        function easeOutCubic(t) {
            return 1 - Math.pow(1 - t, 3);
        }

        // Update main display
        function updateDisplay() {
            updatePagination();
            displayCurrentPage();
            updatePageInfo();
        }

        // Calculate total pages
        function getTotalPages() {
            return Math.ceil(state.filteredCategories.length / CONFIG.ITEMS_PER_PAGE);
        }

        // Display current page items
        function displayCurrentPage() {
            const startIndex = (state.currentPage - 1) * CONFIG.ITEMS_PER_PAGE;
            const endIndex = startIndex + CONFIG.ITEMS_PER_PAGE;

            state.allCategories.forEach(category => {
                category.style.display = 'none';
                category.classList.remove('visible');
            });

            const currentPageCategories = state.filteredCategories.slice(startIndex, endIndex);

            currentPageCategories.forEach((category, index) => {
                category.style.display = 'block';

                setTimeout(() => {
                    category.classList.add('visible');
                }, index * CONFIG.ANIMATION_DELAY);
            });
        }

        // Update pagination controls
        function updatePagination() {
            const totalPages = getTotalPages();
            const paginationContainer = document.querySelector('.pagination');

            if (!paginationContainer) return;

            if (totalPages <= 1) {
                paginationContainer.style.display = 'none';
                return;
            }

            paginationContainer.style.display = 'flex';
            paginationContainer.innerHTML = '';

            const prevBtn = createPaginationButton(
                '<i class="fas fa-chevron-left"></i> Previous',
                () => goToPage(state.currentPage - 1),
                state.currentPage === 1
            );
            prevBtn.classList.add('prev-btn');
            paginationContainer.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = createPaginationButton(
                    i.toString(),
                    () => goToPage(i),
                    false,
                    i === state.currentPage
                );
                paginationContainer.appendChild(pageBtn);
            }

            const nextBtn = createPaginationButton(
                'Next <i class="fas fa-chevron-right"></i>',
                () => goToPage(state.currentPage + 1),
                state.currentPage === totalPages
            );
            nextBtn.classList.add('next-btn');
            paginationContainer.appendChild(nextBtn);

            setTimeout(() => {
                paginationContainer.classList.add('visible');
            }, 100);
        }

        // Create pagination button
        function createPaginationButton(content, onClick, disabled = false, active = false) {
            const button = document.createElement('button');
            button.innerHTML = content;
            button.onclick = onClick;
            button.disabled = disabled;

            if (active) button.classList.add('active');
            if (disabled) button.classList.add('disabled');

            return button;
        }

        // Navigate to specific page
        function goToPage(page) {
            const totalPages = getTotalPages();

            if (page < 1 || page > totalPages || page === state.currentPage) {
                return;
            }

            state.currentPage = page;

            const documentsSection = document.querySelector('.documents-section');
            if (documentsSection) {
                documentsSection.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

            setTimeout(() => {
                updateDisplay();
            }, 300);
        }

        // Update page information
        function updatePageInfo() {
            let pageInfo = document.querySelector('.page-info');

            if (!pageInfo) {
                pageInfo = document.createElement('div');
                pageInfo.className = 'page-info';

                const pagination = document.querySelector('.pagination');
                if (pagination && pagination.parentNode) {
                    pagination.parentNode.appendChild(pageInfo);
                }
            }

            const totalPages = getTotalPages();
            const totalItems = state.filteredCategories.length;

            if (totalPages > 1) {
                const startItem = (state.currentPage - 1) * CONFIG.ITEMS_PER_PAGE + 1;
                const endItem = Math.min(state.currentPage * CONFIG.ITEMS_PER_PAGE, totalItems);

                pageInfo.innerHTML = `
            <div class="page-stats">
                <span class="current-range">Menampilkan ${startItem}-${endItem}</span>
                <span class="total-items">dari ${totalItems} kategori</span>
                <span class="page-indicator">Halaman ${state.currentPage} dari ${totalPages}</span>
            </div>
        `;
                pageInfo.style.display = 'block';
            } else {
                pageInfo.style.display = 'none';
            }
        }

        // Loading states
        function showLoadingState() {
            state.allCategories.forEach(category => {
                category.classList.add('loading');
            });
        }

        function hideLoadingState() {
            state.allCategories.forEach(category => {
                category.classList.remove('loading');
            });
        }

        // Keyboard navigation
        function handleKeyboardNavigation(e) {
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const searchInput = document.getElementById('search-input');
                if (searchInput) {
                    searchInput.focus();
                }
            }

            if (e.key === 'ArrowLeft' && state.currentPage > 1) {
                goToPage(state.currentPage - 1);
            } else if (e.key === 'ArrowRight' && state.currentPage < getTotalPages()) {
                goToPage(state.currentPage + 1);
            }
        }

        // Animation system
        function setupAnimationSystem() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            state.allCategories.forEach(category => {
                observer.observe(category);
            });

            if (!document.getElementById('jdih-animations')) {
                const style = document.createElement('style');
                style.id = 'jdih-animations';
                style.textContent = getAnimationCSS();
                document.head.appendChild(style);
            }
        }

        // Animation CSS
        function getAnimationCSS() {
            return `
        .category-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        .category-card.visible,
        .category-card.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
        
        .document-item {
            opacity: 0;
            transform: translateX(-20px);
            transition: all 0.4s ease;
        }
        
        .category-card.visible .document-item {
            opacity: 1;
            transform: translateX(0);
        }
        
        .pagination {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }
        
        .pagination.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .action-btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .action-btn.loading {
            opacity: 0.7;
            pointer-events: none;
        }
        
        .action-btn.success {
            background: #27ae60;
            color: white;
        }
        
        .category-card.loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .category-card.loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent
            );
            animation: shimmer 1.5s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .page-info {
            text-align: center;
            margin-top: 1rem;
            color: #666;
            font-size: 0.9rem;
        }
        
        .page-stats {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .page-stats span {
            padding: 0.25rem 0.5rem;
            background: #f8f9fa;
            border-radius: 4px;
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .page-stats {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .page-stats span {
                text-align: center;
            }
        }
    `;
        }

        // Log system stats
        function logSystemStats() {
            console.log(`📄 Total Categories: ${state.allCategories.length}`);
            console.log(`📊 Categories per page: ${CONFIG.ITEMS_PER_PAGE}`);
            console.log(`📖 Total pages: ${getTotalPages()}`);

            Object.keys(documentsDatabase).forEach(category => {
                console.log(`📁 ${category.toUpperCase()}: ${documentsDatabase[category].length} dokumen`);
            });
        }

        // Navigation functions for pagination
        function nextPage() {
            const totalPages = getTotalPages();
            if (state.currentPage < totalPages) {
                goToPage(state.currentPage + 1);
            }
        }

        function previousPage() {
            if (state.currentPage > 1) {
                goToPage(state.currentPage - 1);
            }
        }

        // Initialize on DOM content loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Setup intersection observer dan animasi dulu
            setupAnimationSystem();

            // Kemudian inisialisasi data
            setTimeout(() => {
                initializeJDIHSystem();

                console.log('✨ JDIH System Initialized with Real File Support!');
                console.log(`📂 Document path: ${CONFIG.DOCUMENT_PATH}`);
                console.log(`🌐 Base URL: ${CONFIG.BASE_URL}`);

                // Test filter tahun
                console.log('🔍 Testing year filter functionality...');
                const yearFilter = document.getElementById('year-filter');
                if (yearFilter) {
                    console.log('Year filter element found:', yearFilter);
                    console.log('Available options:', Array.from(yearFilter.options).map(opt => opt.value));
                }
            }, 300);

            // Smooth scrolling untuk internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#' || href === '') {
                        e.preventDefault();
                        return;
                    }

                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });

        // Export untuk akses global
        window.viewDocument = viewDocument;
        window.downloadDocument = downloadDocument;
        window.nextPage = nextPage;
        window.previousPage = previousPage;
        window.clearAllFilters = clearAllFilters;
        window.testFilters = testFilters;
    </script>

@endsection

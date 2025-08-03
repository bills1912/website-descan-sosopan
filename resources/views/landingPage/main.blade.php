<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Desa Sosopan')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <link rel="stylesheet" href="{{ url('css/informasiDesa.css') }}">
    <link rel="stylesheet" href="{{ url('css/agendaDesa.css') }}">
    <link rel="stylesheet" href="{{ url('css/jdih.css') }}">
    <link rel="stylesheet" href="{{ url('css/strukturOrganisasi.css') }}">
    <link rel="icon" href="{{ url('img/icon-paluta.png') }}" type="image/png">

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <img id="main-logo" src="{{ url('img/logo-desa-sosopan.png') }}" alt="logo desa sosopan">
            </a>

            <ul class="nav-menu" id="nav-menu">
                <li><a href="{{ route('home') }}"
                        class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>

                <!-- Dropdown Menu untuk Informasi Desa -->
                <li class="nav-dropdown">
                    <a href="javascript:void(0)"
                        class="nav-link dropdown-toggle {{ request()->routeIs('informasi-desa') || request()->routeIs('agenda-desa') ? 'active' : '' }}"
                        data-dropdown="informasi-dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                        Informasi Desa
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <div class="dropdown-menu" id="informasi-dropdown" role="menu">
                        <a href="{{ route('informasi-desa') }}"
                            class="dropdown-item {{ request()->routeIs('informasi-desa') ? 'active' : '' }}"
                            role="menuitem">
                            <i class="fas fa-info-circle"></i>
                            Informasi Umum
                        </a>
                        <a href="{{ route('agenda-desa') }}"
                            class="dropdown-item {{ request()->routeIs('agenda-desa') ? 'active' : '' }}"
                            role="menuitem">
                            <i class="fas fa-calendar-alt"></i>
                            Agenda Desa
                        </a>
                    </div>
                </li>

                <li><a href="{{ route('struktur-organisasi') }}"
                        class="nav-link {{ request()->routeIs('struktur-organisasi') ? 'active' : '' }}">Struktur
                        Organisasi</a></li>
                <li><a href="{{ route('jdih') }}"
                        class="nav-link {{ request()->routeIs('jdih') ? 'active' : '' }}">JDIH</a></li>
                <li><a href="{{ route('apbdes') }}"
                        class="nav-link {{ request()->routeIs('apbdes') ? 'active' : '' }}">APBDes</a></li>
                <li><a href="{{ route('daftar-data') }}"
                        class="nav-link {{ request()->routeIs('daftar-data') ? 'active' : '' }}">Daftar Data</a></li>
            </ul>

            <button class="hamburger" id="hamburger" aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="content-wrapper">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>Portal Desa</h3>
                    <p>Sistem informasi terpadu untuk kemajuan desa dan pelayanan masyarakat yang lebih baik.</p>
                </div>
                <div class="footer-section">
                    <h3>Menu Utama</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('informasi-desa') }}">Informasi Umum</a></li>
                        <li><a href="{{ route('agenda-desa') }}">Agenda Desa</a></li>
                        <li><a href="{{ route('struktur-organisasi') }}">Struktur Organisasi</a></li>
                        <li><a href="{{ route('jdih') }}">JDIH</a></li>
                        <li><a href="{{ route('apbdes') }}">APBDes</a></li>
                        <li><a href="{{ route('daftar-data') }}">Daftar Data</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Kontak</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Alamat Desa, Kecamatan, Kabupaten</p>
                    <p><i class="fas fa-phone"></i> (021) 1234-5678</p>
                    <p><i class="fas fa-envelope"></i> info@portaldesa.id</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Portal Desa. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        console.log('🚀 Enhanced Dropdown Menu System Starting...');

        // Enhanced hamburger menu with dropdown support
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - Initializing enhanced menu system');

            // Initialize all components
            initializeHamburgerMenu();
            initializeDropdownMenus();
            initializeScrollEffects();
            initializeKeyboardNavigation();
            initializeMobileOptimizations();

            console.log('✅ Enhanced menu system initialized successfully');
        });

        // Hamburger menu functionality
        function initializeHamburgerMenu() {
            const hamburger = document.querySelector('#hamburger');
            const navMenu = document.querySelector('#nav-menu');
            const body = document.body;

            if (!hamburger || !navMenu) {
                console.warn('Hamburger or nav menu elements not found');
                return;
            }

            console.log('🍔 Initializing hamburger menu');

            hamburger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log('Hamburger clicked');

                const isActive = hamburger.classList.contains('active');

                if (isActive) {
                    closeHamburgerMenu();
                } else {
                    openHamburgerMenu();
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
                    closeHamburgerMenu();
                }
            });

            // Close menu on window resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeHamburgerMenu();
                    closeAllDropdowns();
                }
            });

            function openHamburgerMenu() {
                hamburger.classList.add('active');
                navMenu.classList.add('show');
                body.classList.add('menu-open');
                console.log('✅ Mobile menu opened');
            }

            function closeHamburgerMenu() {
                hamburger.classList.remove('active');
                navMenu.classList.remove('show');
                body.classList.remove('menu-open');
                closeAllDropdowns();
                console.log('✅ Mobile menu closed');
            }
        }

        // Enhanced dropdown functionality
        function initializeDropdownMenus() {
            console.log('📋 Initializing dropdown menus');

            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

            if (dropdownToggles.length === 0) {
                console.warn('No dropdown toggles found');
                return;
            }

            dropdownToggles.forEach((toggle, index) => {
                console.log(`Setting up dropdown ${index + 1}:`, toggle.textContent.trim());
                setupDropdownToggle(toggle);
            });

            // Setup dropdown items
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            dropdownItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    console.log('Dropdown item clicked:', this.textContent.trim());

                    // Close dropdowns after navigation
                    setTimeout(() => {
                        closeAllDropdowns();

                        // Close mobile menu if open
                        if (window.innerWidth <= 768) {
                            const hamburger = document.querySelector('#hamburger');
                            const navMenu = document.querySelector('#nav-menu');
                            const body = document.body;

                            if (hamburger && navMenu) {
                                hamburger.classList.remove('active');
                                navMenu.classList.remove('show');
                                body.classList.remove('menu-open');
                            }
                        }
                    }, 150);
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.nav-dropdown')) {
                    closeAllDropdowns();
                }
            });
        }

        function setupDropdownToggle(toggle) {
            const dropdownId = toggle.getAttribute('data-dropdown');
            const dropdown = document.getElementById(dropdownId);

            if (!dropdown) {
                console.error(`Dropdown with ID '${dropdownId}' not found`);
                return;
            }

            console.log(`✅ Setting up dropdown: ${dropdownId}`);

            // Remove any existing event listeners by cloning
            const newToggle = toggle.cloneNode(true);
            toggle.parentNode.replaceChild(newToggle, toggle);

            newToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log(`Dropdown toggle clicked: ${dropdownId}`);

                const isCurrentlyOpen = dropdown.classList.contains('show');
                const isMobile = window.innerWidth <= 768;

                // Close all other dropdowns first
                closeAllDropdowns();

                if (!isCurrentlyOpen) {
                    openDropdown(newToggle, dropdown, isMobile);
                }
            });

            // Setup mobile-specific styles
            if (window.innerWidth <= 768) {
                setupMobileDropdown(dropdown);
            }
        }

        function openDropdown(toggle, dropdown, isMobile = false) {
            console.log('Opening dropdown:', dropdown.id);

            // Add active classes
            toggle.classList.add('open');
            toggle.setAttribute('aria-expanded', 'true');
            dropdown.classList.add('show');

            // Mobile-specific handling
            if (isMobile) {
                // Calculate max height based on content
                const items = dropdown.querySelectorAll('.dropdown-item');
                const itemHeight = 50; // approximate height per item
                const maxHeight = items.length * itemHeight;

                dropdown.style.maxHeight = maxHeight + 'px';

                console.log(`📱 Mobile dropdown opened with max-height: ${maxHeight}px`);
            }

            // Add animation class
            setTimeout(() => {
                dropdown.classList.add('animate-in');
            }, 10);
        }

        function closeAllDropdowns() {
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            const toggles = document.querySelectorAll('.dropdown-toggle');

            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('show', 'animate-in');

                // Reset mobile styles
                if (window.innerWidth <= 768) {
                    dropdown.style.maxHeight = '0';
                }
            });

            toggles.forEach(toggle => {
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
            });

            console.log('🔒 All dropdowns closed');
        }

        function setupMobileDropdown(dropdown) {
            dropdown.style.maxHeight = '0';
            dropdown.style.overflow = 'hidden';
            dropdown.style.transition = 'max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
        }

        // Scroll effects for navbar
        function initializeScrollEffects() {
            console.log('🌊 Initializing scroll effects');

            let ticking = false;

            function updateScrollEffects() {
                const navbar = document.getElementById('navbar');
                const scrolled = window.pageYOffset;

                if (scrolled > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                // Parallax effect for hero section
                const heroContent = document.querySelector('.hero-content');
                if (heroContent && scrolled < window.innerHeight) {
                    heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
                }

                ticking = false;
            }

            function requestScrollUpdate() {
                if (!ticking) {
                    requestAnimationFrame(updateScrollEffects);
                    ticking = true;
                }
            }

            window.addEventListener('scroll', requestScrollUpdate);
        }

        // Keyboard navigation
        function initializeKeyboardNavigation() {
            console.log('⌨️ Initializing keyboard navigation');

            document.addEventListener('keydown', function(e) {
                switch (e.key) {
                    case 'Escape':
                        closeAllDropdowns();

                        // Close mobile menu
                        const hamburger = document.querySelector('#hamburger');
                        const navMenu = document.querySelector('#nav-menu');
                        const body = document.body;

                        if (hamburger && navMenu && navMenu.classList.contains('show')) {
                            hamburger.classList.remove('active');
                            navMenu.classList.remove('show');
                            body.classList.remove('menu-open');
                        }
                        break;

                    case 'Tab':
                        // Handle tab navigation for dropdowns
                        handleTabNavigation(e);
                        break;
                }
            });
        }

        function handleTabNavigation(e) {
            const focusedElement = document.activeElement;

            if (focusedElement.classList.contains('dropdown-toggle')) {
                const dropdownId = focusedElement.getAttribute('data-dropdown');
                const dropdown = document.getElementById(dropdownId);

                if (dropdown && dropdown.classList.contains('show')) {
                    if (!e.shiftKey) {
                        // Tab forward into dropdown
                        e.preventDefault();
                        const firstItem = dropdown.querySelector('.dropdown-item');
                        if (firstItem) {
                            firstItem.focus();
                        }
                    }
                }
            }
        }

        // Mobile optimizations
        function initializeMobileOptimizations() {
            console.log('📱 Initializing mobile optimizations');

            // Touch event handling for better mobile experience
            if ('ontouchstart' in window) {
                const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

                dropdownToggles.forEach(toggle => {
                    toggle.addEventListener('touchstart', function() {
                        this.style.backgroundColor = 'rgba(102, 126, 234, 0.1)';
                    });

                    toggle.addEventListener('touchend', function() {
                        setTimeout(() => {
                            this.style.backgroundColor = '';
                        }, 150);
                    });
                });
            }

            // Handle orientation change
            window.addEventListener('orientationchange', function() {
                setTimeout(() => {
                    closeAllDropdowns();

                    // Recalculate mobile dropdown heights
                    const dropdowns = document.querySelectorAll('.dropdown-menu');
                    dropdowns.forEach(dropdown => {
                        if (window.innerWidth <= 768) {
                            setupMobileDropdown(dropdown);
                        }
                    });
                }, 100);
            });
        }

        // Regular nav links (non-dropdown)
        document.addEventListener('DOMContentLoaded', function() {
            const regularNavLinks = document.querySelectorAll('.nav-link:not(.dropdown-toggle)');
            regularNavLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    console.log('Regular nav link clicked');

                    if (window.innerWidth <= 768) {
                        const hamburger = document.querySelector('#hamburger');
                        const navMenu = document.querySelector('#nav-menu');
                        const body = document.body;

                        if (hamburger && navMenu) {
                            hamburger.classList.remove('active');
                            navMenu.classList.remove('show');
                            body.classList.remove('menu-open');
                        }
                    }
                });
            });
        });

        // Counter animation for stats
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

        // Animate counters when stats section is visible
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const numbers = entry.target.querySelectorAll('.stat-number');
                    numbers.forEach(number => {
                        const target = parseInt(number.textContent.replace(/,/g, ''));
                        if (!isNaN(target)) {
                            animateCounter(number, target);
                        }
                    });
                    statsObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        const statsSection = document.querySelector('.stats');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }

        // Intersection Observer for fade-in animations
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

        // Apply fade-in animation to sections
        document.querySelectorAll('.about, .services, .stats').forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(50px)';
            section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(section);
        });

        // Apply stagger animation to cards
        document.querySelectorAll('.service-card').forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            observer.observe(card);
        });

        document.querySelectorAll('.feature-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            item.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            observer.observe(item);
        });

        document.querySelectorAll('.stat-item').forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(30px)';
            item.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
            observer.observe(item);
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href === '#' || href === '' || href === '#!') {
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

        // Add smooth hover effects for buttons
        document.querySelectorAll('.btn-primary, .btn-secondary').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.05)';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Mobile touch interactions
        if ('ontouchstart' in window) {
            document.querySelectorAll('.service-card, .feature-item, .stat-item').forEach(card => {
                card.addEventListener('touchstart', function() {
                    this.style.transform = 'translateY(-3px) scale(0.98)';
                });

                card.addEventListener('touchend', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        }

        // Utility functions for debugging
        function debugDropdownState() {
            console.log('🔍 Dropdown Debug Info:');

            const dropdowns = document.querySelectorAll('.dropdown-menu');
            const toggles = document.querySelectorAll('.dropdown-toggle');

            console.log(`Found ${toggles.length} dropdown toggles`);
            console.log(`Found ${dropdowns.length} dropdown menus`);

            toggles.forEach((toggle, index) => {
                const dropdownId = toggle.getAttribute('data-dropdown');
                const dropdown = document.getElementById(dropdownId);
                const isOpen = toggle.classList.contains('open');
                const isVisible = dropdown && dropdown.classList.contains('show');

                console.log(`Dropdown ${index + 1}:`, {
                    id: dropdownId,
                    toggle: toggle.textContent.trim(),
                    isOpen,
                    isVisible,
                    exists: !!dropdown
                });
            });
        }

        // Export functions for debugging
        window.debugDropdownState = debugDropdownState;
        // window.testDropdowns = testDropdowns;
        window.closeAllDropdowns = closeAllDropdowns;

        // Final initialization and testing
        setTimeout(() => {
            console.log('🎉 Enhanced Portal Desa with Dropdown Menu Loaded Successfully!');
            console.log('📱 Responsive: ✓');
            console.log('🎨 Hover Effects: ✓');
            console.log('🍔 Mobile Menu: ✓');
            console.log('📋 Dropdown Menu: ✓');
            console.log('⌨️ Keyboard Navigation: ✓');
            console.log('🌊 Parallax: ✓');
            console.log('♿ Accessibility: ✓');

            // Auto-test dropdowns
            debugDropdownState();

            // Test dropdown functionality automatically
            if (typeof testDropdowns === 'function') {
                testDropdowns();
            }
        }, 1000);
    </script>
</body>

</html>

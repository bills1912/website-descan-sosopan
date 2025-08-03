@extends('landingPage.main')

@section('title', 'Struktur Organisasi - Portal Desa')

@section('content')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Struktur Organisasi</h1>
            <p>Susunan pemerintahan desa yang berkomitmen melayani masyarakat</p>
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / <span>Struktur Organisasi</span>
            </nav>
        </div>
    </section>

    <!-- Vision Mission (tetap seperti sebelumnya) -->
    <section class="vision-mission">
        <div class="container">
            <h2 class="section-title">Visi & Misi</h2>
            <div class="vm-grid">
                <!-- Visi Card -->
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="vm-title">Visi</h3>
                    <div class="vm-content">
                        Bersama Harun dan Warga Wujudkan Desa Sosopan yang BERADAT, HARMONI & AGAMAIS (BERHARGA).
                    </div>
                </div>

                <!-- Misi Card -->
                <div class="vm-card">
                    <div class="vm-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="vm-title">Misi</h3>
                    <div class="vm-content">
                        <div class="mission-item">
                            Mengidentifikasi seluruh Aset Desa yang sudah ada serta mengoptimalkan pengelolaan dan
                            penggunaannya
                        </div>

                        <div class="mission-item">
                            Melakukan Reformasi Birokrasi yang selama ini menjadi salah satu penyebab matinya pelayanan
                            publik desa dengan pola demokratis, jujur dan akuntabel
                        </div>

                        <div class="mission-item">
                            Menata dan mengoptimalkan kembali kelompok tani dan menjadikan kelompok tani menjadi milik umum
                            bukan milik pribadi
                        </div>

                        <div class="mission-item">
                            Meningkatkan minat belajar anak, mulai dari anak usia dini sampai usia remaja
                        </div>

                        <div class="mission-item">
                            Menyiapkan generasi yang berprestasi untuk siap mewujudkan cita-cita tanpa terkendala dengan
                            kemiskinan
                        </div>

                        <div class="mission-item">
                            Meningkatkan ekonomi masyarakat dengan menghidupkan Badan Usaha Milik Desa (BUMDesa)
                        </div>

                        <div class="mission-item">
                            Mendorong tumbuhnya Ekonomi Kreatif dan Home Industri
                        </div>

                        <div class="mission-item">
                            Membangun infrastruktur desa dengan pola gotong royong dan padat karya tunai
                        </div>

                        <div class="mission-item">
                            Menyusun Kebijakan Desa dengan pola partisipatif
                        </div>

                        <div class="mission-item">
                            Mengedepankan pengelolaan keuangan desa yang efisien, akuntabel dan kredibel
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Organization Chart -->
    <section class="org-chart-section">
        <div class="floating-particles"></div>

        <div class="container">
            <h2 class="section-title">Struktur Organisasi Interaktif</h2>
            <p style="text-align: center; color: #666; margin-bottom: 3rem;">Arahkan kursor ke foto untuk melihat informasi
                detail</p>

            <!-- Tab Navigation -->
            <div class="org-tabs-container">
                <div class="org-tabs">
                    <button class="tab-button active" data-tab="struktur-utama" data-organisasi="pemerintah_desa">
                        <i class="fas fa-users-cog"></i>
                        Pemerintah Desa
                    </button>
                    <button class="tab-button" data-tab="struktur-bpd" data-organisasi="bpd">
                        <i class="fas fa-gavel"></i>
                        BPD
                    </button>
                    <button class="tab-button" data-tab="struktur-pkk" data-organisasi="pkk">
                        <i class="fas fa-female"></i>
                        PKK
                    </button>
                    <button class="tab-button" data-tab="struktur-karang-taruna" data-organisasi="karang_taruna">
                        <i class="fas fa-running"></i>
                        Karang Taruna
                    </button>
                    <button class="tab-button" data-tab="struktur-lpmd" data-organisasi="lpmd">
                        <i class="fas fa-store"></i>
                        LPMD/BUMDes
                    </button>
                    <button class="tab-button" data-tab="struktur-lembaga-adat" data-organisasi="lembaga_adat">
                        <i class="fas fa-university"></i>
                        Lembaga Adat
                    </button>
                </div>
            </div>
        </div>

        <div class="org-chart-container">
            @foreach (['pemerintah_desa' => 'struktur-utama', 'bpd' => 'struktur-bpd', 'pkk' => 'struktur-pkk', 'karang_taruna' => 'struktur-karang-taruna', 'lpmd' => 'struktur-lpmd', 'lembaga_adat' => 'struktur-lembaga-adat'] as $orgKey => $tabId)
                <div class="tab-content {{ $loop->first ? 'active' : '' }}" id="{{ $tabId }}">
                    {{-- @dd($strukturData[$orgKey] ?? null) --}}
                    @if (isset($strukturData[$orgKey]['pimpinan']))
                        @php $pimpinan = $strukturData[$orgKey]['pimpinan']; @endphp

                        <div class="tab-description">
                            <h3>{{ $pimpinan->organisasi }}</h3>
                            <p>{{ $pimpinan->fokus ?? 'Organisasi yang berkomitmen melayani masyarakat desa' }}</p>
                        </div>

                        <div class="org-chart">
                            <svg class="connections-svg"></svg>

                            <!-- Level 1: Pimpinan/Ketua -->
                            <div class="org-level org-level-1">
                                <div class="person-circle kepala-desa" data-id="pimpinan-{{ $orgKey }}">
                                    <div class="person-avatar">
                                        @if ($pimpinan->foto)
                                            <img src="{{ url('/storage/' . $pimpinan->foto) }}" alt="{{ $pimpinan->nama }}">
                                        @else
                                            <i class="fas fa-user-tie"></i>
                                        @endif
                                    </div>
                                    <div class="position-label">{{ $pimpinan->posisi }}</div>
                                    <div class="person-info-card">
                                        <div class="info-header">
                                            <div class="info-avatar">
                                                @if ($pimpinan->foto)
                                                    <img src="{{ url('/storage/' . $pimpinan->foto) }}"
                                                        alt="{{ $pimpinan->nama }}"
                                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                                @else
                                                    <i class="fas fa-user-tie"></i>
                                                @endif
                                            </div>
                                            <div class="info-details">
                                                <h3>{{ $pimpinan->nama }}</h3>
                                                <div class="position">{{ $pimpinan->posisi }}</div>
                                            </div>
                                        </div>
                                        <div class="info-content">
                                            <strong>Periode:</strong> {{ $pimpinan->periode_lengkap }}<br>
                                            @if ($pimpinan->pengalaman)
                                                <strong>Pengalaman:</strong> {{ $pimpinan->pengalaman }}<br>
                                            @endif
                                            @if ($pimpinan->fokus)
                                                <strong>Bidang:</strong> {{ $pimpinan->fokus }}
                                            @endif
                                        </div>
                                        @if ($pimpinan->nomor_telepon || $pimpinan->email)
                                            <div class="info-contact">
                                                @if ($pimpinan->nomor_telepon)
                                                    <div class="contact-item">
                                                        <i class="fas fa-phone"></i>
                                                        <span>{{ $pimpinan->nomor_telepon }}</span>
                                                    </div>
                                                @endif
                                                @if ($pimpinan->email)
                                                    <div class="contact-item">
                                                        <i class="fas fa-envelope"></i>
                                                        <span>{{ $pimpinan->email }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if (isset($strukturData[$orgKey]['anggota']) && !empty($strukturData[$orgKey]['anggota']))
                                @php
                                    $anggotaGrouped = $strukturData[$orgKey]['anggota'];
                                    $wakil = $anggotaGrouped['wakil'] ?? collect();
                                    $sekretaris = $anggotaGrouped['sekretaris'] ?? collect();
                                    $bendahara = $anggotaGrouped['bendahara'] ?? collect();
                                    $koordinator = $anggotaGrouped['koordinator'] ?? collect();
                                    $anggotaBiasa = $anggotaGrouped['anggota'] ?? collect();
                                    $lainnya = $anggotaGrouped['lainnya'] ?? collect();
                                @endphp

                                <!-- Level 2: Wakil dan Sekretaris -->
                                @if ($wakil->count() > 0 || $sekretaris->count() > 0 || $bendahara->count() > 0)
                                    <div class="org-level org-level-2">
                                        @foreach ($wakil as $index => $w)
                                            @include('landingPage.components.partials.person-card', [
                                                'person' => $w,
                                                'id' => 'wakil-' . $orgKey . '-' . ($index + 1),
                                                'class' => 'wakil-kepala',
                                            ])
                                        @endforeach

                                        @foreach ($sekretaris as $index => $s)
                                            @include('landingPage.components.partials.person-card', [
                                                'person' => $s,
                                                'id' => 'sekretaris-' . $orgKey . '-' . ($index + 1),
                                                'class' => 'sekretaris',
                                            ])
                                        @endforeach

                                        @foreach ($bendahara as $index => $b)
                                            @include('landingPage.components.partials.person-card', [
                                                'person' => $b,
                                                'id' => 'bendahara-' . $orgKey . '-' . ($index + 1),
                                                'class' => 'bendahara',
                                            ])
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Level 3: Koordinator/Kepala Urusan/Manajer -->
                                @if ($koordinator->count() > 0)
                                    <div class="org-level org-level-3">
                                        @foreach ($koordinator as $index => $coord)
                                            @include('landingPage.components.partials.person-card', [
                                                'person' => $coord,
                                                'id' => 'koordinator-' . $orgKey . '-' . ($index + 1),
                                            ])
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Level 4: Anggota dan Lainnya -->
                                @if ($anggotaBiasa->count() > 0 || $lainnya->count() > 0)
                                    <div class="org-level org-level-4">
                                        @foreach ($anggotaBiasa as $index => $member)
                                            @include('landingPage.components.partials.person-card', [
                                                'person' => $member,
                                                'id' => 'anggota-' . $orgKey . '-' . ($index + 1),
                                            ])
                                        @endforeach

                                        @foreach ($lainnya as $index => $other)
                                            @include('landingPage.components.partials.person-card', [
                                                'person' => $other,
                                                'id' => 'lainnya-' . $orgKey . '-' . ($index + 1),
                                            ])
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="tab-description">
                            <h3>{{ ucwords(str_replace('_', ' ', $orgKey)) }}</h3>
                            <p>Data struktur organisasi belum tersedia.</p>
                        </div>
                        <div class="org-chart">
                            <div class="no-data-message">
                                <i class="fas fa-info-circle"></i>
                                <p>Struktur organisasi untuk {{ ucwords(str_replace('_', ' ', $orgKey)) }} belum diinput ke
                                    dalam sistem.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <!-- Mobile backdrop for info cards -->
    <div class="mobile-backdrop"></div>

    <script>
        // Enhanced JavaScript with Tab Functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tab functionality
            initializeTabs();

            // Create floating particles
            createFloatingParticles();

            // Initialize connection lines for all tabs
            initializeAllConnectionLines();

            // Setup scroll animations
            setupScrollAnimations();

            // Setup mobile interactions
            setupMobileInteractions();
        });

        function initializeTabs() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    const organisasi = this.getAttribute('data-organisasi');

                    // Remove active class from all buttons and contents
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Add active class to clicked button and corresponding content
                    this.classList.add('active');
                    const targetContent = document.getElementById(targetTab);
                    if (targetContent) {
                        targetContent.classList.add('loading');

                        setTimeout(() => {
                            targetContent.classList.add('active');
                            targetContent.classList.remove('loading');

                            // Reinitialize connection lines for the active tab
                            initializeConnectionLinesForTab(targetTab);

                            // Trigger scroll animation for the new tab
                            triggerTabAnimation(targetContent);
                        }, 200);
                    }
                });
            });
        }

        // Rest of JavaScript functions remain the same...
        function initializeAllConnectionLines() {
            const tabs = ['struktur-utama', 'struktur-bpd', 'struktur-pkk', 'struktur-karang-taruna', 'struktur-lpmd',
                'struktur-lembaga-adat'
            ];
            tabs.forEach(tabId => {
                initializeConnectionLinesForTab(tabId);
            });
        }

        function initializeConnectionLinesForTab(tabId) {
            const tabContent = document.getElementById(tabId);
            if (!tabContent) return;

            const svg = tabContent.querySelector('.connections-svg');
            if (!svg) return;

            // Clear existing lines
            svg.innerHTML = '';

            // Auto-generate connections based on hierarchy
            generateAutoConnections(tabContent, svg);
        }

        function generateAutoConnections(tabContent, svg) {
            const levels = tabContent.querySelectorAll('.org-level');

            levels.forEach((level, levelIndex) => {
                if (levelIndex === 0) return; // Skip first level (no parent)

                const currentLevelPersons = level.querySelectorAll('.person-circle');
                const prevLevel = levels[levelIndex - 1];
                const parentPersons = prevLevel.querySelectorAll('.person-circle');

                // Connect each person in current level to parent(s)
                currentLevelPersons.forEach((person) => {
                    const personId = person.getAttribute('data-id');

                    // For simplicity, connect to first parent or distribute connections
                    parentPersons.forEach((parent, parentIndex) => {
                        if (parentIndex === 0 || parentPersons.length === 1) {
                            const line = document.createElementNS('http://www.w3.org/2000/svg',
                                'path');
                            line.classList.add('connection-line');
                            line.setAttribute('data-from', parent.getAttribute('data-id'));
                            line.setAttribute('data-to', personId);
                            svg.appendChild(line);
                        }
                    });
                });
            });

            // Update line positions
            updateConnectionLinesForTab(tabContent.id);
        }

        function updateConnectionLinesForTab(tabId) {
            const tabContent = document.getElementById(tabId);
            if (!tabContent) return;

            const svg = tabContent.querySelector('.connections-svg');
            const lines = svg.querySelectorAll('.connection-line');

            lines.forEach(line => {
                const fromId = line.getAttribute('data-from');
                const toId = line.getAttribute('data-to');

                const fromElement = tabContent.querySelector(`[data-id="${fromId}"] .person-avatar`);
                const toElement = tabContent.querySelector(`[data-id="${toId}"] .person-avatar`);

                if (fromElement && toElement) {
                    const fromRect = fromElement.getBoundingClientRect();
                    const toRect = toElement.getBoundingClientRect();
                    const svgRect = svg.getBoundingClientRect();

                    const fromX = fromRect.left + fromRect.width / 2 - svgRect.left;
                    const fromY = fromRect.top + fromRect.height / 2 - svgRect.top;
                    const toX = toRect.left + toRect.width / 2 - svgRect.left;
                    const toY = toRect.top + toRect.height / 2 - svgRect.top;

                    const midY = fromY + (toY - fromY) / 2;
                    const pathData = `M ${fromX} ${fromY} C ${fromX} ${midY}, ${toX} ${midY}, ${toX} ${toY}`;
                    line.setAttribute('d', pathData);
                }
            });
        }

        // Rest of the JavaScript functions from original file...
        function triggerTabAnimation(tabContent) {
            const personCircles = tabContent.querySelectorAll('.person-circle');

            personCircles.forEach(circle => {
                circle.style.opacity = '0';
                circle.style.transform = 'translateY(50px)';
            });

            personCircles.forEach((circle, index) => {
                setTimeout(() => {
                    circle.style.opacity = '1';
                    circle.style.transform = 'translateY(0)';
                }, index * 150);
            });

            setTimeout(() => {
                const lines = tabContent.querySelectorAll('.connection-line');
                lines.forEach((line, index) => {
                    setTimeout(() => {
                        line.classList.add('active');
                    }, index * 200);
                });
            }, 600);
        }

        function createFloatingParticles() {
            const particlesContainer = document.querySelector('.floating-particles');
            const particleCount = 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }

        function setupScrollAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const activeTab = document.querySelector('.tab-content.active');
                        if (activeTab) {
                            triggerTabAnimation(activeTab);
                        }
                        setupConnectionLineHovers();
                    }
                });
            }, {
                threshold: 0.3
            });

            const orgChartSection = document.querySelector('.org-chart-section');
            observer.observe(orgChartSection);
        }

        function setupConnectionLineHovers() {
            const allPersonCircles = document.querySelectorAll('.person-circle');

            allPersonCircles.forEach(circle => {
                circle.addEventListener('mouseenter', function() {
                    const personId = this.getAttribute('data-id');
                    const activeTab = document.querySelector('.tab-content.active');
                    if (activeTab) {
                        highlightConnectionsInTab(personId, activeTab);
                    }
                });

                circle.addEventListener('mouseleave', function() {
                    const activeTab = document.querySelector('.tab-content.active');
                    if (activeTab) {
                        removeHighlightsInTab(activeTab);
                    }
                });
            });
        }

        function highlightConnectionsInTab(personId, tabContent) {
            const lines = tabContent.querySelectorAll('.connection-line');
            lines.forEach(line => {
                const fromId = line.getAttribute('data-from');
                const toId = line.getAttribute('data-to');
                if (fromId === personId || toId === personId) {
                    line.classList.add('highlight');
                }
            });
        }

        function removeHighlightsInTab(tabContent) {
            const lines = tabContent.querySelectorAll('.connection-line');
            lines.forEach(line => {
                line.classList.remove('highlight');
            });
        }

        function setupMobileInteractions() {
            const personCircles = document.querySelectorAll('.person-circle');
            const mobileBackdrop = document.querySelector('.mobile-backdrop');

            personCircles.forEach(circle => {
                circle.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        e.preventDefault();
                        e.stopPropagation();

                        personCircles.forEach(c => c.classList.remove('mobile-active'));
                        mobileBackdrop.classList.remove('active');

                        this.classList.add('mobile-active');
                        mobileBackdrop.classList.add('active');
                    }
                });
            });

            if (mobileBackdrop) {
                mobileBackdrop.addEventListener('click', function() {
                    personCircles.forEach(c => c.classList.remove('mobile-active'));
                    this.classList.remove('active');
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    personCircles.forEach(c => c.classList.remove('mobile-active'));
                    if (mobileBackdrop) {
                        mobileBackdrop.classList.remove('active');
                    }
                }
            });
        }

        // Update connection lines on window resize
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const activeTab = document.querySelector('.tab-content.active');
                if (activeTab) {
                    const tabId = activeTab.getAttribute('id');
                    updateConnectionLinesForTab(tabId);
                }
            }, 100);
        });

        console.log('✨ Dynamic Organization Chart Loaded Successfully!');
    </script>

@endsection

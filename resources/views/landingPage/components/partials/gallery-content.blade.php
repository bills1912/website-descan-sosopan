<div class="gallery-grid">
    @forelse($kegiatanDesa as $kegiatan)
        <div class="gallery-item" data-kegiatan="{{ $kegiatan->id }}">
            @if ($kegiatan->file_path)
                <img src="{{ url('/storage/' . $kegiatan->file_path) }}" alt="{{ $kegiatan->judul_kegiatan }}"
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
                <a href="{{ $kegiatanDesa->appends(request()->query())->previousPageUrl() }}" class="pagination-btn">
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
                <a href="{{ $kegiatanDesa->appends(request()->query())->nextPageUrl() }}" class="pagination-btn">
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

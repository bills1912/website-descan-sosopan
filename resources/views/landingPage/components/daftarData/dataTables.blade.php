<section class="data-tables" id="data-tables" style="display: none;">
    <div class="container">
        <div class="table-container">
            <div class="table-header">
                <div class="table-title">
                    <i class="fas fa-users"></i>
                    <span id="table-title">Data Penduduk</span>
                </div>
                <div class="table-actions">
                    <button class="action-btn" onclick="exportData('excel')">
                        <i class="fas fa-file-excel"></i>
                        Export Excel
                    </button>
                    <button class="action-btn" onclick="exportData('pdf')">
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </button>
                    <button class="action-btn" onclick="printData()">
                        <i class="fas fa-print"></i>
                        Print
                    </button>
                </div>
            </div>

            <div class="table-filters">
                <div class="filter-group">
                    <label for="status-filter">Status:</label>
                    <select id="status-filter">
                        <option value="">Semua</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="category-filter">Kategori:</label>
                    <select id="category-filter">
                        <option value="">Semua Kategori</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search-input" placeholder="Cari data...">
                </div>
            </div>

            <div style="overflow-x: auto;">
                <table class="data-table" id="main-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- Data will be loaded here -->
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <button onclick="previousPage()" id="prev-btn">
                    <i class="fas fa-chevron-left"></i>
                    Previous
                </button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>4</button>
                <button>5</button>
                <button onclick="nextPage()" id="next-btn">
                    Next
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<style>
    /* ===== PAGE HEADER ===== */
    .page-header {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 200" fill="rgba(255,255,255,0.1)"><rect x="100" y="50" width="50" height="50"/><rect x="300" y="100" width="30" height="30"/><rect x="700" y="30" width="40" height="40"/><rect x="500" y="80" width="35" height="35"/></svg>');
        background-size: 100% 100%;
        animation: float 15s linear infinite;
    }

    /* ===== DATA CATEGORIES ===== */
    .data-categories {
        background: white;
        padding: 5rem 0;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .category-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .category-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .category-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .category-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        text-align: center;
    }

    .category-description {
        color: #666;
        line-height: 1.6;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .category-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #11998e;
        margin-bottom: 0.2rem;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #666;
    }

    /* ===== DATA TABLES ===== */
    .data-tables {
        background: #f8f9fa;
        padding: 5rem 0;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 3rem;
    }

    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .table-title {
        font-size: 1.5rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .table-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .action-btn {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 25px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .table-filters {
        background: #f8f9fa;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #eee;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-group label {
        font-size: 0.9rem;
        color: #666;
        font-weight: 500;
    }

    .filter-group select,
    .filter-group input {
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
    }

    .search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border: 1px solid #ddd;
        border-radius: 25px;
        font-size: 0.9rem;
    }

    .search-box i {
        position: absolute;
        left: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #f0f0f0;
    }

    .data-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #2c3e50;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .data-table tbody tr {
        transition: background-color 0.3s ease;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .status-badge {
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
        display: inline-block;
        min-width: 70px;
    }

    .status-active {
        background: #d4edda;
        color: #155724;
    }

    .status-inactive {
        background: #f8d7da;
        color: #721c24;
    }

    .status-pending {
        background: #fff3cd;
        color: #856404;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-small {
        padding: 0.3rem 0.6rem;
        border: none;
        border-radius: 5px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #3498db;
        color: white;
    }

    .btn-edit {
        background: #f39c12;
        color: white;
    }

    .btn-delete {
        background: #e74c3c;
        color: white;
    }

    .btn-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        padding: 2rem;
        background: white;
    }

    .pagination button {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        background: white;
        color: #666;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .pagination button:hover,
    .pagination button.active {
        background: #11998e;
        color: white;
        border-color: #11998e;
    }

    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* ===== STATISTICS SECTION ===== */
    .statistics-section {
        background: #2c3e50;
        color: white;
        padding: 5rem 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #38ef7d;
        margin-bottom: 0.5rem;
    }

    .stat-title {
        font-size: 1rem;
        opacity: 0.9;
    }

    /* ===== REPORTS SECTION ===== */
    .reports-section {
        background: white;
        padding: 5rem 0;
    }

    .reports-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .reports-filters {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .reports-search {
        position: relative;
        min-width: 250px;
    }

    .reports-search input {
        width: 100%;
        padding: 0.7rem 1rem 0.7rem 2.5rem;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        font-size: 0.9rem;
        transition: border-color 0.3s ease;
    }

    .reports-search input:focus {
        outline: none;
        border-color: #11998e;
    }

    .reports-search i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
    }

    .filter-select {
        padding: 0.7rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        font-size: 0.9rem;
        background: white;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #11998e;
    }

    .report-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .report-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #f0f0f0;
        position: relative;
        overflow: hidden;
    }

    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    .report-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .report-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.5rem;
    }

    .report-date {
        font-size: 0.8rem;
        color: #666;
        background: #f8f9fa;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
    }

    .report-category {
        font-size: 0.8rem;
        color: #11998e;
        background: rgba(17, 153, 142, 0.1);
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-weight: 500;
    }

    .report-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .report-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .report-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        font-size: 0.8rem;
    }

    .report-stat {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        color: #666;
    }

    .report-actions {
        display: flex;
        gap: 1rem;
    }

    .report-btn {
        flex: 1;
        padding: 0.7rem 1rem;
        border: none;
        border-radius: 25px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .btn-download {
        background: #11998e;
        color: white;
    }

    .btn-download:hover {
        background: #0f8279;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.3);
    }

    .btn-view-report {
        background: transparent;
        color: #3498db;
        border: 2px solid #3498db;
    }

    .btn-view-report:hover {
        background: #3498db;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .reports-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 3rem;
    }

    .pagination-btn {
        padding: 0.7rem 1rem;
        border: 2px solid #e9ecef;
        background: white;
        color: #666;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .pagination-btn:hover,
    .pagination-btn.active {
        background: #11998e;
        color: white;
        border-color: #11998e;
        transform: translateY(-2px);
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .pagination-info {
        color: #666;
        font-size: 0.9rem;
        margin: 0 1rem;
    }

    /* ===== LOADING & EMPTY STATES ===== */
    .loading-spinner {
        display: none;
        justify-content: center;
        align-items: center;
        padding: 3rem;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #11998e;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .no-data {
        text-align: center;
        padding: 3rem;
        color: #666;
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #ccc;
    }

    /* ===== MODAL STYLES ===== */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 20px;
        padding: 2rem;
        max-width: 700px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .close-btn:hover {
        background: #f0f0f0;
        color: #333;
    }

    /* ===== MODAL CONTENT STYLES ===== */
    .detail-section {
        margin-bottom: 2rem;
    }

    .detail-section h4 {
        color: #2c3e50;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #11998e;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .detail-item strong {
        color: #666;
        font-size: 0.9rem;
    }

    .detail-item span {
        color: #2c3e50;
        font-weight: 500;
    }

    .tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .tag {
        background: #e9ecef;
        color: #495057;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
    }

    .stats-row {
        display: flex;
        gap: 2rem;
    }

    .stats-row .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #666;
    }

    .detail-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .error-message {
        text-align: center;
        padding: 2rem;
        color: #666;
    }

    .error-message i {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #dc3545;
    }

    /* ===== NOTIFICATION STYLES ===== */
    .notification {
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
        }

        to {
            transform: translateX(0);
        }
    }

    /* ===== RESPONSIVE DESIGN ===== */
    @media (max-width: 768px) {
        .category-grid {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .table-filters {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            min-width: auto;
        }

        .data-table {
            font-size: 0.8rem;
        }

        .data-table th,
        .data-table td {
            padding: 0.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .pagination {
            flex-wrap: wrap;
        }

        .modal-content {
            width: 95%;
            padding: 1rem;
        }

        .report-grid {
            grid-template-columns: 1fr;
        }

        .reports-controls {
            flex-direction: column;
            align-items: stretch;
        }

        .reports-filters {
            flex-direction: column;
        }

        .reports-search {
            min-width: auto;
        }

        .report-actions {
            flex-direction: column;
        }

        .reports-pagination {
            flex-wrap: wrap;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .stats-row {
            flex-direction: column;
            gap: 1rem;
        }

        .detail-actions {
            flex-direction: column;
        }
    }
</style>

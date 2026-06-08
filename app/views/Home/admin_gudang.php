<div class="container-fluid mt-4 mb-5">
    
    <!-- Header Ucapan & Konteks -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success">Selamat Datang, <?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?>! 🚦</h2>
                <p class="text-muted mb-0">Pantau arus lalu lintas bongkar muat dan alokasi rak gudang hari ini.</p>
            </div>
            <div>
                <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm"><i class="bi bi-person-badge me-2"></i>Akses: ADMIN GUDANG</span>
            </div>
        </div>
    </div>

    <!-- Baris 1: Radar Kemacetan (Bottleneck Radar) -->
    <div class="row g-4 mb-4">
        
        <!-- Antrean Inbound -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 border-start <?= ($data['statistik']['inbound'] > 0) ? 'border-primary' : 'border-success'; ?> border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Antrean Inbound (Bongkar)</h6>
                        <div class="<?= ($data['statistik']['inbound'] > 0) ? 'bg-primary text-primary' : 'bg-success text-success'; ?> bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-box-arrow-in-down fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $data['statistik']['inbound']; ?> <span class="fs-6 text-muted fw-normal">Truk / ASN</span></h2>
                    <a href="<?= BASEURL; ?>/admin/inbound" class="small text-decoration-none fw-bold <?= ($data['statistik']['inbound'] > 0) ? 'text-primary' : 'text-success'; ?>">
                        Proses Kedatangan <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Antrean Putaway -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 border-start <?= ($data['statistik']['putaway'] > 0) ? 'border-warning' : 'border-success'; ?> border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Antrean Putaway (Alokasi Rak)</h6>
                        <div class="<?= ($data['statistik']['putaway'] > 0) ? 'bg-warning text-warning' : 'bg-success text-success'; ?> bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-layers-fill fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $data['statistik']['putaway']; ?> <span class="fs-6 text-muted fw-normal">Batch Barang</span></h2>
                    <a href="<?= BASEURL; ?>/admin/putaway" class="small text-decoration-none fw-bold <?= ($data['statistik']['putaway'] > 0) ? 'text-warning' : 'text-success'; ?>">
                        Cetak Barcode & Alokasikan <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Antrean Ekspedisi (Outbound) -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 border-start <?= ($data['statistik']['ekspedisi'] > 0) ? 'border-danger' : 'border-success'; ?> border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Antrean Ekspedisi (Muat)</h6>
                        <div class="<?= ($data['statistik']['ekspedisi'] > 0) ? 'bg-danger text-danger' : 'bg-success text-success'; ?> bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-truck fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $data['statistik']['ekspedisi']; ?> <span class="fs-6 text-muted fw-normal">Surat Jalan</span></h2>
                    <a href="<?= BASEURL; ?>/outbound" class="small text-decoration-none fw-bold <?= ($data['statistik']['ekspedisi'] > 0) ? 'text-danger' : 'text-success'; ?>">
                        Panggil Truk Keluar <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Papan Instruksi (Opsional) -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-secondary border-0 shadow-sm rounded-4 d-flex align-items-center p-4">
                <i class="bi bi-info-circle-fill text-muted fs-2 me-3"></i>
                <div>
                    <h6 class="fw-bold mb-1">Panduan Operasional Hari Ini</h6>
                    <p class="mb-0 small text-muted">Prioritaskan penyelesaian <strong>Antrean Ekspedisi</strong> terlebih dahulu agar truk klien tidak menunggu terlalu lama. Setelah area Outbound bersih, lanjutkan dengan memindahkan barang dari area Transit (Putaway) ke dalam Rak penyimpanan utama.</p>
                </div>
            </div>
        </div>
    </div>

</div>
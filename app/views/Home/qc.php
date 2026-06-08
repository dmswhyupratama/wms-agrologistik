<div class="container-fluid mt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success">Selamat Datang, <?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?>! 🔬</h2>
                <p class="text-muted mb-0">Pantau antrean inspeksi mutu komoditas dan verifikasi barang rusak hari ini.</p>
            </div>
            <div>
                <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm"><i class="bi bi-person-badge me-2"></i>Akses: QUALITY CONTROL</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 border-start <?= ($data['statistik']['inbound_qc'] > 0) ? 'border-warning' : 'border-success'; ?> border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Antrean Inspeksi Inbound</h6>
                        <div class="<?= ($data['statistik']['inbound_qc'] > 0) ? 'bg-warning text-warning' : 'bg-success text-success'; ?> bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-clipboard-check fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $data['statistik']['inbound_qc']; ?> <span class="fs-6 text-muted fw-normal">Batch Komoditas</span></h2>
                    <a href="<?= BASEURL; ?>/qc" class="small text-decoration-none fw-bold <?= ($data['statistik']['inbound_qc'] > 0) ? 'text-warning' : 'text-success'; ?>">
                        Mulai Inspeksi Mutu <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 border-start <?= ($data['statistik']['waste_qc'] > 0) ? 'border-danger' : 'border-success'; ?> border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Verifikasi Laporan Waste (Barang Rusak)</h6>
                        <div class="<?= ($data['statistik']['waste_qc'] > 0) ? 'bg-danger text-danger' : 'bg-success text-success'; ?> bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-trash3 fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $data['statistik']['waste_qc']; ?> <span class="fs-6 text-muted fw-normal">Laporan</span></h2>
                    <a href="<?= BASEURL; ?>/waste" class="small text-decoration-none fw-bold <?= ($data['statistik']['waste_qc'] > 0) ? 'text-danger' : 'text-success'; ?>">
                        Cek Kelayakan Retur / Buang <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="alert alert-secondary border-0 shadow-sm rounded-4 d-flex align-items-center p-4">
                <i class="bi bi-info-circle-fill text-muted fs-2 me-3"></i>
                <div>
                    <h6 class="fw-bold mb-1">Panduan Standar Operasional (SOP)</h6>
                    <p class="mb-0 small text-muted">Pastikan alat ukur kadar air (*Moisture Meter*) dan timbangan digital telah dikalibrasi sebelum memulai inspeksi. Komoditas yang tidak memenuhi standar mutu (Reject) akan otomatis masuk ke daftar retur pemasok dan tidak dapat dialokasikan ke dalam rak gudang utama.</p>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="container-fluid mt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success">Selamat Datang, <?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?>! 👋</h2>
                <p class="text-muted mb-0">Pantau performa pesanan dan ketersediaan stok untuk klien hari ini.</p>
            </div>
            <div>
                <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm"><i class="bi bi-person-badge me-2"></i>Akses: ADMIN PENJUALAN</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 border-start border-primary border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Pesanan Masuk (Hari Ini)</h6>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                            <i class="bi bi-cart-plus fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-0"><?= $data['statistik']['so_hari_ini']; ?> <span class="fs-6 text-muted fw-normal">Dokumen SO</span></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 border-start border-warning border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Menunggu Diproses Gudang</h6>
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2">
                            <i class="bi bi-hourglass-split fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-0"><?= $data['statistik']['so_gantung']; ?> <span class="fs-6 text-muted fw-normal">Dokumen SO</span></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 border-start border-success border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Sukses Terkirim (Hari Ini)</h6>
                        <div class="bg-success bg-opacity-10 text-success rounded-circle p-2">
                            <i class="bi bi-check2-circle fs-5"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-0"><?= $data['statistik']['so_selesai']; ?> <span class="fs-6 text-muted fw-normal">Dokumen SO</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-md-5">
            <div class="card bg-success text-white shadow-sm border-0 rounded-4 h-100">
                <div class="card-body p-5 text-center d-flex flex-column justify-content-center">
                    <i class="bi bi-cart-check-fill display-1 mb-3 opacity-75"></i>
                    <h4 class="fw-bold mb-2">Input Pesanan Klien Baru</h4>
                    <p class="text-light mb-4">Buat Sales Order (SO) baru dan teruskan langsung ke antrean Kru Gudang.</p>
                    <a href="<?= BASEURL; ?>/penjualan" class="btn btn-light btn-lg text-success fw-bold rounded-pill">
                        <i class="bi bi-plus-circle-fill me-2"></i>Buat Pesanan Sekarang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-dark text-white p-3 rounded-top-4 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-box2-heart-fill me-2"></i>Top 5 Komoditas Melimpah</h6>
                    <a href="<?= BASEURL; ?>/penjualan" class="btn btn-sm btn-outline-light">Lihat Semua di Form SO</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Komoditas</th>
                                    <th class="text-end pe-4">Total Tersedia Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($data['top_stok'])) : ?>
                                    <tr><td colspan="2" class="text-center text-muted py-4">Belum ada stok barang layak jual di gudang.</td></tr>
                                <?php else : ?>
                                    <?php foreach($data['top_stok'] as $stok) : ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark"><i class="bi bi-record-circle-fill text-success small me-2"></i><?= $stok['komoditas']; ?></td>
                                            <td class="text-end pe-4 fw-bold fs-5 text-primary">
                                                <?= number_format($stok['total_berat'], 2, ',', '.'); ?> <span class="fs-6 text-muted fw-normal">Kg</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
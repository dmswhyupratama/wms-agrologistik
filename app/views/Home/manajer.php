<div class="container-fluid mt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold text-success">Selamat Datang, <?= explode(' ', trim($_SESSION['nama_lengkap']))[0]; ?>! 📈</h2>
                <p class="text-muted mb-0">Berikut adalah pantauan operasional gudang Agrologistik secara <em>real-time</em>.</p>
            </div>
            <div>
                <span class="badge bg-dark px-3 py-2 fs-6 shadow-sm"><i class="bi bi-person-badge me-2"></i>Akses: MANAJER</span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 border-start border-primary border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Pesanan Aktif (Outbound)</h6>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                            <i class="bi bi-cart-check fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $data['statistik']['so_aktif']; ?> <span class="fs-6 text-muted fw-normal">Dokumen SO</span></h2>
                    <p class="small text-muted mb-0">Sedang diproses oleh Kru atau Ekspedisi</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4 border-start <?= ($data['statistik']['antrean_qc'] > 0) ? 'border-warning' : 'border-success'; ?> border-5 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="text-muted fw-bold mb-0">Antrean Inspeksi QC</h6>
                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                            <i class="bi bi-clipboard-pulse fs-4"></i>
                        </div>
                    </div>
                    <h2 class="fw-bold text-dark mb-1"><?= $data['statistik']['antrean_qc']; ?> <span class="fs-6 text-muted fw-normal">Laporan Masuk</span></h2>
                    <?php if($data['statistik']['antrean_qc'] > 0) : ?>
                        <p class="small text-danger fw-bold mb-0"><i class="bi bi-exclamation-circle me-1"></i>Butuh atensi segera dari tim QC</p>
                    <?php else : ?>
                        <p class="small text-success fw-bold mb-0"><i class="bi bi-check-circle me-1"></i>Antrean QC bersih hari ini</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-white p-3 rounded-top-4">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-thermometer-high me-2"></i>Status Termostat Ruangan</h6>
                </div>
                <div class="card-body p-4">
                    <?php if(empty($data['suhu']['daftar_suhu'])) : ?>
                        <div class="text-center text-muted py-3">Belum ada pencatatan suhu dari Kru Lapangan hari ini.</div>
                    <?php else : ?>
                        
                        <?php if($data['suhu']['jumlah_anomali'] > 0) : ?>
                            <div class="alert alert-danger mb-4 shadow-sm border-0">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                                <strong>Peringatan Kritis!</strong> Suhu pada ruangan <strong><?= implode(', ', $data['suhu']['daftar_anomali']); ?></strong> terdeteksi di luar batas aman! Segera lakukan pengecekan fisik.
                            </div>
                        <?php endif; ?>
                        
                        <div class="row g-3">
                            <?php foreach($data['suhu']['daftar_suhu'] as $s) : ?>
                                <?php 
                                    // Logika untuk menentukan warna kotak (Merah jika anomali, Hijau jika aman)
                                    $is_anomali = in_array($s['kode_ruangan'], $data['suhu']['daftar_anomali']); 
                                ?>
                                <div class="col-md-3">
                                    <div class="border rounded-4 p-3 text-center <?= $is_anomali ? 'border-danger bg-danger-subtle' : 'border-success-subtle'; ?>">
                                        <h5 class="fw-bold <?= $is_anomali ? 'text-danger' : 'text-dark'; ?>"><?= $s['kode_ruangan']; ?></h5>
                                        <h2 class="<?= $is_anomali ? 'text-danger' : 'text-success'; ?> fw-bold mb-1">
                                            <?= number_format($s['suhu_celcius'], 1, ',', '.'); ?>°C
                                        </h2>
                                        <small class="text-muted fw-medium">Batas: <?= $s['rentang_suhu']; ?></small>
                                        <div class="mt-2 small text-secondary">
                                            <i class="bi bi-clock me-1"></i><?= date('H:i', strtotime($s['waktu_catat'])); ?> WIB
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-white p-3 rounded-top-4 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-pie-chart-fill me-2"></i>Kesehatan Stok Gudang (Tonase)</h6>
                    <a href="<?= BASEURL; ?>/stok" class="btn btn-sm btn-outline-light">Lihat Detail Rak</a>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-6 mb-3 mb-md-0 border-end">
                            <p class="text-muted fw-bold mb-2">Stok Tersedia (Layak Jual)</p>
                            <h1 class="fw-bold text-success display-6"><?= number_format($data['statistik']['stok_tersedia'], 2, ',', '.'); ?> <span class="fs-5">Kg</span></h1>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted fw-bold mb-2">Stok Tertahan (Area Karantina)</p>
                            <h1 class="fw-bold <?= ($data['statistik']['stok_karantina'] > 0) ? 'text-danger' : 'text-secondary'; ?> display-6">
                                <?= number_format($data['statistik']['stok_karantina'], 2, ',', '.'); ?> <span class="fs-5">Kg</span>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h6 class="fw-bold text-muted mb-3"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Akses Cepat</h6>
            <div class="d-grid gap-2 d-md-flex">
                <a href="<?= BASEURL; ?>/waste" class="btn btn-danger btn-lg rounded-3 fw-bold shadow-sm px-4">
                    <i class="bi bi-graph-up-arrow me-2"></i>Buka Laporan Rasio Penyusutan (Waste)
                </a>
            </div>
        </div>
    </div>

</div>
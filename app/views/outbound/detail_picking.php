<div class="container-fluid mt-4 mb-5">
    <div class="row mb-3">
        <div class="col-12">
            <a href="<?= BASEURL; ?>/outbound" class="text-decoration-none text-muted fw-bold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark"><i class="bi bi-list-check me-2 text-primary"></i>Tugas Pengambilan (Picking)</h3>
            <p class="text-muted">ID Pesanan: <span class="badge bg-dark fs-6">SO-<?= str_pad($data['id_so'], 4, '0', STR_PAD_LEFT); ?></span></p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="row">
        <?php if(empty($data['picking'])) : ?>
            <div class="col-12 text-center text-muted mt-5">
                <i class="bi bi-inbox fs-1"></i>
                <p class="mt-2">Tidak ada data instruksi pengambilan untuk pesanan ini.</p>
            </div>
        <?php else : ?>
            <div class="col-12 mb-3">
                <div class="alert alert-info border-0 shadow-sm fw-bold">
                    <i class="bi bi-person-fill me-2"></i>Klien: <?= $data['picking'][0]['nama_klien']; ?>
                </div>
            </div>

            <?php foreach($data['picking'] as $index => $item) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100 <?= ($item['status_picking'] == 'selesai') ? 'bg-light' : 'border-start border-4 border-primary'; ?>">
                        <div class="card-body p-4">
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge <?= ($item['status_picking'] == 'selesai') ? 'bg-success' : 'bg-danger'; ?> fs-6">
                                    <i class="bi bi-geo-alt-fill me-1"></i><?= $item['lokasi_rak']; ?>
                                </span>
                                <span class="text-muted small fw-bold">#<?= $index + 1; ?></span>
                            </div>

                            <h5 class="fw-bold text-dark mb-1"><?= $item['komoditas']; ?></h5>
                            <p class="text-muted small mb-3"><i class="bi bi-upc-scan me-1"></i>SKU: <?= $item['kode_sku']; ?></p>
                            
                            <div class="bg-light rounded-3 p-3 mb-4 text-center">
                                <span class="d-block text-muted small fw-bold mb-1">Ambil Sebanyak:</span>
                                <span class="fs-2 fw-bold text-primary"><?= number_format($item['berat_diambil_kg'], 2, ',', '.'); ?> <span class="fs-5">Kg</span></span>
                            </div>

                            <?php if($item['status_picking'] == 'belum') : ?>
                                <div class="d-grid">
                                    <a href="<?= BASEURL; ?>/outbound/konfirmasiAmbil/<?= $item['id_picking']; ?>/<?= $data['id_so']; ?>" class="btn btn-primary btn-lg fw-bold rounded-pill" onclick="return confirm('Konfirmasi bahwa barang ini telah diambil secara fisik dari rak?');">
                                        <i class="bi bi-check2-circle me-2"></i>Selesai Ambil
                                    </a>
                                </div>
                            <?php else : ?>
                                <div class="d-grid">
                                    <button class="btn btn-success btn-lg fw-bold rounded-pill" disabled>
                                        <i class="bi bi-check-lg me-2"></i>Telah Diambil
                                    </button>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
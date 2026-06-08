<div class="container-fluid mt-4 mb-5">
    
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-primary"><i class="bi bi-clipboard-check-fill me-2"></i>Verifikasi Karantina</h2>
            <p class="text-muted">Pilah barang bermasalah dan putuskan nasib akhir stok tersebut.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php Flasher::flash(); ?>
        </div>
    </div>

    <div class="row">
        <?php if(empty($data['antrean'])) : ?>
            <div class="col-12 text-center text-muted mt-5">
                <i class="bi bi-check-circle fs-1 text-success d-block mb-3"></i>
                <h5>Area Karantina Bersih</h5>
                <p>Tidak ada antrean laporan barang bermasalah dari Kru Lapangan saat ini.</p>
            </div>
        <?php else : ?>
            <?php foreach($data['antrean'] as $item) : ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-header bg-warning text-dark px-4 py-3 border-0 rounded-top-4 d-flex justify-content-between align-items-center">
                            <span class="fw-bold"><i class="bi bi-box-seam me-1"></i><?= $item['komoditas']; ?></span>
                            <span class="badge bg-danger fs-6"><?= number_format($item['berat_susut_kg'], 2, ',', '.'); ?> Kg</span>
                        </div>
                        <div class="card-body p-4">
                            
                            <ul class="list-unstyled small mb-4">
                                <li class="mb-2"><span class="text-muted fw-bold">SKU Karantina:</span> <br> <span class="fw-medium"><?= $item['kode_sku']; ?></span></li>
                                <li class="mb-2"><span class="text-muted fw-bold">Lokasi Rak:</span> <br> <?= $item['lokasi_rak']; ?></li>
                                <li class="mb-2"><span class="text-muted fw-bold">Alasan NG:</span> <br> <span class="text-danger fw-bold"><?= $item['keterangan_ng']; ?></span></li>
                                <li><span class="text-muted fw-bold">Pelapor:</span> <br> <?= explode(' ', trim($item['pelapor']))[0]; ?> <span class="text-secondary">(<?= date('H:i', strtotime($item['waktu_catat'])); ?>)</span></li>
                            </ul>

                            <hr>

                            <form action="<?= BASEURL; ?>/waste/evaluasiQC" method="POST">
                                <input type="hidden" name="id_waste" value="<?= $item['id_waste']; ?>">
                                <input type="hidden" name="id_stok" value="<?= $item['id_stok']; ?>">
                                <input type="hidden" name="berat_total" value="<?= $item['berat_susut_kg']; ?>">

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-success">Berat yang Diselamatkan (Recovery) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" max="<?= $item['berat_susut_kg']; ?>" class="form-control fw-bold border-success" name="berat_recovery" value="0" required>
                                        <span class="input-group-text bg-success text-white fw-bold">Kg</span>
                                    </div>
                                    <div class="form-text small mt-2"><i class="bi bi-info-circle me-1"></i>Sisa berat otomatis dianggap sebagai limbah (dibuang). Biarkan 0 jika dibuang semua.</div>
                                </div>

                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary fw-bold rounded-pill" onclick="return confirm('Kunci keputusan ini? Barang yang selamat akan dikembalikan ke stok rak.');">
                                        <i class="bi bi-check2-all me-1"></i>Kunci & Selesaikan
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>